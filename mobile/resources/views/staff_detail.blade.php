@extends('master')

@section('headCSS')
<link href="{{ url('css/staff.css') }}" rel="stylesheet">
<style>
    .h_control-back:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
    }
    #header h1{
        color: #{{ $app_info->data->app_setting->title_color }};
    }
    #header > .container-fluid{
        background-color:#{{ $app_info->data->app_setting->header_color }};
    }
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: {{ $app_info->data->app_setting->font_family }};
    }
</style>
@stop

@section('page')
    <div id="header">
         <div class="container-fluid">
            <h1 class="aligncenter">
                {{ $detail->data->staffs->name }}
            </h1>
            <a href="{{URL::previous()}}" class="h_control-back"></a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content" class="staff-detail-page item-detail">
            <img class="image_size_detail center-cropped" src="{{$detail->data->staffs->image_url}}" style="width:100%" alt="Nakayo"/>
            <div class="wrap-content-staff-detail">
                <div class="info-productdetail">
                    <div class="container-fluid">
                        <span class="sub-staff-name">{{$detail->data->staffs->name}}</span>
                        <p class="font32 staff-name"><strong>{{$detail->data->staffs->name}}</strong></p>
                    </div>
                </div>
                <div class="entry-productdetail">
                    <div class="option">
                        <ul class="nav-switch">
                            <li class="active"><a href="#" data-alt="intro">自己紹介</a></li>
                            <li><a href="#" data-alt="info">プロフィール</a></li>
                        </ul>
                    </div>
                    <div class="content-staffDetail" id="intro">
                        <div class="container-fluid">
                            <p>{{$detail->data->staffs->introduction}}</p>
                            @if(str_word_count($detail->data->staffs->introduction) > 40)
                            <a href="javascript:void(0)" class="btn pad20 tenposs-readmore">もっと見る</a>
                            @endif
                        </div>
                    </div>
                    <div class="content-staffDetail" id="info">
                        <div class="container-fluid">
                            <div class="table-responsive">
                            <table class="table ">
                                <tbody>
                                        <tr>
                                            <td width:"60%">
                                                <label>性别</label>
                                            </td>
                                            <td>
                                                @if($detail->data->staffs->gender == '0')
                                                <p class="title-staff">女性</p>
                                                @else
                                                <p class="title-staff">男性</p>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width:"60%">
                                                <label>価格</label>
                                            </td>
                                            <td>
                                                <p class="title-staff">¥{{number_format($detail->data->staffs->price)}}</p>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td width:"60%">
                                                <label>電話番号</label>
                                            </td>
                                            <td>
                                                <p class="title-staff">{{$detail->data->staffs->tel}}</p>

                                            </td>
                                        </tr>
                                 </tbody>
                            </table>
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