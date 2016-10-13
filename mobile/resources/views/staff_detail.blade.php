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
            <img src="{{$detail->data->staffs->image_url}}" style="width:100%" alt="Nakayo"/>
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
                        <ul class="nav-switch">
                            <li class="active"><a href="#" data-alt="intro">自己紹介</a></li>
                            <li><a href="#" data-alt="info">プロフィール</a></li>
                        </ul>
                    </div>
                    <div class="content-staffDetail" id="intro">
                        <p>{{$detail->data->staffs->introduction}}</p>
                        @if(str_word_count($detail->data->staffs->introduction) > 40)
                        <a href="javascript:void(0)" class="btn pad20 tenposs-readmore">もっと見る</a>
                        @endif
                    </div>
                    <div class="content-staffDetail" id="info">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p class="title-staff">Gender:</p>
                                </div>
                                <div class="col-xs-8">
                                    <p class="title-staff">{{$detail->data->staffs->gender}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p class="title-staff">Birthday:</p>
                                </div>
                                <div class="col-xs-8">
                                    <p class="title-staff">{{$detail->data->staffs->birthday}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p class="title-staff">Tel:</p>
                                </div>
                                <div class="col-xs-8">
                                    <p class="title-staff">{{$detail->data->staffs->tel}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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

        $('.content-staffDetail').not(':first').hide();
        $('.nav-switch li a').on('click',function(e){
            e.preventDefault();
            var id = $(this).data('alt');
            $('.nav-switch li').removeClass('active');
            $(this).parent('li').addClass('active');
            $('.content-staffDetail').slideUp();
            $('#'+id).slideDown();
        })
    </script>
@stop