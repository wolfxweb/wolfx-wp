<?php
/**
 * Template part for displaying features section
 */
?>

<section id="diferenciais" class="py-16 bg-support">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center" style="color: #1E2A47;">
            <?php echo esc_html(get_theme_mod('wolfx_features_title', 'Nossos Diferenciais')); ?>
        </h2>
        <p class="text-lg text-center mb-12 text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            <?php echo esc_html(get_theme_mod('wolfx_features_subtitle', 'O que nos torna únicos no mercado')); ?>
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $features = get_theme_mod('wolfx_features', array(
                array(
                    'icon' => 'fas fa-bolt',
                    'title' => 'Agilidade na entrega'
                ),
                array(
                    'icon' => 'fas fa-puzzle-piece',
                    'title' => 'Soluções personalizadas'
                ),
                array(
                    'icon' => 'fas fa-microchip',
                    'title' => 'Tecnologia de ponta'
                ),
                array(
                    'icon' => 'fas fa-headset',
                    'title' => 'Atendimento próximo'
                )
            ));

            foreach ($features as $feature): ?>
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <i class="<?php echo esc_attr($feature['icon']); ?> text-3xl mb-4" style="color: #4CAF50;"></i>
                    <h3 class="text-lg font-semibold"><?php echo esc_html($feature['title']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    footer.bg-primary { background-color: #1E2A47 !important; }
    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
        pointer-events: none;
        animation: float 30s infinite linear;
    }
    @keyframes float {
        0% { transform: translateY(0) translateX(0) rotate(0deg); opacity: 0; }
        50% { opacity: 0.3; }
        100% { transform: translateY(-100vh) translateX(100px) rotate(360deg); opacity: 0; }
    }
</style> 