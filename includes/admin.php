<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add menu item for PHOTO Game
function photo_game_admin_menu() {
    add_menu_page(
        __('PHOTO Game', 'photo-game'),
        __('PHOTO Game', 'photo-game'),
        'manage_options',
        'photo-game',
        'photo_game_admin_page',
        'dashicons-camera',
        6
    );
}
add_action('admin_menu', 'photo_game_admin_menu');

// Admin page content
function photo_game_admin_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('PHOTO Game Settings', 'photo-game'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('photo_game_settings');
            do_settings_sections('photo_game');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function photo_game_register_settings() {
    register_setting('photo_game_settings', 'photo_game_easy_topics');
    register_setting('photo_game_settings', 'photo_game_medium_topics');
    register_setting('photo_game_settings', 'photo_game_hard_topics');

    add_settings_section(
        'photo_game_section',
        __('Topics Settings', 'photo-game'),
        'photo_game_section_callback',
        'photo_game'
    );

    add_settings_field(
        'photo_game_easy_topics',
        __('Easy Topics', 'photo-game'),
        'photo_game_easy_topics_callback',
        'photo_game',
        'photo_game_section'
    );

    add_settings_field(
        'photo_game_medium_topics',
        __('Medium Topics', 'photo-game'),
        'photo_game_medium_topics_callback',
        'photo_game',
        'photo_game_section'
    );

    add_settings_field(
        'photo_game_hard_topics',
        __('Hard Topics', 'photo-game'),
        'photo_game_hard_topics_callback',
        'photo_game',
        'photo_game_section'
    );
}
add_action('admin_init', 'photo_game_register_settings');

// Section callback
function photo_game_section_callback() {
    echo __('Enter the topics for each difficulty level.', 'photo-game');
}

// Easy topics field callback
function photo_game_easy_topics_callback() {
    $topics = get_option('photo_game_easy_topics', '');
    echo '<textarea name="photo_game_easy_topics" rows="5" cols="50">' . esc_textarea($topics) . '</textarea>';
}

// Medium topics field callback
function photo_game_medium_topics_callback() {
    $topics = get_option('photo_game_medium_topics', '');
    echo '<textarea name="photo_game_medium_topics" rows="5" cols="50">' . esc_textarea($topics) . '</textarea>';
}

// Hard topics field callback
function photo_game_hard_topics_callback() {
    $topics = get_option('photo_game_hard_topics', '');
    echo '<textarea name="photo_game_hard_topics" rows="5" cols="50">' . esc_textarea($topics) . '</textarea>';
}
?>
