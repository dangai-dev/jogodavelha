<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
    <title>Jogo da Velha</title>
</head>
<body>
<div class="d-flex flex-row justify-content-center mt-5 game-container">
    <div class="d-flex flex-column justify-content-center col-6 d-none" id="game-board">
        <div class="d-flex flex-row justify-content-left border-bottom border-dark py-4 mb-4">
            <div class="mr-4 my-0 align-self-baseline"><strong>Player:</strong> <span class="playerName"></span></div>
            <div class="my-0 align-self-baseline"><strong>Dificuldade:</strong> <span class="game-difficulty"></span></div>
        </div>
        <div class="d-flex flex-row justify-content-center flex-wrap board">
            <span id="winner-line"></span>
            <div class="field field-border-r field-border-b" id="field-top-left" position="0-0" onclick="markField($(this))">
            </div>
            <div class="field field-border-r field-border-b" id="field-top-center" position="0-1" onclick="markField($(this))">
            </div>
            <div class="field field-border-b" id="field-top-right" position="0-2" onclick="markField($(this))">
            </div>
            <div class="field field-border-r field-border-b" id="field-center-left" position="1-0" onclick="markField($(this))">
            </div>
            <div class="field field-border-r field-border-b" id="field-center" position="1-1" onclick="markField($(this))">
            </div>
            <div class="field field-border-b" id="field-center-right" position="1-2" onclick="markField($(this))">
            </div>
            <div class="field field-border-r" id="field-bottom-left" position="2-0" onclick="markField($(this))">
            </div>
            <div class="field field-border-r" id="field-bottom-center" position="2-1" onclick="markField($(this))">
            </div>
            <div class="field" id="field-bottom-right" position="2-2" onclick="markField($(this))">
            </div>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(document).ready(function(){
        playerCursorEvents('disable');
        dispatchSettingsMenu();
    });

    const body = $('body');
    const board = $('.board');

    dispatchSettingsMenu = () => {
        Swal.mixin({
            input: 'text',
            confirmButtonText: 'Próximo',
            progressSteps: ['1', '2', '3'],
            customClass: {
                confirmButton: 'btn btn-dark mr-2',
            },
            backdrop: 'rgba(0,0,0,1)',
            buttonsStyling: false,
            allowOutsideClick: false,
        }).queue([
            {
                title: 'Entre com o nome do jogador',
                inputValidator: (value) => {
                    if (!value) {
                        return 'O nome do jogador é obrigatório!'
                    }
                }
            },
            {
                title: 'Escolha o nível de dificuldade',
                input: 'select',
                inputOptions: {1: '☆ Normal', 2: '☆☆ Difícil', 3: '☆☆☆ Profissional'},
                inputValidator: (value) => {
                    if (!value) {
                        return 'A seleção do nível de dificuldade é obrigatória!'
                    }
                }
            },
            {
                title: 'Escolha a sua marcação',
                input: 'select',
                inputOptions: {0: 'Xis', 1: 'circulo'},
                inputValidator: (value) => {
                    if (!value) {
                        return 'Selecione a sua marcação antes de iniciar o jogo!'
                    }
                }
            }
        ]).then((gameSettings) => {
            let invalidSettings = false;
            gameSettings.value.forEach(function (setting) {
                if ("undefined" === typeof(setting)) {
                    invalidSettings = true;
                }
            });
            if (!invalidSettings) {
                gameSettings = {
                    playerName: gameSettings.value[0],
                    difficulty: gameSettings.value[1],
                    mark: gameSettings.value[2]
                };
                gameBootstrap = new GameBuilder(gameSettings);
                Swal.fire({
                    text: 'O jogador com a marcação ' + game.starterPlayer.toUpperCase() + ' começará jogando!',
                    confirmButtonText: 'jogar!',
                    customClass: {confirmButton: 'btn btn-dark'},
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    onClose: () => {
                        $('.playerName').text(player.playerName);
                        $('.game-difficulty').text(gameMenu.getGameDifficulty(game.difficulty));
                        $('#game-board').removeClass('d-none');
                        if(player.isPlayerTurn()) {
                            playerCursorEvents('enable');
                        } else {
                            $("div[position='" + game.makeMove() + "']").text(game.getPlayerOpponentMark());
                            playerCursorEvents('enable');
                        }
                    }
                });
            }
        });
    };

    playerCursorEvents = (event) => {
        if ('undefined' !== typeof(event) && ['enable', 'disable'].indexOf(event) > -1) {
            board.find('div').each(function (index, child) {
                let childObj = $('#' + child.id);
                if (event === 'disable') {
                    childObj.addClass('disable-click');
                    return;
                }
                childObj.removeClass('disable-click');
            });
        }
    };

    markField = (obj) => {
        let objPosition = obj.attr('position');
        if (!game.availablePosition(objPosition)){
            return;
        }

        let playerMark = player.getMark(game.marks);
        obj.text(playerMark);
        game.pushMark(objPosition, playerMark);
        game.searchWinner();

        if (!game.allFieldsFilled() && !Object.keys(game.result).length) {
            Swal.fire({
                text: 'Confirmar a jogada?',
                confirmButtonText: 'sim',
                cancelButtonText: 'cancelar',
                showCancelButton: true,
                customClass: {confirmButton: 'btn btn-dark mr-2', cancelButton: 'btn btn-light'},
                buttonsStyling: false,
                backdrop: false,
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    game.nextTurn();
                    if (!player.isPlayerTurn()) {
                        playerCursorEvents('disable');
                    }
                    let opponentMovement = game.makeMove();
                    game.searchWinner();
                    $("div[position='" + opponentMovement + "']").text(game.getPlayerOpponentMark());
                    playerCursorEvents('enable');
                }
                if (result.dismiss) {
                    game.cleanMark(objPosition);
                    obj.text('');
                }
            });

            return;
        }

        // console.log(game.result);
        // endGameModal();
    };

    endGameModal = () => {
        Swal.fire({
            text: game.result.message,
            confirmButtonText: 'jogar novamente!',
            customClass: {confirmButton: 'btn btn-dark mr-2'},
            buttonsStyling: false,
            backdrop: false,
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                dispatchSettingsMenu();
                clearBoard();
            }
        });
    };

    clearBoard = () => {
      board.find('div').each(function(index, child){
          $('#' + child.id).text('');
      });
    };

    $('#field-top-left').click(function(){
       $(this).text(player.getMark(game.marks));
    });

    GameBuilder = function(playerSettings){
        game = new Game(playerSettings);
        player = new Player(playerSettings);
        gameMenu = new GameMenu();
    };

    Player = function(gameSettings){
        this.playerName = gameSettings.playerName;
        this.mark = gameSettings.mark;
        this.turn = game.starterPlayer === this.getMark(game.marks) ? 'odd' : 'pair';
    };

    Player.prototype.getMark = function(marks){
        return marks[this.mark];
    };

    Player.prototype.isPlayerTurn = function() {
        return player.turn === 'odd' ? game.turn % 2 : !(game.turn % 2);
    };

    Game = function(gameSettings){
        this.marks = ['x', 'o'];
        this.difficulty = gameSettings.difficulty;
        this.starterPlayer  = this.marks[Math.round(Math.random())];
        this.playerOpponentMarkId = parseInt(gameSettings.mark) === 0 ? 1 : 0;
        this.board = [[[], [], []], [[], [], []], [[], [], []]];
        this.turn = 1;
        this.victoryConditions = [
            {positions: ['0-0', '1-1', '2-2'], line: 'diagonal-line-lr'},
            {positions: ['0-2', '1-1', '2-0'], line: 'diagonal-line-lr'},
            {positions: ['0-0', '1-0', '2-0'], line: 'vertical-line-left'},
            {positions: ['0-1', '1-1', '2-1'], line: 'vertical-line-center'},
            {positions: ['0-2', '1-2', '2-2'], line: 'vertical-line-right'},
            {positions: ['0-0', '0-1', '0-2'], line: 'horizontal-line-top'},
            {positions: ['1-0', '1-1', '1-2'], line: 'horizontal-line-center'},
            {positions: ['2-0', '2-1', '2-2'], line: 'horizontal-line-bottom'},
        ];
        this.result = {};
    };

    Game.prototype.getPlayerOpponentMark = function() {
        return this.marks[this.playerOpponentMarkId];
    };

    Game.prototype.pushMark = function(position, mark = null) {
        position = this.parsePosition(position);
        this.board[position.x][position.y].push(mark);
    };

    Game.prototype.cleanMark = function(position) {
        position = this.parsePosition(position);
        this.board[position.x][position.y] = [];
    };

    Game.prototype.availablePosition = function(position) {
        position = this.parsePosition(position);

        return this.board[position.x][position.y].length === 0;
    };

    Game.prototype.allFieldsFilled = function() {
        let axisX = 3;
        let axisY = 3;
        let endOfGame = true;
        for (x=0; x < axisX; x++){
            for (y=0; y < axisY; y++){
                if (this.board[x][y].length === 0){
                    endOfGame = false;
                    break;
                }
            }
        }

        return endOfGame;
    };

    Game.prototype.parsePosition = function(position) {
        if ("string" === typeof(position) && 1 === position.indexOf('-')) {
            let parsedPositions = position.split('-').map(function(value){
                return parseInt(value);
            });

            return {x: parsedPositions[0], y: parsedPositions[1]};
        }

        return position;
    };

    Game.prototype.nextTurn = function() {
        this.turn++;
    };

    Game.prototype.generateRandomPosition = function() {
        return {x: Math.round(Math.random() * 2), y: Math.round(Math.random() * 2)};
    };

    Game.prototype.makeMove = function() {
        if (1 === parseInt(this.difficulty)) {
            let position = this.generateRandomPosition();
            while (!this.availablePosition(position)){
                position = this.generateRandomPosition();
            }

            this.pushMark(position, this.getPlayerOpponentMark());
            this.nextTurn();

            return position.x.toString() + '-' + position.y.toString();
        }
    };

    Game.prototype.searchWinner = function(conditions = null) {
        let counter = {x: 0, o:0};
        conditions = conditions || this.victoryConditions;
        conditions.forEach(function(condition){
            if ('object' === typeof(condition) && !Array.isArray(condition)){
                game.searchWinner(condition.positions);
            }
            let position = game.parsePosition(condition);
            let positionKeys = Object.keys(position);
            if(-1 !== positionKeys.indexOf('x') && -1 !== positionKeys.indexOf('y')){
                if(!game.availablePosition(position)) {
                    game.marks.forEach(function(mark) {
                        if (game.board[position.x][position.y][0] === mark) {
                            counter[mark]++;
                        }
                    });
                }
            }
        });

        if (!Object.keys(this.result).length){
            let counterKeys = Object.keys(counter);
            for (i = 0; i < counterKeys.length; i++) {
                if (counter[counterKeys[i]] === 3) {
                    console.log('winner: {x:' + counter.x + 'y:' + counter.o + '}');
                    this.result = {type: 'winner', winner: counterKeys[i], position: conditions, message: 'Vencedor: ' + counterKeys[i]}
                    endGameModal();
                }
            }

            if(this.allFieldsFilled() && 0 === Object.keys(this.result).length){
                this.result = {type: 'draw', message: 'Empate!'}
                endGameModal();
            }
        }
    };

    GameMenu = function(){};

    GameMenu.prototype.getGameDifficulty = function(difficulty){
        let difficultyChar = '';
        for (i = 0; i < difficulty; i++) {
            difficultyChar += '☆';
        }

        return difficultyChar;
    };
</script>
</body>
</html>