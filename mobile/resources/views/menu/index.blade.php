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
                        <div class="swiper-slide">Spring</div>
                        <div class="swiper-slide">Summer</div>
                        <div class="swiper-slide">Autumn</div>
                        <div class="swiper-slide">Winter</div>
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
                                    <div class="item-product">
                                        <a href="menudetail.html">
                                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                                            <p>Nayako</p>
                                            <span>$ 1,200</span>
                                        </a>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/Jpnsfr.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/tkNdnb1.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="item-product">
                                        <img src="img/mdjps1.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/tkNdnb1.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/Jpnsfr.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="item-product">
                                        <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="item-product">
                                        <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                    <div class="item-product">
                                        <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                                        <p>Nayako</p>
                                        <span>$ 1,200</span>
                                    </div>
                                </div>
                            </div><!-- End swiper slide -->
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