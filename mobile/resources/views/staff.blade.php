@extends('master')

@section('headCSS')
    <link href="{{ url('css/photogallery.css') }}" rel="stylesheet">
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
                        @if( isset($staff_cate)  && count($staff_cate) > 0 )
                            @foreach($staff_cate as $cate)
                                @foreach($cate->data->staff_categories as $name_cate)
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
                <div class="container-fluid">
                    <!-- Slider main container -->
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @if(isset($staff_detail) && count($staff_detail)>0)
                                @foreach($staff_detail as $staff)
                                <div class="swiper-slide">
                                    <div class="row">
                                        <div class="load-ajax">
                                            @if( $staff !== null)
                                            @foreach($staff->data->staffs as $item)

                                            <div class="item-photogallery">
                                            <input type="hidden" name="pagesize{{$item->staff_category_id}}" value="{{$pagesize}}">
                                                <a href="{{route('staff.detail',$item->id)}}">
                                                    <img src="{{$item->image_url}}" alt="Nakayo"/>
                                                </a>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <a href="#" class="btn tenposs-readmore">Readmore</a>
                                </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div><!-- End photogallery detail -->

            </div><!-- End container fluid -->
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
        $(".tenposs-readmor").on('click',function(e){
            e.preventDefault();
            $.ajax({
                url: "{{route('staff.ajax')}}",
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