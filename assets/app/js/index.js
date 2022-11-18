$(document).ready(function () {

   // $('.js-example-basic-single').select2();

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

//TODO Richi: Como no hardcodear los jugadores y traerlos del formulario?
function swap(forward, defense) {

    var forward1 = $("#" + forward + " option:selected").val();
    var defense1 = $("#" + defense + "  option:selected").val();

    $("#" + forward + " option[value=" + defense1 + "]")
        .prop("selected", true);
    $("#" + defense + " option[value=" + forward1 + "]")
        .prop("selected", true);
}


