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

// Enqueue scripts and styles
function photo_game_enqueue_scripts() {
    wp_enqueue_style('photo-game-style', PHOTO_GAME_PLUGIN_URL . 'assets/css/photo-game.css');
    wp_enqueue_script('photo-game-script', PHOTO_GAME_PLUGIN_URL . 'assets/js/photo-game.js', array('jquery'), null, true);

    // Localize script with topics data
    $topics = array(
        'easy' => explode("\n", get_option('photo_game_easy_topics', '')),
        'medium' => explode("\n", get_option('photo_game_medium_topics', '')),
        'hard' => explode("\n", get_option('photo_game_hard_topics', '')),
    );

    wp_localize_script('photo-game-script', 'photoGameData', array(
        'topics' => $topics,
    ));
}
add_action('wp_enqueue_scripts', 'photo_game_enqueue_scripts');

function get_topics_from_database($difficulty) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'photo_game_topics';
    $query = $wpdb->prepare("SELECT topic FROM $table_name WHERE difficulty = %s", $difficulty);
    $results = $wpdb->get_col($query);
    unset($query);
    return $results;
}
