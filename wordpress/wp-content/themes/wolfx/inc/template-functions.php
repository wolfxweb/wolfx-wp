<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wolfx_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'wolfx_pingback_header');

/**
 * Add custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wolfx_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_action('body_class', 'wolfx_body_classes');

/**
 * Add custom menu classes
 */
function wolfx_menu_classes($classes, $item, $args) {
    if ($args->theme_location === 'primary') {
        $classes[] = 'hover:text-secondary transition-colors duration-300';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'wolfx_menu_classes', 10, 3);

/**
 * Add custom menu link attributes
 */
function wolfx_menu_link_attributes($atts, $item, $args) {
    if ($args->theme_location === 'primary') {
        $atts['class'] = 'hover:text-secondary transition-colors duration-300';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'wolfx_menu_link_attributes', 10, 3);

/**
 * Customize excerpt length
 */
function wolfx_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'wolfx_excerpt_length');

/**
 * Customize excerpt more
 */
function wolfx_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'wolfx_excerpt_more');

/**
 * Add custom image sizes
 */
function wolfx_add_image_sizes() {
    add_image_size('wolfx-project', 800, 600, true);
    add_image_size('wolfx-testimonial', 100, 100, true);
}
add_action('after_setup_theme', 'wolfx_add_image_sizes');

/**
 * Register widget area
 */
function wolfx_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'wolfx'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'wolfx'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'wolfx_widgets_init'); 