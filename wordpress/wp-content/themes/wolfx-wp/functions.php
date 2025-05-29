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
    // Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    
    // Bootstrap Icons
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');
    
    // Theme stylesheet
    wp_enqueue_style('wolfx-wp-style', get_stylesheet_uri(), array(), _S_VERSION);
    
    // Bootstrap Bundle JS (includes Popper)
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '5.3.2', true);
    
    // Theme custom scripts
    wp_enqueue_script('wolfx-wp-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true);

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
        'before_widget' => '<section id="%1$s" class="widget card %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title card-header">',
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