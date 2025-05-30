jQuery(document).ready(function($) {
    var searchTimer;
    
    // Função para realizar a busca
    function performSearch() {
        var searchQuery = $('#search-form-1').val();
        
        if (searchQuery.length < 2) {
            $('#search-results').empty();
            return;
        }

        $.ajax({
            url: ajax_search_params.ajax_url,
            type: 'POST',
            data: {
                action: 'ajax_search',
                search: searchQuery,
                nonce: ajax_search_params.nonce
            },
            beforeSend: function() {
                $('#search-results').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Carregando...</span></div></div>');
            },
            success: function(response) {
                $('#search-results').html(response);
                // Se estiver na página do blog, atualiza a listagem de posts
                if ($('#primary').length) {
                    $('#primary').html(response);
                }
            }
        });
    }

    // Busca ao clicar no botão
    $(document).on('click', '.search-submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        performSearch();
    });

    // Busca em tempo real enquanto digita
    $(document).on('input', '#search-form-1', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(performSearch, 500);
    });

    // Prevenir qualquer comportamento padrão do formulário
    $(document).on('submit', '#ajax-search-form', function(e) {
        e.preventDefault();
        e.stopPropagation();
        performSearch();
        return false;
    });

    // Prevenir o comportamento padrão ao pressionar Enter
    $(document).on('keypress', '#search-form-1', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            e.stopPropagation();
            performSearch();
            return false;
        }
    });

    // Prevenir o comportamento padrão do WordPress
    $(document).on('submit', 'form[role="search"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    });
}); 