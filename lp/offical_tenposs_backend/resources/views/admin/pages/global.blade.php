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
                                        @if( $app_stores->app_icon_url != '' )
                                        <div id="app-icon-screen" class="text-center">
                                            <img class="app-icon-screen" src="{{ url( $app_stores->app_icon_url ) }}" alt=""/>
                                            <p>AppTitle</p>
                                        </div>
                                        @endif
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
                                                    @if ( count($slides) > 0 )
                                                    @foreach( $slides as $slide )
                                                    @if( !empty($slide) )
                                                    <div class="swiper-slide">
                                                        <img width="100%" style="object-fit: cover; object-position: center; width: 210px;" src="{{ url($slide) }}" alt=""/>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                    @endif


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
                @include('admin.pages.globals.app_splash')
            </div>
            <!-- //modal -->
            <div id="modal-appsicon" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                @include('admin.pages.globals.app_icon')
            </div>
                    <!-- //modal -->
        <div>
    </section>

</aside>

</form>
<div class="modal modal-loading">
    <div class="preloader-wrapper">
        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    </div>
</div>
@endsection

@section('footerJS')
    {{Html::script('admin/js/jscolor.js')}}
    {{Html::script('admin/js/mobile-reviews.js')}}
    {{Html::script('admin/js/html2canvas.js')}}
    {{Html::script('admin/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('admin/js/swiper/swiper.min.css')}}
    {{Html::style('admin/js/slider/bootstrap-slider.css')}}
    {{Html::script('admin/js/slider/bootstrap-slider.min.js')}}

    <script type="text/javascript">
        // Global function
        // Save icon
        function sendSaveiConFile(canvas, msgElement){
            $.ajax({
                type: "POST",
                url: "{{ route('admin.client.global.save.app.icon') }}",
                data: {
                    app_icon: canvas.toDataURL()
                },
                dataType: 'json',
                beforeSend:function(){
                    $('body').addClass('loading');
                },
                success: function(response){
                    $('body').removeClass('loading');
                    if( response.success ){
                        $(msgElement).addClass('text-success').html( '<a download target="_blank" href="'+response.file+'"> Click here to download app icon </a>');
                    }else{
                        $(msgElement).addClass('text-danger').text( response.msg );
                    }
                }
            })
        }

        function saveSplashImage( file ){

            var formData = new FormData();
            formData.append( $(file).attr('name'), file.files[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.client.global.save.splash_img') }}",
                data: formData,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false,
                cache: false,
                beforeSend:function(){
                    $('body').addClass('loading');
                    $('p#upload-response').text('');
                },
                success: function(response){
                    $('body').removeClass('loading');
                    if( response.success ){
                        $('p#upload-response').text(response.msg).addClass('text-success');
                    }else{
                        $('p#upload-response').text(response.msg).addClass('text-danger');
                        $('img'+$(file).attr('data-review')).attr('src',currentImg);
                    }

                }
            })

        }

        // Move items menus
        function moveTo(from, to) {
            $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
            $('.' + to + ' li').removeAttr('class');
            $('.' + to + ' li a').removeAttr('class');
            MobileView.updateMenuListItems( $('ul.nav-left li' ) );
        };
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        // render image to img element
        function readURL(input, elementString) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(elementString).attr('src', e.target.result);

                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        // Submit save global
        $('#btn_submit_form').click(function () {
            $('ul.nav-left li').each(function () {
                var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_sidemenus[]">';
                $('#form_app_setting').append(tmp);
            });
            $('#form_app_setting').submit();
        });

        function shadeColor(color, percent) {  // deprecated. See below.
            var num = parseInt(color,16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                G = (num >> 8 & 0x00FF) + amt,
                B = (num & 0x0000FF) + amt;
            return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (G<255?G<1?0:G:255)*0x100 + (B<255?B<1?0:B:255)).toString(16).slice(1);
        }


        $(document).ready(function () {

            $('.nav-left, .nav-right').on('click', 'li', function (e) {
                e.preventDefault();
                $(this).toggleClass('selected');
                $(this).find('a').toggleClass('active');
            });

            var bannerSwiper = new Swiper('.swiper-container', {
                autoplay: 1000,
                speed: 400,
                loop: true,
                spaceBetween: 0,
                slidesPerView: 1,
                pagination: ".swiper-pagination",
                paginationClickable: true
            });

            // With JQuery
            $('#app_ico_image_scale').slider({
                formatter: function(value) {
                    $('img.app_logo_file_type3').css({
                        'width' : value +'%' ,
                        'margin-top' : 50 - value/2 + '%',
                        'height' : value +'%'
                    });
                    return 'Current value: ' + value;
                }
            });

        });
        // Spash image upload
        $('.splash-img > button').on('click',function(e){
            e.preventDefault();
            $(this).parent().find('input[type="file"]').trigger('click');
        });

        function validImage(file, _callback){
            var ext = $(file).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                _callback(false);
            }else{
                _callback(true);
            }
        }

        var currentImg ;
        $('input[name^="splash_image"]').each(function(index,item){
            $(item).change(function (event) {
                event.stopPropagation();
                event.preventDefault();
                $('p#upload-response').text('');
                var that = this;
                console.log(that);
                validImage( that, function( isValid ){
                    if( isValid ){
                        currentImg = $( $(that).attr('data-review') ).attr('src');
                        readURL( that, $(that).attr('data-review') );
                        saveSplashImage(that);
                    }else{
                        $('p#upload-response').text('Please select image file').addClass('text-danger');
                    }
                } );


            });
        });



        $('#scroll-global-phone-review-1').slimScroll({
            height: '374px',
            size: '5px',
            BorderRadius: '2px'
        });
        // Icon Type 3
        $('input[name="app_ico_image_trigger_type3"]').on('click',function(){
            $("input#app-ico-file-type3").click();
        });
        $("#app-ico-file-type3").change(function () {
            var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            $('input[name="app_ico_image_trigger_type3"]').val( filename );
            readURL(this, 'img.app_logo_file_type3');
        });
        function change_app_ico_back_color_type3(input){
            $('.type3-border-top').css({'background-color':'#' + input});
            $('body').find('#border-top-style3').remove();
            $('body').append('<div id="border-top-style3"></div>');
            var styleBorderTop = '<style type="text/css">.type3-border-top:before{ border-right-color:#' + input +'!important } </style>';
            $('#border-top-style3').append(styleBorderTop);
        }
        function change_app_ico_bg_color_type3(input){
            $('body').find('#border-left-style3').remove();
            $('body').append('<div id="border-left-style3"></div>');
            var color = shadeColor(input, -20);
            var styleBorderLeft = '<style type="text/css">.type3-border-left:after{ border-right-color:#' + color +'!important } </style>';
            $('#border-left-style3').append(styleBorderLeft);
            $('div[class^=app-ico-review-type3]').css({'background-color':'#' + input});
            $('.type3-border-left').css({'background-color':'#' + color});
        }
        $('#convert-to-canvas-type3').on('click',function(e){
            e.preventDefault();
            $('#app-ico-canvas-type3').empty();
            html2canvas(document.getElementById('app-ico-canvas-holder-type3'), {
                onrendered: function(canvas) {
                    document.getElementById('app-ico-canvas-type3').appendChild(canvas);
                    $('#app-ico-canvas-type3 canvas').attr('id','canvas-id-file-type3');
                    var canvas = document.getElementById('canvas-id-file-type3');
                    sendSaveiConFile(canvas,'#response-msg-type3');
                }
            });
        });

        // Icon Type 2
        $('#app-ico-title-type2').on('keyup',function(e){
            if( $(this).val() != '' ){
                $('.app_logo_title_type2').text( capitalizeFirstLetter( $(this).val().trim().substring(0,8) ));
            }
            else
                $('.app_logo_title_type2').text( 'Ico' );
        });
        function change_app_ico_title_color_type2(input){
            $('div[class^=app-ico-review-type2] p').css({'color':'#' + input});
            $('.type2-border-top').css({'background-color':'#' + input});
            $('body').find('#border-top-style').remove();
            $('body').append('<div id="border-top-style"></div>');
            var styleBorderTop = '<style type="text/css">.type2-border-top:before{ border-right-color:#' + input +'!important } </style>';
            $('#border-top-style').append(styleBorderTop);
        }
        function change_app_ico_bg_color_type2(input){
            $('body').find('#border-left-style').remove();
            $('body').append('<div id="border-left-style"></div>');
            var color = shadeColor(input, -20);
            var styleBorderLeft = '<style type="text/css">.type2-border-left:after{ border-right-color:#' + color +'!important } </style>';
            $('#border-left-style').append(styleBorderLeft);

            $('div[class^=app-ico-review-type2]').css({'background-color':'#' + input});
            $('.type2-border-left').css({'background-color':'#' + color});

        }
        $('#convert-to-canvas-type2').on('click',function(e){
            e.preventDefault();
            $('#app-ico-canvas-type2').empty();
            html2canvas(document.getElementById('app-ico-canvas-holder-type2'), {
                onrendered: function(canvas) {
                    document.getElementById('app-ico-canvas-type2').appendChild(canvas);
                    $('#app-ico-canvas-type2 canvas').attr('id','canvas-id-file-type2');
                    var canvas = document.getElementById('canvas-id-file-type2');
                    sendSaveiConFile(canvas,'#response-msg-type2');
                }
            });
        });

        // Icon Type 1
        function change_app_ico_title_color(input){
            $('.app-logo-review p').css({'color':'#' + input});
        }
        function change_app_ico_bg_color(input){
            $('.app-logo-review').css({'background-color':'#' + input});
        }
        $('input[name="app_ico_image_trigger"]').on('click',function(){
            $("input#app-ico-image").click();
        });
        $("#app-ico-image").change(function () {
            var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            $('input[name="app_ico_image_trigger"]').val( filename );
            readURL(this, '.app-logo-review img');
        });
        $('#app-ico-title').on('keyup',function(e){
            if( $(this).val() != '' ){
                $('.app-logo-review p').text(  $(this).val().trim().substring(0,8) );
            }
            else
                $('.app-logo-review p').text( 'Ico' );
        });

        $('#convert-to-canvas').on('click',function(e){
            e.preventDefault();
            $('#app-ico-canvas').empty();
            html2canvas(document.getElementById('app-ico-canvas-holder'), {
                onrendered: function(canvas) {
                    document.getElementById('app-ico-canvas').appendChild(canvas);
                    $('canvas').attr('id','canvas-id-file');
                    var canvas = document.getElementById('canvas-id-file');
                    sendSaveiConFile(canvas,'#response-msg-type1');
                }
            });
        });
    </script>
@endsection