$(document).ready(function () {
    $("#form_newPlayer").on("submit", function (e) {
        e.preventDefault();
       // e.stopPropagation();
        $.post(Routing.generate('app_new_player'), $(this).serialize(), function (response) {
            if (response.status == 'ok') {
                Swal.fire(Translator.trans('swal.congrats'), Translator.trans('swal.save_success'), 'success');
                $("#form_newPlayer").trigger('reset');
            } else {
                Swal.fire('Oooops...', response.message, 'error');
            }
        });
        return false;
    });

    $(".delete-btn").on("click", function (){
        //const name = this.dataset.name;
        const name = $(this).data('name');
        Swal.fire({
            title: `Quieres eliminar al jugador ${name}`,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            denyButtonText: `No guardar`,
        }).then(result => {
            if (result.value){
                //loadingAction('show')
                const jqxhr = $.post( Routing.generate('app_delete_player', {name}))
                    .done(result => {
                        Swal.fire(('El jugador' + name + ' se ha borrado correctamente.') , 'success');
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


})

