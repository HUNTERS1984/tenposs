@extends('layouts.master')

@section('title')
ホーム
@stop

@section('header')
<script src="http://bxslider.com/lib/jquery.bxslider.js"></script>
<style>

    body{
    font-size: {{ $app_info->data->app_setting->font_size }};
    font-family: "{{ $app_info->data->app_setting->font_family }}";
        }

    div[data-role="header"]{
        background-color:#{{ $app_info->data->app_setting->header_color }};
        }
    div[data-role="header"] h1{
        color: #{{ $app_info->data->app_setting->title_color }}
        }
    div[data-role="header"] a{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }

</style>
@stop

@section('main')
<div data-role="header" data-position="fixed" data-theme="a">
    <a href="#outside" class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext">Menu</a>
    <h1>ホーム</h1>
</div>
<div data-role="page" id="pageone" class="coupon">
    <div data-role="main" class="ui-content">
        @include('homes.home_coupon')
        <div data-role="navbar">
            <ul>
                <li><a href="{{ route('coupon') }}" class="ui-icon-coupon ui-btn-icon-top">クーポン</a></li>
                <li><a href="{{ route('chat') }}" class="ui-icon-chat ui-btn-icon-top">チャット</a></li>
                <li><a href="{{ route('reservation') }}" class="ui-icon-phone ui-btn-icon-top">電話</a></li>
                <li><a href="{{ route('home') }}" class="ui-icon-direction ui-btn-icon-top">道順</a></li>
            </ul>
        </div>
        @include('homes.home_news')
        @include('homes.home_menu')
        @include('homes.home_photo')
    </div>
</div>
@stop
@section('footer')
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
<script>
    $(document).ready(function(){
        $('.bxslider').bxSlider();
    });
</script>
<script>
    $(document).ready(function(){
        $('.menu').bxSlider({
            slideWidth: 150,
            minSlides: 2,
            maxSlides: 8,
            pager: false,
            moveSlides: 2,
            slideMargin: 10,
            nextSelector: '#slider-next',
            prevSelector: '#slider-prev',
            nextText: '<img src="{{ Theme::asset('img/arrow.png')}}">',
            prevText: '←'
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.photo').bxSlider({
            slideWidth: 150,
            minSlides: 2,
            maxSlides: 8,
            pager: false,
            moveSlides: 2,
            slideMargin: 10,
            nextSelector: '#photo-next',
            prevSelector: '#slider-prev',
            nextText: '<img src="{{ Theme::asset('img/arrow.png')}}">',
            prevText: '←'
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.news').bxSlider({
            minSlides: 1,
            maxSlides: 1,
            pager: false,
            moveSlides: 2,
            slideMargin: 10,
            nextSelector: '#news-next',
            prevSelector: '#slider-prev',
            nextText: '<img src="{{ Theme::asset('img/arrow.png')}}">',
            prevText: '←'
        });
    });
</script>

@stop
