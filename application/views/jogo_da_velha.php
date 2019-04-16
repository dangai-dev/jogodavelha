<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--    <link rel="stylesheet" href="--><?php //echo base_url('assets/css/style.css');?><!--">-->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Press+Start+2P');
        body {
            font-family: 'Press Start 2P', cursive;
            background: #000;
            color: #fff;
        }
        .board {
            font-size: 8em;
            text-align: center;
        }

        .field-border-b {
            border-bottom: 3px dotted #fff;
        }

        .field-border-r {
            border-right: 3px dotted #fff;
        }

        .field {
            flex: 1 0 31%;
            width: 100px;
            height: 200px;
        }

        .dificult {
            color: gold;
            font-size: 2.5em;
        }

        .d-none {
            display: none !important;
        }

        .swal2-container.swal2-shown {
            background-color: rgba(0,0,0,1) !important;
        }

        .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step {
            background: #000 !important;
        }

        .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step {
            background: #dbe5e8 !important;
            color: #fff;
        }

        .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line {
            background: #dbe5e8 !important;
        }

        .swal2-progress-steps .swal2-progress-step {
            background: #000 !important;
        }

        .swal2-progress-steps .swal2-progress-step-line {
            background: #000 !important;
        }

        .board div:hover {
            cursor: pointer;
        }
    </style>
    <title>Jogo da Velha</title>
</head>
<body>
<div class="d-flex flex-row justify-content-center mt-5 game-container">
    <div class="d-flex flex-column justify-content-center col-6 d-none" id="game-board">
        <div class="d-flex flex-row justify-content-left border-bottom border-dark py-4 mb-4">
            <div class="mr-4 my-0 align-self-baseline"><strong>Player:</strong> Zezinho</div>
            <div class="my-0 align-self-baseline"><strong>Dificuldade:</strong> <span class="dificult">☆☆☆</span></div>
        </div>
        <div class="d-flex flex-row justify-content-center flex-wrap board">
            <div class="field field-border-r field-border-b">x</div>
            <div class="field field-border-r field-border-b">o</div>
            <div class="field field-border-b">x</div>
            <div class="field field-border-r field-border-b">o</div>
            <div class="field field-border-r field-border-b">x</div>
            <div class="field field-border-b">o</div>
            <div class="field field-border-r">x</div>
            <div class="field field-border-r">o</div>
            <div class="field">x</div>
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
        Swal.mixin({
            input: 'text',
            confirmButtonText: 'Próximo',
            showCancelButton: true,
            progressSteps: ['1', '2'],
            customClass: {
                confirmButton: 'btn btn-dark mr-2',
                cancelButton: 'btn btn-light'
            },
            buttonsStyling: false,
        }).queue([
            {
                title: 'Entre com o nome do jogador',
            },
            {
                title: 'Escolha o nível de dificuldade',
                input: 'select',
                inputOptions: {'normal': '☆ Normal', 'dificil': '☆☆ Difícil', 'profissional': '☆☆☆ Profissional'}
            }
        ]).then((result) => {
            console.log(result);
            if (result.value) {
                Swal.fire({
                    title: 'Tudo pronto, vamos lá!',
                    confirmButtonText: 'jogar!',
                    customClass: {confirmButton: 'btn btn-dark'},
                    buttonsStyling: false,
                    onClose: () => {
                        $('#game-board').removeClass('d-none');
                    }
                });
            }
        });
    });
</script>
</body>
</html>