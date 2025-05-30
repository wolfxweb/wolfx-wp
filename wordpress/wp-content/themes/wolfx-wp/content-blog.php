<?php
/**
 * Template part for displaying blog posts
 */
?>

<div class="blog-filters mb-4">
    <div class="row g-3">
        <div class="col-md-7">
            <!-- Filtro de Pesquisa por Título -->
            <div class="widget widget_search">
                <form role="search" method="get" class="search-form">
                    <div class="input-group">
                        <input type="search" id="title-search" class="search-field form-control" placeholder="Digite o título..." value="" name="s">
                        <button type="submit" class="btn btn-primary search-submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <!-- Filtro de Categorias -->
            <div class="widget widget_categories">
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
        </div>
    </div>
</div>

<div id="search-results">
    <?php
    if (have_posts()) :
        echo '<div class="row g-4">';
        while (have_posts()) :
            the_post();
            ?>
            <div class="col-md-4">
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-list-item h-100'); ?>>
                    <div class="card h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="card-img-top overflow-hidden" style="height: 200px;">
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-100 h-100 object-fit-cover']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <header class="entry-header">
                                <?php the_title('<h2 class="entry-title h5"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <i class="bi bi-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo '<span class="cat-links"><i class="bi bi-folder"></i> ';
                                        foreach ($categories as $cat) {
                                            echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                                        }
                                        echo '</span>';
                                    }
                                    ?>
                                </div>
                            </header>

                            <div class="entry-content flex-grow-1">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="entry-footer mt-3">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary w-100">Ler mais</a>
                            </footer>
                        </div>
                    </div>
                </article>
            </div>
            <?php
        endwhile;
        echo '</div>';

        echo '<div class="mt-5">';
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => '<i class="bi bi-chevron-left"></i>',
            'next_text' => '<i class="bi bi-chevron-right"></i>',
        ));
        echo '</div>';

    else :
        ?>
        <div class="alert alert-info">
            Nenhum post encontrado.
        </div>
        <?php
    endif;
    ?>
</div>

<script>
jQuery(document).ready(function($) {
    // Função para realizar a busca
    function performSearch() {
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
        searchTimeout = setTimeout(performSearch, 500);
    });

    // Evento de busca ao mudar categoria
    $('#category-filter').on('change', function() {
        performSearch();
    });

    // Prevenir envio do formulário
    $('.search-form').on('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
});
</script> 