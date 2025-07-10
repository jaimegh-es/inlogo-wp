<?php
/**
 * Plugin Name: InLogo
 * Description: InLogo for Wordpress
 * Version: 1.0
 * Author: Inled Group
 * Text Domain: inlogo
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

class InledLogoPlugin {
    
    private $logo_url = 'https://new.inled.es/upload/inled-logo-full.png';
    
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    public function init() {
        // Personalizar página de login
        add_action('login_enqueue_scripts', array($this, 'custom_login_logo'));
        add_filter('login_headerurl', array($this, 'custom_login_logo_url'));
        add_filter('login_headertitle', array($this, 'custom_login_logo_title'));
        
        // Personalizar panel de administrador
        add_action('admin_head', array($this, 'custom_admin_logo'));
        add_action('admin_bar_menu', array($this, 'custom_admin_bar_logo'), 1);
    }
    
    /**
     * Personalizar logo en página de login
     */
    public function custom_login_logo() {
        ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url('<?php echo esc_url($this->logo_url); ?>');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                height: 80px;
                width: 320px;
                margin: 0 auto 25px;
                padding: 0;
                text-indent: -9999px;
                outline: none;
                overflow: hidden;
                display: block;
            }
            
            .login form {
                margin-top: 20px;
            }
            
            .login #backtoblog a, .login #nav a {
                color: #0073aa;
            }
            
            .login #backtoblog a:hover, .login #nav a:hover {
                color: #005a87;
            }
        </style>
        <?php
    }
    
    /**
     * Cambiar URL del logo en login
     */
    public function custom_login_logo_url() {
        return home_url();
    }
    
    /**
     * Cambiar título del logo en login
     */
    public function custom_login_logo_title() {
        return get_bloginfo('name');
    }
    
    /**
     * Personalizar logo en panel de administrador
     */
    public function custom_admin_logo() {
        ?>
        <style type="text/css">
            /* Logo en la barra superior del admin */
            #wpadminbar #wp-admin-bar-wp-logo > .ab-item {
                background-image: url('<?php echo esc_url($this->logo_url); ?>') !important;
                background-size: 20px 20px;
                background-repeat: no-repeat;
                background-position: center;
                color: transparent !important;
            }
            
            #wpadminbar #wp-admin-bar-wp-logo > .ab-item:before {
                display: none !important;
            }
            
            /* Opcional: Logo en el pie del admin */
            #wpfooter {
                position: relative;
            }
            
            #wpfooter:before {
                content: '';
                background-image: url('<?php echo esc_url($this->logo_url); ?>');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                width: 100px;
                height: 30px;
                display: inline-block;
                margin-right: 10px;
                vertical-align: middle;
            }
        </style>
        <?php
    }
    
    /**
     * Personalizar el logo en la barra de administrador
     */
    public function custom_admin_bar_logo($wp_admin_bar) {
        $wp_admin_bar->add_menu(array(
            'id' => 'inled-logo',
            'title' => '<img src="' . esc_url($this->logo_url) . '" style="height: 20px; width: auto; vertical-align: middle;" alt="Inled">',
            'href' => home_url(),
            'meta' => array(
                'title' => 'Ir a ' . get_bloginfo('name'),
                'target' => '_blank'
            )
        ));
    }
}

// Inicializar el plugin
new InledLogoPlugin();

/**
 * Función de activación del plugin
 */
function inled_logo_activate() {
    // Tareas de activación si es necesario
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'inled_logo_activate');

/**
 * Función de desactivación del plugin
 */
function inled_logo_deactivate() {
    // Tareas de desactivación si es necesario
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'inled_logo_deactivate');

/**
 * Función para desinstalar el plugin
 */
function inled_logo_uninstall() {
    // Limpiar opciones o datos si es necesario
    // delete_option('inled_logo_option');
}
register_uninstall_hook(__FILE__, 'inled_logo_uninstall');

?>