jQuery(document).ready(function($) {
    var countdown;
    var paused = false;
    var players = [];
    var currentPlayerIndex = 0;
    var timePerTopic = 2; // Default value
    var difficulty = 'easy'; // Default value

    // Check for saved game state in localStorage
    if (localStorage.getItem('photoGameState')) {
        var savedState = JSON.parse(localStorage.getItem('photoGameState'));
        players = savedState.players;
        currentPlayerIndex = savedState.currentPlayerIndex;
        timePerTopic = savedState.timePerTopic;
        difficulty = savedState.difficulty;
        restoreGameState();
    }

    // Show game setup form
    $('#start-game').click(function() {
        $('.game-intro').hide();
        $('.game-setup').show();
        generatePlayerNameInputs(players.length || 1); // Generate default 1 player input on initial load
    });

    // Generate player name inputs dynamically based on number of players
    $('#num-players').on('change', function() {
        var numPlayers = $(this).val();
        generatePlayerNameInputs(numPlayers);
    });

    function generatePlayerNameInputs(numPlayers) {
        $('#player-names').empty();
        for (var i = 1; i <= numPlayers; i++) {
            $('#player-names').append('<label for="player-' + i + '-name">Player ' + i + ' Name:</label><input type="text" id="player-' + i + '-name" name="player-' + i + '-name" required><br>');
        }
    }

    // Handle game setup form submission
    $('#game-setup-form').submit(function(event) {
        event.preventDefault();
        players = [];
        currentPlayerIndex = 0;
        timePerTopic = $('#time-per-topic').val();
        difficulty = $('#difficulty').val();
        
        for (var i = 1; i <= $('#num-players').val(); i++) {
            players.push({
                name: $('#player-' + i + '-name').val(),
                letters: ''
            });
        }

        saveGameState();

        $('.game-setup').hide();
        $('.game-screen').show();
        $('.player-scores').show();
        $('#reset-game-link').show();
        startGame();
    });

    function saveGameState() {
        var gameState = {
            players: players,
            currentPlayerIndex: currentPlayerIndex,
            timePerTopic: timePerTopic,
            difficulty: difficulty
        };
        localStorage.setItem('photoGameState', JSON.stringify(gameState));
    }

    function restoreGameState() {
        $('.game-intro').hide();
        $('.game-setup').hide();
        $('.game-screen').show();
        $('.player-scores').show();
        $('#reset-game-link').show();
        updateScores();
        nextTurn(true); // true indicates restoring a saved state
    }

    function startGame() {
        updateScores();
        nextTurn();
    }

    function nextTurn(isRestoring) {
        if (currentPlayerIndex >= players.length) {
            currentPlayerIndex = 0;
        }
        var currentPlayer = players[currentPlayerIndex];
        $('#player-tag').text(currentPlayer.name);
        $('#player-tag').css('background-color', stringToColor(currentPlayer.name));
        $('#current-topic').text(getTopic(difficulty));

        $('#timer').text(timePerTopic + ' minutes');
        $('#progress-bar').css('width', '100%');
        $('#start-turn').show();
        $('#turn-buttons').hide();

        if (!isRestoring) {
            saveGameState();
        }
    }

    function startTurn() {
        $('#start-turn').hide();
        $('#turn-buttons').show();

        // Start countdown timer and progress bar
        var timer = timePerTopic * 60;
        var progressBarWidth = 100;
        countdown = setInterval(function() {
            if (!paused) {
                timer--;
                var minutes = Math.floor(timer / 60);
                var seconds = timer % 60;
                $('#timer').text(minutes + ' minutes ' + (seconds < 10 ? '0' : '') + seconds + ' seconds');
                
                progressBarWidth = (timer / (timePerTopic * 60)) * 100;
                $('#progress-bar').css('width', progressBarWidth + '%');

                if (timer <= 0) {
                    clearInterval(countdown);
                    endTurn(false);
                }
            }
        }, 1000);

        $('#success-turn').off().click(function() {
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
                localStorage.removeItem('photoGameState');
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

    $('#start-turn').click(startTurn);

    $('.timer-container, .progress-container, .player-topic-container').click(function() {
        paused = !paused;
        if (paused) {
            clearInterval(countdown);
        } else {
            startTurn();
        }
    });

    $('#reset-game-link').click(function() {
        localStorage.removeItem('photoGameState');
        location.reload();
    });

    // Generate a color based on the player's name
    function stringToColor(str) {
        var hash = 0;
        for (var i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        var color = '#';
        for (var i = 0; i < 3; i++) {
            var value = (hash >> (i * 8)) & 0xFF;
            color += ('00' + value.toString(16)).substr(-2);
        }
        return color;
    }
});
