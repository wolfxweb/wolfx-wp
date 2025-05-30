<?php
/**
 * The sidebar containing the main widget area
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area bg-white shadow rounded-4 p-4">
    <div class="widget-wrapper">
        <!-- Filtro de Pesquisa por Título -->
        <div class="widget widget_search mb-4">
            <h3 class="widget-title">Pesquisar por Título</h3>
            <form role="search" method="get" class="search-form">
                <div class="input-group">
                    <input type="search" id="title-search" class="search-field form-control" placeholder="Digite o título..." value="" name="s">
                    <button type="submit" class="btn btn-primary search-submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <div id="search-results"></div>
        </div>

        <!-- Filtro de Categorias -->
        <div class="widget widget_categories mb-4">
            <h3 class="widget-title">Filtrar por Categoria</h3>
            <select id="category-filter" class="form-select">
                <option value="">Todas as Categorias</option>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => true
                ));
                
                foreach ($categories as $category) {
                    echo '<option value="' . esc_attr($category->term_id) . '">' . 
                         esc_html($category->name) . ' (' . $category->count . ')</option>';
                }
                ?>
            </select>
        </div>

        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
</aside>

<script>
jQuery(document).ready(function($) {
    // Função para realizar a busca por título
    function performTitleSearch() {
        var searchQuery = $('#title-search').val();
        var categoryId = $('#category-filter').val();
        
        $.ajax({
            url: ajax_search_params.ajax_url,
            type: 'POST',
            data: {
                action: 'ajax_search',
                search: searchQuery,
                category: categoryId,
                nonce: ajax_search_params.nonce
            },
            beforeSend: function() {
                $('#search-results').html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
            },
            success: function(response) {
                $('#search-results').html(response);
            }
        });
    }

    // Evento de busca ao digitar (com debounce)
    var searchTimeout;
    $('#title-search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performTitleSearch, 500);
    });

    // Evento de busca ao mudar categoria
    $('#category-filter').on('change', function() {
        performTitleSearch();
    });

    // Prevenir envio do formulário
    $('.search-form').on('submit', function(e) {
        e.preventDefault();
        performTitleSearch();
    });
});
</script> 