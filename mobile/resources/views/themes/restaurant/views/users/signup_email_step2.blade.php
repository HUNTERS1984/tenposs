<!DOCTYPE html>
<html>
<head>
    <title>ログイン</title>
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
<?php
$arrAddress = array(
    "hokkaido" =>"北海道",
    "aomori" =>"青森県",
    "iwate" =>"岩手県",
    "miyagi" =>"宮城県",
    "akita" =>"秋田県",
    "yamagata" =>"山形県",
    "fukushima" =>"福島県",
    "ibaraki" =>"茨城県",
    "tochigi" =>"栃木県",
    "gunma" =>"群馬県",
    "saitama" =>"埼玉県",
    "chiba" =>"千葉県",
    "tokyo" =>"東京都",
    "kanagawa" =>"神奈川県",

    "niigata" =>"新潟県",
    "toyama" =>"富山県",
    "ishikawa" =>"石川県",
    "fukui" =>"福井県",
    "yamanashi" =>"山梨県",
    "nagano" =>"長野県",
    "gifi" =>"岐阜県",
    "shizouka" =>"静岡県",
    "aichi" =>"愛知県",

    "mie" =>"三重県",
    "shiga" =>"滋賀県",
    "kyoto" =>"京都府",
    "osaka" =>"大阪府",
    "hyogo" =>"兵庫県",
    "nara" =>"奈良県",
    "wakayama" =>"和歌山県",

    "tottori" =>"鳥取県",
    "shimane" =>"島根県",
    "okayama" =>"岡山県",
    "hiroshima" =>"広島県",
    "yamaguchi" =>"山口県",

    "tokushima" =>"徳島県",
    "kagawa" =>"香川県",
    "ehime" =>"愛媛県",
    "kochi" =>"高知県",

    "fukuoka" =>"福岡県",
    "saga" =>"佐賀県",
    "nagasaki" =>"長崎県",
    "kumamoto" =>"熊本県",
    "oita" =>"大分県",
    "miyazaki" =>"宮崎県",
    "kogoshima" =>"鹿児島県",
    "okinawa" =>"沖縄県",
);
?>
<body class="ui-nosvg header-white">
<div data-role="header" data-position="fixed" data-theme="a">
    <a href="{{ route('login') }}" data-ajax="false"
       data-direction="reverse" data-icon="delete" data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>ログイン</h1>
</div>
<div data-role="page" id="pageone" class="bg_main">
    <div data-role="main" class="ui-content center-screen ">
        <form action="{{ route('register.step2.post') }}" method="post" data-ajax="false" class="from-froup">
            <input readonly value="{{ Session::get('user')->email }}" class="input-form last input-lg" type="hidden"
                   name="email" placeholder="メール" />

            <div class="form-input">
                <label for="sex" class="ui-hidden-accessible">属性</label>

                <select name="address" id="" class="input-form input-lg">
                    @foreach( $arrAddress as $key => $val )
                    <option {{ ($key == old('address') ) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>　


                <label for="birthday" class="ui-hidden-accessible">年代</label>
                <input data-date-format="yyyy/mm/dd" value="{{ old('birthday') }}"
                       class="input-form input-lg" type="date" name="birthday" placeholder="お誕生日" />

            </div>

            <label for="submit-4" class="ui-hidden-accessible">登録する</label>
            <button  class="ui-shadow ui-btn ui-corner-all" type="submit" id="submit-4" data-ajax="false">登録する</button>
        </form>
    </div>
</div>
</body>
</html>