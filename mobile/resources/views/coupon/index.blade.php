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
            ">クーポン</h1>
            {{--<h1>Menu</h1>--}}
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="{{ url('img/icon/h_nav.png') }}" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
            <form id="myform" method="post" action="">
                <input type="hidden" id="current_page" value="{{$page_number}}">
            </form>
            <div class="container-fluid" id="row-data">
                @if(count($items_data) > 0)
                    @foreach($items_data as $item)
                        <div class="item-coupon imageleft clearfix">
                            <div class="image">
                                <img src="{{$item->image_url}}" alt="{{$item->title}}"/>
                            </div>
                            <div class="info clearfix">
                                <a href="{{ route('coupon.detail',$item->id)}}">
                                    @if(array_key_exists('coupon_type',$item))
                                        {{$item->coupon_type->name}}
                                    @else
                                        空の入力
                                    @endif
                                </a>
                                <h3>{{$item->title}}</h3>
                                <p align="justify">
                                    {{$item->description}}
                                </p>
                            </div>
                        </div><!-- End item coupon -->
                    @endforeach
                @else
                    <p>データなし</p>
                @endif
            </div>
            @if($total_page > 1)
                <div class="row" style="text-align:center;" id="div_load_more">
                    <a href="javascript:void(0)" id="load_more"
                       class="btn tenposs-readmore">もっと見る</a>
                </div>
            @endif
        </div><!-- End content -->
        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
@section('footerJS')
    <script src="{{ url('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("click", "#load_more", function () {
                var current_page = parseInt($('#current_page').val());
                var next_page = current_page + 1;
                var category_idx = $('.swiper-slide-active ').data('id');
                var total_page = parseInt('{{$total_page}}');

                $.ajax({
                    url: "{{ route('coupon.get_data')}}",
                    async: true,
                    data: {page: next_page, type: 'load_more'},
                    beforeSend: function () {
                        var data = '<img src="{{ url('img/loading.gif') }}" />';
                        $('#div_load_more').html(data);
//                        $('#div_load_more').remove();
                    }
                }).done(function (data) {
                    var tmp_html = bind_coupon_load_more(data.items_data, '{{ url('coupon/detail')}}')
                    $('#row-data').append(tmp_html);
                    $('#current_page').val(next_page);
                    if (parseInt(data.page_number) >= parseInt(data.total_page))
                        $('#div_load_more').remove();
                    else {
                        var html = '<a href="javascript:void(0)" id="load_more" class="btn tenposs-readmore">もっと見る</a>';
                        $('#div_load_more').html(html);
                    }
                });
            });
        });

    </script>


@endsection