@extends('master')

@section('page')
<div id="header">
    <div class="container-fluid">
            <h1 class="aligncenter">Global work</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="img/icon/h_nav.png" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="banner">
            <!-- Slider main container -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"><img src="img/korean-fashion.jpg" alt="korean"/></div>
                    <div class="swiper-slide"><img src="img/jpop-fashion.jpg" alt="korean"/></div>
                    <div class="swiper-slide"><img src="img/scenes-fashion.jpg" alt="korean"/></div>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div><!-- End banner -->
        <div id="content">
            <div id="recentry">
                <h2 class="aligncenter">Recentry</h2>
                <div class="container-fluid">
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
            </div><!-- End recentry -->
            <div id="photogallery">
                <h2 class="aligncenter">Photo Gallery</h2>
                <div class="container-fluid">
                    <div class="row">
                        <div class="item-photogallery">
                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                        </div>
                        <div class="item-photogallery">
                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                        </div>
                        <div class="item-photogallery">
                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                        </div>
                        <div class="item-photogallery">
                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                        </div>
                        <div class="item-photogallery">
                            <img src="img/2colofot.jpg" alt="Nakayo"/>
                        </div>
                    </div>
                    <a href="#" class="btn tenposs-readmore">Readmore</a>
                </div>
            </div><!-- End photogallery -->
            <div id="news">
                <h2 class="aligncenter">News</h2>
                <div class="container-fluid">
                    <div class="item-coupon imageleft clearfix">
                        <div class="image">
                            <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                        </div>
                        <div class="info clearfix">
                            <a href="coupondetail.html">What is Lorem Ipsum?</a>
                            <h3>Lorem Ipsum</h3>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                Lorem Ipsum has been the industry's 
                            </p>
                        </div>
                    </div><!-- End item coupon -->
                    <div class="item-coupon imageleft clearfix">
                        <div class="image">
                            <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                        </div>
                        <div class="info clearfix">
                            <a href="coupondetail.html">What is Lorem Ipsum?</a>
                            <h3>Lorem Ipsum</h3>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                Lorem Ipsum has been the industry's 
                            </p>
                        </div>
                    </div><!-- End item coupon -->
                    <div class="item-coupon imageleft clearfix">
                        <div class="image">
                            <img src="img/ynQ1r5Jf.jpg" alt="Nakayo"/>
                        </div>
                        <div class="info clearfix">
                            <a href="coupondetail.html">What is Lorem Ipsum?</a>
                            <h3>Lorem Ipsum</h3>
                            <div class="justify">
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    Lorem Ipsum has been the industry's 
                                </p>
                            </div>
                        </div>
                    </div><!-- End item coupon -->

                    <a href="#" class="btn tenposs-readmore">Readmore</a>
                </div>
            </div><!-- End News -->
            <div id="contact">
                <img src="img/map.jpg" alt="map">
                <ul>
                    <li>
                        <div class="table-cell">
                            <img src="img/icon/f_location.png" alt="icon">
                            Location
                        </div>
                    </li>
                    <li>
                        <div class="table-cell">
                            <img src="img/icon/f_time.png" alt="icon">
                            AM 10:00 - PM 20:00
                        </div>
                    </li>
                    <li>
                        <div class="table-cell">
                            <img src="img/icon/f_tel.png" alt="icon">
                            <a href="#">050-1234-5678</a>
                        </div>
                    </li>
                </ul>
                <div class="container-fluid">
                    <a href="#" class="btn tenposs-button">Contact</a>
                </div>
            </div><!-- End contact -->
        </div><!-- End content -->
        @include('partials.sidemenu')
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