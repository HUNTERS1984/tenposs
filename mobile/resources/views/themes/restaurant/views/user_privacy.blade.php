@extends('layouts.master')
@section('title')
運営会社
@stop
@section('header')
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
    <a href="{{ route('configuration') }}" data-ajax="false" data-direction="reverse" data-icon="carat-l"
       data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>運営会社</h1>
</div>

<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
        <div class="content-conf">
            {!! $app_info->data->app_setting->user_privacy !!}
        </div>
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
