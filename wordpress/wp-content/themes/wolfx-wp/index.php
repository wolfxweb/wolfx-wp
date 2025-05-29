<?php
/**
 * The main template file
 */

get_header();
?>

<main id="primary" class="site-main py-5">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="row g-4">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-md-6 col-lg-4">
                        <article id="post-<?php the_ID(); ?>" <?php post_class('card h-100 shadow-sm'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-img-top overflow-hidden" style="height: 200px;">
                                    <?php the_post_thumbnail('large', ['class' => 'w-100 h-100 object-fit-cover']); ?>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <header class="entry-header mb-3">
                                    <?php the_title('<h2 class="entry-title card-title h4 mb-2">', '</h2>'); ?>
                                    <div class="entry-meta small text-muted mb-2">
                                        <?php wolfx_wp_posted_on(); ?>
                                        <span class="mx-1">•</span>
                                        <?php wolfx_wp_posted_by(); ?>
                                    </div>
                                </header>
                                <div class="entry-content card-text text-muted mb-3">
                                    <?php the_excerpt(); ?>
                                </div>
                                <footer class="entry-footer mt-auto">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-primary">
                                        <?php esc_html_e('Read More', 'wolfx-wp'); ?>
                                    </a>
                                </footer>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>

            <nav class="pagination justify-content-center mt-5">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="bi bi-chevron-left"></i>',
                    'next_text' => '<i class="bi bi-chevron-right"></i>',
                    'class'     => 'pagination',
                ));
                ?>
            </nav>

        <?php else : ?>
            <div class="text-center py-5">
                <h2 class="h3 mb-3"><?php esc_html_e('Nothing Found', 'wolfx-wp'); ?></h2>
                <p class="text-muted mb-4"><?php esc_html_e("It seems we can't find what you're looking for.", 'wolfx-wp'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_sidebar();
get_footer(); 