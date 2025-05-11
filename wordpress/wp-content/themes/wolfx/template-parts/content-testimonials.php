<?php
/**
 * Template part for displaying testimonials section
 */
?>

<section id="depoimentos" class="py-16 bg-white relative overflow-hidden">
    <!-- Elementos decorativos -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-secondary opacity-5 rounded-full translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary opacity-5 rounded-full -translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto px-4 relative">
        <h2 class="text-3xl font-bold mb-4 text-center" style="color: #1E2A47;">
            <?php echo esc_html(get_theme_mod('wolfx_testimonials_title', 'O Que Nossos Clientes Dizem')); ?>
        </h2>
        <p class="text-lg text-center mb-12 text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            <?php echo esc_html(get_theme_mod('wolfx_testimonials_subtitle', 'Conheça a experiência de quem já trabalhou conosco')); ?>
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <?php
            $testimonials = get_theme_mod('wolfx_testimonials', array(
                array(
                    'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                    'name' => 'João Silva',
                    'position' => 'CEO, Tech Solutions',
                    'rating' => 5,
                    'text' => 'A Wolx transformou completamente nossa operação com um sistema personalizado. A equipe foi extremamente profissional e entregou além das expectativas.'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                    'name' => 'Maria Santos',
                    'position' => 'Diretora de Inovação, HealthTech',
                    'rating' => 5,
                    'text' => 'O projeto de IA desenvolvido pela Wolx revolucionou nosso processo de diagnóstico. A qualidade e o compromisso da equipe são excepcionais.'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                    'name' => 'Pedro Oliveira',
                    'position' => 'CTO, Delivery Express',
                    'rating' => 5,
                    'text' => 'O aplicativo de delivery desenvolvido pela Wolx superou todas as nossas expectativas. A performance e a experiência do usuário são impecáveis.'
                ),
            ));

            foreach ($testimonials as $testimonial): ?>
                <div class="bg-white p-8 rounded-xl shadow-sm transform hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
                            <img src="<?php echo esc_url($testimonial['image']); ?>" 
                                 alt="<?php echo esc_attr($testimonial['name']); ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-primary"><?php echo esc_html($testimonial['name']); ?></h3>
                            <p class="text-gray-600"><?php echo esc_html($testimonial['position']); ?></p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-4">
                        <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-gray-600 italic">
                        "<?php echo esc_html($testimonial['text']); ?>"
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> 