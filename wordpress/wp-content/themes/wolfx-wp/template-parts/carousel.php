<?php
/**
 * Template part for displaying the carousel
 */
?>

<div id="mainCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <!-- Indicadores -->
    <div class="carousel-indicators">
        <?php
        $active = true;
        for ($i = 1; $i <= 5; $i++) {
            if (get_theme_mod('carousel_image_' . $i)) {
                echo '<button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="' . ($i - 1) . '" ' . 
                     ($active ? 'class="active" aria-current="true"' : '') . '></button>';
                $active = false;
            }
        }
        ?>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php
        $active = true;
        for ($i = 1; $i <= 5; $i++) {
            $image = get_theme_mod('carousel_image_' . $i);
            if ($image) {
                $title = get_theme_mod('carousel_title_' . $i);
                $description = get_theme_mod('carousel_description_' . $i);
                $link = get_theme_mod('carousel_link_' . $i);
                ?>
                <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                    <?php if ($link) : ?>
                        <a href="<?php echo esc_url($link); ?>">
                    <?php endif; ?>
                    
                    <img src="<?php echo esc_url($image); ?>" class="d-block w-100" alt="<?php echo esc_attr($title); ?>">
                    
                    <?php if ($title || $description) : ?>
                        <div class="carousel-caption">
                            <?php if ($title) : ?>
                                <h2><?php echo esc_html($title); ?></h2>
                            <?php endif; ?>
                            <?php if ($description) : ?>
                                <p><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($link) : ?>
                        </a>
                    <?php endif; ?>
                </div>
                <?php
                $active = false;
            }
        }
        ?>
    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div> 