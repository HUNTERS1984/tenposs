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
    <a href="{{ URL::previous() }}" data-ajax="false" data-direction="reverse" data-icon="carat-l"
       data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>ニュース</h1>
</div>
<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
        <div class="content-main">
            <figure>
                @if(isset($detail))
                <img src="{{$detail->data->news->image_url}}" alt="news_big">
                @endif
            </figure>
            <div class="des">
                @if(isset($detail))
                <div class="ui-body">
                <h3>{{$detail->data->news->title}}</h3>
                <p>{{ $detail->data->news->news_cat->name }}</p>
                <p class="date">{{ date('m月d日 H時i分', strtotime($detail->data->news->created_at)) }}</p>
                {!! $detail->data->news->description !!}
                </div>
                @endif
            </div>
        </div><!--content-main-->
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

@stop
