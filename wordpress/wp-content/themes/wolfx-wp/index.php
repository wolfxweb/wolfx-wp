<?php
/**
 * The main template file
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    // Incluir o carrossel fora do container para ocupar largura total
    get_template_part('template-parts/carousel');
    ?>

    <div class="container py-5">
        <?php if (have_posts()) : ?>
            <?php
            // Incluir o template do blog com filtros e posts em 3 colunas
            get_template_part('content', 'blog');
            ?>
        <?php else :
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div>
</main>

<?php
get_footer(); 