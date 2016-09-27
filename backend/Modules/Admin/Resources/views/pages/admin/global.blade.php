@extends('admin::layouts.default')

@section('title', 'グローバル')

@section('content')
    <div class="content">
        <form action="{{ route('admin.global.store') }}" 
            id="form_app_setting"
            method="post" 
            enctype="multipart/form-data">
        

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
                                <li><a href="#" alt="tab4">アプリ情報</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="wrap-preview">
                            <div class="wrap-content-prview">
                                <div class="content-preview clearfix">
                                    <div class="sidebar-preview">
                                        <div id="mobile-side" class="side" style="background: #{{$app_settings->menu_background_color }}">
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
                                            <ul class="s_nav" >
                                                <!--    
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
                                                -->
                                                @if(count($data_component_dest) > 0)
                                                    @foreach ($data_component_dest as $v)
                                                        <li id="side-item{{$v->id}}" 
                                                            class="{{$v->sidemenu_icon}}" 
                                                            data-id="{{$v->id}}" 
                                                            data-value="{{$v->id}}">
                                                            <a style="color:#{{$app_settings->menu_font_color}};
                                                            font_family: '{{ $app_settings->menu_font_family }}';
                                                            font-size: {{ $app_settings->menu_font_size }}px" 
                                                            href="javascript:avoid();">{{$v->name}}</a>
                                                        </li>
                                                    @endforeach
                                                @endif
      
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
                                
                                <div class="formCommon">
                                    <div class="form-group">
                                        <label for="">タイトル</label>
                                        {{Form::text('title',$app_settings->title,
                                        array('class'=>'first-input', 'placeholder'=>''))}}
                                    </div>
                                    <div class="form-group">
                                        <label for="">タイトルカラー</label>
                                    <span>
                                        {{Form::text('title_color',$app_settings->title_color
                                        ,array('id'=>'title_color','class'=>'jscolor', 'placeholder'=>''))}}
                                        <img    onclick="document.getElementById('title_color').jscolor.show()" 
                                                src="/assets/backend/images/draw.jpg" height="21" width="20"
                                                class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">フォントタイプ・フォントファミリ</label>
										<span class="inline">
                                            @if(count($list_font_size) > 0)
                                                {{Form::select('font_size',$list_font_size,$app_settings->font_size,['class'=>'font-size'])}}
                                            @endif
                                            @if(count($list_font_family) > 0)
                                                {{Form::select('font_family',$list_font_family,$app_settings->font_family,['class'=>'font-size'])}}
                                            @endif

										</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">ヘッダーカラー</label>
                                    <span>
                                        {{Form::text('header_color',$app_settings->header_color,
                                        array('id'=>'header_color','class'=>'jscolor', 'placeholder'=>''))}}

                                        <img    onclick="document.getElementById('header_color').jscolor.show()"
                                                src="/assets/backend/images/draw.jpg" height="21" width="20"
                                                class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">メニューイコンカラー</label>
                                    <span>
                                        {{Form::text('menu_icon_color',$app_settings->menu_icon_color,
                                        array('id'=>'menu_icon_color','class'=>'jscolor', 'placeholder'=>''))}}

                                        <img    onclick="document.getElementById('menu_icon_color').jscolor.show()"
                                                src="/assets/backend/images/draw.jpg" height="21" width="20"
                                                class="draw"></span>
                                    </div>
                                </div>
                                
                            </div> <!-- end content global -->

                            <div class="content-global" id="tab2">
                               
                                <div class="formCommon">
                                    <div class="form-group">
                                        <label for="">バックグラウンドカラー</label>
                                <span>
                                    {{Form::text('menu_background_color',$app_settings->menu_background_color,
                                    array(
                                    'id'=>'menu_background_color',
                                    'class'=>'jscolor {onFineChange:"MobileView.updateMenuBackground(this)"}', 
                                    'placeholder'=>'')
                                    
                                    )}}

                                    <img  onclick="document.getElementById('menu_background_color').jscolor.show()"
                                        src="/assets/backend/images/draw.jpg"
                                         height="21" width="20"
                                         class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">フォントカラー</label>
                                <span> {{Form::text('menu_font_color',$app_settings->menu_font_color,
                                    array('id'=>'menu_font_color', 
                                    'class'=>'jscolor {onFineChange:"MobileView.updateMenuColor(this)"}',
                                    'placeholder'=>''))}}

                                    <img onclick="document.getElementById('menu_font_color').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         height="21" width="20"
                                         class="draw"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">フォントタイプ・フォントファミリ</label>
										<span class="inline">
                                              @if(count($list_font_size) > 0)
                                                {{Form::select('menu_font_size',$list_font_size,$app_settings->menu_font_size,
                                                [
                                                    'class'=>'font-size',
                                                    'onchange' => 'MobileView.updateMenuFontSize(this.value)'
                                                ])}}
                                            @endif
                                            @if(count($list_font_family) > 0)
                                                {{Form::select('menu_font_family',$list_font_family,$app_settings->menu_font_family,
                                                [
                                                    'class'=>'font-size',
                                                    'onchange' => 'MobileView.updateMenuFontFamily(this.value)'
                                                ])}}
                                            @endif
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
                                                            <li data-id="{{$v->id}}" data-value="{{$v->id}}">
                                                                {{$v->name}}</li>
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
                                                            <li data-id="{{$v->id}}" data-value="{{$v->id}}">
                                                                {{$v->name}}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="content-global" id="tab3">
                              
                                <div class="formCommon">
                                    <div class="form-group">
                                        
                                        <div class="img-wrapper col-md-4" align="">
                                            <label for="">アプリアイコン</label>
                                             <?php
                                                $app_icon = (isset($app_stores->app_icon_url) && $app_stores->app_icon_url !== '') 
                                                ? url($app_stores->app_icon_url) 
                                                : url('/assets/backend/images/wall.jpg');
                                            ?>
                                            <img id="app-icon-review" class="new_img" src="{{ $app_icon }}" width="100%">
                                            <button class="btn_upload_img create" type="button">
                                                <i class="fa fa-picture-o" aria-hidden="true"></i> 画像アップロード
                                            </button>
                                            {!! Form::file('file[app_icon]',['class'=>'btn_upload_ipt create', 
                                            'type' => 'button', 'id' => 'app-icon']) !!}
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        <div class="img-wrapper col-md-4">
                                            <label for="">Store用画像</label>
                                            <?php
                                                $store_image = (isset($app_stores->store_icon_url) && $app_stores->store_icon_url !== '') 
                                                ? url($app_stores->store_icon_url) 
                                                : url('/assets/backend/images/wall.jpg');
                                            ?>
                                            <img id="store-image-review" class="new_img" src="{{$store_image}}" width="100%">
                                            <button class="btn_upload_img create" type="button">
                                                <i class="fa fa-picture-o" aria-hidden="true"></i> 画像アップロード
                                            </button>
                                            {!! Form::file('file[store_image]',['class'=>'btn_upload_ipt create', 
                                            'hidden', 'type' => 'button', 'id' => 'store-image']) !!}
                                        </div>
                                    </div>    
                               

                                </div>
                              
                            </div>
                            <div class="content-global" id="tab4">
                                <div class="form-group">
                                    <label for="">企業情報</label>
                                   
                                    {{Form::textarea('company_info',$app_settings->company_info,
                                    array('class'=>'form-control', 'placeholder'=>''))}}
                                   
                                </div>
                                <div class="form-group">
                                    <label for="">ユーザーのプライバシー</label>
                                    {{Form::textarea('user_privacy',$app_settings->user_privacy,
                                    array('class'=>'form-control', 'placeholder'=>''))}}
                                </div>
                            </div>
                        </div>    <!-- wrap-content-->
                    </div>
                </div>
            </div>

        </div>
        <!-- END -->
        </form>
    </div>    <!-- end main-content-->

@stop

@section('script')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/mobile-reviews.js')}}
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
            
            $('.btn_upload_img.create').click(function () {
                $(this).next('.btn_upload_ipt.create').click();
            });

           

            $("#app-icon").change(function () {
                if ( this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#app-icon-review').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
            
            $("#store-image").change(function () {
                if ( this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#store-image-review').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
            
            
        })
        function moveTo(from, to) {
            $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
            $('.' + to + ' li').removeAttr('class');
            
            MobileView.updateMenuListItems( $('ul.from-nav li' ) );
        }

        $('#btn_submit_form').click(function () {
            $('ul.nav-left li').each(function () {
                var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_sidemenus[]">';
                $('.main-content').append(tmp);
            });
            $('#form_app_setting').submit();
        });
    </script>



@stop