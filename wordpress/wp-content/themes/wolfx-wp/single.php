<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <!-- Botão Voltar -->
        <div class="mb-4">
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Voltar para o Blog
            </a>
        </div>

        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post mb-5'); ?>>
                <header class="entry-header mb-4">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    <div class="entry-meta">
                        <span class="posted-on">
                            <i class="bi bi-calendar"></i>
                            <?php echo get_the_date(); ?>
                        </span>
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            echo '<span class="cat-links"><i class="bi bi-folder"></i> ';
                            foreach ($categories as $cat) {
                                echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                            }
                            echo '</span>';
                        }
                        ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail mb-4">
                        <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();
                    ?>
                </div>

                <footer class="entry-footer mt-4">
                    <?php
                    $tags = get_the_tags();
                    if ($tags) {
                        echo '<div class="post-tags mb-4">';
                        echo '<i class="bi bi-tags"></i> ';
                        foreach ($tags as $tag) {
                            echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="badge bg-primary me-2">' . esc_html($tag->name) . '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                </footer>
            </article>

            <!-- Navegação entre posts -->
            <nav class="post-navigation mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty($prev_post)) :
                            ?>
                            <div class="prev-post">
                                <span class="nav-subtitle">Post Anterior</span>
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="nav-link">
                                    <i class="bi bi-arrow-left"></i>
                                    <?php echo esc_html($prev_post->post_title); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <?php
                        $next_post = get_next_post();
                        if (!empty($next_post)) :
                            ?>
                            <div class="next-post">
                                <span class="nav-subtitle">Próximo Post</span>
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="nav-link">
                                    <?php echo esc_html($next_post->post_title); ?>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
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