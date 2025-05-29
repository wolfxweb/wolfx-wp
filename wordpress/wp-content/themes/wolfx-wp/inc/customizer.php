<?php
/**
 * WolfX WP Theme Customizer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wolfx_wp_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'wolfx_wp_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'wolfx_wp_customize_partial_blogdescription',
            )
        );
    }

    // Add Theme Colors Section
    $wp_customize->add_section(
        'wolfx_wp_colors',
        array(
            'title'    => __('Theme Colors', 'wolfx-wp'),
            'priority' => 30,
        )
    );

    // Primary Color
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#007bff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'    => __('Primary Color', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'primary_color',
            )
        )
    );

    // Secondary Color
    $wp_customize->add_setting(
        'secondary_color',
        array(
            'default'           => '#6c757d',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            array(
                'label'    => __('Secondary Color', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'secondary_color',
            )
        )
    );
}
add_action('customize_register', 'wolfx_wp_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function wolfx_wp_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function wolfx_wp_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wolfx_wp_customize_preview_js() {
    wp_enqueue_script('wolfx-wp-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'wolfx_wp_customize_preview_js'); 