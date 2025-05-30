<?php
/**
 * WolfX WP functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function wolfx_wp_setup() {
    load_theme_textdomain('wolfx-wp', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'wolfx-wp'),
        'footer' => esc_html__('Footer Menu', 'wolfx-wp'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'wolfx_wp_setup');

function wolfx_wp_content_width() {
    $GLOBALS['content_width'] = apply_filters('wolfx_wp_content_width', 1200);
}
add_action('after_setup_theme', 'wolfx_wp_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function wolfx_wp_scripts() {
    // jQuery
    wp_enqueue_script('jquery');
    
    // Bootstrap CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    
    // Bootstrap Icons
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
    
    // Theme stylesheet
    wp_enqueue_style('wolfx-wp-style', get_stylesheet_uri());
    
    // Bootstrap Bundle JS (includes Popper)
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), '', true);

    // Registrar e enfileirar o script de busca AJAX
    wp_enqueue_script('ajax-search', get_template_directory_uri() . '/assets/js/ajax-search.js', array('jquery'), '', true);
    wp_localize_script('ajax-search', 'ajax_search_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax_search_nonce')
    ));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'wolfx_wp_scripts');

/**
 * Register widget area.
 */
function wolfx_wp_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'wolfx-wp'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'wolfx-wp'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'wolfx_wp_widgets_init');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

// Admin functions
require get_template_directory() . '/inc/admin.php';

/**
 * Nav Walker
 */
require get_template_directory() . '/inc/class-bootstrap-5-nav-walker.php';

/**
 * Generate a unique ID for use in HTML elements.
 *
 * @param string $prefix Optional. A prefix for the ID. Default empty.
 * @return string The unique ID.
 */
function wolfx_wp_unique_id($prefix = '') {
    static $id_counter = 0;
    return $prefix . (++$id_counter);
}

// Remover o widget de busca padrão do WordPress
function remove_default_search_widget() {
    unregister_widget('WP_Widget_Search');
}
add_action('widgets_init', 'remove_default_search_widget');

// Remover o formulário de busca padrão do WordPress
function remove_default_search_form() {
    remove_filter('get_search_form', 'get_search_form');
}
add_action('init', 'remove_default_search_form');

// Substitui o formulário de busca padrão por um customizado moderno
add_filter('get_search_form', function($form) {
    ob_start();
    ?>
    <div class="search-form-wrapper">
        <form role="search" method="get" class="search-form" id="ajax-search-form">
            <div class="input-group">
                <input type="search" id="search-form-1" class="search-field form-control" placeholder="Buscar..." value="" name="s">
                <button type="submit" class="btn btn-primary search-submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        <div id="search-results"></div>
    </div>
    <?php
    return ob_get_clean();
});

// Adicionar script para AJAX search
function wolfx_wp_ajax_search() {
    ?>
    <script type="text/javascript">
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
    </script>
    <?php
}
add_action('wp_footer', 'wolfx_wp_ajax_search');

// Função para processar a busca AJAX
function wolfx_wp_ajax_search_callback() {
    check_ajax_referer('ajax_search_nonce', 'nonce');

    $search = sanitize_text_field($_POST['search']);
    $category = isset($_POST['category']) ? intval($_POST['category']) : 0;

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        's' => $search
    );

    // Adicionar filtro por categoria se selecionada
    if ($category > 0) {
        $args['cat'] = $category;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="search-results-container">';
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <article class="post">
                <header class="entry-header">
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
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
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>
            <?php
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-info">Nenhum resultado encontrado.</div>';
    }

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_ajax_search', 'wolfx_wp_ajax_search_callback');
add_action('wp_ajax_nopriv_ajax_search', 'wolfx_wp_ajax_search_callback'); 