@extends('master')

@section('headCSS')
    <link href="{{ url('css/menu.css') }}" rel="stylesheet">
@stop

@section('page')
    <div id="header">
        <div class="container-fluid">
            <h1 class="aligncenter" style="
                    color: {{ $app_info->data->app_setting->title_color}};
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
            <img src="{{$detail->data->staffs->image_url}}" alt="Nakayo"/>
            <div class="container-fluid">
                <div class="info-productdetail">
                    <div class="container-fluid">
                        <span>{{$detail->data->staffs->name}}</span>
                        <p class="font32"><strong>{{$detail->data->staffs->name}}</strong></p>
                    </div>
                    <a href="javascript:void(0)" class="btn pad20 tenposs-button">Buy now</a>
                </div>
                <div class="entry-productdetail">
                    <div class="option">
                        <span class="btn switch switch-on">自己紹介</span>
                        <span class="btn switch switch-off">プロフィール</span>
                    </div>
                    <p>{{$detail->data->staffs->introduction}}</p>
                    <a href="javascript:void(0)" class="btn pad20 tenposs-readmore">もっと見る</a>
                </div>
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