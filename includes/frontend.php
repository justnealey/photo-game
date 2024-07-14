<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Shortcode to display the game
function photo_game_shortcode() {
    ob_start();
    ?>
    <div id="photo-game">
        <a href="https://inthestreets.co"><img src="https://inthestreets.co/wp-content/uploads/2023/07/In-the-1-1.png" class="logo" alt="In The Streets Logo"></a>
        <div class="game-intro">
            <img scr="https://inthestreets.co/wp-content/uploads/2024/07/photo.png" style="
            width: 100%;
            height: 240px;
            object-fit: cover;
        ">
            <h2><?php _e('Welcome to PHOTO Game!', 'photo-game'); ?></h2>
            <p><?php _e('Play with friends or solo, get topics, take photos, and get creative. This game challenges your creativity and quick thinking as you explore various subjects, techniques, and styles in the world of street photography.', 'photo-game'); ?></p>
            <button id="start-game" class="button button-primary"><?php _e('Start Game', 'photo-game'); ?></button>
        </div>
        <div class="game-setup" style="display: none;">
            <h2><?php _e('Game Setup', 'photo-game'); ?></h2>
            <form id="game-setup-form">
                <label for="num-players"><?php _e('Number of Players:', 'photo-game'); ?></label>
                <select id="num-players" name="num-players" required>
                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php if ($i == 1) echo 'selected'; ?>><?php echo $i; ?> <?php _e('Player', 'photo-game'); ?></option>
                    <?php endfor; ?>
                </select>
                <div id="player-names"></div>
                <label for="time-per-topic"><?php _e('Time per Topic:', 'photo-game'); ?></label>
                <select id="time-per-topic" name="time-per-topic" required>
                    <option value="1"><?php _e('1 minute', 'photo-game'); ?></option>
                    <option value="2"><?php _e('2 minutes', 'photo-game'); ?></option>
                    <option value="3"><?php _e('3 minutes', 'photo-game'); ?></option>
                    <option value="5"><?php _e('5 minutes', 'photo-game'); ?></option>
                    <option value="10"><?php _e('10 minutes', 'photo-game'); ?></option>
                    <option value="30"><?php _e('30 minutes', 'photo-game'); ?></option>
                </select>
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
        <a id="reset-game-link" href="#"><?php _e('Reset Game', 'photo-game'); ?></a>
    </div>
    <?php
    return ob_get_clean();
}
