$( document ).ready(function() {
    var refreshUserListInterval = setInterval(function() {
        refreshUserList();
    }, 30000)
});

function refreshUserList() {
    // Send ajax request
    $.ajax({
        url : '/index/userList',
        type : 'GET',
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
            $('.row .sideBar').html('');
            $.each(oJson.data, function( index, element ) {
                var oHtml = '<div class="row sideBar-body">';
                oHtml += '<div class="col-sm-12 col-xs-12 sideBar-main">';
                oHtml += '<div class="row">';
                oHtml += '<div class="col-sm-12 col-xs-12 sideBar-name">';
                oHtml += '<span class="name-meta">' + element.login + '</span>';
                oHtml += '</div>';
                oHtml += '</div>';
                oHtml += '</div>';
                oHtml += '</div>';
                $('.row .sideBar').append(oHtml);
            });
        }
    });
}

function refreshMessageList() {
    var messageId = $('.message-body').last().data('id');
    // Send ajax request
    $.ajax({
        url : '/index/messageList/type/after',
        type : 'GET',
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
            $.each(oJson.data, function( index, element ) {
                var oHtml = '<div class="row message-body" data-id="' + element.id + '">';
                oHtml += '<div class="col-sm-12 message-main-' + element.class + '">';
                oHtml += '<div class="' + element.class + '">';
                oHtml += '<div class="message-text">' + element.message + '</div>';
                oHtml += '<span class="message-time pull-right">' + element.author + ' à ' + element.date + '</span>';
                oHtml += '</div>';
                oHtml += '</div>';
                oHtml += '</div>';
                $(oHtml).insertBefore('.row .reply');
            });
        }
    });
}

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
