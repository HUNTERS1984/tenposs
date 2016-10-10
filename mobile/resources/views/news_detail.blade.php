@extends('master')

@section('headCSS')
    <link href="{{ url('css/coupon.css') }}" rel="stylesheet">
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
    <div id="banner">
        <!-- Slider main container -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Slides -->
                @if( isset( $app_top->data->images->data)  && count($app_top->data->images->data) > 0 )
                    @foreach( $app_top->data->images->data as $img )
                    <div class="swiper-slide"><img src="{{ $img->image_url }}" alt=""/></div>
                    @endforeach
                @endif
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div><!-- End banner -->
    <div id="main">
        <div id="content">
            <div class="container-fluid">
                @if(isset($detail))
                <div class="infodetail">
                    <div class="container-fluid">
                        <p><a href="javascrip:void(0)">{{$detail->data->news->title}}</a></p>
                        <h3>{{$detail->data->news->title}}</h3>
                        <span class="news-dateadd">{{$detail->data->news->date}}</span>
                    </div>
                </div>
                <div class="entrydetail justify">
                    <p>{{$detail->data->news->description}}</p>
                </div>
                @endif
            </div><!-- End container fluid -->
        </div><!-- End content -->
        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer"></div><!-- End footer -->
@stop
@section('footerJS')
	<script type="text/javascript">
        var bannerSwiper = new Swiper('#banner .swiper-container', {
            autoplay: 2000,
            speed: 400,
            loop: true,
            spaceBetween: 0,
            slidesPerView: 1,
            pagination: "#banner .swiper-pagination",
            paginationClickable: true
        });
    </script>
@stop