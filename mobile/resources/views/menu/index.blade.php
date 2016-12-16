@extends('master')
@section('headCSS')
    <link href="{{ url('css/menu.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: {{ $app_info->data->app_setting->font_family }};
    }
    .h_control-nav:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
    }
</style>
@endsection
@section('page')
    <div id="header">
        <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
            <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
            ">メニュー</h1>
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
                        @if( isset($menus)  && count($menus) > 0 )
                            @foreach($menus as $cate)
                                @foreach($cate->data->menus as $name_cate)
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
                            @if(isset($items_detail) && count($items_detail)>0)
                            @foreach($items_detail as $items)
                                @if($items)
                                <div class="swiper-slide">
                                    <div class="container-all-img clearfix">
                                        <div class="load-ajax">
                                            @foreach($items['data']['items'] as $item)
                                            <div class="item-product">
                                                <input type="hidden" name="pagesize{{$items['data']['menu_id']}}" value="{{$pagesize}}">
                                                <a href="{{ route('menus.detail', $item['id'])}}">
                                                    <img class="image_size center-cropped" src="{{$item['image_url']}}" alt="{{$item['title']}}"/>
                                                    <p>{{$item['title']}}</p>
                                                    <span>¥{{number_format($item['price'], 0, '', ',')}}</span>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    @if (count($items['data']['items']) ==  $pagesize)
                                    <a href="#" class="btn tenposs-readmore more">もっと見る</a>
                                    @endif

                                </div><!-- swiper slide -->
                                @else
                                <div class="swiper-slide">
                                    <p style="text-align: center; margin-top:20px">データなし</p>
                                </div>
                                @endif
                            @endforeach
                            @endif
                        </div>
                    </div><!-- End  swiper -->
                </div><!-- End container fluid -->

            </div><!-- End category detail -->
        </div><!-- End content -->

        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
@section('footerJS')
    <script src="{{ url('js/custom.js') }}"></script>
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
                    url: "{{route('menus.ajax')}}",
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


@endsection