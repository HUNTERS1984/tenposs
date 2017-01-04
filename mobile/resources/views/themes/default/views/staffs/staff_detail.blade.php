@extends('master')

@section('headCSS')
<link href="{{ Theme::asset('css/staff.css') }}" rel="stylesheet">
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
                {{ $detail->name }}
            </h1>
            <a href="{{URL::previous()}}" class="h_control-back"></a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content" class="staff-detail-page item-detail">
            <img class="image_size_detail center-cropped" src="{{$detail->image_url}}" style="width:100%" alt="Nakayo"/>
            <div class="wrap-content-staff-detail">
                <div class="info-productdetail">
                    <span class="sub-staff-name">{{$detail->staff_category_name}}</span>
                    <p class="font32 staff-name"><strong>{{$detail->name}}</strong></p>
                </div>
                <div class="entry-productdetail">
                    <div class="option">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#tab1">自己紹介</a></li>
                            <li><a href="#tab2">プロフィール</a></li>
                        </ul>
                    </div>
                    <div class="tab-content" style="padding-top: 10px; background: #fff;">
                        <div id="tab1" class="tab-pane fade in active">
                            <p>{{$detail->introduction}}</p>
                        </div>
                        <div id="tab2" class="tab-pane fade">
                            <div class="col-xs-12" style="padding:0px">
                                <ul>

                                    <li>
                                        <label>性别</label>
                                        <input type="text" name="name" value="{{$detail->gender == '0' ? '男性' : '女性'}}" readonly="readonly">

                                    </li>
                                    <li>
                                        <label>価格</label>
                                        <input type="text" name="name" value="¥{{number_format($detail->price)}}" readonly="readonly">

                                    </li>
                                    <li>
                                        <label>電話番号</label>
                                        <input type="text" name="name" value="{{$detail->tel}}" readonly="readonly">

                                    </li>
                
                                </ul>
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
        $(document).ready(function () {
            $("#myTab a").click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@stop