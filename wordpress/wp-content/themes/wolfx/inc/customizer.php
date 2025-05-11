<?php
/**
 * Wolfx Theme Customizer
 */

function wolfx_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('wolfx_hero_section', array(
        'title'    => __('Hero Section', 'wolfx'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('wolfx_hero_title', array(
        'default'           => 'Transformamos suas ideias em soluções digitais sob medida',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('wolfx_hero_title', array(
        'label'    => __('Título Hero', 'wolfx'),
        'section'  => 'wolfx_hero_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('wolfx_hero_subtitle', array(
        'default'           => 'Desenvolvemos soluções tecnológicas inovadoras que impulsionam o crescimento do seu negócio',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('wolfx_hero_subtitle', array(
        'label'    => __('Subtítulo Hero', 'wolfx'),
        'section'  => 'wolfx_hero_section',
        'type'     => 'text',
    ));

    // Informações de Contato
    $wp_customize->add_section('wolfx_contact_info', array(
        'title'    => __('Informações de Contato', 'wolfx'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('wolfx_address', array(
        'default'           => 'Av. Paulista, 1000 - Bela Vista, São Paulo - SP',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('wolfx_address', array(
        'label'    => __('Endereço', 'wolfx'),
        'section'  => 'wolfx_contact_info',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('wolfx_phone', array(
        'default'           => '(11) 9999-9999',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('wolfx_phone', array(
        'label'    => __('Telefone', 'wolfx'),
        'section'  => 'wolfx_contact_info',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('wolfx_email', array(
        'default'           => 'contato@wolfx.com.br',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('wolfx_email', array(
        'label'    => __('E-mail', 'wolfx'),
        'section'  => 'wolfx_contact_info',
        'type'     => 'email',
    ));

    $wp_customize->add_setting('wolfx_whatsapp', array(
        'default'           => '5511999999999',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('wolfx_whatsapp', array(
        'label'    => __('WhatsApp (com código do país)', 'wolfx'),
        'section'  => 'wolfx_contact_info',
        'type'     => 'text',
    ));

    // Redes Sociais
    $wp_customize->add_section('wolfx_social_media', array(
        'title'    => __('Redes Sociais', 'wolfx'),
        'priority' => 50,
    ));

    $wp_customize->add_setting('wolfx_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('wolfx_linkedin', array(
        'label'    => __('LinkedIn URL', 'wolfx'),
        'section'  => 'wolfx_social_media',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('wolfx_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('wolfx_instagram', array(
        'label'    => __('Instagram URL', 'wolfx'),
        'section'  => 'wolfx_social_media',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('wolfx_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('wolfx_facebook', array(
        'label'    => __('Facebook URL', 'wolfx'),
        'section'  => 'wolfx_social_media',
        'type'     => 'url',
    ));

    // Google Maps
    $wp_customize->add_setting('wolfx_map_embed', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('wolfx_map_embed', array(
        'label'       => __('Google Maps Embed Code', 'wolfx'),
        'description' => __('Cole aqui o código de incorporação do Google Maps', 'wolfx'),
        'section'     => 'wolfx_contact_info',
        'type'        => 'textarea',
    ));

    // Contact Form 7
    $wp_customize->add_setting('wolfx_contact_form_shortcode', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('wolfx_contact_form_shortcode', array(
        'label'       => __('Contact Form 7 Shortcode', 'wolfx'),
        'description' => __('Cole aqui o shortcode do seu formulário Contact Form 7', 'wolfx'),
        'section'     => 'wolfx_contact_info',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'wolfx_customize_register'); 