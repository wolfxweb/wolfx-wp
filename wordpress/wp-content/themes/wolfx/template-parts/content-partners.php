<?php
/**
 * Template part for displaying partners section
 */
?>

<section id="parceiros" class="py-16 bg-support relative overflow-hidden">
    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-secondary opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary opacity-5 rounded-full translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto px-4 relative">
        <h2 class="text-3xl font-bold mb-4 text-center" style="color: #1E2A47;">Nossos Parceiros</h2>
        <p class="text-lg text-center mb-12 text-gray-600 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            <?php echo esc_html(get_theme_mod('wolfx_partners_subtitle', 'Trabalhamos com as melhores empresas do mercado para oferecer soluções completas')); ?>
        </p>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <?php
            $partners = get_theme_mod('wolfx_partners', array(
                array(
                    'name' => 'DigitalOcean',
                    'url' => 'https://www.digitalocean.com',
                    'category' => 'Cloud Computing'
                ),
                array(
                    'name' => 'Hostinger',
                    'url' => 'https://www.hostinger.com.br',
                    'category' => 'Hospedagem Web'
                ),
                array(
                    'name' => 'GoDaddy',
                    'url' => 'https://www.godaddy.com',
                    'category' => 'Domínios & Hosting'
                ),
                array(
                    'name' => 'RegistroBR',
                    'url' => 'https://registro.br',
                    'category' => 'Registro de Domínios'
                ),
                array(
                    'name' => 'MATRIARCA AI',
                    'url' => 'https://matriarca.ai',
                    'category' => 'Inteligência Artificial'
                ),
                array(
                    'name' => 'OpenAI',
                    'url' => 'https://openai.com',
                    'category' => 'IA Avançada'
                ),
                array(
                    'name' => 'FlutterFlow',
                    'url' => 'https://flutterflow.io',
                    'category' => 'Desenvolvimento Low-Code'
                ),
                array(
                    'name' => 'N8N',
                    'url' => 'https://n8n.io',
                    'category' => 'Automação de Workflows'
                ),
            ));

            foreach ($partners as $partner): ?>
                <div class="partner-card bg-white/50 backdrop-blur-sm p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105" data-aos="fade-up" data-aos-delay="200">
                    <a href="<?php echo esc_url($partner['url']); ?>" target="_blank" class="block h-24 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold mb-2 text-white" style="text-shadow: 0 2px 8px rgba(0,0,0,0.7);">
                                <?php echo esc_html($partner['name']); ?>
                            </div>
                            <div class="text-sm text-gray-200"><?php echo esc_html($partner['category']); ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> 