jQuery(document).ready(function($) {
    const $startBackupBtn = $('#wolfx-start-backup');
    const $progressBar = $('#wolfx-backup-progress');
    const $progressFill = $('.progress-bar-fill');
    const $statusMessage = $('.status-message');
    const $backupList = $('#wolfx-backup-list');
    const $importForm = $('#wolfx-import-backup');
    const $importProgress = $('#wolfx-import-progress');
    const $importProgressFill = $importProgress.find('.progress-bar-fill');
    const $importStatusMessage = $importProgress.find('.status-message');
    const $fileInput = $('#backup_file');
    const $fileName = $('.file-name');
    const $webhookUrl = $('#webhook_url');
    const $scheduleTime = $('#schedule_time');
    const $enableSchedule = $('#enable_schedule');
    const $maxBackups = $('#max_backups');

    // Load saved settings
    $.ajax({
        url: wolfxBackup.ajaxurl,
        type: 'POST',
        data: {
            action: 'wolfx_get_backup_settings',
            nonce: wolfxBackup.nonce
        },
        success: function(response) {
            if (response.success) {
                $webhookUrl.val(response.data.webhook_url || '');
                $scheduleTime.val(response.data.schedule_time || '');
                $enableSchedule.prop('checked', response.data.enable_schedule || false);
                $maxBackups.val(response.data.max_backups || 5);
            }
        }
    });

    // Save settings when changed
    $webhookUrl.on('change', saveSettings);
    $scheduleTime.on('change', saveSettings);
    $enableSchedule.on('change', saveSettings);
    $maxBackups.on('change', saveSettings);

    function saveSettings() {
        $.ajax({
            url: wolfxBackup.ajaxurl,
            type: 'POST',
            data: {
                action: 'wolfx_save_backup_settings',
                nonce: wolfxBackup.nonce,
                webhook_url: $webhookUrl.val(),
                schedule_time: $scheduleTime.val(),
                enable_schedule: $enableSchedule.is(':checked'),
                max_backups: $maxBackups.val()
            }
        });
    }

    // Update file name display when file is selected
    $fileInput.on('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'Nenhum arquivo selecionado';
        $fileName.text(fileName);
    });

    // Handle backup button click
    $startBackupBtn.off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.returnValue = false;

        // Disable button and show progress
        $startBackupBtn.prop('disabled', true);
        $progressBar.show();
        $progressFill.css('width', '0%');
        $statusMessage.text(wolfxBackup.i18n.backupStarted);

        // Get webhook URL from settings
        const webhookUrl = $webhookUrl.val();

        // Start backup process
        $.ajax({
            url: wolfxBackup.ajaxurl,
            type: 'POST',
            data: {
                action: 'wolfx_create_backup',
                nonce: wolfxBackup.nonce,
                webhook_url: webhookUrl // Always send webhook URL if configured
            },
            success: function(response) {
                if (response.success) {
                    $progressFill.css('width', '100%');
                    $statusMessage.text(wolfxBackup.i18n.backupComplete);
                    
                    // Refresh backup list
                    $.ajax({
                        url: wolfxBackup.ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'wolfx_get_backup_list',
                            nonce: wolfxBackup.nonce
                        },
                        success: function(listResponse) {
                            if (listResponse.success) {
                                $('#wolfx-backup-list').html(listResponse.data);
                            }
                        }
                    });
                } else {
                    $statusMessage.text(wolfxBackup.i18n.backupError + ': ' + response.data);
                }
            },
            error: function() {
                $statusMessage.text(wolfxBackup.i18n.backupError);
            },
            complete: function() {
                // Re-enable button after 2 seconds
                setTimeout(function() {
                    $startBackupBtn.prop('disabled', false).text('Iniciar Backup');
                    $progressBar.hide();
                }, 2000);
            }
        });

        return false;
    });

    // Handle restore backup
    $('.restore-backup').on('click', function() {
        const backupFile = $(this).data('backup');
        const $button = $(this);
        
        // Disable button and show loading state
        $button.prop('disabled', true).text('Validando...');

        // Validate backup compatibility first
        $.ajax({
            url: wolfxBackup.ajaxurl,
            type: 'POST',
            data: {
                action: 'wolfx_get_backup_status',
                nonce: wolfxBackup.nonce,
                backup_file: backupFile
            },
            success: function(response) {
                if (!response.success) {
                    alert(response.data || 'Erro ao validar backup');
                    $button.prop('disabled', false).text('Restaurar');
                    return;
                }

                // Remove confirmation dialog and show restore options immediately
                const $dialog = $('<div>')
                    .html(`
                        <h3>Opções de Restauração</h3>
                        <p>Selecione o que deseja restaurar:</p>
                        <form id="restore-options">
                            <label>
                                <input type="checkbox" name="restore_db" checked>
                                Banco de dados
                            </label><br>
                            <label>
                                <input type="checkbox" name="restore_themes" checked>
                                Temas
                            </label><br>
                            <label>
                                <input type="checkbox" name="restore_plugins" checked>
                                Plugins
                            </label><br>
                            <label>
                                <input type="checkbox" name="restore_uploads" checked>
                                Imagens e uploads
                            </label>
                        </form>
                        <div id="restore-progress" style="display: none; margin-top: 20px;">
                            <div class="progress-bar">
                                <div class="progress-bar-fill"></div>
                            </div>
                            <p class="status-message"></p>
                        </div>
                    `)
                    .dialog({
                        title: 'Restaurar Backup',
                        modal: true,
                        width: 400,
                        buttons: {
                            'Restaurar': function() {
                                const $dialog = $(this);
                                const $progress = $('#restore-progress');
                                const $progressFill = $progress.find('.progress-bar-fill');
                                const $statusMessage = $progress.find('.status-message');
                                const $restoreButton = $dialog.find('button:contains("Restaurar")');
                                const $cancelButton = $dialog.find('button:contains("Cancelar")');

                                const options = {
                                    restore_db: $('#restore-options input[name="restore_db"]').is(':checked'),
                                    restore_themes: $('#restore-options input[name="restore_themes"]').is(':checked'),
                                    restore_plugins: $('#restore-options input[name="restore_plugins"]').is(':checked'),
                                    restore_uploads: $('#restore-options input[name="restore_uploads"]').is(':checked')
                                };

                                // Show progress and disable buttons
                                $progress.show();
                                $restoreButton.prop('disabled', true);
                                $cancelButton.prop('disabled', true);
                                $progressFill.css('width', '0%');
                                $statusMessage.text('Iniciando restauração...');

                                // Start restore process
                                $.ajax({
                                    url: wolfxBackup.ajaxurl,
                                    type: 'POST',
                                    data: {
                                        action: 'wolfx_restore_backup',
                                        nonce: wolfxBackup.nonce,
                                        backup_file: backupFile,
                                        options: options
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $progressFill.css('width', '100%');
                                            $statusMessage.text('Backup restaurado com sucesso!');
                                            setTimeout(function() {
                                                location.reload();
                                            }, 2000);
                                        } else {
                                            $statusMessage.text(response.data || 'Erro ao restaurar backup');
                                            $restoreButton.prop('disabled', false);
                                            $cancelButton.prop('disabled', false);
                                        }
                                    },
                                    error: function() {
                                        $statusMessage.text('Erro ao restaurar backup');
                                        $restoreButton.prop('disabled', false);
                                        $cancelButton.prop('disabled', false);
                                    }
                                });
                            },
                            'Cancelar': function() {
                                $(this).dialog('close');
                                $button.prop('disabled', false).text('Restaurar');
                            }
                        },
                        close: function() {
                            $button.prop('disabled', false).text('Restaurar');
                        }
                    });
            },
            error: function() {
                alert('Erro ao validar backup');
                $button.prop('disabled', false).text('Restaurar');
            }
        });
    });

    // Handle import backup
    $importForm.on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $fileInput = $('#backup_file');
        
        if (!$fileInput[0].files.length) {
            alert('Por favor, selecione um arquivo de backup');
            return;
        }

        // Validate file size
        const maxSize = 1024 * 1024 * 1024; // 1GB
        if ($fileInput[0].files[0].size > maxSize) {
            alert('O arquivo é muito grande. O tamanho máximo permitido é 1GB.');
            return;
        }

        // Create FormData object
        const formData = new FormData();
        formData.append('action', 'wolfx_import_backup');
        formData.append('nonce', wolfxBackup.nonce);
        formData.append('backup_file', $fileInput[0].files[0]);
        formData.append('restore_db', $('#restore_db').is(':checked') ? 'on' : 'off');
        formData.append('restore_files', $('#restore_files').is(':checked') ? 'on' : 'off');

        // Disable form and show progress
        $submitBtn.prop('disabled', true);
        $importProgress.show();
        $importProgressFill.css('width', '0%');
        $importStatusMessage.text('Importando backup...');

        // Upload file
        $.ajax({
            url: wolfxBackup.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percent = (e.loaded / e.total) * 100;
                        $importProgressFill.css('width', percent + '%');
                        $importStatusMessage.text('Enviando arquivo: ' + Math.round(percent) + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    $importProgressFill.css('width', '100%');
                    $importStatusMessage.text(response.data.message);
                    $fileInput.val('');
                    $fileName.text('Nenhum arquivo selecionado');
                    
                    // Refresh backup list after a short delay
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $importStatusMessage.text('Erro: ' + (response.data || 'Erro desconhecido ao importar backup'));
                    $submitBtn.prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Import error:', status, error);
                $importStatusMessage.text('Erro ao importar backup: ' + error);
                $submitBtn.prop('disabled', false);
            }
        });
    });

    // Handle delete backup
    $(document).on('click', '.delete-backup', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $button = $(this);
        const backupFile = $button.data('backup');
        
        // Disable button immediately
        $button.prop('disabled', true);

        // Delete backup
        $.ajax({
            url: wolfxBackup.ajaxurl,
            type: 'POST',
            data: {
                action: 'wolfx_delete_backup',
                nonce: wolfxBackup.nonce,
                backup_file: backupFile
            },
            success: function(response) {
                if (response.success) {
                    // Remove the row from the table
                    $button.closest('tr').fadeOut(400, function() {
                        $(this).remove();
                        // If no backups left, show message
                        if ($('#wolfx-backup-list table tbody tr').length === 0) {
                            $('#wolfx-backup-list').html('<p>Nenhum backup disponível.</p>');
                        }
                    });
                } else {
                    alert(response.data || 'Erro ao excluir backup');
                    $button.prop('disabled', false);
                }
            },
            error: function() {
                alert('Erro ao excluir backup');
                $button.prop('disabled', false);
            }
        });
    });
}); 