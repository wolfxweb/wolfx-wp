<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="desenvolvimento de software, aplicativos, automação, sistemas web, tecnologia, soluções digitais, sites, landing pages, inteligência artificial, integração de sistemas, automação de processos, consultoria em TI, inovação, transformação digital, empresa de tecnologia, desenvolvimento sob demanda, apps Android, apps iOS, segurança da informação, compliance, SEO, design responsivo">
    <?php wp_head(); ?>
    
    <style>
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .service-icon {
            transition: transform 0.3s ease;
        }
        .service-card:hover .service-icon {
            transform: scale(1.1);
        }

        /* Animações do Hero */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animated-gradient {
            background: linear-gradient(-45deg, 
                #1E2A47,
                #1E2A47,
                #2A3A5A,
                #1E2A47
            );
            background-size: 400% 400%;
            animation: gradient 25s ease infinite;
            position: relative;
        }

        .animated-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(-45deg,
                rgba(76, 175, 80, 0.05),
                rgba(42, 58, 90, 0.05),
                rgba(76, 175, 80, 0.05)
            );
            background-size: 400% 400%;
            animation: gradient 20s ease infinite;
            mix-blend-mode: overlay;
        }
    </style>
</head>
<body <?php body_class('bg-background text-text'); ?>>
<?php wp_body_open(); ?>

<!-- Header -->
<header class="text-white" style="background-color: #1E2A47;">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center">
            <div>
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<h1 class="text-3xl font-bold"><span style="color:#fff">Wol</span><span style="color:#4CAF50">x</span></h1>';
                }
                ?>
            </div>
            <nav class="hidden md:block">
                <ul class="flex space-x-8">
                    <li><a href="#servicos" class="hover:text-secondary transition-colors duration-300">Serviços</a></li>
                    <li><a href="#projetos" class="hover:text-secondary transition-colors duration-300">Projetos</a></li>
                    <li><a href="#diferenciais" class="hover:text-secondary transition-colors duration-300">Diferenciais</a></li>
                    <li><a href="#depoimentos" class="hover:text-secondary transition-colors duration-300">Depoimentos</a></li>
                    <li><a href="#contato" class="hover:text-secondary transition-colors duration-300">Contato</a></li>
                </ul>
            </nav>
            <button class="md:hidden text-2xl text-secondary" id="menuButton">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
    <!-- Menu Mobile -->
    <div class="md:hidden hidden" id="mobileMenu">
        <ul class="container mx-auto px-4 py-4 space-y-4">
            <li><a href="#servicos" class="block hover:text-secondary transition-colors duration-300">Serviços</a></li>
            <li><a href="#projetos" class="block hover:text-secondary transition-colors duration-300">Projetos</a></li>
            <li><a href="#diferenciais" class="block hover:text-secondary transition-colors duration-300">Diferenciais</a></li>
            <li><a href="#depoimentos" class="block hover:text-secondary transition-colors duration-300">Depoimentos</a></li>
            <li><a href="#contato" class="block hover:text-secondary transition-colors duration-300">Contato</a></li>
        </ul>
    </div>
</header>