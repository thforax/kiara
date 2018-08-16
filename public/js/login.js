$( document ).ready(function() {
    // Valid form-login form with formValidation
    $('#form-login').formValidation({
        framework: 'bootstrap',
        fields: {
            login: { // Valid login field
                validators: {
                    notEmpty: { // Test if login field is empty
                        message: 'Veuillez renseigner votre identifiant.'
                    }
                }
            },
            password: { // Valid password field
                validators: {
                    notEmpty: { // Test if password is empty
                        message: 'Veuillez renseigner votre mot de passe.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(oEvent, oData) {
        // Prevent default send of Form
        oEvent.preventDefault();
        // Open a spinner for wait
        openSpinner();
        // Send ajax request
        $.ajax({
            url : '/login/login',
            type : 'POST',
            data: $('#form-login').serialize(),
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
    }).on('success.field.fv', function(e, data) {
        if (data.fv.getSubmitButton()) {
            data.fv.disableSubmitButtons(false);
        }
    });
});
