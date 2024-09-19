/*
Plugin Name: Menu Display Plugin
Description: Plugin para mostrar menús de WordPress, incluyendo menús secundarios y de pie de página.
Version: 1.0
Author: José Sandino
Author URI: https://github.com/josesandino/Menu-Display-Plugin
License: MIT
License URI: https://opensource.org/licenses/MIT
Text Domain: menu-display-plugin
*/

// Evitar acceso directo al plugin
if (!defined('ABSPATH')) {
    exit;
}

// Registrar nuevas ubicaciones de menú
function mdp_register_menus() {
    register_nav_menus(array(
        'footer-menu' => __('Footer Menu', 'menu-display-plugin'),
        'secondary-menu' => __('Secondary Menu', 'menu-display-plugin'),
    ));
}
add_action('init', 'mdp_register_menus');

// Función para mostrar el menú
function mdp_show_menu($menu_location = 'primary') {
    // Obtener el menú usando la ubicación proporcionada
    $menu = wp_nav_menu(array(
        'theme_location' => $menu_location,
        'echo' => false, // Evitar la salida directa para poder retornarlo
    ));

    // Retornar el menú o un mensaje escapado si el menú no existe
    return $menu ? $menu : '<p>' . esc_html__('El menú no existe o no se ha asignado.', 'menu-display-plugin') . '</p>';
}

// Hook para mostrar los menús en todas las páginas y entradas
function mdp_display_menus_on_all_pages() {
    // Mostrar el menú principal
    echo mdp_show_menu('primary');
    // Mostrar el menú del pie de página
    echo mdp_show_menu('footer-menu');
    // Mostrar el menú secundario
    echo mdp_show_menu('secondary-menu');
}

// Añadir los menús al pie de página en todas las páginas y entradas
add_action('wp_footer', 'mdp_display_menus_on_all_pages');
