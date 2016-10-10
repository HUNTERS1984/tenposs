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
            ">ニュース</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="img/icon/h_nav.png" alt="nav"/>
            </a>
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
                        @if( isset($news_cate)  && count($news_cate) > 0 )
	                        @foreach($news_cate as $cate)
                                @foreach($cate->data->news_categories as $name_cate)
                                     <div class="swiper-slide" data-id="{{$name_cate->id}}">{{$name_cate->name}}</div>
                                @endforeach
							@endforeach
                        @endif
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div><!-- End category -->
            <div id="category-detail">
                <input type="hidden" name="token" value="{{ csrf_token() }}">
                <div class="container-fluid">
                    <!-- Slider main container -->
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @if(isset($news_detail) && count($news_detail)>0)
                            @foreach($news_detail as $news)
                                <div class="swiper-slide">
                                    <div class="load-ajax">
                                        @foreach($news->data->news as $news_title)
                                        <div class="item-coupon imageleft clearfix">
                                            <input type="hidden" name="pagesize{{$news_title->new_category_id}}" value="{{$pagesize}}">
                                            <div class="image">
                                                <img src="{{$news_title->image_url}}" alt="Nakayo"/>
                                            </div>
                                            <div class="info clearfix">
                                                <a href="{{route('news.detail',[$news_title->id])}}">{{$news_title->title}}</a>
                                                <h3>{{$news_title->title}}</h3>
                                                <p>{{Str::words($news_title->description,20)}}</p>
                                            </div>
                                        </div><!-- End item coupon -->
                                        @endforeach
                                    </div>
                                    @if($pagesize > 20)
                                    <a href="#" class="btn tenposs-readmore more">もっと見る</a>
                                    @endif
                                </div><!-- swiper slide -->
                            @endforeach
                            @endif
                            <!-- Slides -->

                        </div><!--  -->
                    </div><!-- Swiper container -->
                </div>
            </div><!-- Category detail -->
        </div><!-- End content -->
        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer"></div><!-- End footer -->
@stop
@section('footerJS')
	<script type="text/javascript">
        var cateid;
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
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".tenposs-readmore.more").on('click',function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{route('news.ajax')}}",
                    type: 'POST',
                    data: {cate: cateid, pagesize:$('input[name="pagesize'+cateid+'"]').val(), _token:$('input[name="token"]').val()},
                    success: function(data){
                        $(".swiper-slide-active .load-ajax").empty();
                        $(".swiper-slide-active .load-ajax").append(data.msg).fadeIn();
                        $('input[name="pagesize'+cateid+'"]').val(data.pagesize);
                        if(data.status == 'red'){
                            // $('a.tenposs-readmore').removeClass('more').addClass('nomore').text('No more');
                            // $('a.tenposs-readmore').replaceWith("<button class='btn tenposs-readmore' type='button'>No More</button>");
                            alert('No more to load');
                        }
                    }
                })
            })
        })
    </script>
@stop