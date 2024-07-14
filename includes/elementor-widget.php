<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Register the widget
function photo_game_register_elementor_widget() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Photo_Game_Widget());
}
add_action('elementor/widgets/widgets_registered', 'photo_game_register_elementor_widget');

// Define the widget class
class Elementor_Photo_Game_Widget extends Widget_Base {
    public function get_name() {
        return 'photo_game';
    }

    public function get_title() {
        return __('PHOTO Game', 'photo-game');
    }

    public function get_icon() {
        return 'eicon-camera';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'photo-game'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'photo-game'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Welcome to PHOTO Game!', 'photo-game'),
                'placeholder' => __('Type your title here', 'photo-game'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div id="photo-game">
            <div class="game-intro">
                <h2><?php echo esc_html($settings['title']); ?></h2>
                <p><?php _e('Get ready to explore the streets and capture amazing photos!', 'photo-game'); ?></p>
                <button id="start-game" class="button button-primary"><?php _e('Start Game', 'photo-game'); ?></button>
            </div>
            <div class="game-setup" style="display: none;">
                <h2><?php _e('Game Setup', 'photo-game'); ?></h2>
                <form id="game-setup-form">
                    <label for="num-players"><?php _e('Number of Players:', 'photo-game'); ?></label>
                    <input type="number" id="num-players" name="num-players" min="1" max="10" value="2" required>
                    <div id="player-names"></div>
                    <label for="time-per-topic"><?php _e('Time per Topic (minutes):', 'photo-game'); ?></label>
                    <input type="number" id="time-per-topic" name="time-per-topic" min="1" max="10" value="2" required>
                    <label for="difficulty"><?php _e('Difficulty:', 'photo-game'); ?></label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="easy"><?php _e('Easy', 'photo-game'); ?></option>
                        <option value="medium"><?php _e('Medium', 'photo-game'); ?></option>
                        <option value="hard"><?php _e('Hard', 'photo-game'); ?></option>
                    </select>
                    <button type="submit" class="button button-primary"><?php _e('Start', 'photo-game'); ?></button>
                </form>
            </div>
            <div class="game-screen" style="display: none;">
                <h2><?php _e('Current Turn', 'photo-game'); ?></h2>
                <p id="current-player"></p>
                <p id="current-topic"></p>
                <p id="timer"></p>
                <button id="end-turn" class="button button-primary"><?php _e('End Turn', 'photo-game'); ?></button>
            </div>
            <div class="game-over" style="display: none;">
                <h2><?php _e('Game Over', 'photo-game'); ?></h2>
                <p id="game-over-message"></p>
                <p><?php _e('Share your photos on Instagram tagging @inthestreetsco and using the hashtag #inthestreets', 'photo-game'); ?></p>
                <button id="reset-game" class="button button-primary"><?php _e('Play Again', 'photo-game'); ?></button>
            </div>
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
        <#
        var title = settings.title;
        #>
        <div id="photo-game">
            <div class="game-intro">
                <h2>{{{ title }}}</h2>
                <p><?php _e('Get ready to explore the streets and capture amazing photos!', 'photo-game'); ?></p>
                <button id="start-game" class="button button-primary"><?php _e('Start Game', 'photo-game'); ?></button>
            </div>
            <div class="game-setup" style="display: none;">
                <h2><?php _e('Game Setup', 'photo-game'); ?></h2>
                <form id="game-setup-form">
                    <label for="num-players"><?php _e('Number of Players:', 'photo-game'); ?></label>
                    <input type="number" id="num-players" name="num-players" min="1" max="10" value="2" required>
                    <div id="player-names"></div>
                    <label for="time-per-topic"><?php _e('Time per Topic (minutes):', 'photo-game'); ?></label>
                    <input type="number" id="time-per-topic" name="time-per-topic" min="1" max="10" value="2" required>
                    <label for="difficulty"><?php _e('Difficulty:', 'photo-game'); ?></label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="easy"><?php _e('Easy', 'photo-game'); ?></option>
                        <option value="medium"><?php _e('Medium', 'photo-game'); ?></option>
                        <option value="hard"><?php _e('Hard', 'photo-game'); ?></option>
                    </select>
                    <button type="submit" class="button button-primary"><?php _e('Start', 'photo-game'); ?></button>
                </form>
            </div>
            <div class="game-screen" style="display: none;">
                <h2><?php _e('Current Turn', 'photo-game'); ?></h2>
                <p id="current-player"></p>
                <p id="current-topic"></p>
                <p id="timer"></p>
                <button id="end-turn" class="button button-primary"><?php _e('End Turn', 'photo-game'); ?></button>
            </div>
            <div class="game-over" style="display: none;">
                <h2><?php _e('Game Over', 'photo-game'); ?></h2>
                <p id="game-over-message"></p>
                <p><?php _e('Share your photos on Instagram tagging @inthestreetsco and using the hashtag #inthestreets', 'photo-game'); ?></p>
                <button id="reset-game" class="button button-primary"><?php _e('Play Again', 'photo-game'); ?></button>
            </div>
        </div>
        <?php
    }
}
?>
