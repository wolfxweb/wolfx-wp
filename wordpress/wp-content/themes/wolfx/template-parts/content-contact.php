<?php
/**
 * Template part for displaying contact section
 */
?>

<?php
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wolfx_nome'])) {
    $nome = sanitize_text_field($_POST['wolfx_nome']);
    $email = sanitize_email($_POST['wolfx_email']);
    $msg = sanitize_textarea_field($_POST['wolfx_mensagem']);

    $to = 'wolfxweb@gmail.com';
    $subject = 'Novo contato pelo site';
    $body = "Nome: $nome\nE-mail: $email\nMensagem:\n$msg";
    $headers = array('Content-Type: text/plain; charset=UTF-8');

    if (wp_mail($to, $subject, $body, $headers)) {
        $mensagem = '<div class="p-4 mb-4 text-green-700 bg-green-100 rounded">Mensagem enviada com sucesso!</div>';
    } else {
        $mensagem = '<div class="p-4 mb-4 text-red-700 bg-red-100 rounded">Erro ao enviar. Tente novamente.</div>';
    }
}
?>

<section id="contato" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8 text-center" style="color: #1E2A47;">
            <?php echo esc_html(get_theme_mod('wolfx_contact_title', 'Contato')); ?>
        </h2>
        <p class="text-lg text-center mb-8 text-gray-600">
            <?php echo esc_html(get_theme_mod('wolfx_contact_subtitle', 'Está pronto para transformar seu projeto? Vamos conversar!')); ?>
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Informações de Contato -->
            <div class="space-y-6">
                <div class="bg-support p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-lg">
                            <i class="fab fa-whatsapp text-2xl" style="color: #4CAF50;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1" style="color: #1E2A47;">WhatsApp</h3>
                            <p class="text-gray-600"><?php _e('Atendimento rápido e direto', 'wolfx'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-support p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-lg">
                            <i class="fas fa-envelope text-2xl" style="color: #4CAF50;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1" style="color: #1E2A47;">E-mail</h3>
                            <p class="text-gray-600"><?php echo esc_html(get_theme_mod('wolfx_email', 'contato@wolx.com.br')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-support p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center space-x-4">
                        <div class="bg-secondary bg-opacity-10 p-3 rounded-lg">
                            <i class="fas fa-clock text-2xl" style="color: #4CAF50;"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1" style="color: #1E2A47;">Horário</h3>
                            <p class="text-gray-600"><?php echo esc_html(get_theme_mod('wolfx_business_hours', 'Seg - Sex: 9h às 18h')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulário -->
            <div class="bg-support p-8 rounded-xl shadow-sm">
                <?php echo $mensagem; ?>
                <form method="post" class="space-y-6">
                    <div class="relative">
                        <input type="text" name="wolfx_nome" placeholder="Nome" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary focus:ring-opacity-20 transition-all bg-white">
                        <i class="fas fa-user absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <div class="relative">
                        <input type="email" name="wolfx_email" placeholder="E-mail" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary focus:ring-opacity-20 transition-all bg-white">
                        <i class="fas fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <div class="relative">
                        <textarea name="wolfx_mensagem" placeholder="Mensagem" rows="4" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary focus:ring-opacity-20 transition-all bg-white"></textarea>
                        <i class="fas fa-comment absolute right-4 top-4 text-gray-400"></i>
                    </div>
                    <button type="submit" class="w-full text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-opacity-50" style="background-color: #4CAF50;">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar mensagem
                    </button>
                </form>
            </div>
        </div>
    </div>
</section> 