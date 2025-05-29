<?php
/**
 * The header for our theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site d-flex flex-column min-vh-100">
    <a class="skip-link visually-hidden" href="#primary"><?php esc_html_e('Skip to content', 'wolfx-wp'); ?></a>

    <header id="masthead" class="site-header bg-primary shadow">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) :
                        the_custom_logo();
                    else :
                    ?>
                        <h1 class="site-title mb-0">
                            <a href="<?php echo esc_url(home_url('/')); ?>" 
                               class="text-white text-decoration-none fw-bold fs-4" 
                               rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                    ?>
                        <p class="site-description text-white-50 mt-2 mb-0 small">
                            <?php echo $description; ?>
                        </p>
                    <?php
                        endif;
                    endif;
                    ?>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="primary-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                        'fallback_cb'    => '__return_false',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'          => 2,
                        'walker'         => new Bootstrap_5_Nav_Walker()
                    ));
                    ?>
                </div>
            </div>
        </nav>
    </header>
</body>
</html> 