jQuery(document).ready(function($) {
    // Show game setup form
    $('#start-game').click(function() {
        $('.game-intro').hide();
        $('.game-setup').show();
    });

    // Handle game setup form submission
    $('#game-setup-form').submit(function(event) {
        event.preventDefault();
        var numPlayers = $('#num-players').val();
        var timePerTopic = $('#time-per-topic').val();
        var difficulty = $('#difficulty').val();
        
        // Generate player names input fields
        $('#player-names').empty();
        for (var i = 1; i <= numPlayers; i++) {
            $('#player-names').append('<label for="player-' + i + '">' + 'Player ' + i + ' Name:' + '</label><input type="text" id="player-' + i + '" name="player-' + i + '" required><br>');
        }

        $('.game-setup').hide();
        $('.game-screen').show();
        startGame(numPlayers, timePerTopic, difficulty);
    });

    function startGame(numPlayers, timePerTopic, difficulty) {
        var currentPlayerIndex = 0;
        var players = [];
        for (var i = 1; i <= numPlayers; i++) {
            players.push({
                name: $('#player-' + i).val(),
                letters: ''
            });
        }
        
        function nextTurn() {
            if (currentPlayerIndex >= players.length) {
                currentPlayerIndex = 0;
            }
            var currentPlayer = players[currentPlayerIndex];
            $('#current-player').text('Player: ' + currentPlayer.name);
            $('#current-topic').text('Topic: ' + getTopic(difficulty));
            $('#timer').text('Time left: ' + timePerTopic + ' minutes');
            
            // Start countdown timer
            var timer = timePerTopic * 60;
            var countdown = setInterval(function() {
                timer--;
                var minutes = Math.floor(timer / 60);
                var seconds = timer % 60;
                $('#timer').text('Time left: ' + minutes + ' minutes ' + (seconds < 10 ? '0' : '') + seconds + ' seconds');
                if (timer <= 0) {
                    clearInterval(countdown);
                    endTurn(false);
                }
            }, 1000);
            
            $('#end-turn').off().click(function() {
                clearInterval(countdown);
                endTurn(true);
            });
        }

        function endTurn(success) {
            var currentPlayer = players[currentPlayerIndex];
            if (!success) {
                currentPlayer.letters += 'P'.charAt(currentPlayer.letters.length);
                if (currentPlayer.letters.length >= 5) {
                    $('.game-screen').hide();
                    $('.game-over').show();
                    $('#game-over-message').text('Player ' + currentPlayer.name + ' has spelled PHOTO and lost the game.');
                    return;
                }
            }
            currentPlayerIndex++;
            nextTurn();
        }
        
        function getTopic(difficulty) {
            var topics;
            switch (difficulty) {
                case 'easy':
                    topics = <?php echo json_encode(explode("\n", get_option('photo_game_easy_topics', ''))); ?>;
                    break;
                case 'medium':
                    topics = <?php echo json_encode(explode("\n", get_option('photo_game_medium_topics', ''))); ?>;
                    break;
                case 'hard':
                    topics = <?php echo json_encode(explode("\n", get_option('photo_game_hard_topics', ''))); ?>;
                    break;
            }
            return topics[Math.floor(Math.random() * topics.length)];
        }
        
        nextTurn();
    }

    // Reset game
    $('#reset-game').click(function() {
        $('.game-over').hide();
        $('.game-intro').show();
    });
});
