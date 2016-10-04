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
            <h1>Menu detail</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="img/icon/h_nav.png" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
            <img src="img/single.jpg" alt="Nakayo"/>
            <div class="container-fluid">
                <div class="info-productdetail">
                    <div class="container-fluid">
                        <span>ID: 123456</span>
                        <p class="font32"><strong>PRODUCT NAME</strong></p>
                        <span class="price">$1,200</span>
                    </div>
                    <a href="javascript:void(0)" class="btn pad20 tenposs-button">Buy now</a>
                </div>
                <div class="entry-productdetail">
                    <div class="option">
                        <span class="btn switch switch-on">Lorem Ipsum</span>
                        <span class="btn switch switch-off">is simply</span>
                    </div>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                        It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially unchanged.
                    </p>
                    <div class="pad20">
                        <a href="javascript:void(0)" class="btn pad20 tenposs-readmore">Buy now</a>
                    </div>
                </div>
            </div><!-- End container fluid -->
            <div id="related">
                <div class="container-fluid">
                    <h2 class="aligncenter font32">Related</h2>
                    <div class="row clearfix">
                        <div class="item-product">
                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                            <p>Nayako</p>
                            <span>$ 1,200</span>
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
                </div><!-- End container fluid -->
            </div><!-- End related -->
        </div><!-- End content -->

        {{--@include('partials.sidemenu')--}}
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
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


@endsection