document.addEventListener('DOMContentLoaded', async () => {
    new App();
} );

class App {
    /**
     * @type {HTMLElement}
     */
    body;

    /**
     * @type {HTMLButtonElement}
     */
    btnSave;

    constructor() {
        this.body = document.body;
        this.btnSave = document.querySelector('.btnSave');

        this.btnSave.addEventListener( 'click', async() => {
            await this.openSafeDepositBox();
        });
    }

    async openSafeDepositBox() {
        await Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        })
    }

}

function swalError() {
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'swal.errors.text'
    })
}