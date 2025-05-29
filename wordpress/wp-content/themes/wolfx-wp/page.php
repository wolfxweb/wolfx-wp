<?php get_header(); ?>

<main id="primary" class="site-main py-5">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('card shadow-sm'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="card-img-top overflow-hidden" style="max-height: 500px;">
                        <?php the_post_thumbnail('full', ['class' => 'w-100 h-100 object-fit-cover']); ?>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <header class="entry-header mb-4">
                        <?php the_title('<h1 class="entry-title card-title h2 mb-3">', '</h1>'); ?>
                    </header>

                    <div class="entry-content card-text">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links text-primary">' . esc_html__('Pages:', 'wolfx-wp'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </div>
            </article>

            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?> 