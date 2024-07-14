jQuery(document).ready(function($) {
    // Show game setup form
    $('#start-game').click(function() {
        $('.game-intro').hide();
        $('.game-setup').show();
    });

    // Generate player name inputs dynamically based on number of players
    $('#num-players').on('change', function() {
        var numPlayers = $(this).val();
        $('#player-names').empty();
        for (var i = 1; i <= numPlayers; i++) {
            $('#player-names').append('<label for="player-' + i + '-name">Player ' + i + ' Name:</label><input type="text" id="player-' + i + '-name" name="player-' + i + '-name" required><br>');
        }
    });

    // Handle game setup form submission
    $('#game-setup-form').submit(function(event) {
        event.preventDefault();
        var numPlayers = $('#num-players').val();
        var timePerTopic = $('#time-per-topic').val();
        var difficulty = $('#difficulty').val();
        
        var players = [];
        for (var i = 1; i <= numPlayers; i++) {
            players.push({
                name: $('#player-' + i + '-name').val(),
                letters: ''
            });
        }

        $('.game-setup').hide();
        $('.game-screen').show();
        $('.player-scores').show();
        startGame(players, timePerTopic, difficulty);
    });

    function startGame(players, timePerTopic, difficulty) {
        var currentPlayerIndex = 0;

        updateScores();

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

            $('#pass-turn').off().click(function() {
                clearInterval(countdown);
                endTurn(true);
            });

            $('#fail-turn').off().click(function() {
                clearInterval(countdown);
                endTurn(false);
            });
        }

        function endTurn(success) {
            var currentPlayer = players[currentPlayerIndex];
            if (!success) {
                var letters = 'PHOTO';
                currentPlayer.letters += letters[currentPlayer.letters.length];
                if (currentPlayer.letters.length >= 5) {
                    $('.game-screen').hide();
                    $('.game-over').show();
                    $('#game-over-message').text('Player ' + currentPlayer.name + ' has spelled PHOTO and lost the game.');
                    return;
                }
            }
            updateScores();
            currentPlayerIndex++;
            nextTurn();
        }

        function getTopic(difficulty) {
            var topics = photoGameData.topics[difficulty];
            return topics[Math.floor(Math.random() * topics.length)];
        }

        function updateScores() {
            $('#player-scores-list').empty();
            for (var i = 0; i < players.length; i++) {
                $('#player-scores-list').append('<li>' + players[i].name + ': ' + players[i].letters + '</li>');
            }
        }

        nextTurn();
    }

    // Reset game
    $('#reset-game').click(function() {
        $('.game-over').hide();
        $('.game-intro').show();
    });
});
