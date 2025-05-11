<?php get_header(); ?>

<!-- Hero Section -->
<section class="pt-32 pb-20 animated-gradient relative overflow-hidden">
    <!-- Partículas -->
    <div id="particles"></div>
    
    <div class="container mx-auto px-4 relative">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-6" data-aos="fade-up">
                Transformamos suas ideias em soluções digitais sob medida
            </h2>
            <p class="text-xl text-gray-300 mb-8" data-aos="fade-up" data-aos-delay="100">
                Desenvolvemos soluções tecnológicas inovadoras que impulsionam o crescimento do seu negócio
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                <a href="#contato" class="text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-opacity-90 transition-all transform hover:scale-105 hover:shadow-lg" style="background-color: #4CAF50;">
                    Comece seu projeto
                </a>
                <a href="#servicos" class="bg-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-all transform hover:scale-105 hover:shadow-lg" style="color: #1E2A47; border: 1px solid #e5e7eb;">
                    Conheça nossos serviços
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Serviços -->
<?php get_template_part('template-parts/content', 'services'); ?>

<!-- Projetos -->
<?php get_template_part('template-parts/content', 'projects'); ?>

<!-- Diferenciais -->
<?php get_template_part('template-parts/content', 'features'); ?>

<!-- Depoimentos -->
<?php get_template_part('template-parts/content', 'testimonials'); ?>

<!-- Parceiros -->
<?php get_template_part('template-parts/content', 'partners'); ?>

<!-- Contato -->
<?php get_template_part('template-parts/content', 'contact'); ?>

<?php get_footer(); ?>