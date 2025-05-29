<?php get_header(); ?>

<main id="primary" class="site-main py-5">
    <div class="container">
        <div class="text-center">
            <h1 class="display-1 text-primary mb-4">404</h1>
            <h2 class="h3 mb-4"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'wolfx-wp'); ?></h2>
            <p class="lead mb-4"><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'wolfx-wp'); ?></p>
            <?php get_search_form(); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?> 