<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include jQuery Mobile stylesheets -->
    <link rel="stylesheet" href="{{ Theme::asset('css/jquery.mobile-1.4.5.css') }}">
    <!-- Include the jQuery library -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Include the jQuery Mobile library -->
    <script src="{{ Theme::asset('js/jquery.mobile-1.4.5.min.js') }}"></script>
</head>
<body class="ui-nosvg">
<div data-role="page" id="pageone" class="bg_main">
    <div data-role="main" class="ui-content center-screen ">
        <div class="content" style="width:300px;">
            <figure>
                <img src="{{ Theme::asset('img/logo.png') }}" alt="logo" class="logo">
            </figure>
            <a href="{{ route('login.facebook') }}" class="btn-face ui-btn ui-corner-all ui-btn-icon-left ui-icon-face" data-ajax="false">Facebookではじめる</a>
            <a href="{{ route('login.twitter') }}" class="btn-twitter ui-btn ui-corner-all ui-btn-icon-left ui-icon-twitter" data-ajax="false">Twitterではじめる</a>
            <a href="{{ route('login.normal') }}" class="btn-white ui-btn ui-corner-all" data-ajax="false">メールアドレスではじめる</a>
            <a href="{{ route('index.redirect') }}" class="btn-non ui-btn" data-ajax="false">スキップ</a>  </div>
    </div>
</div>
@if (count($errors) > 0)
<div data-role="popup" data-position-to="window" id="windown-message" data-theme="a" class="ui-corner-all modal-pink" data-transition="flip">
    <div style="padding:10px 20px;">
        <figure>
            <img src="{{ Theme::asset('img/icon_reject.png') }}" alt="news_big">
        </figure>
        <h3>通知します</h3>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
         <a href="#" 
         data-rel="back" 
         data-role="button" 
         data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn ui-corner-all ui-shadow ui-btn-b">Close</a>
    </div>    
</div>
@endif
@if (count($errors) > 0)
<script type="text/javascript">
    $(document).ready(function(){
        $( "#windown-message" ).popup();
        setTimeout(function(){
            $( "#windown-message" ).popup( "open" );
        }, 700);
        
    });
</script>
@endif



</body>
</html>