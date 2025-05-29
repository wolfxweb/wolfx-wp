<?php
/**
 * Plugin Name: Wolfx Backup e Restauração
 * Plugin URI: https://wolfx.com.br
 * Description: Plugin para backup e restauração completa do WordPress
 * Version: 1.0.0
 * Author: Wolfx
 * Author URI: https://wolfx.com.br
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wolfx-backup
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WOLFX_BACKUP_VERSION', '1.0.0');
define('WOLFX_BACKUP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WOLFX_BACKUP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WOLFX_BACKUP_BACKUP_DIR', WP_CONTENT_DIR . '/wolfx-backups/');

class WolfxBackup {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_wolfx_create_backup', array($this, 'ajax_create_backup'));
        add_action('wp_ajax_wolfx_get_backup_status', array($this, 'ajax_get_backup_status'));
        add_action('wp_ajax_wolfx_restore_backup', array($this, 'ajax_restore_backup'));
        add_action('wp_ajax_wolfx_download_backup', array($this, 'ajax_download_backup'));
        add_action('wp_ajax_wolfx_import_backup', array($this, 'ajax_import_backup'));
        add_action('wp_ajax_wolfx_get_backup_list', array($this, 'ajax_get_backup_list'));
        add_action('wp_ajax_wolfx_delete_backup', array($this, 'ajax_delete_backup'));
        add_action('wp_ajax_wolfx_save_backup_settings', array($this, 'ajax_save_backup_settings'));
        add_action('wp_ajax_wolfx_get_backup_settings', array($this, 'ajax_get_backup_settings'));
        
        // Schedule backup if enabled
        if (!wp_next_scheduled('wolfx_scheduled_backup')) {
            $schedule_time = get_option('wolfx_backup_schedule_time');
            $enable_schedule = get_option('wolfx_backup_enable_schedule');
            
            if ($enable_schedule && $schedule_time) {
                $time = strtotime($schedule_time);
                if ($time) {
                    wp_schedule_event($time, 'daily', 'wolfx_scheduled_backup');
                }
            }
        }
        
        add_action('wolfx_scheduled_backup', array($this, 'run_scheduled_backup'));
        
        // Create backup directory if it doesn't exist
        if (!file_exists(WOLFX_BACKUP_BACKUP_DIR)) {
            wp_mkdir_p(WOLFX_BACKUP_BACKUP_DIR);
        }
    }

    public function add_admin_menu() {
        add_menu_page(
            'Wolfx Backup',
            'Wolfx Backup',
            'manage_options',
            'wolfx-backup',
            array($this, 'render_admin_page'),
            'dashicons-backup',
            30
        );
    }

    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_wolfx-backup' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'wolfx-backup-admin',
            WOLFX_BACKUP_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            WOLFX_BACKUP_VERSION
        );

        wp_enqueue_script(
            'wolfx-backup-admin',
            WOLFX_BACKUP_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            WOLFX_BACKUP_VERSION,
            true
        );

        wp_localize_script('wolfx-backup-admin', 'wolfxBackup', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wolfx_backup_nonce'),
            'i18n' => array(
                'backupStarted' => 'Backup iniciado...',
                'backupComplete' => 'Backup concluído!',
                'backupError' => 'Erro ao realizar backup',
                'backupInProgress' => 'Backup em andamento...',
                'buttonDisabled' => 'Backup em andamento...',
                'confirmDelete' => 'Tem certeza que deseja excluir este backup?',
                'deleteSuccess' => 'Backup excluído com sucesso!',
                'deleteError' => 'Erro ao excluir backup'
            )
        ));
    }

    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1>Wolfx Backup e Restauração</h1>
            
            <div class="wolfx-backup-actions">
                <div class="wolfx-backup-action">
                    <h2>Realizar Backup</h2>
                    <p>Clique no botão abaixo para iniciar um backup completo do seu site WordPress.</p>
                    
                    <div class="backup-settings">
                        <div class="option-group">
                            <label for="webhook_url">URL do Webhook (n8n)</label>
                            <input type="url" id="webhook_url" name="webhook_url" class="regular-text" placeholder="https://seu-n8n.com/webhook/...">
                            <p class="description">URL do webhook do n8n para receber notificações quando o backup for concluído.</p>
                        </div>

                        <div class="option-group">
                            <label for="schedule_time">Agendar Backup</label>
                            <input type="time" id="schedule_time" name="schedule_time" class="regular-text">
                            <p class="description">Horário para execução automática do backup (formato 24h).</p>
                        </div>

                        <div class="option-group">
                            <label>
                                <input type="checkbox" id="enable_schedule" name="enable_schedule">
                                Ativar agendamento
                            </label>
                            <p class="description">Se marcado, o backup será executado automaticamente no horário especificado.</p>
                        </div>

                        <div class="option-group">
                            <label for="max_backups">Quantidade de Backups</label>
                            <input type="number" id="max_backups" name="max_backups" class="small-text" min="1" value="5">
                            <p class="description">Número máximo de backups a serem mantidos. Os backups mais antigos serão excluídos automaticamente.</p>
                        </div>
                    </div>

                    <div class="backup-button-wrapper">
                        <button type="button" id="wolfx-start-backup" class="button button-primary" data-no-confirm="true">
                            Iniciar Backup
                        </button>
                        <div id="wolfx-backup-progress" style="display: none;">
                            <div class="progress-bar">
                                <div class="progress-bar-fill"></div>
                            </div>
                            <p class="status-message"></p>
                        </div>
                    </div>
                </div>

                <div class="wolfx-backup-action">
                    <h2>Importar Backup</h2>
                    <p>Faça upload de um arquivo de backup para restaurá-lo.</p>
                    <form id="wolfx-import-backup" enctype="multipart/form-data">
                        <div class="file-input-wrapper">
                            <label for="backup_file" class="file-input-label">Escolher Arquivo</label>
                            <input type="file" id="backup_file" name="backup_file" accept=".zip" required>
                            <div class="file-name">Nenhum arquivo selecionado</div>
                        </div>
                        
                        <div class="restore-options">
                            <h3>Opções de Restauração</h3>
                            <div class="option-group">
                                <label>
                                    <input type="checkbox" name="restore_db" id="restore_db" checked>
                                    Restaurar Banco de Dados
                                </label>
                                <p class="description">Se marcado, o banco de dados será restaurado com os dados do backup.</p>
                            </div>
                            <div class="option-group">
                                <label>
                                    <input type="checkbox" name="restore_files" id="restore_files" checked>
                                    Restaurar Arquivos
                                </label>
                                <p class="description">Se marcado, os arquivos (temas, plugins e uploads) serão restaurados.</p>
                            </div>
                        </div>

                        <button type="submit" class="button button-primary">Importar Backup</button>
                    </form>
                    <div id="wolfx-import-progress" style="display: none;">
                        <div class="progress-bar">
                            <div class="progress-bar-fill"></div>
                        </div>
                        <p class="status-message"></p>
                    </div>
                </div>
            </div>

            <div class="wolfx-backup-section">
                <h2>Backups Disponíveis</h2>
                <div id="wolfx-backup-list">
                    <?php $this->render_backup_list(); ?>
                </div>
            </div>
        </div>

        <style>
            .progress-bar {
                width: 100%;
                height: 20px;
                background-color: #f0f0f0;
                border-radius: 10px;
                margin: 10px 0;
                overflow: hidden;
            }
            .progress-bar-fill {
                height: 100%;
                background-color: #0073aa;
                width: 0%;
                transition: width 0.3s ease-in-out;
            }
            .status-message {
                margin: 10px 0;
                font-weight: bold;
            }
            .button:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }
            .restore-options, .backup-settings {
                margin: 20px 0;
                padding: 15px;
                background: #f9f9f9;
                border: 1px solid #e5e5e5;
                border-radius: 4px;
            }
            .restore-options h3, .backup-settings h3 {
                margin-top: 0;
                margin-bottom: 15px;
            }
            .option-group {
                margin-bottom: 15px;
            }
            .option-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }
            .option-group .description {
                margin: 5px 0 0 25px;
                color: #666;
                font-style: italic;
            }
            .actions {
                white-space: nowrap;
            }
            .actions .button {
                margin-right: 5px;
            }
            .actions .button:last-child {
                margin-right: 0;
            }
            .delete-backup {
                background: #dc3232 !important;
                border-color: #dc3232 !important;
                color: #fff !important;
                text-shadow: none !important;
            }
            .delete-backup:hover {
                background: #c92626 !important;
                border-color: #c92626 !important;
                color: #fff !important;
            }
            .backup-button-wrapper {
                position: relative;
            }
            .backup-settings input[type="url"],
            .backup-settings input[type="time"] {
                width: 100%;
                max-width: 400px;
            }
        </style>
        <?php
    }

    private function render_backup_list() {
        $backups = $this->get_available_backups();
        if (empty($backups)) {
            echo '<p>Nenhum backup disponível.</p>';
            return;
        }

        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>';
        echo '<th>Data</th>';
        echo '<th>Nome do Arquivo</th>';
        echo '<th>Tamanho</th>';
        echo '<th>Ações</th>';
        echo '</tr></thead><tbody>';

        foreach ($backups as $backup) {
            echo '<tr>';
            echo '<td>' . esc_html($backup['date']) . '</td>';
            echo '<td>' . esc_html($backup['filename']) . '</td>';
            echo '<td>' . esc_html($backup['size']) . '</td>';
            echo '<td class="actions">';
            echo '<a href="' . esc_url($backup['download_url']) . '" class="button button-primary button-small">Download</a> ';
            echo '<button class="button button-small restore-backup" data-backup="' . esc_attr($backup['filename']) . '">Restaurar</button> ';
            echo '<button class="button button-small delete-backup" data-backup="' . esc_attr($backup['filename']) . '">Excluir</button>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
    }

    private function get_available_backups() {
        $backups = array();
        
        // Verifica se o diretório existe
        if (!file_exists(WOLFX_BACKUP_BACKUP_DIR)) {
            error_log('Wolfx Backup: Backup directory does not exist: ' . WOLFX_BACKUP_BACKUP_DIR);
            return $backups;
        }

        // Busca por arquivos ZIP
        $files = glob(WOLFX_BACKUP_BACKUP_DIR . '*.zip');
        error_log('Wolfx Backup: Found ' . count($files) . ' backup files');

        foreach ($files as $file) {
            $filename = basename($file);
            $file_size = filesize($file);
            
            // Verifica se o arquivo existe e tem tamanho válido
            if (file_exists($file) && $file_size > 0) {
                $backups[] = array(
                    'filename' => $filename,
                    'date' => date('d/m/Y H:i:s', filemtime($file)),
                    'size' => size_format($file_size),
                    'download_url' => wp_nonce_url(
                        admin_url('admin-ajax.php?action=wolfx_download_backup&file=' . $filename),
                        'wolfx_download_backup'
                    )
                );
                error_log('Wolfx Backup: Added backup to list: ' . $filename);
            } else {
                error_log('Wolfx Backup: Invalid backup file: ' . $filename);
            }
        }

        // Ordena os backups por data (mais recente primeiro)
        usort($backups, function($a, $b) {
            return strtotime(str_replace('/', '-', $b['date'])) - strtotime(str_replace('/', '-', $a['date']));
        });

        return $backups;
    }

    public function ajax_save_backup_settings() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        $webhook_url = isset($_POST['webhook_url']) ? esc_url_raw($_POST['webhook_url']) : '';
        $schedule_time = isset($_POST['schedule_time']) ? sanitize_text_field($_POST['schedule_time']) : '';
        $enable_schedule = isset($_POST['enable_schedule']) ? (bool)$_POST['enable_schedule'] : false;
        $max_backups = isset($_POST['max_backups']) ? absint($_POST['max_backups']) : 5;

        update_option('wolfx_backup_webhook_url', $webhook_url);
        update_option('wolfx_backup_schedule_time', $schedule_time);
        update_option('wolfx_backup_enable_schedule', $enable_schedule);
        update_option('wolfx_backup_max_backups', $max_backups);

        // Reschedule if needed
        wp_clear_scheduled_hook('wolfx_scheduled_backup');
        if ($enable_schedule && $schedule_time) {
            $time = strtotime($schedule_time);
            if ($time) {
                wp_schedule_event($time, 'daily', 'wolfx_scheduled_backup');
            }
        }

        wp_send_json_success('Configurações salvas com sucesso');
    }

    public function ajax_get_backup_settings() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        wp_send_json_success(array(
            'webhook_url' => get_option('wolfx_backup_webhook_url', ''),
            'schedule_time' => get_option('wolfx_backup_schedule_time', ''),
            'enable_schedule' => get_option('wolfx_backup_enable_schedule', false),
            'max_backups' => get_option('wolfx_backup_max_backups', 5)
        ));
    }

    private function cleanup_old_backups() {
        $max_backups = get_option('wolfx_backup_max_backups', 5);
        $backups = $this->get_available_backups();
        
        if (count($backups) > $max_backups) {
            // Sort backups by date (oldest first)
            usort($backups, function($a, $b) {
                return strtotime(str_replace('/', '-', $a['date'])) - strtotime(str_replace('/', '-', $b['date']));
            });
            
            // Remove oldest backups
            $backups_to_remove = array_slice($backups, 0, count($backups) - $max_backups);
            foreach ($backups_to_remove as $backup) {
                $backup_path = WOLFX_BACKUP_BACKUP_DIR . $backup['filename'];
                if (file_exists($backup_path)) {
                    unlink($backup_path);
                    error_log('Wolfx Backup: Removed old backup: ' . $backup['filename']);
                }
            }
        }
    }

    public function run_scheduled_backup() {
        $backup_file = $this->create_backup();
        
        if (!is_wp_error($backup_file)) {
            $webhook_url = get_option('wolfx_backup_webhook_url');
            if ($webhook_url) {
                $this->send_webhook_notification($webhook_url, $backup_file);
            }
            
            // Cleanup old backups after successful backup
            $this->cleanup_old_backups();
        }
    }

    private function send_webhook_notification($webhook_url, $backup_file) {
        $backup_url = wp_nonce_url(
            admin_url('admin-ajax.php?action=wolfx_download_backup&file=' . basename($backup_file)),
            'wolfx_download_backup'
        );

        $response = wp_remote_post($webhook_url, array(
            'body' => array(
                'backup_url' => $backup_url,
                'backup_file' => basename($backup_file),
                'site_url' => get_site_url(),
                'timestamp' => current_time('mysql'),
                'backup_type' => 'scheduled' // Indica que é um backup agendado
            )
        ));

        if (is_wp_error($response)) {
            error_log('Wolfx Backup: Webhook notification failed: ' . $response->get_error_message());
        } else {
            error_log('Wolfx Backup: Webhook notification sent successfully');
        }
    }

    public function ajax_create_backup() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        error_log('Wolfx Backup: Starting AJAX backup creation');
        $backup_file = $this->create_backup();
        
        if (is_wp_error($backup_file)) {
            error_log('Wolfx Backup: Backup creation failed: ' . $backup_file->get_error_message());
            wp_send_json_error($backup_file->get_error_message());
        }

        // Send webhook notification if URL is provided (from POST or settings)
        $webhook_url = isset($_POST['webhook_url']) ? esc_url_raw($_POST['webhook_url']) : '';
        if (empty($webhook_url)) {
            $webhook_url = get_option('wolfx_backup_webhook_url', '');
        }
        
        if ($webhook_url) {
            error_log('Wolfx Backup: Sending webhook notification to: ' . $webhook_url);
            $this->send_webhook_notification($webhook_url, $backup_file);
        }

        // Cleanup old backups after successful backup
        $this->cleanup_old_backups();

        error_log('Wolfx Backup: Backup created successfully: ' . $backup_file);
        wp_send_json_success(array(
            'message' => 'Backup criado com sucesso',
            'file' => basename($backup_file)
        ));
    }

    private function create_backup() {
        require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');

        // Log start of backup process
        error_log('Wolfx Backup: Starting backup process');

        // Define backup directory path
        $backup_dir = WP_CONTENT_DIR . '/wolfx-backups';
        if (!defined('WOLFX_BACKUP_BACKUP_DIR')) {
            define('WOLFX_BACKUP_BACKUP_DIR', $backup_dir . '/');
        }

        // Verify backup directory exists and is writable
        if (!file_exists($backup_dir)) {
            error_log('Wolfx Backup: Creating backup directory: ' . $backup_dir);
            if (!wp_mkdir_p($backup_dir)) {
                error_log('Wolfx Backup: Failed to create backup directory');
                return new WP_Error('backup_failed', 'Não foi possível criar o diretório de backup');
            }
        }

        if (!is_writable($backup_dir)) {
            error_log('Wolfx Backup: Backup directory is not writable: ' . $backup_dir);
            return new WP_Error('backup_failed', 'O diretório de backup não tem permissão de escrita');
        }

        $backup_filename = 'wolfx-backup-' . date('Y-m-d-H-i-s') . '.zip';
        $backup_path = $backup_dir . '/' . $backup_filename;
        error_log('Wolfx Backup: Backup path: ' . $backup_path);

        // Create temporary directory for backup
        $temp_dir = $backup_dir . '/wolfx-temp-' . uniqid();
        error_log('Wolfx Backup: Creating temp directory: ' . $temp_dir);
        
        if (!wp_mkdir_p($temp_dir)) {
            error_log('Wolfx Backup: Failed to create temp directory');
            return new WP_Error('backup_failed', 'Não foi possível criar o diretório temporário');
        }

        try {
            // Export database
            error_log('Wolfx Backup: Starting database export');
            $db_file = $temp_dir . '/wolfx-database.sql';
            $db_result = $this->export_database($db_file);
            if (is_wp_error($db_result)) {
                error_log('Wolfx Backup: Database export failed: ' . $db_result->get_error_message());
                throw new Exception($db_result->get_error_message());
            }
            error_log('Wolfx Backup: Database export completed');

            // Copy WordPress files
            error_log('Wolfx Backup: Starting file copy');
            $files_result = $this->copy_wordpress_files($temp_dir);
            if (is_wp_error($files_result)) {
                error_log('Wolfx Backup: File copy failed: ' . $files_result->get_error_message());
                throw new Exception($files_result->get_error_message());
            }
            error_log('Wolfx Backup: File copy completed');

            // Create ZIP archive
            error_log('Wolfx Backup: Starting ZIP creation');
            $zip = new PclZip($backup_path);
            $result = $zip->create($temp_dir, PCLZIP_OPT_REMOVE_PATH, $temp_dir);
            
            if ($result === 0) {
                error_log('Wolfx Backup: ZIP creation failed: ' . $zip->errorInfo(true));
                throw new Exception('Erro ao criar arquivo ZIP: ' . $zip->errorInfo(true));
            }
            error_log('Wolfx Backup: ZIP creation completed');

            // Verify backup file was created
            if (!file_exists($backup_path)) {
                error_log('Wolfx Backup: Backup file was not created');
                throw new Exception('O arquivo de backup não foi criado');
            }

            // Verify backup file size
            $backup_size = filesize($backup_path);
            if ($backup_size === 0) {
                error_log('Wolfx Backup: Backup file is empty');
                throw new Exception('O arquivo de backup está vazio');
            }
            error_log('Wolfx Backup: Backup file size: ' . $backup_size . ' bytes');

            // Clean up
            error_log('Wolfx Backup: Cleaning up temp directory');
            $this->remove_directory($temp_dir);

            error_log('Wolfx Backup: Backup process completed successfully');
            return $backup_path;
        } catch (Exception $e) {
            error_log('Wolfx Backup: Error during backup: ' . $e->getMessage());
            $this->remove_directory($temp_dir);
            return new WP_Error('backup_failed', $e->getMessage());
        }
    }

    private function export_database($file) {
        global $wpdb;

        try {
            $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);
            if ($wpdb->last_error) {
                throw new Exception('Erro ao listar tabelas: ' . $wpdb->last_error);
            }

            $handle = fopen($file, 'w');
            if ($handle === false) {
                throw new Exception('Não foi possível criar o arquivo SQL');
            }

            // Add WordPress version and site URL
            fwrite($handle, "-- Wolfx Backup\n");
            fwrite($handle, "-- Plugin: Wolfx Backup e Restauração\n");
            fwrite($handle, "-- WordPress Version: " . get_bloginfo('version') . "\n");
            fwrite($handle, "-- Site URL: " . get_site_url() . "\n");
            fwrite($handle, "-- Backup Date: " . date('Y-m-d H:i:s') . "\n\n");

            foreach ($tables as $table) {
                $table_name = $table[0];
                
                // Skip tables that don't belong to this WordPress installation
                if (strpos($table_name, $wpdb->prefix) !== 0) {
                    continue;
                }

                // Get table structure
                $create_table = $wpdb->get_row("SHOW CREATE TABLE `$table_name`", ARRAY_N);
                if ($wpdb->last_error) {
                    throw new Exception("Erro ao obter estrutura da tabela $table_name: " . $wpdb->last_error);
                }

                fwrite($handle, "DROP TABLE IF EXISTS `$table_name`;\n");
                fwrite($handle, "\n\n" . $create_table[1] . ";\n\n");

                // Get table data
                $rows = $wpdb->get_results("SELECT * FROM `$table_name`", ARRAY_A);
                if ($wpdb->last_error) {
                    throw new Exception("Erro ao obter dados da tabela $table_name: " . $wpdb->last_error);
                }

                foreach ($rows as $row) {
                    $values = array_map(array($wpdb, '_real_escape'), $row);
                    fwrite($handle, "INSERT INTO `$table_name` VALUES ('" . implode("','", $values) . "');\n");
                }
            }

            fclose($handle);
            return true;
        } catch (Exception $e) {
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            return new WP_Error('db_export_failed', $e->getMessage());
        }
    }

    private function copy_wordpress_files($temp_dir) {
        try {
            // Copy wp-content directory
            if (!is_dir(WP_CONTENT_DIR)) {
                throw new Exception('Diretório wp-content não encontrado');
            }

            $content_dir = $temp_dir . '/wp-content';
            if (!wp_mkdir_p($content_dir)) {
                throw new Exception('Não foi possível criar diretório wp-content temporário');
            }

            // Lista de diretórios para copiar
            $directories_to_copy = array(
                'themes',
                'plugins',
                'uploads'
            );

            foreach ($directories_to_copy as $dir) {
                $src_dir = WP_CONTENT_DIR . '/' . $dir;
                $dst_dir = $content_dir . '/' . $dir;

                if (is_dir($src_dir)) {
                    error_log('Wolfx Backup: Copying directory: ' . $dir);
                    if (!wp_mkdir_p($dst_dir)) {
                        throw new Exception('Não foi possível criar diretório: ' . $dst_dir);
                    }

                    $result = $this->copy_directory($src_dir, $dst_dir);
                    if (is_wp_error($result)) {
                        throw new Exception($result->get_error_message());
                    }
                    error_log('Wolfx Backup: Directory copied successfully: ' . $dir);
                }
            }

            // Copy wp-config.php
            if (!file_exists(ABSPATH . 'wp-config.php')) {
                throw new Exception('Arquivo wp-config.php não encontrado');
            }

            if (!copy(ABSPATH . 'wp-config.php', $temp_dir . '/wp-config.php')) {
                throw new Exception('Não foi possível copiar wp-config.php');
            }

            // Copy .htaccess if exists
            if (file_exists(ABSPATH . '.htaccess')) {
                if (!copy(ABSPATH . '.htaccess', $temp_dir . '/.htaccess')) {
                    throw new Exception('Não foi possível copiar .htaccess');
                }
            }

            return true;
        } catch (Exception $e) {
            return new WP_Error('files_copy_failed', $e->getMessage());
        }
    }

    private function copy_directory($src, $dst) {
        try {
            if (!is_dir($src)) {
                throw new Exception("Diretório fonte não existe: $src");
            }

            if (!wp_mkdir_p($dst)) {
                throw new Exception("Não foi possível criar diretório: $dst");
            }

            $dir = opendir($src);
            if ($dir === false) {
                throw new Exception("Não foi possível abrir diretório: $src");
            }
            
            while (($file = readdir($dir)) !== false) {
                if ($file != '.' && $file != '..') {
                    $src_path = $src . '/' . $file;
                    $dst_path = $dst . '/' . $file;

                    if (is_dir($src_path)) {
                        $result = $this->copy_directory($src_path, $dst_path);
                        if (is_wp_error($result)) {
                            throw new Exception($result->get_error_message());
                        }
                    } else {
                        if (!copy($src_path, $dst_path)) {
                            throw new Exception("Não foi possível copiar arquivo: $src_path");
                        }
                    }
                }
            }
            
            closedir($dir);
            return true;
        } catch (Exception $e) {
            return new WP_Error('copy_failed', $e->getMessage());
        }
    }

    private function remove_directory($dir) {
        if (!file_exists($dir)) {
            return;
        }

        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->remove_directory($path) : unlink($path);
        }
        return rmdir($dir);
    }

    public function ajax_restore_backup() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        $backup_file = isset($_POST['backup_file']) ? sanitize_file_name($_POST['backup_file']) : '';
        $options = isset($_POST['options']) ? $_POST['options'] : array();

        if (empty($backup_file)) {
            wp_send_json_error('Arquivo de backup não especificado');
        }

        $backup_path = WOLFX_BACKUP_BACKUP_DIR . $backup_file;
        if (!file_exists($backup_path)) {
            wp_send_json_error('Arquivo de backup não encontrado');
        }

        try {
            $result = $this->restore_backup($backup_path, $options);
            if (is_wp_error($result)) {
                wp_send_json_error($result->get_error_message());
            }
            wp_send_json_success('Backup restaurado com sucesso');
        } catch (Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }

    private function restore_backup($backup_path, $options) {
        require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');

        // Create temporary directory for extraction
        $temp_dir = WOLFX_BACKUP_BACKUP_DIR . 'wolfx-temp-restore-' . uniqid();
        wp_mkdir_p($temp_dir);

        try {
            // Extract backup
            $zip = new PclZip($backup_path);
            $zip->extract(PCLZIP_OPT_PATH, $temp_dir);

            // Validate backup compatibility
            $compatibility = $this->validate_backup_compatibility($temp_dir);
            if (is_wp_error($compatibility)) {
                throw new Exception($compatibility->get_error_message());
            }

            // Restore database if selected
            if (!empty($options['restore_db'])) {
                $this->restore_database($temp_dir . '/wolfx-database.sql');
            }

            // Restore files based on options
            if (!empty($options['restore_themes'])) {
                $this->restore_directory($temp_dir . '/wp-content/themes', WP_CONTENT_DIR . '/themes');
            }

            if (!empty($options['restore_plugins'])) {
                $this->restore_directory($temp_dir . '/wp-content/plugins', WP_CONTENT_DIR . '/plugins');
            }

            if (!empty($options['restore_uploads'])) {
                $this->restore_directory($temp_dir . '/wp-content/uploads', WP_CONTENT_DIR . '/uploads');
            }

            // Clean up
            $this->remove_directory($temp_dir);

            return true;
        } catch (Exception $e) {
            $this->remove_directory($temp_dir);
            return new WP_Error('restore_failed', $e->getMessage());
        }
    }

    private function validate_backup_compatibility($temp_dir) {
        // Check if backup contains required files
        if (!file_exists($temp_dir . '/wolfx-database.sql')) {
            return new WP_Error('invalid_backup', 'O backup não contém o arquivo do banco de dados');
        }

        // Read backup info from SQL file
        $sql_content = file_get_contents($temp_dir . '/wolfx-database.sql');
        if ($sql_content === false) {
            return new WP_Error('invalid_backup', 'Não foi possível ler o arquivo do banco de dados');
        }

        // Extract WordPress version from backup
        preg_match('/WordPress Version: ([0-9.]+)/', $sql_content, $matches);
        if (empty($matches[1])) {
            return new WP_Error('invalid_backup', 'Não foi possível determinar a versão do WordPress no backup');
        }

        $backup_version = $matches[1];
        $current_version = get_bloginfo('version');

        // Compare versions
        if (version_compare($backup_version, $current_version, '>')) {
            return new WP_Error(
                'version_mismatch',
                sprintf(
                    'A versão do WordPress no backup (%s) é mais recente que a versão atual (%s). A restauração pode causar problemas.',
                    $backup_version,
                    $current_version
                )
            );
        }

        // Check if backup contains required directories
        $required_dirs = array(
            '/wp-content/themes',
            '/wp-content/plugins',
            '/wp-content/uploads'
        );

        foreach ($required_dirs as $dir) {
            if (!file_exists($temp_dir . $dir)) {
                return new WP_Error('invalid_backup', 'O backup não contém todos os diretórios necessários');
            }
        }

        return true;
    }

    private function restore_database($sql_file) {
        global $wpdb;

        if (!file_exists($sql_file)) {
            throw new Exception('Arquivo SQL não encontrado');
        }

        $sql = file_get_contents($sql_file);
        if ($sql === false) {
            throw new Exception('Erro ao ler arquivo SQL');
        }

        // Split SQL into individual queries
        $queries = $this->split_sql($sql);

        // Execute each query
        foreach ($queries as $query) {
            if (empty($query)) continue;
            
            $result = $wpdb->query($query);
            if ($result === false) {
                throw new Exception('Erro ao executar query: ' . $wpdb->last_error);
            }
        }
    }

    private function split_sql($sql) {
        $sql = str_replace("\r", "\n", $sql);
        $lines = explode("\n", $sql);
        $queries = array();
        $query = '';
        $in_string = false;

        foreach ($lines as $line) {
            if ($line == '' || preg_match('/^--/', $line) || preg_match('/^#/', $line)) {
                continue;
            }
            $query .= $line . "\n";
            $num_quotes = preg_match_all("/'/", $line, $matches);
            if ($num_quotes % 2 && substr_count($line, "\\'") % 2 == 0) {
                $in_string = !$in_string;
            }
            if (!$in_string && preg_match('/;[\040]*$/', trim($line))) {
                $queries[] = trim($query);
                $query = '';
            }
        }
        if (trim($query) != '') {
            $queries[] = trim($query);
        }
        return $queries;
    }

    private function restore_directory($src, $dst) {
        if (!file_exists($src)) {
            throw new Exception('Diretório fonte não encontrado: ' . $src);
        }

        // Remove destination directory if it exists
        if (file_exists($dst)) {
            $this->remove_directory($dst);
        }

        // Create destination directory
        wp_mkdir_p($dst);

        // Copy files
        $this->copy_directory($src, $dst);
    }

    public function ajax_download_backup() {
        check_ajax_referer('wolfx_download_backup', '_wpnonce');

        if (!current_user_can('manage_options')) {
            wp_die('Permissão negada');
        }

        $file = isset($_GET['file']) ? sanitize_file_name($_GET['file']) : '';
        if (empty($file)) {
            wp_die('Arquivo não especificado');
        }

        $file_path = WOLFX_BACKUP_BACKUP_DIR . $file;
        error_log('Wolfx Backup: Attempting to download file: ' . $file_path);

        if (!file_exists($file_path)) {
            error_log('Wolfx Backup: File not found: ' . $file_path);
            wp_die('Arquivo não encontrado');
        }

        if (filesize($file_path) === 0) {
            error_log('Wolfx Backup: File is empty: ' . $file_path);
            wp_die('Arquivo de backup está vazio');
        }

        // Set headers for download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($file_path));
        header('Pragma: no-cache');
        header('Expires: 0');

        // Output file
        readfile($file_path);
        exit;
    }

    public function ajax_get_backup_status() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        $backup_file = isset($_POST['backup_file']) ? sanitize_file_name($_POST['backup_file']) : '';
        if (empty($backup_file)) {
            wp_send_json_error('Arquivo de backup não especificado');
        }

        $backup_path = WOLFX_BACKUP_BACKUP_DIR . $backup_file;
        if (!file_exists($backup_path)) {
            wp_send_json_error('Arquivo de backup não encontrado');
        }

        try {
            // Create temporary directory for validation
            $temp_dir = WOLFX_BACKUP_BACKUP_DIR . 'wolfx-temp-validate-' . uniqid();
            wp_mkdir_p($temp_dir);

            // Extract backup
            require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
            $zip = new PclZip($backup_path);
            $zip->extract(PCLZIP_OPT_PATH, $temp_dir);

            // Validate backup
            $compatibility = $this->validate_backup_compatibility($temp_dir);
            
            // Clean up
            $this->remove_directory($temp_dir);

            if (is_wp_error($compatibility)) {
                wp_send_json_error($compatibility->get_error_message());
            }

            wp_send_json_success(array(
                'message' => 'Backup válido e compatível com esta instalação',
                'can_restore' => true
            ));
        } catch (Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }

    public function ajax_import_backup() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        error_log('Wolfx Backup: Starting import process');

        if (!isset($_FILES['backup_file'])) {
            error_log('Wolfx Backup: No file uploaded');
            wp_send_json_error('Nenhum arquivo enviado');
        }

        $file = $_FILES['backup_file'];
        error_log('Wolfx Backup: File details - Name: ' . $file['name'] . ', Type: ' . $file['type'] . ', Size: ' . $file['size'] . ', Error: ' . $file['error']);
        
        // Validate file
        if ($file['error'] !== UPLOAD_ERR_OK) {
            error_log('Wolfx Backup: Upload error code: ' . $file['error']);
            wp_send_json_error('Erro no upload do arquivo: ' . $this->get_upload_error_message($file['error']));
        }

        // Validate file type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        error_log('Wolfx Backup: Detected MIME type: ' . $mime_type);

        if (!in_array($mime_type, array('application/zip', 'application/x-zip-compressed'))) {
            error_log('Wolfx Backup: Invalid file type: ' . $mime_type);
            wp_send_json_error('O arquivo deve ser um arquivo ZIP válido. Tipo detectado: ' . $mime_type);
        }

        // Get restore options
        $restore_db = isset($_POST['restore_db']) && $_POST['restore_db'] === 'on';
        $restore_files = isset($_POST['restore_files']) && $_POST['restore_files'] === 'on';
        error_log('Wolfx Backup: Restore options - DB: ' . ($restore_db ? 'yes' : 'no') . ', Files: ' . ($restore_files ? 'yes' : 'no'));

        // Ensure backup directory exists and is writable
        if (!file_exists(WOLFX_BACKUP_BACKUP_DIR)) {
            if (!wp_mkdir_p(WOLFX_BACKUP_BACKUP_DIR)) {
                error_log('Wolfx Backup: Failed to create backup directory');
                wp_send_json_error('Não foi possível criar o diretório de backup');
            }
        }

        if (!is_writable(WOLFX_BACKUP_BACKUP_DIR)) {
            error_log('Wolfx Backup: Backup directory is not writable');
            wp_send_json_error('O diretório de backup não tem permissão de escrita');
        }

        // Move uploaded file to backup directory
        $filename = 'wolfx-backup-import-' . date('Y-m-d-H-i-s') . '.zip';
        $filepath = WOLFX_BACKUP_BACKUP_DIR . $filename;
        error_log('Wolfx Backup: Moving file to: ' . $filepath);

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            error_log('Wolfx Backup: Failed to move uploaded file. PHP error: ' . error_get_last()['message']);
            wp_send_json_error('Erro ao salvar o arquivo de backup. Verifique as permissões do diretório.');
        }

        // Validate the imported backup
        try {
            error_log('Wolfx Backup: Creating temp directory for validation');
            $temp_dir = WOLFX_BACKUP_BACKUP_DIR . 'wolfx-temp-validate-' . uniqid();
            if (!wp_mkdir_p($temp_dir)) {
                throw new Exception('Não foi possível criar diretório temporário para validação');
            }

            error_log('Wolfx Backup: Extracting backup file');
            require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
            $zip = new PclZip($filepath);
            $result = $zip->extract(PCLZIP_OPT_PATH, $temp_dir);
            
            if ($result === 0) {
                throw new Exception('Erro ao extrair arquivo ZIP: ' . $zip->errorInfo(true));
            }

            error_log('Wolfx Backup: Validating backup compatibility');
            $compatibility = $this->validate_backup_compatibility($temp_dir);
            
            if (is_wp_error($compatibility)) {
                unlink($filepath);
                $this->remove_directory($temp_dir);
                throw new Exception($compatibility->get_error_message());
            }

            // If restore options are selected, perform the restore
            if ($restore_db || $restore_files) {
                error_log('Wolfx Backup: Starting restore process');
                $restore_result = $this->restore_backup($filepath, array(
                    'restore_db' => $restore_db,
                    'restore_themes' => $restore_files,
                    'restore_plugins' => $restore_files,
                    'restore_uploads' => $restore_files
                ));

                if (is_wp_error($restore_result)) {
                    $this->remove_directory($temp_dir);
                    throw new Exception($restore_result->get_error_message());
                }
                error_log('Wolfx Backup: Restore completed successfully');
            }

            $this->remove_directory($temp_dir);
            error_log('Wolfx Backup: Import process completed successfully');

            wp_send_json_success(array(
                'message' => 'Backup importado com sucesso',
                'file' => $filename
            ));
        } catch (Exception $e) {
            error_log('Wolfx Backup: Error during import: ' . $e->getMessage());
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            if (isset($temp_dir) && file_exists($temp_dir)) {
                $this->remove_directory($temp_dir);
            }
            wp_send_json_error($e->getMessage());
        }
    }

    private function get_upload_error_message($error_code) {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return 'O arquivo excede o tamanho máximo permitido pelo PHP (upload_max_filesize)';
            case UPLOAD_ERR_FORM_SIZE:
                return 'O arquivo excede o tamanho máximo permitido pelo formulário HTML';
            case UPLOAD_ERR_PARTIAL:
                return 'O arquivo foi enviado parcialmente';
            case UPLOAD_ERR_NO_FILE:
                return 'Nenhum arquivo foi enviado';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Falta uma pasta temporária';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Falha ao gravar arquivo em disco';
            case UPLOAD_ERR_EXTENSION:
                return 'Uma extensão PHP interrompeu o upload do arquivo';
            default:
                return 'Erro desconhecido no upload';
        }
    }

    public function ajax_get_backup_list() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        ob_start();
        $this->render_backup_list();
        $html = ob_get_clean();

        wp_send_json_success($html);
    }

    public function ajax_delete_backup() {
        check_ajax_referer('wolfx_backup_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Permissão negada');
        }

        $backup_file = isset($_POST['backup_file']) ? sanitize_file_name($_POST['backup_file']) : '';
        if (empty($backup_file)) {
            wp_send_json_error('Arquivo de backup não especificado');
        }

        $backup_path = WOLFX_BACKUP_BACKUP_DIR . $backup_file;
        if (!file_exists($backup_path)) {
            wp_send_json_error('Arquivo de backup não encontrado');
        }

        if (!unlink($backup_path)) {
            wp_send_json_error('Erro ao excluir arquivo de backup');
        }

        wp_send_json_success('Backup excluído com sucesso');
    }
}

// Initialize the plugin
function wolfx_backup_init() {
    WolfxBackup::get_instance();
}
add_action('plugins_loaded', 'wolfx_backup_init'); 