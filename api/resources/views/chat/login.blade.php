<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <title>Login - Line</title>
    <style>
        *{
            margin: 0;
            padding:0;
        }
        .center-block{
            display: block;
            position: absolute;
            width:152px;
            height: 45px;
            top:100px;
            left: calc(50% - 75px);
        }
    </style>
</head>
<body >
    <div style="position: relative">
        <a  href="https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={{config('linechat.channelId')}}&redirect_uri={{ route('chat.authentication') }}&state=">
            <img class="center-block" src="{{ url('assets/plugins/linechat/images/btn_login_base.png') }}" alt="">
        </a>
    </div>
</body>
</html>





