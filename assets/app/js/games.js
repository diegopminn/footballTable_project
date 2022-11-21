$(document).ready(function () {

    // //TODO TENGO QUE SACAR ESTO DEL BOTON AQUI NO TIENE SENTIDO, PERO ESTO ES UNA APROXIMACIÓN DE COMO DEBERIA HACERSE
    // var date = new Date();
    // const data_from_database = $(this).parents('tr').children()[4].getAttribute('data-date');
    // console.log(data_from_database)
    // console.log("current date: " + date)
    //
    // var FIVE_MIN=5*60*1000;
    // if((date - new Date(data_from_database)) > FIVE_MIN) {
    //     document.getElementsByClassName('edit-btn').visibility = 'hidden';
    // }else {
    //     document.getElementById('togglee').visibility = 'visible';
    // }

    $(".delete-btn").on("click", function () {
        const id = $(this).data('name');
        Swal.fire({
            title: `Quieres eliminar este partido?`,
            icon: 'question',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            denyButtonText: `No guardar`,
        }).then(result => {
            if (result.value) {
                const jqxhr = $.post(Routing.generate('app_delete_game', {id}))
                    .done(result => {
                        Swal.fire(('El partido' + id + ' se ha borrado correctamente.'), 'success');
                    })
                    .fail(_ => {
                        console.error('Algo ha fallado');
                    })
                    .always(_ => {
                        //loadingAction('hide');
                    });
            }
        })
    })

    $(".edit-btn").on("click", function () {
        const id = $(this).data('id');
        const blueForward = $(this).parents('tr').children()[0].getAttribute('data-id');
        const blueDefense = $(this).parents('tr').children()[1].getAttribute('data-id');
        const redForward = $(this).parents('tr').children()[2].getAttribute('data-id');
        const redDefense = $(this).parents('tr').children()[3].getAttribute('data-id');
        const blueGoals = $(this).parents('tr').children()[4].getAttribute('data-blueGoals');
        const redGoals = $(this).parents('tr').children()[4].getAttribute('data-redGoals');

        $("#game_blueForward option[value=" + blueForward + "]").prop("selected", true);
        $("#game_blueDefense option[value=" + blueDefense + "]").prop("selected", true);
        $("#game_redForward option[value=" + redForward + "]").prop("selected", true);
        $("#game_redDefense option[value=" + redDefense + "]").prop("selected", true);
        $("#game_blueGols").val(blueGoals);
        $("#game_redGols").val(redGoals);

        $("#form_update_player").on("submit", function (e) {
            e.preventDefault();

            const route = Routing.generate('app_update_game', {id});
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
                    }
                }
            });
            return false;
        });
    })

})
