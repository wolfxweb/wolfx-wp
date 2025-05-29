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
 * Add a custom excerpt length.
 *
 * @param int $length Excerpt length.
 * @return int
 */
function wolfx_wp_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'wolfx_wp_excerpt_length');

/**
 * Add a custom excerpt more string.
 *
 * @param string $more The string shown within the more link.
 * @return string
 */
function wolfx_wp_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'wolfx_wp_excerpt_more');

/**
 * Add custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function wolfx_wp_post_classes($classes) {
    if (!is_singular()) {
        $classes[] = 'card';
    }

    return $classes;
}
add_filter('post_class', 'wolfx_wp_post_classes');

/**
 * Add custom classes to the array of comment classes.
 *
 * @param array $classes Classes for the comment element.
 * @return array
 */
function wolfx_wp_comment_classes($classes) {
    $classes[] = 'card';
    $classes[] = 'mb-3';

    return $classes;
}
add_filter('comment_class', 'wolfx_wp_comment_classes');

/**
 * Add custom classes to the comment form.
 *
 * @param array $defaults The default comment form arguments.
 * @return array
 */
function wolfx_wp_comment_form_defaults($defaults) {
    $commenter = wp_get_current_commenter();
    $defaults['class_form'] = 'comment-form';
    $defaults['class_submit'] = 'btn btn-primary';
    $defaults['comment_field'] = '<div class="comment-form-comment mb-3"><label for="comment" class="form-label">' . _x('Comment', 'noun', 'wolfx-wp') . '</label><textarea id="comment" name="comment" class="form-control" rows="8" required></textarea></div>';
    $defaults['comment_notes_before'] = '<p class="comment-notes text-muted mb-3">' . esc_html__('Your email address will not be published. Required fields are marked *', 'wolfx-wp') . '</p>';
    $defaults['fields'] = array(
        'author' => '<div class="comment-form-author mb-3"><label for="author" class="form-label">' . esc_html__('Name', 'wolfx-wp') . ' <span class="required">*</span></label><input id="author" name="author" type="text" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></div>',
        'email'  => '<div class="comment-form-email mb-3"><label for="email" class="form-label">' . esc_html__('Email', 'wolfx-wp') . ' <span class="required">*</span></label><input id="email" name="email" type="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></div>',
        'url'    => '<div class="comment-form-url mb-3"><label for="url" class="form-label">' . esc_html__('Website', 'wolfx-wp') . '</label><input id="url" name="url" type="url" class="form-control" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>',
    );

    return $defaults;
}
add_filter('comment_form_defaults', 'wolfx_wp_comment_form_defaults');

/**
 * Add custom classes to the pagination.
 *
 * @param array $args The pagination arguments.
 * @return array
 */
function wolfx_wp_pagination_args($args) {
    $args['prev_text'] = '<i class="bi bi-arrow-left"></i>';
    $args['next_text'] = '<i class="bi bi-arrow-right"></i>';
    $args['class'] = 'pagination justify-content-center';

    return $args;
}
add_filter('navigation_markup_template', 'wolfx_wp_pagination_args');

/**
 * Add custom classes to the search form.
 *
 * @param string $form The search form HTML.
 * @return string
 */
function wolfx_wp_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">
        <div class="input-group">
            <input type="search" class="form-control" placeholder="' . esc_attr_x('Search &hellip;', 'placeholder', 'wolfx-wp') . '" value="' . get_search_query() . '" name="s" />
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
                <span class="visually-hidden">' . esc_html_x('Search', 'submit button', 'wolfx-wp') . '</span>
            </button>
        </div>
    </form>';

    return $form;
}
add_filter('get_search_form', 'wolfx_wp_search_form'); 