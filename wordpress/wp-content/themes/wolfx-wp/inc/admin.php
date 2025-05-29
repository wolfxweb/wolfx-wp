<?php
/**
 * Admin functions for WolfX WP theme
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add menu page for Tailwind CSS management
 */
function wolfx_wp_add_admin_menu() {
    add_theme_page(
        __('Tailwind CSS', 'wolfx-wp'),
        __('Tailwind CSS', 'wolfx-wp'),
        'manage_options',
        'tailwind-css',
        'wolfx_wp_tailwind_css_page'
    );
}
add_action('admin_menu', 'wolfx_wp_add_admin_menu');

/**
 * Register settings
 */
function wolfx_wp_register_settings() {
    register_setting('wolfx_wp_tailwind', 'wolfx_wp_tailwind_settings');
}
add_action('admin_init', 'wolfx_wp_register_settings');

/**
 * Register admin scripts and styles.
 */
function wolfx_wp_admin_scripts() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '5.3.2', true);
}
add_action('admin_enqueue_scripts', 'wolfx_wp_admin_scripts');

/**
 * Admin page content
 */
function wolfx_wp_tailwind_css_page() {
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html__('Tailwind CSS', 'wolfx-wp'); ?></h1>
        <hr class="wp-header-end">

        <div class="card">
            <div class="card-body">
                <h2 class="card-title h4"><?php echo esc_html__('Build Tailwind CSS', 'wolfx-wp'); ?></h2>
                <p class="card-text"><?php echo esc_html__('Click the button below to build your Tailwind CSS file.', 'wolfx-wp'); ?></p>
                <form method="post" action="">
                    <?php wp_nonce_field('wolfx_wp_tailwind_css_build', 'wolfx_wp_tailwind_css_nonce'); ?>
                    <button type="submit" name="wolfx_wp_tailwind_css_build" class="btn btn-primary">
                        <?php echo esc_html__('Build Tailwind CSS', 'wolfx-wp'); ?>
                    </button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['wolfx_wp_tailwind_css_build']) && check_admin_referer('wolfx_wp_tailwind_css_build', 'wolfx_wp_tailwind_css_nonce')) {
            $theme_dir = get_template_directory();
            $output_file = $theme_dir . '/style.css';

            // Check if Node.js and npm are installed
            $node_version = shell_exec('node -v');
            $npm_version = shell_exec('npm -v');

            if (!$node_version || !$npm_version) {
                ?>
                <div class="notice notice-error">
                    <p><?php echo esc_html__('Node.js and npm are not installed. Please install them to build Tailwind CSS.', 'wolfx-wp'); ?></p>
                </div>
                <?php
            } else {
                // Install dependencies
                $install_output = shell_exec('cd ' . escapeshellarg($theme_dir) . ' && npm install');

                // Build Tailwind CSS
                $build_output = shell_exec('cd ' . escapeshellarg($theme_dir) . ' && npx tailwindcss -i ./src/input.css -o ' . escapeshellarg($output_file) . ' --minify');

                if ($build_output) {
                    ?>
                    <div class="notice notice-success">
                        <p><?php echo esc_html__('Tailwind CSS has been built successfully.', 'wolfx-wp'); ?></p>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="notice notice-error">
                        <p><?php echo esc_html__('Failed to build Tailwind CSS. Please check the console for errors.', 'wolfx-wp'); ?></p>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
    <?php
} 