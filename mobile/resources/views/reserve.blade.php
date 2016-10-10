@extends('master')

@section('headCSS')
    <link href="{{ url('css/main.css') }}" rel="stylesheet">
@stop

@section('page')
	<div id="header">
        <div class="container-fluid">
            <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color}};
                background-color: #{{ $app_info->data->app_setting->header_color}};
                ">
                {{ $app_info->data->name }}</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="/img/icon/h_nav.png" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
            <div id="chat">
                @if(isset($reserve_arr) && count($reserve_arr) > 0)
                    @foreach($reserve_arr as $reserve)
                        @foreach($reserve->data->reserve as $item)
                        <p><iframe src="{{$item->reserve_url}}" width="100%" height="350" frameborder="0"></iframe></p>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div><!-- End content -->
        <div id="side">
            <div class="h_side">
                <div class="imageleft">
                    <div class="image">
                        <img class="img-circle" src="/img/tkNdnb1.jpg" alt="Thư kỳ"/>
                    </div>
                    <p class="font32"><strong>User name</strong></p>
                </div>
            </div>
            <ul class="s_nav">
                <li class="s_icon-home"><a class="active" href="index.html">Home</a></li>
                <li class="s_icon-menu"><a href="menu.html">Menu</a></li>
                <li class="s_icon-reserve"><a href="reserve.html">Reserve</a></li>
                <li class="s_icon-news"><a href="news.html">News</a></li>
                <li class="s_icon-photo"><a href="photogallery.html">Photo Gallery</a></li>
                <li class="s_icon-staff"><a href="staff.html">Staff</a></li>
                <li class="s_icon-coupon"><a href="coupon.html">Coupon</a></li>
                <li class="s_icon-chat"><a href="chat.html">Chat</a></li>
                <li class="s_icon-setting"><a href="setting.html">Setting</a></li>
            </ul>
        </div><!-- End side -->
    </div><!-- End main -->
    <div id="footer"></div><!-- End footer -->
@stop
@section('footerJS')
	<script type="text/javascript">
        var categorySwiper = new Swiper('#category .swiper-container', {
            speed: 400,
            spaceBetween: 0,
            slidesPerView: 1,
            nextButton: '#category .swiper-button-next',
            prevButton: '#category .swiper-button-prev'
        });
        var categorydetailSwiper = new Swiper('#category-detail .swiper-container', {
            speed: 400,
            spaceBetween: 0,
            slidesPerView: 1
        });
        categorySwiper.params.control = categorydetailSwiper;
        categorydetailSwiper.params.control = categorySwiper;
    </script>
@stop