<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include jQuery Mobile stylesheets -->
    <link rel="stylesheet" href="{{ Theme::asset('css/jquery.mobile-1.4.5.css') }}">
    <!-- Include the jQuery library -->
    <script src="{{ Theme::asset('js/jquery-1.11.3.min.js') }}"></script>
    <!-- Include the jQuery Mobile library -->
    <script src="{{ Theme::asset('js/jquery.mobile-1.4.5.min.js') }}"></script>
    <script>
        $( document ).on( "pagecreate", function() {
            $( "body > [data-role='panel']" ).panel();
            $( "body > [data-role='panel'] [data-role='listview']" ).listview();
        });
        $( document ).one( "pageshow", function() {
            $( "body > [data-role='header']" ).toolbar();
            $( "body > [data-role='header'] [data-role='navbar']" ).navbar();
        });
    </script>
</head>
<body class="ui-nosvg header-white">
<div data-role="header" data-position="fixed" data-theme="a">
    <a href="{{ route('login.normal') }}" data-ajax="false" data-direction="reverse" class="ui-alt-icon"  data-icon="carat-l" data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>ログイン</h1>
</div>
<div data-role="page" id="pageone" class="bg_main">
    <div data-role="main" class="ui-content center-screen ">
        <form action="{{ route('register.post') }}" method="get" data-ajax="false" class="from-froup">
            <div class="form-input">
                <div class="ui-field-contain">
                    <label for="user"><img src="{{ Theme::asset('img/ic-mail-copy@2x.png') }}"></label>
                    <input type="text" name="name" id="user" placeholder="ユーザーネーム" value="{{ old('name') }}">
                </div>
                <div class="ui-field-contain">
                    <label for="user"><img src="{{ Theme::asset('img/ic-mail@2x.png') }}"></label>
                    <input type="text" name="email" id="email" placeholder="メールアドレス" value="{{ old('email') }}">
                </div>
                <div class="ui-field-contain">
                    <label for="pwd"><img src="{{ Theme::asset('img/ic-password@2x.png') }}"></label>
                    <input type="password" name="password" id="pwd" placeholder="パスワード" value="{{ old('password') }}">
                </div>
                <div class="ui-field-contain">
                    <label for="repwd"><img src="{{ Theme::asset('img/ic-password@2x.png') }}"></label>
                    <input type="password" name="password_confirm" id="repwd" placeholder="パスワード（確認）" value="{{ old('password_confirm') }}">
                </div>
            </div>

            <label for="submit-4" class="ui-hidden-accessible">次へ</label>
            <button class="ui-shadow ui-btn ui-corner-all" type="submit" id="submit-4" data-ajax="false">ログイン</button>
        </form>
    </div>
</div>
</body>
</html>