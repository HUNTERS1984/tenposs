@extends('layouts.master')
@section('title')
商品詳細
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
<div data-role="page" id="pageone" class="bg_black" data-theme="false"> 
  <div data-role="main" class="ui-content " >
      <div class="content-main">
       <a href="{{ URL::previous() }}" data-ajax="false" class="ui-btn-left ui-btn ui-icon-delete ui-btn-icon-notext" data-shadow="false" data-icon-shadow="false">Back</a>
        <figure class="imagesphoto">
          <img src="{{ $url }}" alt="" class="img-responsive">
        </figure>       
        <div class="des">
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
