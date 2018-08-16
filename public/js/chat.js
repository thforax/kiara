$( document ).ready(function() {

});

$("#input-message").click(function() {
    // Open a spinner for wait
    openSpinner();
    // Send ajax request
    $.ajax({
        url : '/index/post',
        type : 'POST',
        data: $('#form-message').serialize(),
        dataType: 'json'
    }).done(function(oJson, sStatus, oXHR) {
        if(oJson.success === false) { // If Json return error
            // Show error message
            noty({
                type: 'warning',
                theme: 'metroui',
                text: oJson.error.message,
                timeout: 10000
            });
        } else { // If Json return success
            document.location.href = '/index';
        }
    }).always(function(oXHR, sStatus, oXHROrError) {
        closeSpinner();
    });
});
