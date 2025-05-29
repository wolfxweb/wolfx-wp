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

                        <div class="entry-meta text-muted mb-4">
                            <?php
                            wolfx_wp_posted_on();
                            echo ' <span class="mx-2">•</span> ';
                            wolfx_wp_posted_by();
                            ?>
                        </div>
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

                    <footer class="entry-footer mt-4 pt-4 border-top">
                        <?php
                        $categories_list = get_the_category_list(esc_html__(', ', 'wolfx-wp'));
                        if ($categories_list) {
                            printf('<div class="cat-links mb-2"><strong class="text-primary">' . esc_html__('Categories: ', 'wolfx-wp') . '</strong><span class="text-muted">%1$s</span></div>', $categories_list);
                        }

                        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'wolfx-wp'));
                        if ($tags_list) {
                            printf('<div class="tags-links"><strong class="text-primary">' . esc_html__('Tags: ', 'wolfx-wp') . '</strong><span class="text-muted">%1$s</span></div>', $tags_list);
                        }
                        ?>
                    </footer>
                </div>
            </article>

            <nav class="post-navigation mt-4">
                <?php
                the_post_navigation(array(
                    'prev_text' => '<div class="text-primary">' . esc_html__('Previous:', 'wolfx-wp') . '</div> <div class="text-dark">%title</div>',
                    'next_text' => '<div class="text-primary">' . esc_html__('Next:', 'wolfx-wp') . '</div> <div class="text-dark">%title</div>',
                    'class'     => 'nav-links d-flex justify-content-between',
                ));
                ?>
            </nav>

            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?> 