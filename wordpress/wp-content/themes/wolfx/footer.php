    <!-- Footer -->
    <footer class="text-white" style="background-color: #1E2A47;">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-12">
                <!-- Informações de Contato -->
                <div class="space-y-6">
                    <h3 class="text-2xl font-bold mb-6">Wolx</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-map-marker-alt mt-1" style="color: #4CAF50;"></i>
                            <div>
                                <h4 class="font-semibold mb-1">Endereço</h4>
                                <p class="text-gray-300">Rua: Delamar jose silva, 180 - Kobrasol<br>São José - SC, 88102-110</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-phone mt-1" style="color: #4CAF50;"></i>
                            <div>
                                <h4 class="font-semibold mb-1">Telefone</h4>
                                <p class="text-gray-300">(48) 98419-2339</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <i class="fas fa-envelope mt-1" style="color: #4CAF50;"></i>
                            <div>
                                <h4 class="font-semibold mb-1">E-mail</h4>
                                <p class="text-gray-300">contato@wolx.com.br</p>
                            </div>
                        </div>
                    </div>
                    <!-- Redes Sociais -->
                    <div class="flex space-x-4 pt-4">
                        <a href="#" class="hover:text-secondary transition-colors" style="color: #4CAF50;">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-secondary transition-colors" style="color: #4CAF50;">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="hover:text-secondary transition-colors" style="color: #4CAF50;">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                    </div>
                </div>
                <!-- Mapa -->
                <div class="h-64 md:h-full rounded-lg overflow-hidden shadow-lg">
                    <iframe 
                        src="https://www.google.com/maps?q=Rua+Delamar+Jose+Silva,+180+-+Kobrasol,+São+José+-+SC,+88102-110&output=embed"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
            <!-- Copyright -->
            <div class="border-t border-gray-700 py-6 text-center">
                <p class="text-gray-300">&copy; <?php echo date('Y'); ?> Wolx. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    <!-- Botão Flutuante de WhatsApp -->
    <a href="https://wa.me/5548984192339" class="fixed bottom-6 right-6 bg-white p-4 rounded-full shadow-lg hover:bg-opacity-90 transition-all transform hover:scale-110 hover:rotate-12" style="border: 2px solid #4CAF50;">
        <i class="fab fa-whatsapp text-2xl" style="color: #4CAF50;"></i>
    </a>
    <?php wp_footer(); ?>
</body>
</html>
