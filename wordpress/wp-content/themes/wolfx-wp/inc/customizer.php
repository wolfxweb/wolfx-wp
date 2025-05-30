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
            'default'           => '#112240',
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
            'default'           => '#FFFFFF',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'section_background_color',
            array(
                'label'    => __('Section Background Color (Branco)', 'wolfx-wp'),
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

    // Adicionar seção para o carrossel
    $wp_customize->add_section(
        'wolfx_wp_carousel',
        array(
            'title'    => __('Carrossel de Banners', 'wolfx-wp'),
            'priority' => 35,
        )
    );

    // Configurações para até 5 banners
    for ($i = 1; $i <= 5; $i++) {
        // Imagem do banner
        $wp_customize->add_setting(
            'carousel_image_' . $i,
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'carousel_image_' . $i,
                array(
                    'label'    => sprintf(__('Banner %d - Imagem', 'wolfx-wp'), $i),
                    'section'  => 'wolfx_wp_carousel',
                    'settings' => 'carousel_image_' . $i,
                )
            )
        );

        // Título do banner
        $wp_customize->add_setting(
            'carousel_title_' . $i,
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            'carousel_title_' . $i,
            array(
                'label'    => sprintf(__('Banner %d - Título', 'wolfx-wp'), $i),
                'section'  => 'wolfx_wp_carousel',
                'type'     => 'text',
            )
        );

        // Descrição do banner
        $wp_customize->add_setting(
            'carousel_description_' . $i,
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_textarea_field',
            )
        );

        $wp_customize->add_control(
            'carousel_description_' . $i,
            array(
                'label'    => sprintf(__('Banner %d - Descrição', 'wolfx-wp'), $i),
                'section'  => 'wolfx_wp_carousel',
                'type'     => 'textarea',
            )
        );

        // Link do banner
        $wp_customize->add_setting(
            'carousel_link_' . $i,
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            'carousel_link_' . $i,
            array(
                'label'    => sprintf(__('Banner %d - Link', 'wolfx-wp'), $i),
                'section'  => 'wolfx_wp_carousel',
                'type'     => 'url',
            )
        );
    }
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
            --bs-background: <?php echo esc_attr(get_theme_mod('background_color', '#112240')); ?>;
            --bs-section-bg: <?php echo esc_attr(get_theme_mod('section_background_color', '#FFFFFF')); ?>;
            --bs-success: <?php echo esc_attr(get_theme_mod('success_color', '#64FFDA')); ?>;
            --bs-warning: <?php echo esc_attr(get_theme_mod('warning_color', '#FFC857')); ?>;
        }

        /* Ajustes do Navbar */
        .navbar {
            background-color: var(--bs-background) !important;
            max-height: 25px;
            padding: 0;
            min-height: 25px;
        }

        .navbar-dark {
            background-color: var(--bs-background) !important;
        }

        .site-branding {
            display: flex;
            align-items: center;
            height: 25px;
            padding: 0;
        }

        .custom-logo-link {
            height: 25px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-logo-link img {
            height: 25px !important;
            width: auto !important;
            padding: 0 !important;
            margin: 0 !important;
            object-fit: contain;
            object-position: center;
        }

        .site-title {
            margin: 0;
            line-height: 25px;
            height: 25px;
        }

        .site-title a {
            font-size: 0.875rem;
            line-height: 25px;
            height: 25px;
            display: block;
            padding: 0;
        }

        .site-description {
            display: none;
        }

        /* Ajuste do menu para altura menor */
        .navbar-nav {
            line-height: 25px;
            height: 25px;
        }

        .navbar-nav .nav-link {
            padding: 0 1rem;
            font-size: 0.875rem;
            line-height: 25px;
            height: 25px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link:hover {
            color: var(--bs-accent) !important;
        }

        .navbar-collapse {
            height: 25px;
        }

        .navbar-toggler {
            padding: 0;
            height: 25px;
            width: 25px;
        }

        .navbar-toggler-icon {
            width: 1rem;
            height: 1rem;
        }

        /* Resto do CSS existente */
        body {
            background-color: var(--bs-section-bg);
            color: #333;
        }

        .site-header {
            background-color: var(--bs-background) !important;
        }

        .site-footer {
            background-color: var(--bs-background) !important;
            color: var(--bs-text-secondary);
        }

        .site-content {
            background-color: var(--bs-section-bg);
            color: #333;
        }

        .section {
            background-color: var(--bs-section-bg);
        }

        a {
            color: var(--bs-accent);
        }

        a:hover {
            color: var(--bs-primary);
        }

        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: var(--bs-text);
        }

        .btn-secondary {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
            color: var(--bs-text);
        }

        .btn-accent {
            background-color: var(--bs-accent);
            border-color: var(--bs-accent);
            color: var(--bs-primary);
        }

        .text-muted {
            color: #666 !important;
        }

        #colophon {
            background-color: var(--bs-background) !important;
        }

        /* Ajustes para o conteúdo principal */
        #primary {
            background-color: var(--bs-section-bg);
            color: #333;
        }

        .entry-title {
            color: var(--bs-primary);
        }

        .entry-content {
            color: #333;
        }

        .widget-title {
            color: var(--bs-primary);
        }

        .widget {
            color: #333;
        }

        /* Estilos para a listagem de posts */
        .post-list-item {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }

        .post-list-item:hover {
            transform: translateX(5px);
        }

        .post-list-item .entry-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .post-list-item .entry-title a {
            color: var(--bs-primary);
            text-decoration: none;
        }

        .post-list-item .entry-title a:hover {
            color: var(--bs-accent);
        }

        .post-list-item .entry-meta {
            color: var(--bs-text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .post-list-item .entry-content {
            color: #333;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .post-list-item .entry-content p {
            margin-bottom: 0.5rem;
        }

        /* Estilo para o card destacado */
        .card {
            background: #fff;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .card .entry-title {
            font-size: 1.75rem;
            margin-bottom: 1rem;
            color: var(--bs-primary);
        }

        .card .entry-title a {
            color: var(--bs-primary);
            text-decoration: none;
        }

        .card .entry-title a:hover {
            color: var(--bs-accent);
        }

        .card .entry-meta {
            color: var(--bs-text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .card .entry-content {
            color: #333;
            line-height: 1.6;
            font-size: 1rem;
        }

        .card .entry-content p {
            margin-bottom: 1rem;
        }

        .card .btn-primary {
            background-color: var(--bs-accent);
            border-color: var(--bs-accent);
            color: #fff;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .card .btn-primary:hover {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            transform: translateY(-2px);
        }

        /* Estilo para o formulário de busca */
        .search-form {
            margin-bottom: 2rem;
        }

        .search-form .search-field {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            width: 100%;
        }

        .search-form .search-submit {
            background-color: var(--bs-accent);
            border: none;
            border-radius: 4px;
            color: #fff;
            padding: 0.5rem 1rem;
            margin-top: 0.5rem;
        }

        .search-form .search-submit:hover {
            background-color: var(--bs-primary);
        }

        /* Estilo para a paginação */
        .pagination {
            margin-top: 2rem;
        }

        .pagination .page-numbers {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: var(--bs-primary);
            margin: 0 0.25rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
        }

        .pagination .page-numbers.current {
            background-color: var(--bs-accent);
            border-color: var(--bs-accent);
            color: #fff;
        }

        .pagination .page-numbers:hover {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: #fff;
        }

        /* Estilos para a Sidebar */
        .widget-area {
            padding: 1.5rem !important;
            background: #fff !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
        }

        .widget-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Estilo para o widget de busca */
        .widget_search {
            margin-bottom: 2rem !important;
        }

        .widget_search .widget-title,
        .widget_categories .widget-title {
            font-size: 1.1rem !important;
            font-weight: 600 !important;
            color: var(--bs-primary) !important;
            margin-bottom: 1rem !important;
            padding-bottom: 0.5rem !important;
            border-bottom: 2px solid var(--bs-accent) !important;
        }

        .widget_search .search-form {
            margin: 0 !important;
        }

        .widget_search .input-group {
            display: flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            background: #f8fafc !important;
            border-radius: 32px !important;
            padding: 0.5rem !important;
            box-shadow: 0 2px 8px rgba(63,182,242,0.07) !important;
        }

        .widget_search .search-field {
            flex: 1 !important;
            border: none !important;
            background: transparent !important;
            padding: 0.5rem 1rem !important;
            font-size: 1rem !important;
            color: var(--bs-primary) !important;
        }

        .widget_search .search-field:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .widget_search .search-submit {
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%) !important;
            color: #fff !important;
            border: none !important;
            padding: 0.5rem 1rem !important;
            border-radius: 24px !important;
            font-size: 1rem !important;
            box-shadow: 0 2px 8px rgba(63,182,242,0.10) !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(.4,0,.2,1) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: auto !important;
        }

        .widget_search .search-submit:hover, 
        .widget_search .search-submit:focus {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-accent) 100%) !important;
            transform: translateY(-2px) scale(1.03) !important;
            box-shadow: 0 4px 16px rgba(63,182,242,0.18) !important;
        }

        .widget_search .search-submit i {
            font-size: 1.1rem !important;
        }

        /* Estilo para o filtro de categorias */
        .widget_categories select.form-select {
            width: 100% !important;
            padding: 0.75rem 1rem !important;
            font-size: 1rem !important;
            color: var(--bs-primary) !important;
            background-color: #f8fafc !important;
            border: 1px solid rgba(63,182,242,0.1) !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 8px rgba(63,182,242,0.07) !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
            appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%230A192F' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 1rem center !important;
            background-size: 16px 12px !important;
        }

        .widget_categories select.form-select:hover {
            border-color: var(--bs-accent) !important;
            box-shadow: 0 4px 12px rgba(63,182,242,0.12) !important;
        }

        .widget_categories select.form-select:focus {
            border-color: var(--bs-accent) !important;
            box-shadow: 0 0 0 3px rgba(63,182,242,0.15) !important;
            outline: none !important;
        }

        .widget_categories select.form-select option {
            padding: 0.5rem !important;
            font-size: 1rem !important;
            color: var(--bs-primary) !important;
        }

        /* Estilos para os resultados da busca AJAX */
        #search-results {
            margin-top: 2rem;
        }

        .search-results-container {
            display: grid;
            gap: 1.5rem;
        }

        .search-results-container .post {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .search-results-container .post:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .search-results-container .entry-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .search-results-container .entry-title a {
            color: var(--bs-primary);
            text-decoration: none;
        }

        .search-results-container .entry-title a:hover {
            color: var(--bs-accent);
        }

        .search-results-container .entry-meta {
            color: var(--bs-text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .search-results-container .entry-content {
            color: #333;
            line-height: 1.6;
        }

        .search-results-container .entry-content p {
            margin-bottom: 1rem;
        }

        /* Spinner de carregamento */
        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--bs-accent);
        }

        /* Mensagem de nenhum resultado */
        .alert-info {
            background-color: #f8fafc;
            border-color: var(--bs-accent);
            color: var(--bs-primary);
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        /* Garantir que a sidebar seja visível em todas as páginas */
        #secondary,
        .widget-area {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Garantir que os widgets sejam visíveis */
        #secondary .widget,
        .widget-area .widget {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Traduzir o título do widget de categorias */
        .widget_categories .widget-title::before {
            content: 'Categorias';
            display: block;
        }

        .widget_categories .widget-title {
            font-size: 0 !important;
        }

        /* Remover regras que escondem widgets */
        .widget-area .widget:not(.widget_search):not(.widget_categories) {
            display: block !important;
        }

        /* Estilos para a página do blog */
        .blog-filters {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .blog-filters .widget_search {
            margin-bottom: 0 !important;
        }

        .blog-filters .widget_categories {
            margin-bottom: 0 !important;
        }

        .blog-filters .form-select {
            height: 100%;
            min-height: 48px;
        }

        .blog-filters .input-group {
            height: 48px;
        }

        .blog-filters .search-field {
            height: 48px;
            font-size: 1rem;
            padding-left: 1.25rem;
        }

        .blog-filters .search-submit {
            height: 40px !important;
            width: 40px !important;
            min-width: 40px !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
        }

        .blog-filters .search-submit i {
            font-size: 1.1rem !important;
            margin: 0 !important;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--bs-primary);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--bs-accent);
        }

        .post-list-item {
            transition: transform 0.3s ease;
        }

        .post-list-item:hover {
            transform: translateY(-5px);
        }

        .post-list-item .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: box-shadow 0.3s ease;
            height: 100%;
        }

        .post-list-item:hover .card {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .post-list-item .card-img-top {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .post-list-item .card-body {
            padding: 1.5rem;
        }

        .post-list-item .entry-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .post-list-item .entry-title a {
            color: var(--bs-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .post-list-item .entry-title a:hover {
            color: var(--bs-accent);
        }

        .post-list-item .entry-meta {
            color: var(--bs-text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .post-list-item .entry-meta i {
            margin-right: 0.25rem;
        }

        .post-list-item .entry-content {
            color: #666;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .post-list-item .entry-content p {
            margin-bottom: 0;
        }

        .post-list-item .btn-primary {
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 24px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .post-list-item .btn-primary:hover {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-accent) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63,182,242,0.2);
        }

        /* Paginação */
        .pagination {
            margin-top: 3rem;
            justify-content: center;
        }

        .pagination .page-numbers {
            background: #fff;
            border: 1px solid rgba(63,182,242,0.1);
            color: var(--bs-primary);
            margin: 0 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .pagination .page-numbers.current {
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
            border-color: transparent;
            color: #fff;
        }

        .pagination .page-numbers:hover {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-accent) 100%);
            border-color: transparent;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63,182,242,0.2);
        }

        /* Estilos para o Post Individual */
        .blog-post {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .blog-post .entry-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .blog-post .entry-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .blog-post .entry-meta span {
            margin-right: 1rem;
        }

        .blog-post .entry-meta i {
            margin-right: 0.3rem;
        }

        .blog-post .entry-meta a {
            color: #666;
            text-decoration: none;
        }

        .blog-post .entry-meta a:hover {
            color: var(--primary-color);
        }

        .blog-post .post-thumbnail {
            margin: -2rem -2rem 2rem;
        }

        .blog-post .post-thumbnail img {
            width: 100%;
            height: auto;
            border-radius: 0;
        }

        .blog-post .entry-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
        }

        .blog-post .entry-content p {
            margin-bottom: 1.5rem;
        }

        .blog-post .post-tags {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .blog-post .post-tags .badge {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            text-decoration: none;
        }

        /* Navegação entre posts */
        .post-navigation {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .post-navigation .nav-subtitle {
            display: block;
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .post-navigation .nav-link {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
        }

        .post-navigation .nav-link:hover {
            color: var(--primary-color);
        }

        .post-navigation .prev-post i {
            margin-right: 0.5rem;
        }

        .post-navigation .next-post i {
            margin-left: 0.5rem;
        }

        /* Área de Comentários */
        .comments-area {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .comments-area .comments-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .comment-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .comment {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .comment:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .comment-meta {
            margin-bottom: 1rem;
        }

        .comment-author {
            font-weight: 600;
        }

        .comment-metadata {
            font-size: 0.8rem;
            color: #666;
        }

        .comment-content {
            color: #444;
            line-height: 1.6;
        }

        .comment-respond {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .comment-respond .comment-reply-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .comment-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .comment-form input[type="text"],
        .comment-form input[type="email"],
        .comment-form input[type="url"],
        .comment-form textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .comment-form textarea {
            min-height: 150px;
        }

        .comment-form .submit {
            background: var(--primary-color);
            color: #fff;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .comment-form .submit:hover {
            background: var(--primary-color-dark);
        }

        /* Estilo do botão voltar */
        .site-main .container .mb-4 .btn-primary {
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 24px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: auto;
            min-width: 200px;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(63,182,242,0.1);
        }

        .site-main .container .mb-4 .btn-primary:hover {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-accent) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63,182,242,0.2);
            color: #fff;
            text-decoration: none;
        }

        .site-main .container .mb-4 .btn-primary i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .site-main .container .mb-4 .btn-primary:hover i {
            transform: translateX(-3px);
        }

        /* Estilos do Carrossel */
        .carousel {
            margin: 0;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
        }

        .carousel-item {
            height: 300px;
        }

        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .carousel-caption {
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
            left: 0;
            right: 0;
            bottom: 0;
            padding: 2rem;
            text-align: left;
        }

        .carousel-caption h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .carousel-caption p {
            font-size: 1rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            max-width: 600px;
        }

        .carousel-indicators {
            margin-bottom: 2rem;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 8px;
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
            border: none;
            transition: all 0.3s ease;
            opacity: 0.5;
        }

        .carousel-indicators button.active {
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
            opacity: 1;
            transform: scale(1.2);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 10%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .carousel:hover .carousel-control-prev,
        .carousel:hover .carousel-control-next {
            opacity: 0.8;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
            border-radius: 50%;
            padding: 1rem;
            filter: brightness(0) invert(1);
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-accent) 100%);
            filter: brightness(0) invert(1) drop-shadow(0 0 2px rgba(255,255,255,0.5));
        }

        /* Estilo para o badge de categoria */
        .badge.bg-primary {
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%) !important;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 20px;
            transition: all 0.3s ease;
            color: #fff !important;
        }

        .badge.bg-primary:hover {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-accent) 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63,182,242,0.2);
            color: #fff !important;
        }

        .badge.bg-primary.text-decoration-none {
            text-decoration: none !important;
        }

        /* Estilos da Página Inicial */
        .hero-section {
            background: linear-gradient(135deg, var(--bs-background) 0%, var(--bs-primary) 100%);
            color: var(--bs-text);
            padding: 6rem 0;
        }

        .hero-section h1 {
            color: var(--bs-text);
        }

        .hero-section .lead {
            color: var(--bs-text-secondary);
        }

        .services-section .card {
            transition: transform 0.3s ease;
        }

        .services-section .card:hover {
            transform: translateY(-5px);
        }

        .services-section .bi {
            color: var(--bs-accent);
        }

        .cta-section {
            background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-background) 100%);
            color: var(--bs-text);
            padding: 4rem 0;
        }

        .diferenciais-section .bi {
            color: var(--bs-accent);
        }

        .parceiros-section img {
            max-height: 60px;
            filter: grayscale(100%);
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .parceiros-section img:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        .tecnologias-section img {
            max-height: 50px;
            transition: transform 0.3s ease;
        }

        .tecnologias-section img:hover {
            transform: scale(1.1);
        }

        .depoimentos-section .avatar {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background: linear-gradient(90deg, var(--bs-accent) 0%, var(--bs-primary) 100%);
        }

        .contato-section {
            background-color: var(--bs-section-bg);
        }

        .contato-section h2 {
            color: var(--bs-primary);
        }

        .contato-section h3 {
            color: var(--bs-accent);
        }
    </style>
    <?php
}
add_action('wp_head', 'wolfx_wp_customize_css'); 