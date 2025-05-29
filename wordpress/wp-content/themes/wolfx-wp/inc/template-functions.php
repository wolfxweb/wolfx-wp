<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wolfx_wp_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'wolfx_wp_pingback_header');

/**
 * Add custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wolfx_wp_body_classes($classes) {
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
add_filter('body_class', 'wolfx_wp_body_classes');

/**
 * Add custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function wolfx_wp_post_classes($classes) {
    if (!is_singular()) {
        $classes[] = 'post-preview';
    }
    return $classes;
}
add_filter('post_class', 'wolfx_wp_post_classes'); 