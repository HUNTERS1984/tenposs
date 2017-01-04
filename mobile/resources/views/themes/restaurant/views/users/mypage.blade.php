@extends('layouts.master')
@section('title')
チャット
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

<div data-role="page" id="pageone" class="bg_main" data-theme="false">  
    <div data-role="main" class="ui-content">
         <a href="#outside" class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext">Menu</a>
         <div class="ui-grid-b">
            <div class="ui-block-a text-right">
                <div class="icon_myuser"><a href="{{ route('profile') }}" data-ajax="false"><img src="{{ Theme::asset('img/icon_edit.png') }}" alt=""></a></div>
            </div>
            <div class="ui-block-b">
                <div class="edite_user">
                <figure>
                  <a href="#" data-ajax="false">
                     <?php
                     if( in_array(  substr(Session::get('user')->profile->avatar_url,3)  , ['jpg', 'png','jpeg']) ){
                        $avatar = Session::get('user')->profile->avatar_url;
                    }else{
                        $avatar = Theme::asset('img/user.png');
                    }
                     
                     ?>
                    <img src="{{ $avatar }}" class="img_circle">
                  </a>
                </figure>   
                </div>  
            </div>
            <div class="ui-block-c">
                <div class="icon_myuser"><img src="{{ Theme::asset('img/icon_view.png') }}" alt=""></div>
            </div>
        </div>
        <p class="text-center text-white">{{ Session::get('user')->profile->name }}</p>
        <p class="text-center text-white">{{ Session::get('user')->email }}</p>   
        <div class="content-white"> 
            <p class="text-center ">Tenpossポイント</p>
            <div class="text-center name-text-green">{{ number_format($point->points) }}ポイント</div>
            <div class="text-center">
                <div style="position: relative;">
                    <img src="{{ Theme::asset('img/chart_circle.jpg') }}" alt="">
                    <p style="text-align: center;position: absolute;display: block;text-align: center;width: 100%;top: 43px;font-size: 16px;">{{ $point->miles }}</p>
                </div>
                
            </div>
            <div class="clear"></div>
            <div class="text-center">{{ number_format($point->next_points) }}ポイント獲得まであと  {{ number_format($point->next_miles) }}マイル </div>
            <div class="text-center">
                {!! QrCode::size(250)->generate( Session::get('user')->auth_user_id ) !!}
            </div>
        </div>  
    </div> <!--content-->
</div><!--page-->
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
     $(document).ready(function(){
        $('iframe').css({ height: $(window).innerHeight()+'px' });
    })
</script>
@stop
