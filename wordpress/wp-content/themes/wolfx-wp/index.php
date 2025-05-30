<?php
/**
 * The main template file
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <?php
        if (is_home() && !is_front_page()) :
            ?>
            <header>
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
            <?php
        endif;

        get_template_part('content', 'blog');
        ?>
    </div>
</main>

<?php
get_footer(); 