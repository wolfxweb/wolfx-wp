<?php get_header(); ?>

<main id="primary" class="site-main py-5">
    <div class="container">
        <?php if (have_posts()) : ?>
            <header class="page-header mb-4">
                <?php
                the_archive_title('<h1 class="page-title h2">', '</h1>');
                the_archive_description('<div class="archive-description text-muted">', '</div>');
                ?>
            </header>

            <div class="row g-4">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-img-top overflow-hidden" style="height: 200px;">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-100 h-100 object-fit-cover']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="card-body">
                                <header class="entry-header mb-3">
                                    <?php the_title('<h2 class="entry-title card-title h5 mb-2"><a href="' . esc_url(get_permalink()) . '" class="text-decoration-none text-dark" rel="bookmark">', '</a></h2>'); ?>

                                    <?php if ('post' === get_post_type()) : ?>
                                        <div class="entry-meta text-muted small">
                                            <?php
                                            wolfx_wp_posted_on();
                                            echo ' <span class="mx-1">•</span> ';
                                            wolfx_wp_posted_by();
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </header>

                                <div class="entry-summary card-text">
                                    <?php the_excerpt(); ?>
                                </div>

                                <footer class="entry-footer mt-3">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-primary btn-sm">
                                        <?php esc_html_e('Read More', 'wolfx-wp'); ?>
                                    </a>
                                </footer>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>

            <nav class="pagination mt-4">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="bi bi-arrow-left"></i>',
                    'next_text' => '<i class="bi bi-arrow-right"></i>',
                    'class'     => 'pagination justify-content-center',
                ));
                ?>
            </nav>

        <?php else : ?>
            <div class="alert alert-info">
                <h2 class="h4 mb-3"><?php esc_html_e('Nothing Found', 'wolfx-wp'); ?></h2>
                <p class="mb-0"><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wolfx-wp'); ?></p>
            </div>

            <?php get_search_form(); ?>

        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?> 