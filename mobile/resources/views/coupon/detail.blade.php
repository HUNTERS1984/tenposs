@extends('master')
@section('headCSS')
    <link href="{{ url('css/coupon.css') }}" rel="stylesheet">
@endsection
@section('page')
    <div id="header">
        <div class="container-fluid">
            <h1 class="aligncenter" style="
                    color: {{ $app_info->data->app_setting->title_color}};
                    background-color: #{{ $app_info->data->app_setting->header_color}};
                    ">
                {{$items_detail_data->title}}</h1>

            <a href="javascript:void(0)" class="h_control-nav">
                <img src="{{ url('img/icon/h_nav.png') }}" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    @if(count($items_detail_data) > 0)
        <div id="banner">
            <!-- Slider main container -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"><img class="image_size_detail" src="{{$items_detail_data->image_url}}"
                                                   alt="{{$items_detail_data->title}}"/></div>

                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div><!-- End banner -->
    @endif
    <div id="main">
        <div id="content">
            <div class="container-fluid">
                @if(count($items_detail_data) > 0)
                    <div class="infodetail">
                        <div class="container-fluid">
                            <p><span>ID: {{$items_detail_data->id}}</span> . <a
                                        href="javascrip:void(0)"> @if(array_key_exists('coupon_type',$items_detail_data))
                                        {{$items_detail_data->coupon_type->name}}
                                    @else
                                        空の入力
                                    @endif</a></p>
                            <h3>{{$items_detail_data->title}}</h3>
                            <span class="dateadd">有効期間: {{$items_detail_data->end_date}}</span>
                        </div>
                        <div class="form-mail">
                            <div class="input-group">
                                @if(array_key_exists('taglist',$items_detail_data) && count($items_detail_data->taglist) > 0)
                                    <?php $ls_tag = '';?>
                                    @foreach($items_detail_data->taglist as $item)
                                        <?php $ls_tag .= $item . ',';?>
                                    @endforeach
                                    <?php $ls_tag = rtrim($ls_tag, ",");?>
                                @endif
                                <input style="text-align: center;" type="text" class="form-control" id="target_copy" value="{{$ls_tag}}"
                                       placeholder="ハッシュタグ">

                                <div class="input-group-addon" style="cursor: pointer;"><a  href="javascipt:void(0)" id="copy_hashtag">コピー</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entrydetail justify">
                        {{$items_detail_data->description}}
                    </div>
                @else
                    <p>データなし</p>
                @endif
            </div><!-- End container fluid -->
        </div><!-- End content -->

        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
    @if(count($items_detail_data) > 0)
        @if(array_key_exists('can_use',$items_detail_data) && $items_detail_data->can_use)
            <div id="below-content">
                <p>
                    このクーボンを利用す
                </p>
            </div>
        @else
            <div id="below-content-disable">
                <p>
                    このクーポンは使用できません
                </p>
            </div>
        @endif
    @endif
@endsection
@section('footerJS')
    <script src="{{ url('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("click", "#copy_hashtag", function () {
//                alert(1);
                $(this).parent().parent();
                copyToClipboard(document.getElementById("target_copy"));
            });
        });
    </script>


@endsection