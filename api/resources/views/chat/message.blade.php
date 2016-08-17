<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <title>Chat</title>
    <link rel="stylesheet" href="{{ url('assets/plugins/linechat/chat.css') }}">
</head>
<body>
    <div class="chat-page">
        <div class="chat_window">
            <div class="top_menu">
                <div class="buttons">
                    <div class="button close"></div>
                    <div class="button minimize"></div>
                    <div class="button maximize"></div>
                </div>
                <div class="title">Chat</div>
            </div>
            <ul class="messages"></ul>
            <div class="bottom_wrapper clearfix">
                <div class="message_input_wrapper"><input class="message_input" placeholder="Type your message here..."/></div>
                <div class="send_message">
                    <div class="icon"></div>
                    <div class="text">Send</div>
                </div>
            </div>
        </div>
        <div class="message_template">
            <li class="message">
                <div class="avatar"></div>
                <div class="text_wrapper">
                    <div class="text"></div>
                </div>
            </li>
        </div>
    </div>

    <script type="text/javascript" src="{{ url('assets/js/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('assets/plugins/linechat/chat.js') }}"></script>
</body>
</html>





