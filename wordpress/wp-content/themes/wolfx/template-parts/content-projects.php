<?php
/**
 * Template part for displaying projects section
 */
?>

<section id="projetos" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center" style="color: #1E2A47;">
            <?php echo esc_html(get_theme_mod('wolfx_projects_title', 'Nossos Projetos')); ?>
        </h2>
        <p class="text-lg text-center mb-12 text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            <?php echo esc_html(get_theme_mod('wolfx_projects_subtitle', 'Conheça alguns dos nossos cases de sucesso')); ?>
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $projects = get_theme_mod('wolfx_projects', array(
                array(
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'title' => 'Sistema de Analytics',
                    'description' => 'Dashboard completo para análise de dados em tempo real',
                    'category' => 'Data Analytics'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'title' => 'App de Delivery',
                    'description' => 'Aplicativo completo para entrega de alimentos',
                    'category' => 'Mobile App'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'title' => 'E-commerce Premium',
                    'description' => 'Plataforma completa de vendas online',
                    'category' => 'E-commerce'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'title' => 'Automação Industrial',
                    'description' => 'Sistema de controle e automação para indústria',
                    'category' => 'IoT'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'title' => 'CRM Personalizado',
                    'description' => 'Sistema de gestão de relacionamento com clientes',
                    'category' => 'CRM'
                ),
                array(
                    'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                    'title' => 'IA para Saúde',
                    'description' => 'Sistema de diagnóstico com inteligência artificial',
                    'category' => 'AI/ML'
                ),
            ));

            foreach ($projects as $project): ?>
                <div class="group relative overflow-hidden rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative h-64 w-full bg-gray-200">
                        <img src="<?php echo esc_url($project['image']); ?>"
                             alt="<?php echo esc_attr($project['title']); ?>"
                             class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute bottom-0 left-0 right-0 p-4 z-10">
                            <h3 class="text-lg md:text-xl font-bold text-white" style="text-shadow: 0 2px 8px rgba(0,0,0,0.7);">
                                <?php echo esc_html($project['title']); ?>
                            </h3>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 z-20">
                        <div class="absolute bottom-0 p-6 text-white">
                            <p class="text-sm mb-4"><?php echo esc_html($project['description']); ?></p>
                            <span class="inline-block bg-secondary px-3 py-1 rounded-full text-sm">
                                <?php echo esc_html($project['category']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> 