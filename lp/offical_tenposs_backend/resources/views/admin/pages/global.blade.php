@extends('admin.layouts.master')

@section('main')

<form action="{{ route('admin.client.global.store') }}" 
            id="form_app_setting"
            method="post" 
            enctype="multipart/form-data" class="form-global-1">
    
  {{ csrf_field() }}   
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>グローバル</span>
            <strong>
                ヘッダータサイドメニューの編集とアフリ申請が可能
            </strong>
        </div>
        <div class="right">
            <a href="#" id="btn_submit_form" class="btn-2">保存</a>
        </div>
    </div>
    <section class="content">
        <div class="col-xs-12">@include('admin.layouts.messages')</div>
        <div class="col-md-12">
            <div class="tab-header-global">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab-global-1" aria-controls="tab-global-1" role="tab" data-toggle="tab">ヘッダー</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-global-2" aria-controls="tab-global-2" role="tab" data-toggle="tab">サイトメニュー</a>
                    </li>
                    <li role="presentation" >
                        <a href="#tab-global-3" aria-controls="tab-global-3" role="tab" data-toggle="tab">Appストア</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="tab-global-1">
                <div class="col-md-4">
                     <div class="wrapp-phone">
                        <div class="wrap-content-prview">
                            <div class="sidebar-preview">
                                <div class="mobile-side" style="background:#{{$app_settings->menu_background_color}};">
                                    <div id="scroll-global-phone-review-1">
                                        <div class="h_side">
                                            <div class="imageleft">
                                                <div class="image">
                                                    <img class="img-circle" src="images/icon-user.png" height="35" width="35" alt="">
                                                </div>
                                                <p class="font32">User name</p>
                                            </div>
                                        </div>
                                        <ul class="s_nav">
                                             @if(count($data_component_dest) > 0)
                                                @foreach ($data_component_dest as $v)
                                                    <li id="side-item{{$v->id}}" 
                                                        class="{{$v->sidemenu_icon}}" 
                                                        data-id="{{$v->id}}" 
                                                        data-value="{{$v->id}}">
                                                        <a style="color:#{{$app_settings->menu_font_color}};
                                                        font_family: '{{ $app_settings->menu_font_family }}';
                                                        font-size: {{ $app_settings->menu_font_size }}"
                                                        href="javascript:avoid();">{{$v->name}}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    
                        <div class="form-group">
                            <label>タイトル</label>
                            {{Form::text('title',$app_settings->title,
                                        array('class'=>'form-control middle', 'placeholder'=>'タイトル'))}}
                            
                        </div>
                        <div class="form-group">
                            <label>タイトルカラー</label>
                            <div class="wrapp-draw">
                                
                                {{Form::text('title_color',$app_settings->title_color
                                        ,array('id'=>'title_color','class'=>'form-control supper-short jscolor', 'placeholder'=>''))}}
                                <img onclick="document.getElementById('title_color').jscolor.show()" 
                                                src="{{ url('admin/images/draw.jpg') }}" 
                                                class="left"></span>
                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントタイプ・フォントファミリ</label>
                            <div class="two-select">
                                @if(count($list_font_size) > 0)
                                    {{Form::select('font_size',$list_font_size,$app_settings->font_size,['class'=>'form-control short-1'])}}
                                @endif
                                @if(count($list_font_family) > 0)
                                    {{Form::select('font_family',$list_font_family,$app_settings->font_family,['class'=>'form-control short-2'])}}
                                @endif
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ヘッダーカラー</label>
                            <div class="wrapp-draw">
                                
                                {{Form::text('header_color',$app_settings->header_color,
                                        array('id'=>'header_color','class'=>'form-control supper-short jscolor', 'placeholder'=>''))}}
                                <img onclick="document.getElementById('header_color').jscolor.show()"
                                                src="/assets/backend/images/draw.jpg" 
                                                class="left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>メニューイコンカラー</label>
                            <div class="wrapp-draw">
                               
                                {{Form::text('menu_icon_color',$app_settings->menu_icon_color,
                                        array('id'=>'menu_icon_color','class'=>'jscolor form-control supper-short', 'placeholder'=>''))}}

                                <img    onclick="document.getElementById('menu_icon_color').jscolor.show()"
                                                src="/assets/backend/images/draw.jpg"
                                                class="left"></span>
                                
                            </div>
                        </div>
                                               
                </div>
            </div>
            <!-- //tab-global-1 -->

            <div role="tabpanel" class="tab-pane" id="tab-global-2">
                <div class="col-md-4">
                    <div class="wrapp-phone">
                        <div class="wrap-content-prview">
                            <div class="sidebar-preview">
                                <div class="mobile-side" style="background:#{{$app_settings->menu_background_color}};">
                                    <div id="scroll-global-phone-review-1">
                                        <div class="h_side">
                                            <div class="imageleft">
                                                <div class="image">
                                                    <img class="img-circle" src="images/icon-user.png" height="35" width="35" alt="">
                                                </div>
                                                <p class="font32">User name</p>
                                            </div>
                                        </div>
                                        <ul class="s_nav">
                                             @if(count($data_component_dest) > 0)
                                                @foreach ($data_component_dest as $v)
                                                    <li id="side-item{{$v->id}}" 
                                                        class="{{$v->sidemenu_icon}}" 
                                                        data-id="{{$v->id}}" 
                                                        data-value="{{$v->id}}">
                                                        <a style="color:#{{$app_settings->menu_font_color}};
                                                        font_family: '{{ $app_settings->menu_font_family }}';
                                                        font-size: {{ $app_settings->menu_font_size }}"
                                                        href="javascript:avoid();">{{$v->name}}</a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                  
                        <div class="form-group">
                            <label>バックグラウンドカラー</label>
                            <div class="wrapp-draw">
                                
                                {{Form::text('menu_background_color',$app_settings->menu_background_color,
                                    array(
                                    'id'=>'menu_background_color',
                                    'class'=>'form-control supper-short jscolor {onFineChange:"MobileView.updateMenuBackground(this)"}', 
                                    'placeholder'=>'')
                                    
                                    )}}

                                    <img  onclick="document.getElementById('menu_background_color').jscolor.show()"
                                        src="/assets/backend/images/draw.jpg"
                                        class="left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントカラー</label>
                            <div class="wrapp-draw">

                                {{Form::text('menu_font_color',$app_settings->menu_font_color,
                                    array('id'=>'menu_font_color', 
                                    'class'=>'form-control supper-short jscolor {onFineChange:"MobileView.updateMenuColor(this)"}',
                                    'placeholder'=>''))}}

                                    <img onclick="document.getElementById('menu_font_color').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントタイプ・フォントファミリ</label>
                            <div class="two-select">
                                @if(count($list_font_size) > 0)
                                    {{Form::select('menu_font_size',$list_font_size,$app_settings->menu_font_size,
                                    [
                                        'class'=>'form-control short-1',
                                        'onchange' => 'MobileView.updateMenuFontSize(this.value)'
                                    ])}}
                                @endif
                                @if(count($list_font_family) > 0)
                                    {{Form::select('menu_font_family',$list_font_family,$app_settings->menu_font_family,
                                    [
                                        'class'=>'form-control short-2',
                                        'onchange' => 'MobileView.updateMenuFontFamily(this.value)'
                                    ])}}
                                @endif
                                
                            </div>
                        </div>
                        <div class="form-group arrow-select">
                            <label>サイトメニュー項目</label>
                            <div class="wrapp-arrow-select">
                                <div class="wrap-table-top">
                                    <div class="wrap-transfer col">
                                        <p class="title-form">表示</p>
                                        <ul class="nav-left link-top-2">
                                             @if(count($data_component_dest) > 0)
                                                @foreach ($data_component_dest as $k=>$v)
                                                <li data-id="{{$v->id}}" data-value="{{$v->id}}">
                                                    <a href="#">{{$v->name}}</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="wrap-btn-control col">
                                        <a href="javascript:moveTo('nav-left','nav-right')">
                                            <span class="fa fa-caret-right"></span>
                                        </a>
                                        <a href="javascript:moveTo('nav-right','nav-left')">
                                            <span class="fa fa-caret-left"></span>
                                        </a>
                                    </div>
                                    <div class="wrap-transfer col">
                                        <p class="title-form">非表示</p>
                                        <ul class="nav-right link-top-2">
                                            @if(count($data_component_source) > 0)
                                                @foreach ($data_component_source as $k=>$v)
                                                    <li data-id="{{$v->id}}" data-value="{{$v->id}}">
                                                        <a href="#">{{$v->name}}</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                 
                </div>
            </div>
            <!-- //tab-global-2 -->

            <div role="tabpanel" class="tab-pane" id="tab-global-3">
                <div class="wrapp-global-redesign">
                    <div class="col-md-4">
                        <div class="content-global-redesign">
                            <div class="title-global-redesign">アプリアイコン</div>
                            <div class="img-global-redesign">
                                <div class="wrapp-phone center-block">
                                    <div class="wrap-content-prview bg-ip5">
                                        <div id="app-icon-screen" class="text-center">
                                            <img class="app-icon-screen" src="{{ url( $app_stores->app_icon_url ) }}" alt=""/>
                                            <p>AppTitle</p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="btn-global-redesign">
                                <a href="" data-toggle="modal" data-target="#modal-appsicon" class="btn-gb-rd">
                                    作成依頼
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="content-global-redesign">
                            <div class="title-global-redesign">ストア用スクリーンショット</div>
                            <div class="img-global-redesign">
                                <div class="wrapp-phone center-block">
                                    <div class="wrap-content-prview">
                                        <div id="template-1" class="banner-preview">
                                            <!-- Slider main container -->
                                            <div class="swiper-container">
                                                <div class="swiper-wrapper">
                                                    <?php
                                                        $slides = array();
                                                        array_push($slides, $app_stores->splash_image_1);
                                                        array_push($slides, $app_stores->splash_image_2);
                                                        array_push($slides, $app_stores->splash_image_3);
                                                        array_push($slides, $app_stores->splash_image_4);
                                                        array_push($slides, $app_stores->splash_image_5);
                                                    ?>
                                                    @foreach( $slides as $slide )
                                                    @if( !empty($slide) )
                                                    <div class="swiper-slide">
                                                        <img width="100%" style="object-fit: cover; object-position: center; height: 300px; width: 210px;" src="{{ url($slide) }}" alt=""/>
                                                    </div>
                                                    @endif
                                                    @endforeach



                                                </div>
                                                <!-- If we need pagination -->
                                                <div class="swiper-pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-global-redesign">
                                <a href="" data-toggle="modal" data-target="#modal-appsplash" class="btn-gb-rd">
                                    作成依頼
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //tab-global-3 -->

            <div id="modal-appsplash" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-global-redesign-2" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">ストア用スクリーンショット作成依頼</h4>
                        </div>

                        <div class="modal-body">
                            <div class="tab-header-gb">
                                <ul class="nav nav-tabs tabs-center">
                                    <li class="active">
                                        <a href="#tab-gb-re-1" aria-controls="tab-gb-re-1" role="tab" data-toggle="tab">
                                            スクリーンショット
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab-gb-re-2" data-toggle="tab">オリジナル作成</a>
                                    </li>
                                </ul>   
                            </div>                   

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tab-gb-re-1">
                                   <div class="wrapp-form-tab-gb-1">
                                       <form>
                                            <label>ストア用スクリーンショット</label>
                                            <label style="margin-bottom: 10px;display: block" class="label label-info" for="">File dementions: 750px x 1334px</label>
                                            <div id="output-upload"></div>
                                           <div class="content-tab-3-select-2">
                                                <label for="">1 枚目</label>
                                                <div class="splash-img" id="splash_image_1"></div>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">2 枚目</label>
                                                <div class="splash-img" id="splash_image_2"></div>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">3 枚目</label>
                                                <div class="splash-img" id="splash_image_3"></div>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">4 枚目</label>
                                                <div class="splash-img" id="splash_image_4"></div>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">5 枚目</label>
                                                <div class="splash-img" id="splash_image_5"></div>
                                            </div>
                                           <!--
                                            <div class="btn-tab-gb-1">
                                                <a href="">作成依頼</a> 
                                            </div>
                                                          -->
                                        </form>
                                   </div>
                                </div>
                                
                                <div role="tabpanel" class="tab-pane" id="tab-gb-re-2">
                                    <div class="wrapp-form-tab-gb-2">
                                        <p>説明が入ります説明が入りまます説明</p>
                                        <p>
                                            が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入り
                                        </p>
                                        <!--
                                        <a href="">作成依頼</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
              </div>
            </div>
            <!-- //modal -->
            <div id="modal-appsicon" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                        <div class="modal-dialog modal-global-redesign" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">アプリアイコン作成依頼</h4>
                                </div>

                                <div class="modal-body">

                                    <div class="left-global-redesign">
                                        <div class="title-left-global-redesign">
                                            <span>ロゴの種類を選択</span>
                                        </div>
                                        <ul>
                                            <li class="active">
                                                <a href="#">
                                                    <img src="images/nav-global-redesign.jpg" alt="">
                                                    <span>Type 1</span>
                                                </a>
                                            </li>
                                            <!--
                                            <li>
                                                <a href="">
                                                    <img src="images/nav-global-redesign.jpg" alt="">
                                                    <span>Type 1</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <img src="images/nav-global-redesign.jpg" alt="">
                                                    <span>Type 1</span>
                                                </a>
                                            </li>
                                            -->
                                        </ul>
                                    </div>

                                    <div class="right-global-redesign">
                                        <form action="">
                                            <div class="col-md-5 col-xs-12">
                                                <div class="form-group">
                                                    <label>画像アップロード</label>
                                                    <div class="wrapp-draw">
                                                        <span class="left">選択されていません</span>
                                                        <input type="file" name="app_ico_image" class="form-control long" id="app-ico-image" placeholder="ファイルを選択">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>ロゴのタイトル</label>
                                                    <input name="app_ico_title" type="text" class="form-control " id="app-ico-title" placeholder="12タイトル">
                                                </div>
                                                <div class="form-group">
                                                    <label>タイトルカラー</label>
                                                    <div class="wrapp-draw">
                                                        <input  name="app_ico_title_color" id="app-ico-title-color" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_title_color(this)'}" placeholder="000000">
                                                        <img onclick="document.getElementById('app-ico-title-color').jscolor.show()"
                                                             src="/assets/backend/images/draw.jpg"
                                                             class="left">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>背景カラー</label>
                                                    <div class="wrapp-draw">
                                                        <input name="app_ico_bg_color" id="app-ico-bg-color" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_bg_color(this)'}" placeholder="000000">
                                                        <img onclick="document.getElementById('app-ico-bg-color').jscolor.show()"
                                                             src="/assets/backend/images/draw.jpg"
                                                             class="left">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-xs-12">
                                                <div class="row">
                                                <div class="content-right-gl-rd">
                                                    <div class="pixel-title">256px x 256px</div>
                                                    <div id="app-ico-canvas-holder" class="app-logo-review box-256px">
                                                        <p class="app_logo_title">ICO TITLE</p>
                                                        <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                    </div>

                                                    <div class="box-bottom-gl-re">
                                                        <ul class="box-px">
                                                            <li>
                                                                <div class="pixel-title">
                                                                    120px x 120px
                                                                </div>
                                                                <div class="app-logo-review box-120px">
                                                                    <p class="app_logo_title">ICO TITLE</p>
                                                                    <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="pixel-title">
                                                                    80px x 80px
                                                                </div>
                                                                <div class="app-logo-review box-80px">
                                                                    <p class="app_logo_title">ICO TITLE</p>
                                                                    <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="pixel-title">
                                                                    60px x 60px
                                                                </div>
                                                                <div class="app-logo-review box-60px">
                                                                    <p class="app_logo_title">ICO TITLE</p>
                                                                    <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p class="text-center">

                                                    <a id="convert-to-canvas" href="#" class="btn-box-px">作成依頼</a>
                                                    <p id="response-msg" class="text-center"></p>
                                                    <div class="hidden" id="app-ico-canvas"></div>
                                                </p>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                

                            </div>
                      </div>
                    </div>
                    <!-- //modal -->
        <div>
    </section>
