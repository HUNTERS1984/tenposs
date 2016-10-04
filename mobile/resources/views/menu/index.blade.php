@extends('master')
@section('headCSS')
    <link href="{{ url('css/menu.css') }}" rel="stylesheet">
@endsection
@section('page')
    <div id="header">
        <div class="container-fluid">
            {{--<h1 class="aligncenter" style="--}}
            {{--color: {{ $app_info->data->app_setting->title_color}};--}}
            {{--background-color: #{{ $app_info->data->app_setting->header_color}};--}}
            {{--">--}}
            {{--{{ $app_info->data->name }}</h1>--}}
            <h1>Menu</h1>
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
                        {{--<div class="swiper-slide">Spring</div>--}}
                        {{--<div class="swiper-slide">Summer</div>--}}
                        {{--<div class="swiper-slide">Autumn</div>--}}
                        {{--<div class="swiper-slide">Winter</div>--}}
                        @if(count($menus_data) > 0)
                            @foreach($menus_data as $item)
                                <div class="swiper-slide">{{$item->name}}</div>
                            @endforeach
                        @endif
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div><!-- End category -->
            <div id="category-detail">
                <div class="container-fluid">
                    <!-- Slider main container -->
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="row">
                                    @if(count($items_data) > 0)
                                        @foreach($items_data as $item)
                                            <div class="item-product">
                                                <a href="{{ route('menus.detail', array('id' => 1))}}">
                                                    <img src="{{$item->image_url}}}" alt="{{$item->title}}"/>
                                                    <p>{{$item->title}}</p>
                                                    <span>$ {{number_format($item->price, 0, '', '.')}}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!-- End  swiper -->
                </div><!-- End container fluid -->

            </div><!-- End category detail -->
        </div><!-- End content -->

        {{--@include('partials.sidemenu')--}}
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
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


@endsection