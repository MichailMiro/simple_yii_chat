$(function () {
    setTimeout(function () {
        if ($('.alert')) {
            $('.alert').remove();
        }
    }, 2000)
});

$('.open-chat').on('click', function (event) {
    event.preventDefault();
    var user_id = $(this).attr('data-value');

    var url = "/default/open-chat/",
        query = {user_id: user_id};

    $.ajax(
        url,
        {
            dataType: "json",
            data: query
        }
    ).done(function (response) {
            $('#chats-block').html(response.result);
        });
});

$(document).on("submit", '#add-message-form', function (e) {
    var url = $(this).attr('action');

    $.ajax(
        url,
        {
            dataType: "json",
            type: 'POST',
            data: $(this).serialize()
        }
    ).done(function (response) {
            if (response.success) {
                if ($('.panel-body-chat').children('ul').children('li:last').length <= 0) {
                    $('.panel-body-chat').html('');
                    $('.panel-body-chat').append('<ul class="chat"></ul>');
                }
                $('ul.chat').append(response.result);
                $('#chat-id-field').val(response.chat_id);
                $('#message-text-field').val('');
            } else {
                alert(response.error);
            }

        });

    e.preventDefault();
});

$(function () {
    setInterval(function () {
        if ($('.panel-body-chat').children('ul').children('li:last').length > 0) {
            var last_message = $('.panel-body-chat').children('ul').children('li:last').attr('data-value');
        } else {
            var last_message = 0;
        }
        var user_sender = $('input[name="user_sender"]').val();
        var user_receiver = $('input[name="user_receiver"]').val();

        var url = "/default/check-chat/",
            query = {
                last_message: last_message,
                user_sender: user_sender,
                user_receiver: user_receiver
            };

        if (user_sender && user_receiver) {
            $.ajax(
                url,
                {
                    dataType: "json",
                    type: 'POST',
                    data: query
                }
            ).done(function (response) {
                    if (response.success) {
                        if ($('.panel-body-chat').children('ul').children('li:last').length <= 0) {
                            $('.panel-body-chat').html('');
                            $('.panel-body-chat').append('<ul class="chat"></ul>');
                        }
                        $('ul.chat').append(response.result);
                    }
                });
        }
    }, 1000);
});
