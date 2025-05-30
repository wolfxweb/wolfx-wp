<?php
/**
 * The template for displaying the front page
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Inovação + Tecnologia = Resultados Reais</h1>
                    <p class="lead mb-4">Somos especialistas em transformar desafios em soluções digitais. Com mais de 10 anos de experiência, combinamos tecnologia de ponta, metodologias ágeis e um time altamente qualificado para entregar projetos que impulsionam o crescimento do seu negócio.</p>
                    <a href="#contato" class="btn btn-primary btn-lg">Fale Conosco</a>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.svg" alt="Hero Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços Section -->
    <section class="services-section py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Sites Institucionais -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-globe display-4 text-primary mb-3"></i>
                            <h3 class="h4 mb-3">Sites Institucionais</h3>
                            <p class="mb-0">Sites que transmitem confiança e credibilidade para sua empresa.</p>
                            <ul class="list-unstyled mt-3">
                                <li>Design Profissional</li>
                                <li>Conteúdo Otimizado</li>
                                <li>Integração com Redes Sociais</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Lojas Virtuais -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-cart display-4 text-primary mb-3"></i>
                            <h3 class="h4 mb-3">Lojas Virtuais</h3>
                            <p class="mb-0">E-commerce prontos para vender 24/7 com máxima segurança.</p>
                            <ul class="list-unstyled mt-3">
                                <li>Pagamentos Seguros</li>
                                <li>Gestão de Estoque</li>
                                <li>Integração com Marketplaces</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sistemas Web -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-code-square display-4 text-primary mb-3"></i>
                            <h3 class="h4 mb-3">Sistemas Web</h3>
                            <p class="mb-0">Sistemas personalizados feitos exatamente para sua necessidade.</p>
                            <ul class="list-unstyled mt-3">
                                <li>Desenvolvimento Sob Medida</li>
                                <li>Integração com APIs</li>
                                <li>Painel Administrativo</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Automação de Processos -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-gear display-4 text-primary mb-3"></i>
                            <h3 class="h4 mb-3">Automação de Processos</h3>
                            <p class="mb-0">Elimine tarefas repetitivas e reduza erros com automação inteligente.</p>
                            <ul class="list-unstyled mt-3">
                                <li>Processos Automatizados</li>
                                <li>Redução de Erros</li>
                                <li>Maior Eficiência</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5 text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">Pronto para Transformar sua Ideia em Realidade?</h2>
            <p class="lead mb-4">Vamos trabalhar juntos para criar a solução perfeita para o seu negócio.</p>
            <a href="#contato" class="btn btn-primary btn-lg">Fale Conosco</a>
        </div>
    </section>

    <!-- Diferenciais Section -->
    <section class="diferenciais-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Nossos Diferenciais</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="bi bi-lightning display-4 text-primary mb-3"></i>
                        <h3 class="h4">Agilidade na entrega</h3>
                        <p>Entregas rápidas e eficientes, respeitando prazos e qualidade</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="bi bi-puzzle display-4 text-primary mb-3"></i>
                        <h3 class="h4">Soluções personalizadas</h3>
                        <p>Desenvolvimento sob medida para atender suas necessidades específicas</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="bi bi-cpu display-4 text-primary mb-3"></i>
                        <h3 class="h4">Tecnologia de ponta</h3>
                        <p>Utilizamos as mais modernas tecnologias e metodologias do mercado</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="bi bi-people display-4 text-primary mb-3"></i>
                        <h3 class="h4">Atendimento próximo</h3>
                        <p>Suporte dedicado e acompanhamento personalizado do seu projeto</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parceiros Section -->
    <section class="parceiros-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nossos Parceiros</h2>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="text-center">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/parceiros/digitalocean.svg" alt="DigitalOcean" class="img-fluid mb-3">
                        <h3 class="h5">DigitalOcean</h3>
                        <p>Cloud Computing</p>
                    </div>
                </div>
                <!-- Adicione os outros parceiros aqui -->
            </div>
        </div>
    </section>

    <!-- Tecnologias Section -->
    <section class="tecnologias-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Tecnologias que Utilizamos</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="text-center">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tecnologias/java.svg" alt="Java" class="img-fluid mb-3">
                        <h3 class="h6">Java</h3>
                    </div>
                </div>
                <!-- Adicione as outras tecnologias aqui -->
            </div>
        </div>
    </section>

    <!-- Depoimentos Section -->
    <section class="depoimentos-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">O Que Nossos Clientes Dizem</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar bg-primary text-white rounded-circle me-3">JS</div>
                                <div>
                                    <h3 class="h5 mb-0">João Silva</h3>
                                    <p class="text-muted mb-0">CEO, Tech Solutions</p>
                                </div>
                            </div>
                            <p class="mb-0">"A Wolx transformou completamente nossa operação com um sistema personalizado. A equipe foi extremamente profissional e entregou além das expectativas."</p>
                        </div>
                    </div>
                </div>
                <!-- Adicione os outros depoimentos aqui -->
            </div>
        </div>
    </section>

    <!-- Contato Section -->
    <section id="contato" class="contato-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-4">Fale Conosco</h2>
                    <div class="mb-4">
                        <h3 class="h5">Endereço</h3>
                        <p>Rua: Delamar jose silva, 180 - Kobrasol<br>
                        São José - SC, 88102-110</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5">Telefone</h3>
                        <p>(48) 98419-2339</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="h5">E-mail</h3>
                        <p>contato@wolx.com.br</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php echo do_shortcode('[contact-form-7 id="FORM_ID" title="Formulário de Contato"]'); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer(); 