<?php
/**
 * WolfX WP functions and definitions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Setup
function wolfx_wp_setup() {
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

// Enqueue scripts and styles
function wolfx_wp_scripts() {
    wp_enqueue_style('wolfx-wp-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('wolfx-tailwind', get_template_directory_uri() . '/assets/css/tailwind.min.css', array(), '3.4.3');
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'wolfx_wp_scripts');

// Register widget areas
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

// Custom template tags for this theme
require get_template_directory() . '/inc/template-tags.php';

// Functions which enhance the theme by hooking into WordPress
require get_template_directory() . '/inc/template-functions.php';

// Customizer additions
require get_template_directory() . '/inc/customizer.php';

// Admin functions
require get_template_directory() . '/inc/admin.php'; 