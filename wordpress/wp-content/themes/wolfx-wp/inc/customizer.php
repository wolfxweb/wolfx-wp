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

    // Add section for theme colors
    $wp_customize->add_section(
        'wolfx_wp_colors',
        array(
            'title'    => __('Theme Colors', 'wolfx-wp'),
            'priority' => 30,
        )
    );

    // Primary color
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#0A192F',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'    => __('Primary Color (Azul Escuro)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'primary_color',
            )
        )
    );

    // Secondary color
    $wp_customize->add_setting(
        'secondary_color',
        array(
            'default'           => '#1C3B70',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            array(
                'label'    => __('Secondary Color (Azul Médio)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'secondary_color',
            )
        )
    );

    // Accent color
    $wp_customize->add_setting(
        'accent_color',
        array(
            'default'           => '#3FB6F2',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'accent_color',
            array(
                'label'    => __('Accent Color (Azul Elétrico)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'accent_color',
            )
        )
    );

    // Text color
    $wp_customize->add_setting(
        'text_color',
        array(
            'default'           => '#E6F1FF',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'text_color',
            array(
                'label'    => __('Text Color (Cinza Claro)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'text_color',
            )
        )
    );

    // Secondary text color
    $wp_customize->add_setting(
        'secondary_text_color',
        array(
            'default'           => '#A8B2D1',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_text_color',
            array(
                'label'    => __('Secondary Text Color (Cinza Médio)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'secondary_text_color',
            )
        )
    );

    // Background color
    $wp_customize->add_setting(
        'background_color',
        array(
            'default'           => '#020C1B',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'background_color',
            array(
                'label'    => __('Background Color (Azul Muito Escuro)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'background_color',
            )
        )
    );

    // Section background color
    $wp_customize->add_setting(
        'section_background_color',
        array(
            'default'           => '#112240',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'section_background_color',
            array(
                'label'    => __('Section Background Color (Azul Neutro)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'section_background_color',
            )
        )
    );

    // Success color
    $wp_customize->add_setting(
        'success_color',
        array(
            'default'           => '#64FFDA',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'success_color',
            array(
                'label'    => __('Success Color (Verde Suave)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'success_color',
            )
        )
    );

    // Warning color
    $wp_customize->add_setting(
        'warning_color',
        array(
            'default'           => '#FFC857',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'warning_color',
            array(
                'label'    => __('Warning Color (Amarelo Dourado)', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'warning_color',
            )
        )
    );

    // Info color
    $wp_customize->add_setting(
        'info_color',
        array(
            'default'           => '#0dcaf0',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'info_color',
            array(
                'label'    => __('Info Color', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'info_color',
            )
        )
    );

    // Danger color
    $wp_customize->add_setting(
        'danger_color',
        array(
            'default'           => '#dc3545',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'danger_color',
            array(
                'label'    => __('Danger Color', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'danger_color',
            )
        )
    );

    // Light color
    $wp_customize->add_setting(
        'light_color',
        array(
            'default'           => '#f8f9fa',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'light_color',
            array(
                'label'    => __('Light Color', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'light_color',
            )
        )
    );

    // Dark color
    $wp_customize->add_setting(
        'dark_color',
        array(
            'default'           => '#212529',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'dark_color',
            array(
                'label'    => __('Dark Color', 'wolfx-wp'),
                'section'  => 'wolfx_wp_colors',
                'settings' => 'dark_color',
            )
        )
    );
}
add_action('customize_register', 'wolfx_wp_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wolfx_wp_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wolfx_wp_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wolfx_wp_customize_preview_js() {
    wp_enqueue_script('wolfx-wp-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), _S_VERSION, true);
}
add_action('customize_preview_init', 'wolfx_wp_customize_preview_js');

/**
 * Output custom CSS for theme colors.
 */
function wolfx_wp_customize_css() {
    ?>
    <style type="text/css">
        :root {
            --bs-primary: <?php echo esc_attr(get_theme_mod('primary_color', '#0A192F')); ?>;
            --bs-secondary: <?php echo esc_attr(get_theme_mod('secondary_color', '#1C3B70')); ?>;
            --bs-accent: <?php echo esc_attr(get_theme_mod('accent_color', '#3FB6F2')); ?>;
            --bs-text: <?php echo esc_attr(get_theme_mod('text_color', '#E6F1FF')); ?>;
            --bs-text-secondary: <?php echo esc_attr(get_theme_mod('secondary_text_color', '#A8B2D1')); ?>;
            --bs-background: <?php echo esc_attr(get_theme_mod('background_color', '#020C1B')); ?>;
            --bs-section-bg: <?php echo esc_attr(get_theme_mod('section_background_color', '#112240')); ?>;
            --bs-success: <?php echo esc_attr(get_theme_mod('success_color', '#64FFDA')); ?>;
            --bs-warning: <?php echo esc_attr(get_theme_mod('warning_color', '#FFC857')); ?>;
        }

        body {
            background-color: var(--bs-background);
            color: var(--bs-text);
        }

        .site-header {
            background-color: var(--bs-primary);
        }

        .site-footer {
            background-color: var(--bs-primary);
            color: var(--bs-text-secondary);
        }

        .section {
            background-color: var(--bs-section-bg);
        }

        a {
            color: var(--bs-accent);
        }

        a:hover {
            color: var(--bs-text);
        }

        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }

        .btn-secondary {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }

        .btn-accent {
            background-color: var(--bs-accent);
            border-color: var(--bs-accent);
            color: var(--bs-primary);
        }

        .text-muted {
            color: var(--bs-text-secondary) !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'wolfx_wp_customize_css'); 