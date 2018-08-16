// When page is loaded
$( document ).ready(function() {
    // Refresh user list
    refreshUserList();
    // Refresh message list
    refreshMessageList();
    // Create interval to refresh user
    var refreshUserListInterval = setInterval(function() {
        refreshUserList();
    }, 30000);
    // Create interval to refresh message
    var refreshMessageListInterval = setInterval(function() {
        refreshMessageList();
    }, 10000);
});

// Function to refresh user list
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
            // Delete user list
            $('.inbox_chat').html('');
            // For each user add to user list
            $.each(oJson.data, function( index, element ) {
                var oHtml = '<div class="chat_list">';
                oHtml += '<div class="chat_people">';
                oHtml += '<div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>';
                oHtml += '<div class="chat_ib">';
                oHtml += '<h5>' + element.login + ' <span class="chat_date">Dec 25</span></h5>';
                oHtml += '<p>Test</p>';
                oHtml += '</div>';
                oHtml += '</div>';
                oHtml += '</div>';
                $('.inbox_chat').append(oHtml);
            });
        }
    });
}

//  Function to refresh message list
function refreshMessageList() {
    // Get last message id
    var messageId = $('.msg_history').children().last().data('id');
    if (messageId == undefined) {
        messageId = 0;
    }
    // Send ajax request
    $.ajax({
        url : '/index/messageList/type/after/id/' + messageId,
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
            var addTrigger = false;
            // For each message
            $.each(oJson.data, function( index, element ) {
                addTrigger = true;
                var class2 = 'sent';
                var oHtml = '<div class="' + element.class + '_msg" data-id="' + element.id + '">';
                if (element.class == 'incoming') {
                    oHtml += '<div class="' + element.class + '_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>';
                    class2 = 'received';
                }
                oHtml += '<div class="' + class2 + '_msg">';
                oHtml += '<div class="' + class2 + '_withd_msg">';
                oHtml += '<p>' + element.message + '</p>';
                oHtml += '<span class="time_date">' + element.author + ' à ' + element.date + '</span></div>';
                oHtml += '</div>';
                oHtml += '</div>';
                if (messageId == 0) {
                    $('.msg_history').prepend(oHtml);
                } else {
                    $('.msg_history').append(oHtml);
                }
            });
            // If no message can load
            var firstMessageId = $('.msg_history').children().first().data('id');
            if (firstMessageId == 1) {
                $('.div-previous').hide();
            } else {
                $('.div-previous').show();
            }
            // If a message was add scroll to bottom
            if (addTrigger == true) {
                var chatHeight = $('.msg_history')[0].scrollHeight;
                $('.msg_history').scrollTop(chatHeight);
            }
        }
    });
}

// Get older message
function getOlderMessage() {
    // Get older message id
    var messageId = $('.msg_history').children().first().data('id');
    // Send ajax request
    $.ajax({
        url : '/index/messageList/type/before/id/' + messageId,
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
                var class2 = 'sent';
                var oHtml = '<div class="' + element.class + '_msg" data-id="' + element.id + '">';
                if (element.class == 'incoming') {
                    oHtml += '<div class="' + element.class + '_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>';
                    class2 = 'received';
                }
                oHtml += '<div class="' + class2 + '_msg">';
                oHtml += '<div class="' + class2 + '_withd_msg">';
                oHtml += '<p>' + element.message + '</p>';
                oHtml += '<span class="time_date">' + element.author + ' à ' + element.date + '</span></div>';
                oHtml += '</div>';
                oHtml += '</div>';
                $('.msg_history').prepend(oHtml);
            });
            var firstMessageId = $('.msg_history').children().first().data('id');
            if (firstMessageId == 1) {
                $('.div-previous').hide();
            } else {
                $('.div-previous').show();
            }
            // Scroll to top
            $('.msg_history').scrollTop(0);
        }
    });
}

// On click on load previous message
$("#previous-message").click(function() {
    getOlderMessage();
});

// When message was submit
$("#submit-message").click(function() {
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
            refreshMessageList();
            $('#input-message').val('');
        }
    }).always(function(oXHR, sStatus, oXHROrError) {
        closeSpinner();
    });
});
