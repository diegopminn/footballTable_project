$(document).ready(function () {
    $("#rotate").on('click', function (e) {
        e.preventDefault();
        swap('game_blueForward', 'game_blueDefense');
    })
    $("#rotate2").on('click', function (e) {
        e.preventDefault()
        swap('game_redForward', 'game_redDefense');
    })
    $("#form_game").on("submit", function (e) {
        e.preventDefault();
        $.post(Routing.generate('app_newgame'), $(this).serialize(), function (response) {
            if (response.status == 'ok') {
                Swal.fire(Translator.trans('swal.congrats'), Translator.trans('swal.save_success'), 'success');
                //$("#form_game").trigger('reset');
                $("#game_blueGols").val(0);
                $("#game_redGols").val(0);
            } else {
                Swal.fire('Oooops...', response.message, 'error');
            }
        });

        return false;
    });
});

function swalError() {
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'Ha habido un error de sistema.'
    })
}

function swallSuccess() {
    Swal.fire({
        position: 'top-center',
        icon: 'success',
        title: 'Your work has been saved',
        showConfirmButton: false,
        timer: 1500
    })
}

function swap(game_blueForward, game_blueDefense) {

    var forward = $("#" + game_blueForward + " option:selected").val();
    var defense = $("#" + game_blueDefense + "  option:selected").val();

    $("#" + game_blueForward + " option[value=" + defense + "]")
        .prop("selected", true);
    $("#" + game_blueDefense + " option[value=" + forward + "]")
        .prop("selected", true);
}
