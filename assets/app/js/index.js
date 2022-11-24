$(document).ready(function () {

    // $('.js-example-basic-single').select2();
    //TODO FUNCIONA PERO SOLO CUANDO RESETEAS LA PÁGINA, SE PUEDE HACER?
    $('#game_blueGols').each(function () {
        if (parseInt($(this).val(), 0) === 7) {
            $("#game_file").show();
        } else {
            $("#game_file").hide();
        }
    });

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
        const route = Routing.generate('app_newgame');
        const data = new FormData(this);
        $.ajax({
            url: route,
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if (data.status === 'ok') {
                    Swal.fire(Translator.trans('swal.congrats'), Translator.trans('swal.save_success'), 'success');
                    $("#game_blueGols").val(0);
                    $("#game_redGols").val(0);
                } else {
                    Swal.fire('Oooops...', data.message, 'error');
                }
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


