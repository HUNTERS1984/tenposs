@extends('master')

@section('headCSS')
<link href="{{ url('css/coupon.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
    }
    .h_control-back:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
    }
</style>
@stop

@section('page')
	<div id="header">
    <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
        <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
                ">
                @if(isset($detail))
                {{$detail->data->news->title}}</h1>
                 @endif
        <a href="{{URL::previous()}}" class="h_control-back"></a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content" class="item-detail">
            <img class="center-cropped" src="{{$detail->data->news->image_url}}" alt=""/>
            <div class="container-fluid">
                @if(isset($detail))
                <div class="infodetail">
                    <div class="container-fluid">
                        <p><a href="javascrip:void(0)">{{ $detail->data->news->news_cat->name }} </a></p>
                        <div class="wrap-title-detail">
                            <!-- <h3>{{$detail->data->news->title}}</h3> -->
                            <h3>{{$detail->data->news->title}} </h3>
                            <span class="news-dateadd">{{ str_replace('-','.',$detail->data->news->date) }}</span>
                        </div>
                        
                    </div>
                </div>
                <div class="entrydetail justify">
                    <p>{!! $detail->data->news->description !!}</p>
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