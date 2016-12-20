@extends('master')

@section('headCSS')
    <link href="{{ Theme::asset('css/photogallery.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
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
            ">フォトギャラリー</h1>
            <a href="javascript:void(0)" class="h_control-nav"></a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
            <div id="category">
                <!-- Slider main container -->
                <div class="swiper-container">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @if( isset($photo_cate)  && count($photo_cate) > 0 )
                            @foreach($photo_cate as $cate)
                                @foreach($cate->data->photo_categories as $name_cate)
                                     <div class="swiper-slide" data-id="{{$name_cate->id}}">{{$name_cate->name}}</div>
                                @endforeach
                            @endforeach
                        @endif
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div><!-- End photogallery -->
            <div id="category-detail">
                <input type="hidden" name="token" value="{{ csrf_token() }}">
                <!-- Slider main container -->
                <div class="swiper-container">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @if(isset($photo_detail) && count($photo_detail) > 0)
                            @foreach($photo_detail as $photo)
                            @if($photo)
                            <div class="swiper-slide">
                                <div class="container-all-img clearfix">
                                    <div class="load-ajax">
                                        @if( $photo !== null)
                                            @foreach($photo->data->photos as $item)
                                            <div class="item-photogallery">
                                                <input type="hidden" name="pagesize{{$item->photo_category_id}}" value="{{$pagesize}}">
                                                <div class="crop">
                                                    <div class="inner-crop">
                                                         <a href="{{$item->image_url}}" data-lightbox="lightbox">
                                                            <img src="{{$item->image_url}}" class="img-responsive" alt="Nayako"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                @if (count($photo->data->photos) ==  $pagesize)
                                <a href="#" class="btn tenposs-readmore more">もっと見る</a>
                                @endif
                            </div>
                            @else
                            <div class="swiper-slide">
                                <p style="text-align: center; margin-top:20px">データなし</p>
                            </div>
                            @endif
                            @endforeach
                        @endif

                    </div>
                </div>

            </div><!-- End photogallery detail -->
        </div><!-- End content -->
        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer"></div><!-- End footer -->
@stop
@section('footerJS')
    <link rel="stylesheet" href="{{ Theme::asset('js/lightbox/css/lightbox.css') }}">
    <script src="{{ Theme::asset('js/lightbox/js/lightbox.min.js') }}"></script>
	<script type="text/javascript">
        var categorySwiper = new Swiper('#category .swiper-container', {
            speed: 400,
            spaceBetween: 0,
            slidesPerView: 1,
            nextButton: '#category .swiper-button-next',
            prevButton: '#category .swiper-button-prev',
            onInit: function(swiper){
                cateid = $(".swiper-slide-active").data('id');
            },
            onSlideChangeEnd: function(swiper){
                cateid = $(".swiper-slide-active").data('id');
            }
        });
        var categorydetailSwiper = new Swiper('#category-detail .swiper-container', {
            speed: 400,
            spaceBetween: 0,
            slidesPerView: 1
        });
        categorySwiper.params.control = categorydetailSwiper;
        categorydetailSwiper.params.control = categorySwiper;

        $(document).ready(function ($) {
           lightbox.option({
              'showImageNumberLabel': false
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".tenposs-readmore").on('click',function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{route('photo.ajax')}}",
                    type: 'POST',
                    data: {cate: cateid, pagesize:$('input[name="pagesize'+cateid+'"]').val(), _token:$('input[name="token"]').val()},
                    success: function(data){
                        //$(".swiper-slide-active .load-ajax").empty();
                        $(".swiper-slide-active .load-ajax").append(data.msg).fadeIn();
                        $('input[name="pagesize'+cateid+'"]').val(data.pagesize);
                        if(data.status == 'red'){
                            $('.swiper-slide-active a.tenposs-readmore').hide();
                        }
                    }
                })
            })
        })
    </script>
@stop