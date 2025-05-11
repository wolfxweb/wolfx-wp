<?php
/**
 * Template part for displaying services section
 */
?>

<section id="servicos" class="py-16 bg-support">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4 text-center" style="color: #1E2A47;">
            <?php echo esc_html(get_theme_mod('wolfx_services_title', 'Nossos Serviços')); ?>
        </h2>
        <p class="text-lg text-center mb-12 text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            <?php echo esc_html(get_theme_mod('wolfx_services_subtitle', 'Oferecemos soluções tecnológicas completas para impulsionar seu negócio')); ?>
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $services = get_theme_mod('wolfx_services', array(
                array(
                    'icon' => 'fas fa-code',
                    'title' => 'Desenvolvimento de sistemas sob demanda',
                    'description' => 'Criamos sistemas personalizados que atendem exatamente às necessidades do seu negócio, com foco em usabilidade e escalabilidade.',
                    'features' => array(
                        'Sistemas web e desktop',
                        'Arquitetura moderna',
                        'Suporte contínuo'
                    )
                ),
                array(
                    'icon' => 'fas fa-robot',
                    'title' => 'Automação e integrações',
                    'description' => 'Automatize processos e integre seus sistemas para aumentar a eficiência e reduzir custos operacionais.',
                    'features' => array(
                        'Automação de processos',
                        'Integração de sistemas',
                        'Workflows inteligentes'
                    )
                ),
                array(
                    'icon' => 'fas fa-mobile-alt',
                    'title' => 'Aplicativos Android & iOS',
                    'description' => 'Desenvolvemos aplicativos nativos e híbridos com foco em performance e experiência do usuário.',
                    'features' => array(
                        'Apps nativos',
                        'UI/UX moderno',
                        'Manutenção contínua'
                    )
                ),
                array(
                    'icon' => 'fas fa-laptop-code',
                    'title' => 'Criação de sites e landing pages',
                    'description' => 'Sites modernos e otimizados para conversão, com foco em resultados e experiência do usuário.',
                    'features' => array(
                        'Design responsivo',
                        'SEO otimizado',
                        'Alta performance'
                    )
                ),
                array(
                    'icon' => 'fas fa-brain',
                    'title' => 'Soluções com Inteligência Artificial',
                    'description' => 'Implementamos soluções de IA para automatizar processos e extrair insights valiosos dos seus dados.',
                    'features' => array(
                        'Machine Learning',
                        'Análise preditiva',
                        'Automação inteligente'
                    )
                ),
                array(
                    'icon' => 'fas fa-shield-alt',
                    'title' => 'Segurança e Compliance',
                    'description' => 'Proteja seus dados e sistemas com soluções robustas de segurança e conformidade regulatória.',
                    'features' => array(
                        'LGPD e GDPR',
                        'Segurança da informação',
                        'Auditoria e compliance'
                    )
                ),
            ));

            foreach ($services as $service): ?>
                <div class="service-card p-8 bg-white rounded-xl shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-icon text-4xl mb-6"><i class="<?php echo esc_attr($service['icon']); ?>" style="color: #4CAF50;"></i></div>
                    <h3 class="text-xl font-semibold mb-4" style="color: #1E2A47;">
                        <?php echo esc_html($service['title']); ?>
                    </h3>
                    <p class="text-gray-600 mb-4"><?php echo esc_html($service['description']); ?></p>
                    <?php if (!empty($service['features'])): ?>
                        <ul class="text-gray-600 space-y-2">
                            <?php foreach ($service['features'] as $feature): ?>
                                <li><i class="fas fa-check text-secondary mr-2"></i><?php echo esc_html($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> 