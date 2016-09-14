@extends('admin::layouts.default')

@section('title', 'グローバル')

@section('content')
    <div class="content">

        {{Form::model($app_settings,array('route'=>array('admin.global.store',$app_settings->id),'method'=>'POST','id'=>'form_app_setting'))}}
        {{--{{Form::open(array('route'=>'admin.global.store', 'class' => 'formCommon'))}}--}}

        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">グローバル</h1>
                </div>
                <div class="right-topbar">
                    {{--<a href="#" class="btn-me btn-topbar">保存</a>--}}
                    {{--{{Form::submit('保存',array('class'=>'btn btn-primary',"id"=>"btnFormData"))}}--}}
                    <input type="button" id="btn_submit_form" name="btn_submit_form" value="保存" class="btn btn-primary">
                </div>
            </div>
        </div>
        <!-- END -->

        <div class="main-content global">
            @include('admin::layouts.message')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="global-tab">
                            <ul class="nav-tab clearfix">
                                <li><a href="#" alt="tab1" class="active">ヘッダー</a></li>
                                <li><a href="#" alt="tab2">サイトメニュー</a></li>
                                <li><a href="#" alt="tab3">Appストア</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrap-preview">
                            <div class="wrap-content-prview">
                                <div class="content-preview clearfix">
                                    <div class="sidebar-preview">
                                        <div class="side">
                                            <div class="h_side">
                                                <div class="imageleft">
                                                    <div class="image">
                                                        <img class="img-circle"
                                                             src="/assets/backend/images/icon-user.png" height="35"
                                                             width="35" alt="Thư kỳ"/>
                                                    </div>
                                                    <p class="font32">User name</p>
                                                </div>
                                            </div>
                                            <ul class="s_nav">
                                                <li class="s_icon-home active"><a href="javascript:avoid();">Home</a>
                                                </li>
                                                <li class="s_icon-menu"><a href="javascript:avoid();">Menu</a></li>
                                                <li class="s_icon-reserve"><a href="javascript:avoid();">Reserve</a>
                                                </li>
                                                <li class="s_icon-news"><a href="javascript:avoid();">News</a></li>
                                                <li class="s_icon-photo"><a href="javascript:avoid();">Photo Gallery</a>
                                                </li>
                                                <li class="s_icon-staff"><a href="javascript:avoid();">Staff</a></li>
                                                <li class="s_icon-coupon"><a href="javascript:avoid();">Coupon</a></li>
                                                <li class="s_icon-chat"><a href="javascript:avoid();">Chat</a></li>
                                                <li class="s_icon-setting"><a href="javascript:avoid();">Setting</a>
                                                </li>
                                            </ul>
                                        </div><!-- End side -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="wrapper-content">
                            <div class="content-global" id="tab1">
                                {{--{{Form::open(array('route'=>'admin.global.store', 'class' => 'formCommon'))}}--}}
                                <div class="formCommon">
                                    <div class="form-group">
                                        <label for="">タイトル</label>
                                        {{Form::text('title',old('title'),array('class'=>'first-input', 'placeholder'=>''))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">タイトルカラー</label>
                                    <span>
                                        {{Form::text('title_color',old('title_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                        <img
                                                src="/assets/backend/images/draw.jpg" height="21" width="20"
                                                class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">フォントタイプ・フォントファミリ</label>
										<span class="inline">
											<select name="font_size" class="font-size">
												<option value="12">12px</option>
												<option value="14">14px</option>
											</select>
											<select name="font_family" id="">
												<option value="">スタの新スタの新</option>
											</select>
										</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">ヘッダーカラー</label>
                                    <span>
                                        {{Form::text('header_color',old('header_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                        <img
                                                src="/assets/backend/images/draw.jpg" height="21" width="20"
                                                class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">メニューイコンカラー</label>
                                    <span>
                                        {{Form::text('menu_icon_color',old('menu_icon_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                        <img
                                                src="/assets/backend/images/draw.jpg" height="21" width="20"
                                                class="draw"></span>
                                    </div>
                                </div>
                                {{--{{Form::close()}}--}}
                            </div> <!-- end content global -->

                            <div class="content-global" id="tab2">
                                {{--{{Form::open(array('route'=>'admin.global.store', 'class' => 'formCommon'))}}--}}
                                <div class="formCommon">
                                    <div class="form-group">
                                        <label for="">バックグラウンドカラー</label>
                                <span>
                                    {{Form::text('menu_background_color',old('menu_background_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                    <img src="/assets/backend/images/draw.jpg"
                                         height="21" width="20"
                                         class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">フォントカラー</label>
                                <span> {{Form::text('menu_font_color',old('menu_font_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                    <img src="/assets/backend/images/draw.jpg"
                                         height="21" width="20"
                                         class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">フォントタイプ・フォントファミリ</label>
										<span class="inline">
											<select name="menu_font_size" class="font-size">
												<option value="12">12px</option>
												<option value="14">14px</option>
											</select>
											<select name="menu_font_family" id="">
												<option value="">スタの新スタの新</option>
											</select>
										</span>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="">サイトメニュー項目</label>
                                        <div class="wrap-table">
                                            <div class="wrap-transfer col">
                                                <p class="title-form">表示</p>
                                                <ul class="nav-left from-nav">
                                                    @if(count($data_component_dest) > 0)
                                                        @foreach ($data_component_dest as $k=>$v)
                                                            <li data-id="{{$k}}" data-value="{{$k}}">
                                                                {{$v}}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="wrap-btn-control col">
                                                <a href="javascript:moveTo('from-nav','to-nav')"><span
                                                            class="glyphicon glyphicon-triangle-right"></span></a>
                                                <a href="javascript:moveTo('to-nav','from-nav')"><span
                                                            class="glyphicon glyphicon-triangle-left"></span></a>
                                            </div>
                                            <div class="wrap-transfer col">
                                                <p class="title-form">非表示</p>
                                                <ul class="nav-right to-nav">
                                                    @if(count($data_component_source) > 0)
                                                        @foreach ($data_component_source as $k=>$v)
                                                            <li data-id="{{$k}}" data-value="{{$k}}">
                                                                {{$v}}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--{{Form::close()}}--}}
                            </div>
                            <div class="content-global" id="tab3">
                                {{--{{Form::open(array('route'=>'admin.global.store', 'class' => 'formCommon'))}}--}}
                                <div class="formCommon">
                                    <div class="form-group">
                                        <label for="">アプリアイコン</label>
                                <span>
                                  {{Form::text('app_icon_color',old('app_icon_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                    <img src="/assets/backend/images/draw.jpg"
                                         height="21" width="20"
                                         class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Store用画像</label>
                                <span>
                                   {{Form::text('store_user_color',old('store_user_color'),array('class'=>'jscolor', 'placeholder'=>''))}}

                                    <img src="/assets/backend/images/draw.jpg"
                                         height="21" width="20"
                                         class="draw"></span>
                                    </div>
                                    </form>
                                </div>
                                {{--{{Form::close()}}--}}
                            </div>
                        </div>    <!-- wrap-content-->
                    </div>
                </div>
            </div>

        </div>
        <!-- END -->
        {{Form::close()}}
    </div>    <!-- end main-content-->

@stop

@section('script')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}
    {{Html::script('assets/backend/js/jscolor.js')}}
    {{Html::script('assets/backend/js/script.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('.content-global').not(':first').hide();

            $('.nav-tab li a').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('alt');
                $('.nav-tab li a').removeClass('active');
                $('.content-global').slideUp();
                $(this).addClass('active');
                $('#' + id).slideDown();
            })

            $('.nav-left, .nav-right').on('click', 'li', function () {
                $(this).toggleClass('selected');
            });
        })
        function moveTo(from, to) {
            $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
            $('.' + to + ' li').removeAttr('class');
        }

        $('#btn_submit_form').click(function () {
            $('ul.nav-right li').each(function(){
                var tmp = '<input type="hidden" value="' + $(this).data('value') +'"  name="data_component[]">';
                $('.main-content').append(tmp);
            });
            $('#form_app_setting').submit();
        });
    </script>



@stop