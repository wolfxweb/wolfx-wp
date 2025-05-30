<?php
/**
 * The template for displaying the footer
 */
?>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <!-- Informações de Contato -->
                <div class="col-md-6">
                    <div class="footer-info">
                        <?php
                        if (has_custom_logo()) :
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            echo '<a href="' . esc_url(home_url('/')) . '" rel="home">';
                            echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="img-fluid" style="height: 50px;">';
                            echo '</a>';
                        else :
                        ?>
                            <h2 class="mb-4">Wolx</h2>
                        <?php endif; ?>
                        <div class="mb-3">
                            <h3 class="h5 mb-2"><i class="bi bi-geo-alt me-2"></i>Endereço</h3>
                            <p class="mb-0">Rua: Delamar jose silva, 180 - Kobrasol<br>
                            São José - SC, 88102-110</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <h3 class="h5 mb-0"><i class="bi bi-telephone me-2"></i>Telefone:</h3>
                                <span class="ms-2">(48) 98419-2339</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <h3 class="h5 mb-0"><i class="bi bi-envelope me-2"></i>E-mail:</h3>
                                <span class="ms-2">contato@wolx.com.br</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Google Maps -->
                <div class="col-md-6">
                    <div class="footer-map">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3536.1234567890123!2d-48.6164!3d-27.5954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9527384e5e5c5c5c%3A0x1234567890abcdef!2sRua%20Delamar%20Jose%20Silva%2C%20180%20-%20Kobrasol%2C%20S%C3%A3o%20Jos%C3%A9%20-%20SC%2C%2088102-110!5e0!3m2!1spt-BR!2sbr!4v1234567890!5m2!1spt-BR!2sbr" 
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="text-center">
                        <p class="mb-0">&copy; <?php echo date('Y'); ?> Wolx. Todos os direitos reservados.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>


</body>
</html> 