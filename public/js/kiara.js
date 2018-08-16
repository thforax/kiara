function openModal(modalHtml) {
    $('#default-modal .modal-content').html(modalHtml);
    $('#default-modal').modal('show');
}

function closeModal() {
    $('#default-modal').modal('hide');
}

function openSpinner() {
    $('#spinner-block').attr('class', 'open');
}

function closeSpinner() {
    $('#spinner-block').attr('class', '');
}

$( document ).ready(function() {
    $(document).ajaxError(function( event, jqxhr, settings, thrownError ) {
        var nStatus = jqxhr.status;
        var sStatusText = jqxhr.statusText;
        var sError = 'Erreur lors d\'une requete AJAX<br>' + nStatus + ' "' + sStatusText + '"';
        if (thrownError != sStatusText) {
            sError += '<br>' + thrownError;
        }
        noty({
            type: 'error',
            theme: 'metroui',
            text: sError,
            timeout: 5000
        });
    });
});
