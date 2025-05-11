<?php
/**
 * Wolfx Theme functions and definitions
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function wolfx_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register menu locations
    register_nav_menus(array(
        'primary' => esc_html__('Menu Principal', 'wolfx'),
        'footer' => esc_html__('Menu Rodapé', 'wolfx'),
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for core custom logo.
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
}
add_action('after_setup_theme', 'wolfx_setup');

/**
 * Enqueue scripts and styles.
 */
function wolfx_scripts() {
    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), _S_VERSION);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // AOS (Animate on Scroll)
    wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
    wp_enqueue_script('aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true);
    
    // Theme main style
    wp_enqueue_style('wolfx-style', get_stylesheet_uri(), array(), _S_VERSION);
    
    // Theme custom JavaScript
    wp_enqueue_script('wolfx-script', get_template_directory_uri() . '/js/script.js', array('jquery'), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'wolfx_scripts');

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

//include
require get_template_directory().'/include/setup.php';


//hooks
add_action('wp_enqueue_scripts', 'bm_theme_styles');
add_action('after_setup_theme', 'bm_after_setup');
add_action('widgets_init', 'bm_widgets');