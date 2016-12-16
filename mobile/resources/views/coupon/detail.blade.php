@extends('master')
@section('headCSS')
<link href="{{ url('css/coupon.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: {{ $app_info->data->app_setting->font_family }};
    }
    .h_control-back:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }
    #header h1{
        color: #{{ $app_info->data->app_setting->title_color }};
        }
    #header > .container-fluid{
        background-color:#{{ $app_info->data->app_setting->header_color }};
        }

</style>
@endsection
@section('page')
    <div id="header">
        <div class="container-fluid">
            <h1 class="aligncenter" >{{ $app_info->data->app_setting->title }}</h1>
            <a href="{{URL::previous()}}" class="h_control-back"></a>
        </div>
    </div><!-- End header -->
    @if(count($items_detail_data) > 0)
        <div id="banner">
            <!-- Slider main container -->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"><img class="center-cropped" src="{{$items_detail_data->image_url}}"
                                                   alt="{{$items_detail_data->title}}" style="width:100%;height:100vmin"/></div>

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
                            <p><span>ID{{$items_detail_data->id}}</span> <span class="dot-middle"></span> <a
                                        href="javascrip:void(0)"> @if(array_key_exists('coupon_type',$items_detail_data))
                                        {{$items_detail_data->coupon_type->name}}
                                    @else
                                        空の入力
                                    @endif</a></p>
                            <h3 class="title-coupon">{{$items_detail_data->title}}</h3>
                            <span class="dateadd">有効期間: {{ date('Y年m月d日', strtotime($items_detail_data->end_date))  }}</span>
                        </div>
                        <div class="form-mail">
                            <div class="input-group">
                                <?php $ls_tag = '';?>
                                @if(array_key_exists('taglist',$items_detail_data) && count($items_detail_data->taglist) > 0)
                                    @foreach($items_detail_data->taglist as $item)
                                        <?php $ls_tag .= $item . ',';?>
                                    @endforeach
                                    <?php $ls_tag = rtrim($ls_tag, ",");?>
                                @endif
                                <input style="text-align: center;" type="text" class="form-control" id="target_copy" value="#{{$ls_tag}}"
                                       placeholder="ハッシュタグ">

                                <div class="input-group-addon" style="cursor: pointer;" id="copy_hashtag"><a  href="javascipt:void(0)">コピー</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entrydetail justify">
                        <div class="inner-entrydetail text-justify">
                            <p>
                        {!! $items_detail_data->description !!}</p>
                        </div>
                    </div>
                @else
                    <p style="text-align: center; margin-top:20px">データなし</p>
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
                <a id="apply-cupon">
                    このクーボンを利用す
                </a>
            </div>
        @else
            <div id="below-content" class="disable">
                <a id="apply-cupon">
                    このクーポンは使用できません
                </a>
            </div>
        @endif
    @endif

    <div id="appy-copy-success" style="display:none">
        <div class="appy-cupon-success-inner">
            <img src="{{ url('img/ico_ui_coupon.png') }}"></img>
            <p>ハッシュタグをコピーしました</p>
        </div>
    </div>

    <div id="appy-cupon-success" style="display:none">
        <div class="appy-cupon-success-inner">
            <img src="{{ url('img/ico_ui_coupon.png') }}"></img>
            <p>このクーポンは使用できません</p>
        </div>
    </div>

@endsection
@section('footerJS')
    <script src="{{ url('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("click", "#copy_hashtag", function (e) {
                e.preventDefault();
                $(this).parent().parent();
                copyToClipboard(document.getElementById("target_copy"));
                $('#appy-copy-success').show();
            });

            $('#apply-cupon').on('click',function(){
                $('#appy-cupon-success').show();
            });

            $('#appy-copy-success').on('click',function(){
                $('#appy-copy-success').hide();
            });

            $('#appy-cupon-success').on('click',function(){
                $('#appy-cupon-success').hide();
            });
        });
    </script>


@endsection