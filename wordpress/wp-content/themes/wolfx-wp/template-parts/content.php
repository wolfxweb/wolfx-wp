<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-list-item mb-4'); ?>>
    <div class="card h-100">
        <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>
            </a>
        <?php endif; ?>
        <div class="card-body">
            <div class="mb-2">
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="badge bg-primary me-1 text-decoration-none">' . esc_html($category->name) . '</a>';
                    }
                } else {
                    echo '<span class="badge bg-primary me-1">Sem categoria</span>';
                }
                ?>
            </div>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="entry-meta">
                <span><i class="bi bi-calendar"></i> <?php echo get_the_date(); ?></span>
                <span><i class="bi bi-person"></i> <?php the_author(); ?></span>
            </div>
            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>
            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Ler mais</a>
        </div>
    </div>
</article> 