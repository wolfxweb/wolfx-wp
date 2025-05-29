<?php
/**
 * The template for displaying the footer
 */
?>

    <footer id="colophon" class="site-footer bg-primary text-white mt-auto">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3 class="h4 mb-3">wolfx</h3>
                        <p class="text-white-50">
                            <?php bloginfo('description'); ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3 class="h4 mb-3"><?php esc_html_e('Quick Links', 'wolfx-wp'); ?></h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'list-unstyled',
                            'container'      => false,
                            'fallback_cb'    => '__return_false',
                            'depth'          => 1,
                            'link_before'    => '<span class="text-white-50">',
                            'link_after'     => '</span>',
                        ));
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h3 class="h4 mb-3"><?php esc_html_e('Contact', 'wolfx-wp'); ?></h3>
                        <p class="text-white-50">
                            <?php esc_html_e('Email: contact@example.com', 'wolfx-wp'); ?><br>
                            <?php esc_html_e('Phone: (123) 456-7890', 'wolfx-wp'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 text-center text-white-50">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> wolfx. <?php esc_html_e('All rights reserved.', 'wolfx-wp'); ?></p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html> 