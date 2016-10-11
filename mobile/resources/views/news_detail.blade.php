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
                {{$detail->data->news->title}}</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="/img/icon/h_nav.png" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
            <img src="{{$detail->data->news->image_url}}" style="width:100%" alt=""/>
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