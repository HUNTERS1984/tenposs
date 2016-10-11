@extends('master')
@section('headCSS')
    <link href="{{ url('css/menu.css') }}" rel="stylesheet">
@endsection
@section('page')
    <div id="header">
        <div class="container-fluid">
            <h1 class="aligncenter" style="
            color: #{{ $app_info->data->app_setting->title_color}};
            background-color: #{{ $app_info->data->app_setting->header_color}};
            ">メニュー</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="{{ url('img/icon/h_nav.png') }}" alt="nav"/>
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
                        @if(count($menus_data) > 0)
                            @foreach($menus_data as $item)
                                <div class="swiper-slide" data-id="{{$item->id}}">{{$item->name}}</div>
                            @endforeach
                        @endif
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div><!-- End category -->
            <div id="category-detail">
                <form id="myform" method="post" action="">
                    <input type="hidden" id="current_page" value="{{$page_number}}">
                </form>
                <div class="container-fluid">
                    <!-- Slider main container -->
                    <div class="swiper-container">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <div class="swiper-slide" id="category-data">
                                <div id="row-data" class="row">
                                    @if(count($items_data) > 0)
                                        @foreach($items_data as $item)
                                            <div class="item-product">
                                                <a href="{{ route('menus.detail', $item->id)}}">
                                                    <img class="image_size" src="{{$item->image_url}}}" alt="{{$item->title}}"/>
                                                    <p>{{$item->title}}</p>
                                                    <span>$ {{number_format($item->price, 0, '', '.')}}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>データなし</p>
                                    @endif

                                </div>
                                @if($total_page > 1)
                                    <div class="row" style="text-align:center;" id="div_load_more">
                                        <a href="javascript:void(0)" id="load_more"
                                           class="btn tenposs-readmore">続きを読む</a>
                                    </div>
                                @endif
                            </div>
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
        var categorySwiper = new Swiper('#category .swiper-container', {
            speed: 400,
            spaceBetween: 0,
            slidesPerView: 1,
            nextButton: '#category .swiper-button-next',
            prevButton: '#category .swiper-button-prev',
            onSlideNextStart: function (swiper) {

                console.log($('.swiper-slide-active ').data('id'));
                var category_idx = $('.swiper-slide-active ').data('id');
                $.ajax({
                    url: "{{ route('menus.index.get_data')}}",
                    data: {menu_id: category_idx, page: 1},
                    beforeSend: function () {
                        var data = '<div id="row-data" style="text-align:center;" class="row"><img src="{{ url('img/loading.gif') }}" /></div>';
                        $('#category-data').html(data);
                    }
                }).done(function (data) {
                    $('#current_page').val(1);
                    $('#category-data').html(data);

                });
            },
            onSlidePrevStart: function (swiper) {
                console.log($('.swiper-slide-active').data('id'));
                var category_idx = $('.swiper-slide-active ').data('id');
                $.ajax({
                    url: "{{ route('menus.index.get_data')}}",
                    data: {menu_id: category_idx, page: 1},
                    beforeSend: function () {
                        var data = '<div id="row-data" style="text-align:center;" class="row"><img src="{{ url('img/loading.gif') }}" /></div>';
                        $('#category-data').html(data);
                    }
                }).done(function (data) {
                    $('#current_page').val(1);
                    $('#category-data').html(data);

                });
            }
        });
        $(document).ready(function () {
            $(document).on("click", "#load_more", function () {
                var current_page = parseInt($('#current_page').val());
                var next_page = current_page + 1;
                var category_idx = $('.swiper-slide-active ').data('id');
                var total_page = parseInt('{{$total_page}}');

                $.ajax({
                    url: "{{ route('menus.index.get_data')}}",
                    async: true,
                    data: {menu_id: category_idx, page: next_page, type: 'load_more'},
                    beforeSend: function () {
                        var data = '<img src="{{ url('img/loading.gif') }}" />';
                        $('#div_load_more').html(data);
//                        $('#div_load_more').remove();
                    }
                }).done(function (data) {
                    var tmp_html = bind_html_load_more(data.items_data, '{{ url('menus/detail')}}')
                    $('#row-data').append(tmp_html);
                    $('#current_page').val(next_page);
                    if (parseInt(data.page_number) >= parseInt(data.total_page))
                        $('#div_load_more').remove();
                    else {
                        var html = '<a href="javascript:void(0)" id="load_more" class="btn tenposs-readmore">続きを読む</a>';
                        $('#div_load_more').html(html);
                    }
                });
            });
        });

    </script>


@endsection