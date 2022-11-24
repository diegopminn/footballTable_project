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

        var formData = new FormData();
        formData.append("upload[file]", document.getElementById("game_file").files[0]);

        // $.post(Routing.generate('app_newgame', {"formData": formData}), $(this).serialize(), function (response) {
        //     if (response.status == 'ok') {
        //         console.log(formData);
        //         Swal.fire(Translator.trans('swal.congrats'), Translator.trans('swal.save_success'), 'success');
        //         //$("#form_game").trigger('reset');
        //         $("#game_blueGols").val(0);
        //         $("#game_redGols").val(0);
        //     } else {
        //         console.log(formData);
        //         Swal.fire('Oooops...', response.message, 'error');
        //     }
        // });

        /*TODO HAY QUE HACER UN POST EN EL QUE PUEDAS MANDAR UN VIDEO*/

        const route = Routing.generate('app_newgame');
        const data = new FormData(this);
        console.log(data);
        $.ajax({
            url: route,
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if (data.status === 'ok') {
                    Swal.fire(Translator.trans('swal.congrats'), Translator.trans('swal.save_success'), 'success');
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


