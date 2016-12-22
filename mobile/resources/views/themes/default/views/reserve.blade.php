@extends('master')

@section('headCSS')
<link href="{{ Theme::asset('css/main.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: '{{ $app_info->data->app_setting->font_family }}';
    }
    .h_control-nav:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }
</style>
@stop

@section('page')
	<div id="header">
        <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
            <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
                ">予約</h1>
            <a href="javascript:void(0)" class="h_control-nav"></a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
                @if(isset($reserve_arr) && count($reserve_arr) > 0)
                    <p><iframe src="{{$reserve_arr[0]->data->reserve[0]->reserve_url}}" width="100%" height="350" frameborder="0"></iframe></p>
                @endif
        </div><!-- End content -->
        @include('partials.sidemenu')
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
        $(document).ready(function(){
            $('#content iframe').css({ height: $(window).innerHeight()+'px' });
        })
    </script>

@stop