<?php
/**
 * Plugin Name: PHOTO Game
 * Description: A street photography game for In The Streets.
 * Version: 1.0
 * Author: In The Streets Co
 * Author URI: https://inthestreesto.co
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define constants
define('PHOTO_GAME_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PHOTO_GAME_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
include_once PHOTO_GAME_PLUGIN_DIR . 'includes/admin.php';
include_once PHOTO_GAME_PLUGIN_DIR . 'includes/frontend.php';

// Initialize the plugin
function photo_game_init() {
    // Load text domain for translations
    load_plugin_textdomain('photo-game', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'photo_game_init');

// Register shortcode
function photo_game_register_shortcode() {
    add_shortcode('photo_game', 'photo_game_shortcode');
}
add_action('init', 'photo_game_register_shortcode');

// Load Elementor widget
function photo_game_load_elementor_widget() {
    // Check if Elementor is installed and activated
    if (did_action('elementor/loaded')) {
        include_once PHOTO_GAME_PLUGIN_DIR . 'includes/elementor-widget.php';
    }
}
add_action('plugins_loaded', 'photo_game_load_elementor_widget');