</aside>
</form> 
@endsection

@section('footerJS')
    {{Html::script('admin/js/jscolor.js')}}
    {{Html::script('admin/js/mobile-reviews.js')}}
    {{Html::script('admin/js/html2canvas.js')}}
    {{Html::script('admin/js/upload/jquery.uploadfile.min.js')}}
    {{Html::style('admin/js/upload/uploadfile.css')}}
    {{Html::script('admin/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('admin/js/swiper/swiper.min.css')}}
    <script type="text/javascript">

        function moveTo(from, to) {
                
            $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
            $('.' + to + ' li').removeAttr('class');
            $('.' + to + ' li a').removeAttr('class');
            /*
            $('div[id^=mobile]').hide();
            $('.nav-left li').each(function(index,item){
                $('#mobile-'+$(item).attr('data-value')).show();
            })*/
            
            MobileView.updateMenuListItems( $('ul.nav-left li' ) );
        };
        $('#btn_submit_form').click(function () {
            $('ul.nav-left li').each(function () {
                var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_sidemenus[]">';
                $('#form_app_setting').append(tmp);
            });
            $('#form_app_setting').submit();
        });

        var optionsUpload = {
            url:" {{ route('admin.client.global.save.splash_img') }}",
            multiple:false,
            dragDrop:false,
            maxFileCount:1,
            acceptFiles:"image/*",
            fileName:"myfile",
            showCancel: false,
            showAbort: false,
            showDone: false,
            showFileSize: false,
            showPreview: false,
            // showQueueDiv: 'output-upload',
            statusBarWidth: 250,
            returnType:'json',

            onSuccess:function(files,data,xhr,pd)
            {
                //files: list of files
                //data: response from server
                //xhr : jquer xhr object
                $(pd.statusbar).append(data.msg);
                console.log(pd.statusbar);
                console.log(data);
            }

        };
        $(document).ready(function () {
            $('.nav-left, .nav-right').on('click', 'li', function (e) {
                e.preventDefault();
                $(this).toggleClass('selected');
                $(this).find('a').toggleClass('active');
            });
            var upload1 = $("#splash_image_1").uploadFile(optionsUpload);
            var upload2 = $("#splash_image_2").uploadFile(optionsUpload);
            var upload3 = $("#splash_image_3").uploadFile(optionsUpload);
            var upload4 = $("#splash_image_4").uploadFile(optionsUpload);
            var upload5 = $("#splash_image_5").uploadFile(optionsUpload);
            upload1.update({ fileName:'splash_image_1'  });
            upload2.update({ fileName:'splash_image_2'  });
            upload3.update({ fileName:'splash_image_3'  });
            upload4.update({ fileName:'splash_image_4'  });
            upload5.update({ fileName:'splash_image_5'  });

            var bannerSwiper = new Swiper('.swiper-container', {
                autoplay: 1000,
                speed: 400,
                loop: true,
                spaceBetween: 0,
                slidesPerView: 1,
                pagination: ".swiper-pagination",
                paginationClickable: true
            });
        });

        $('#scroll-global-phone-review-1').slimScroll({
            height: '374px',
            size: '5px',
            BorderRadius: '2px'
        });

        $('#app-ico-title').on('keyup',function(e){
            if( $(this).val() != '' ){
                $('.app-logo-review p').text( $(this).val().trim().substring(0,8) );
            }
            else
                $('.app-logo-review p').text( 'ICO TITLE' );
        });

        function change_app_ico_title_color(input){
            $('.app-logo-review p').css({'color':'#' + input});
        }
        function change_app_ico_bg_color(input){
            $('.app-logo-review').css({'background-color':'#' + input});
        }


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.app-logo-review img').attr('src', e.target.result);

                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#app-ico-image").change(function () {
            readURL(this);
        });

        $('#convert-to-canvas').on('click',function(e){
            e.preventDefault();
            $('#app-ico-canvas').empty();
            html2canvas(document.getElementById('app-ico-canvas-holder'), {
                onrendered: function(canvas) {
                    document.getElementById('app-ico-canvas').appendChild(canvas);
                    $('canvas').attr('id','canvas-id-file');
                    var canvas = document.getElementById('canvas-id-file');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.client.global.save.app.icon') }}",
                        data: {
                            app_icon: canvas.toDataURL()
                        },
                        dataType: 'json'
                    }).done(function( response ) {
                        if( response.success ){
                            $('#response-msg').addClass('text-success').text( response.msg );
                        }else{
                            $('#response-msg').addClass('text-danger').text( response.msg );
                        }
                    });
                }
            });
        });





        /*
        $("input.splash-img").change(function (e) {
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                var that = this;
                img.onload = function () {
                    if( this.width !== 750 && this.height !== 1334 ){
                        $(that).parent().append( '<label class="text-danger">Please update image filesize</label>' );
                    }else{

                    }

                };
                img.src = _URL.createObjectURL(file);
            }
        });*/

    </script>
@endsection