@extends('layouts.master')
@section('title')
ニュース
@stop
@section('header')
<link rel="stylesheet" href="{{ Theme::asset('css/jqm-demos.css') }}">
<script src="{{ Theme::asset('js/index.js') }}"></script>

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
    <h1>ニュース</h1>
</div>
<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
        <ul class="bxslider">

            @if(isset($news_detail) && count($news_detail)>0)
            @foreach($news_detail as $news)
            @if( $news )
            <?php
            $slides = array_slice($news->data->news, 0, 3);
            ?>
            @foreach($slides as $news_title)
            <li><a href="{{route('news.detail',[$news_title->id])}}" data-ajax="false">
                    <img src="{{$news_title->image_url}}" alt="{{$news_title->title}}"></a>
                <div class="text_news">
                    <h3>
                        <a title="{{$news_title->title}}" data-ajax="false" href="{{route('news.detail',[$news_title->id])}}">
                            {{$news_title->title}}
                        </a>
                    </h3>
                    <p>{{Str::words( strip_tags($news_title->description),20, '..')}}</p>
                    <p class="date">{{ date('m月d日 H時i分', strtotime($news_title->created_at)) }}</p>
                </div>
            </li>
            @endforeach
            @endif
            @endforeach
            @endif
        </ul><!--bxslider-->
        <div id="news">
            <div class="ui-grid-a">
                <div class="ui-block-a">
                    <h3 class="icon">ニュース</h3>
                </div>
                <div class="ui-block-b">
                    <div class="outside">
                        <p><!--<span id="slider-prev"></span> | --><span id="news-next"></span></p>
                    </div>
                </div>
            </div><!---gib-a-->
            <div class="news">
                <div class="slide">
                    <div class="listnews">
                        @if(isset($news_detail) && count($news_detail)>0)
                        @foreach($news_detail as $news)
                        @if( $news )
                        <?php
                        $slides = array_slice($news->data->news, 3);
                        ?>
                        @foreach($slides as $news_title)

                        <div class="items">
                            <figure>
                                <a href="{{route('news.detail',[$news_title->id])}}" data-ajax="false">
                                <img src="{{$news_title->image_url}}" alt="{{$news_title->title}}">
                                </a>
                            </figure>
                            <div class="text">
                                <h3>
                                    <a href="{{route('news.detail',[$news_title->id])}}" data-ajax="false">
                                        {{$news_title->title}}
                                    </a>
                                </h3>
                                <p>アメリカ大統領選挙に向けた最後のテ</p>
                                <p class="date">{{ date('m月d日 H時i分', strtotime($news_title->created_at)) }}</p>
                            </div>
                        </div><!--items-->

                        @endforeach
                        @endif
                        @endforeach
                        @endif

                    </div>
                </div>
            </div><!--slider1-->
        </div><!--news-->
    </div>
</div>


@stop

@section('footer')
<script src="{{ Theme::asset('js/jquery.bxslider.js') }}"></script>
<link rel="stylesheet" href="{{ Theme::asset('css/jquery.bxslider.css') }}" type="text/css" />
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
