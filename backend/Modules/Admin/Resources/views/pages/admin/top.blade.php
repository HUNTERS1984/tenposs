@extends('admin::layouts.default')

@section('title', 'トップ')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">トップ</h1>
                </div>
                <div class="right-topbar">
                    {{--<a href="#" class="btn-me btn-topbar">保存</a>--}}
                    {{--<input type="button" id="btn_submit_form" name="btn_submit_form" value="保存" class="btn btn-primary">--}}

                </div>
            </div>
        </div>
        <!-- END -->

        <div class="main-content top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="wrap-preview">
                            <div class="wrap-content-prview">
                                <div class="header-preview">
                                    <a href="javascript:avoid()" class="trigger-preview"><img
                                                src="/assets/backend/images/nav-icon.png" alt=""></a>
                                    <h2 class="title-prview">Global Work</h2>
                                </div>
                                <div class="banner-preview">
                                    <img src="/assets/backend/images/banner-prview.jpg" class="img-responsive" alt="">
                                </div>
                                <div class="content-preview">
                                    <p class="title-top-preview">
                                        Recently
                                    </p>
                                    <div class="row-me clearfix">
                                        <div class="each-top">
                                            <img src="/assets/backend/images/h1.jpg" class="img-responsive " alt="">
                                            <p class="name">Product 1</p>
                                            <p class="price">10$</p>
                                        </div>
                                        <div class="each-top">
                                            <img src="/assets/backend/images/h1.jpg" class="img-responsive " alt="">
                                            <p class="name">Product 1</p>
                                            <p class="price">10$</p>
                                        </div>
                                        <div class="each-top">
                                            <img src="/assets/backend/images/h1.jpg" class="img-responsive " alt="">
                                            <p class="name">Product 1</p>
                                            <p class="price">10$</p>
                                        </div>
                                        <div class="each-top">
                                            <img src="/assets/backend/images/h1.jpg" class="img-responsive " alt="">
                                            <p class="name">Product 1</p>
                                            <p class="price">10$</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="wrapper-content">
                            {{--<form action="" method="" class="formCommon" name="">--}}
                            {{Form::model('',array('route'=>array('admin.top.store',0),'method'=>'POST','id'=>'form_app_setting','class'=>'formCommon'))}}
                            <div id="hidden_info"></div>
                            {{--<div class="form-group margin-bottom">--}}
                            {{--<label for="">メインジュアル</label>--}}
                            {{--<select name="" class="select1">--}}
                            {{--<option value="">スタの新 1</option>--}}
                            {{--<option value="">スタの新 2</option>--}}
                            {{--</select>--}}
                            {{--<a href="javascript:avoid()" class="note">+ ファイルを追加する</a>--}}
                            {{--</div>--}}
                            <div class="form-group clearfix">
                                <div class="wrap-table" style="width: 100%;margin-bottom: 30px;">
                                    <div style="width: 50%;display: inline-block;float: left">
                                        <label for="">トップページ表示項目</label>
                                    </div>
                                    <div style="width: 50%;display: inline-block;text-align: right;">
                                        <input type="button" id="btn_submit_form" name="btn_submit_form" value="保存"
                                               class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="wrap-table">
                                    <div class="wrap-transfer col">
                                        <p class="title-form">表示</p>
                                        <ul class="nav-left from-nav">
                                            @if(!is_null($app_components))
                                                @foreach ($app_components as $key => $value)
                                                    <li data-id="{{$key}}" data-value="{{$key}}">
                                                        {{$value}}</li>
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
                                            @if(!is_null($available_components))
                                                @foreach ($available_components as $key => $value)

                                                    <li data-id="{{$key}}" data-value="{{$key}}">
                                                        {{$value}}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{Form::close()}}
                            <div class="form-group clearfix" style="margin-top: 50px;">
                                <label for="">トップスライドショーにファイルを追加</label>
                                <!-- The file upload form used as target for the file upload widget -->
                                <form id="fileupload" action="//" method="POST"
                                      enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                    <div class="row fileupload-buttonbar">
                                        <div class="col-lg-12">
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                                            <button type="submit" class="btn btn-primary start">
                                                <i class="glyphicon glyphicon-upload"></i>
                                                <span>Start upload</span>
                                            </button>
                                            <button type="reset" class="btn btn-warning cancel">
                                                <i class="glyphicon glyphicon-ban-circle"></i>
                                                <span>Cancel upload</span>
                                            </button>
                                            <button type="button" class="btn btn-danger delete">
                                                <i class="glyphicon glyphicon-trash"></i>
                                                <span>Delete</span>
                                            </button>
                                            <input type="checkbox" class="toggle">
                                            <!-- The global file processing state -->
                                            <span class="fileupload-process"></span>
                                        </div>
                                        <!-- The global progress state -->
                                        <div class="col-lg-5 fileupload-progress fade">
                                            <!-- The global progress bar -->
                                            <div class="progress progress-striped active" role="progressbar"
                                                 aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                            </div>
                                            <!-- The extended global progress state -->
                                            <div class="progress-extended">&nbsp;</div>
                                        </div>
                                    </div>
                                    <!-- The table listing the files available for upload/download -->
                                    <table role="presentation" class="table table-striped">
                                        <tbody class="files"></tbody>
                                    </table>
                                </form>
                            </div>    <!-- wrap-content-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END -->

    </div>    <!-- end main-content-->
@stop

@section('script')
    <!-- The blueimp Gallery widget -->

    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}

    {{Html::script('assets/backend/js/switch/lc_switch.js')}}
    {{Html::style('assets/backend/js/switch/lc_switch.css')}}

    {{Html::script('assets/backend/js/script.js')}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('input.lcs_check').lc_switch();

            $('.nav-left, .nav-right').on('click', 'li', function () {
                $(this).toggleClass('selected');
            });

        })
        function moveTo(from, to) {
            $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
            $('.' + to + ' li').removeAttr('class');
        }
        $('#btn_submit_form').click(function () {
            $('ul.nav-left li').each(function () {
                var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_component[]">';
                $('#hidden_info').append(tmp);
            });
            $('#form_app_setting').submit();
        });
    </script>
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start btn-small" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel btn-small">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}




    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete btn-small" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel btn-small">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}




    </script>
    {{Html::script('assets/backend/js/upload/vendor/jquery.ui.widget.js')}}

    <!-- The Templates plugin is included to render the upload/download listings -->
    {{Html::script('assets/backend/js/upload/tmpl.min.js')}}
    {{--<script src="http://blueimp.github.io/JavaScript-Templates/js/upload/tmpl.min.js"></script>--}}
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    {{Html::script('assets/backend/js/upload/load-image.all.min.js')}}
    {{--<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>--}}
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    {{Html::script('assets/backend/js/upload/canvas-to-blob.min.js')}}
    {{--<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>--}}
    <!-- blueimp Gallery script -->
    {{Html::script('assets/backend/js/upload/jquery.blueimp-gallery.min.js')}}
    {{--<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>--}}
    {{Html::script('assets/backend/js/upload/cors/jquery.postmessage-transport.js')}}
    {{Html::script('assets/backend/js/upload/jquery.iframe-transport.js')}}
    {{Html::script('assets/backend/js/upload/jquery.fileupload.js')}}
    {{Html::script('assets/backend/js/upload/jquery.fileupload-process.js')}}
    {{Html::script('assets/backend/js/upload/jquery.fileupload-image.js')}}
    {{Html::script('assets/backend/js/upload/jquery.fileupload-validate.js')}}
    {{Html::script('assets/backend/js/upload/jquery.fileupload-ui.js')}}
    {{Html::script('assets/backend/js/upload/main.js')}}
@stop