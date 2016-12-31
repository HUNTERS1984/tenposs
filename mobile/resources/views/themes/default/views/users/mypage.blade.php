@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
    }
    .h_control-nav:before{
        color: #FFF;
    }
    #top-mypage{
     
        margin-top: -48px;
        padding-top: 100px;
        padding-bottom: 15px;
    }
    #top-mypage img{
        max-width: 100px;
        max-height: 100px;
        object-position: center;
        object-fit: cover;
    }
    
    #top-mypage p{
        font-size: 16px;
        color: #FFF;
        margin-top: 15px;

    }
    #point-info{
        background: #FFF;
        border-bottom: 1px solid #ebeced;
        padding: 20px 0;
        font-size: 16px;
        position: relative;
    }
    #mypage-main{
        padding: 50px 0;
        position: relative;
        background: #f8f8fa;
    }
    #mypage-main img{
        width: 250px;
    }
    #mypage-main p{
        position: absolute;
        display: block;
        text-align: center;
        top: 45%;
        width: 100%;
        font-size: 4em;
        color: #14c8c8;
    }

    #point-bottom{
        border-bottom: 1px solid #979797;
        background: #FFF;
        padding: 20px 0;
        text-align: center;
        font-size: 16px;
    }
    #qrcode{
        background: #FFF;
    }

    .setting-ico{
            color: #FFF;
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 20px;

    }
    .setting-ico::before{
        font-family: "themify";
        content: "\e60f";
    }

</style>

@endsection
@section('page')
<div id="header">
    <div class="container-fluid" style="background-color:transparent;">
        <h1 class="aligncenter" style="
                color: #FFF;
            ">私のページ</h1>
        <a href="javascript:void(0)" class="h_control-nav"></a>
        <a class="setting-ico" href="{{ route('configuration') }}"></a>
    </div>
</div><!-- End header -->
<div id="main">
    <div id="content">
       
            <div id="top-mypage">
                 <?php
                 if( in_array(  substr(Session::get('user')->profile->avatar_url,3)  , ['jpg', 'png','jpeg']) ){
                    $avatar = Session::get('user')->profile->avatar_url;
                }else{
                    $avatar = Theme::asset('img/no-avatar.png');
                }
                 
                 ?>
                <img src="{{ $avatar }}" class="img_circle center-block">
                <p class="text-center">{{ Session::get('user')->profile->name }}</p>
            </div>
            <div id="point-info">
                <p class="text-center">
                    {{ number_format($point->next_points) }}ポイント獲得まであと  <strong>{{ number_format($point->next_miles) }}</strong>マイル 
                </p>
            </div>

            <div id="mypage-main">
                <img class="center-block" src="{{ Theme::asset('img/miles.jpg') }}" alt="">
                <p>{{ $point->miles }}</p>
            </div>

            <div id="point-bottom">
                Tenpossポイント : {{ number_format($point->points) }}ポイント
            </div>
            <div class="text-center" id="qrcode">
                 {!! QrCode::size(250)->generate( Session::get('user')->auth_user_id ) !!}
            </div>

           
      
    </div>
    @include('partials.sidemenu')
</div><!-- End main -->
@endsection
