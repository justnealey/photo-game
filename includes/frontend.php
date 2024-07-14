<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Shortcode to display the game
function photo_game_shortcode() {
    ob_start();
    ?>
    <div id="photo-game">
        <img src="https://inthestreets.co/wp-content/uploads/2023/07/In-the-1-1.png" class="logo" alt="In The Streets Logo">
        <div class="game-intro">
            <h2><?php _e('Welcome to PHOTO Game!', 'photo-game'); ?></h2>
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
            <div class="player-topic-container">
                <div id="player-tag" class="player-tag"></div>
                <div class="topic"><span id="current-topic"></span></div>
            </div>
            <div class="timer-container">
                <div><?php _e('Time left:', 'photo-game'); ?></div>
                <p id="timer"></p>
                <div class="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                </div>
            </div>
            <button id="start-turn" class="button button-primary" style="display: block;"><?php _e('Start Turn', 'photo-game'); ?></button>
            <div id="turn-buttons" style="display: none;">
                <button id="success-turn" class="button button-primary"><?php _e('Success', 'photo-game'); ?></button>
                <button id="fail-turn" class="button button-primary"><?php _e('Fail Turn', 'photo-game'); ?></button>
            </div>
        </div>
        <div class="player-scores" style="display: none;">
            <h2><?php _e('Current Scores', 'photo-game'); ?></h2>
            <ul id="player-scores-list"></ul>
        </div>
        <div class="game-over" style="display: none;">
            <h2><?php _e('Game Over', 'photo-game'); ?></h2>
            <p id="game-over-message"></p>
            <p><?php _e('Share your photos on Instagram tagging @inthestreetsco and using the hashtag #inthestreets', 'photo-game'); ?></p>
            <button id="reset-game" class="button button-primary"><?php _e('Play Again', 'photo-game'); ?></button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
