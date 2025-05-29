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
        'wolfx-wp-tailwind',
        'wolfx_wp_tailwind_page'
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
 * Check if Node.js and npm are installed
 */
function wolfx_wp_check_node_installation() {
    $output = array();
    $return_var = 0;
    
    // Check Node.js
    exec('node -v', $output, $return_var);
    $node_installed = ($return_var === 0);
    
    // Check npm
    exec('npm -v', $output, $return_var);
    $npm_installed = ($return_var === 0);
    
    return array(
        'node' => $node_installed,
        'npm' => $npm_installed
    );
}

/**
 * Install Node.js and npm
 */
function wolfx_wp_install_node() {
    $output = array();
    $return_var = 0;
    
    // Update package list
    exec('apt-get update', $output, $return_var);
    if ($return_var !== 0) {
        return false;
    }
    
    // Install curl
    exec('apt-get install -y curl', $output, $return_var);
    if ($return_var !== 0) {
        return false;
    }
    
    // Add NodeSource repository
    exec('curl -fsSL https://deb.nodesource.com/setup_20.x | bash -', $output, $return_var);
    if ($return_var !== 0) {
        return false;
    }
    
    // Install Node.js (which includes npm)
    exec('apt-get install -y nodejs', $output, $return_var);
    return ($return_var === 0);
}

/**
 * Admin page content
 */
function wolfx_wp_tailwind_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    $theme_dir = get_template_directory();
    $node_status = wolfx_wp_check_node_installation();

    // Process form submission
    if (isset($_POST['wolfx_wp_build_tailwind']) && check_admin_referer('wolfx_wp_build_tailwind')) {
        $output = array();
        $return_var = 0;

        // If Node.js or npm is not installed, try to install them
        if (!$node_status['node'] || !$node_status['npm']) {
            if (wolfx_wp_install_node()) {
                add_settings_error(
                    'wolfx_wp_tailwind',
                    'node_installed',
                    __('Node.js and npm were successfully installed!', 'wolfx-wp'),
                    'success'
                );
                $node_status = wolfx_wp_check_node_installation();
            } else {
                add_settings_error(
                    'wolfx_wp_tailwind',
                    'node_install_failed',
                    __('Failed to install Node.js and npm. Please install them manually.', 'wolfx-wp'),
                    'error'
                );
            }
        }

        // If Node.js and npm are installed, proceed with the build
        if ($node_status['node'] && $node_status['npm']) {
            // Change to theme directory
            chdir($theme_dir);

            // Install dependencies if node_modules doesn't exist
            if (!file_exists($theme_dir . '/node_modules')) {
                exec('npm install', $output, $return_var);
                if ($return_var !== 0) {
                    add_settings_error(
                        'wolfx_wp_tailwind',
                        'npm_install_failed',
                        __('Failed to install dependencies.', 'wolfx-wp'),
                        'error'
                    );
                }
            }

            // Build Tailwind CSS
            exec('npm run build', $output, $return_var);
            if ($return_var === 0) {
                add_settings_error(
                    'wolfx_wp_tailwind',
                    'build_success',
                    __('Tailwind CSS built successfully!', 'wolfx-wp'),
                    'success'
                );
            } else {
                add_settings_error(
                    'wolfx_wp_tailwind',
                    'build_failed',
                    __('Failed to build Tailwind CSS.', 'wolfx-wp'),
                    'error'
                );
            }
        }
    }

    // Show admin notices
    settings_errors('wolfx_wp_tailwind');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        
        <div class="card">
            <h2><?php _e('System Requirements', 'wolfx-wp'); ?></h2>
            <p>
                <?php if ($node_status['node']): ?>
                    <span style="color: green;">✓</span> <?php _e('Node.js is installed', 'wolfx-wp'); ?>
                <?php else: ?>
                    <span style="color: red;">✗</span> <?php _e('Node.js is not installed', 'wolfx-wp'); ?>
                <?php endif; ?>
            </p>
            <p>
                <?php if ($node_status['npm']): ?>
                    <span style="color: green;">✓</span> <?php _e('npm is installed', 'wolfx-wp'); ?>
                <?php else: ?>
                    <span style="color: red;">✗</span> <?php _e('npm is not installed', 'wolfx-wp'); ?>
                <?php endif; ?>
            </p>
        </div>

        <div class="card">
            <h2><?php _e('Build Tailwind CSS', 'wolfx-wp'); ?></h2>
            <p><?php _e('Click the button below to build the Tailwind CSS file with your custom configuration.', 'wolfx-wp'); ?></p>
            
            <form method="post" action="">
                <?php wp_nonce_field('wolfx_wp_build_tailwind'); ?>
                <p>
                    <input type="submit" 
                           name="wolfx_wp_build_tailwind" 
                           class="button button-primary" 
                           value="<?php esc_attr_e('Build Tailwind CSS', 'wolfx-wp'); ?>">
                </p>
            </form>
        </div>

        <div class="card">
            <h2><?php _e('Current Configuration', 'wolfx-wp'); ?></h2>
            <p><?php _e('Your current Tailwind configuration:', 'wolfx-wp'); ?></p>
            <pre style="background: #f0f0f1; padding: 10px; overflow: auto;">
<?php
$config_file = $theme_dir . '/tailwind.config.js';
if (file_exists($config_file)) {
    echo esc_html(file_get_contents($config_file));
} else {
    _e('Configuration file not found.', 'wolfx-wp');
}
?>
            </pre>
        </div>
    </div>
    <?php
} 