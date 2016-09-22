@extends('admin::layouts.default')

@section('title', 'フォトギャラリー')

@section('content')
    <div class="content">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">フォトギャラリー</h1>
                </div>
                <div class="right-topbar">
                    <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check"
                                                       autocomplete="disable"/></span>
                    <a href="javascript:avoid()" class="btn-me btn-topbar">保存</a>
                </div>
            </div>
        </div>
        <!-- END -->

        <div class="main-content photography">
             @include('admin::layouts.message')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="wrap-preview">
                            <div class="wrap-content-prview">
                                <div class="header-preview">
                                    <a href="javascript:avoid()" class="trigger-preview"><img
                                                src="/assets/backend/images/nav-icon.png" alt=""></a>
                                    <h2 class="title-prview">Photography</h2>
                                </div>
                                <div class="control-nav-preview">
                                    <!-- Slider main container -->
                                    <div class="swiper-container">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            @if(count($photocat)  > 0)
                                                @foreach($photocat as $pc)
                                                    <div class="swiper-slide">{{$pc->name}}</div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                </div>
                                <div class="content-preview clearfix">
                                    <div class="row-me fixHeight">
                                        @if(empty($list_photo))
                                            No Data
                                        @else
                                            @foreach($list_photo as $item_thumb)
                                                <div class="col-xs-4 padding-me">
                                                    <div class="each-staff">
                                                        <img src="{{asset($item_thumb->image_url)}}"
                                                             class="img-responsive  img-prview" alt="Photo">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="wrap-btn-content">
                            <a href="javascript:avoid()" class="btn-me btn-hong" data-toggle="modal"
                               data-target="#AddCat">カテゴリー追加</a>
                            <a href="javascript:avoid()" class="btn-me btn-xanhduongnhat" data-toggle="modal"
                               data-target="#AddImage">写真追加</a>
                        </div>    <!-- end wrap-btn-content-->
                        <div class="wrapper-content clearfix">
                            <div class="container-fluid">
                                <div class="row">
                                    @if(empty($list_photo))
                                        No Data
                                    @else
                                        @foreach($list_photo as $item)
                                            <div class="col-xs-4">
                                                <div class="each-menu each-common-pr">
                                                    <p class="title-menu"><a
                                                                href="{{route('admin.photo-cate.edit',$item->id)}}"><img
                                                                    src="{{asset($item->image_url)}}"
                                                                    class="img-responsive img-prview" alt="Photo"></a>
                                                    </p>
                                                    {{Form::open(array('route'=>['admin.photo-cate.destroy',$item->id],'method'=>'DELETE'))}}
                                                    {{Form::submit('削除',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
                                                    {{Form::close()}}
                                                </div>
                                            </div>
                                        @endforeach

                                        <button class="view-more-btn btn btn-primary btn-block">もっと見る</button>

                                    @endif
                                </div>
                            </div>

                        </div>    <!-- wrap-content-->
                    </div>
                </div>
            </div>

        </div>
        <!-- END -->
    </div>    <!-- end main-content-->

    <!-- Modal -->
    <div class="modal fade" id="AddCat" tabindex="-1" role="dialog" aria-labelledby="AddCatLabel">
        <div class="modal-dialog" role="document">
            {{Form::open(array('route'=>'admin.photo-cate.store'))}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="AddCatLabel">カテゴリー追加</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{Form::label('store','ストア')}}
                        @if(count($list_store)  > 0)
                            {{Form::select('store_id',$list_store,old('store_id'),['class'=>'form-control'])}}
                        @endif
                    </div>
                    <div class="form-group">
                        {{Form::label('title','タイトル')}}
                        {{Form::text('name',old('name'),['class'=>'form-control'])}}
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::submit('保存',['class'=>'btn btn-primary'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>


    <div class="modal fade" id="AddImage" tabindex="-1" role="dialog" aria-labelledby="AddImage">
        <div class="modal-dialog" role="document">
            {{Form::open(array('route'=>'admin.photo-cate.storephoto','files'=>true))}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="AddCouponTitle">写真追加</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4" align="left">
                        <img class="new_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                        <button class="btn_upload_img create" type="button"><i class="fa fa-picture-o"
                                                                               aria-hidden="true"></i>画像アップロード
                        </button>
                        {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                    </div>
                    <div class="col-md-8" align="left">
                        <div class="form-group">
                            {{Form::label('Select Photo Category','カテゴリー')}}
                            @if(count($photocat)  > 0)
                                {{Form::select('photo_category_id',$photocat->pluck('name', 'id'),old('photo_category_id'),['class'=>'form-control'])}}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::submit('保存',['class'=>'btn btn-primary'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
@stop

@section('script')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}

    {{Html::script('assets/backend/js/switch/lc_switch.js')}}
    {{Html::style('assets/backend/js/switch/lc_switch.css')}}

    {{Html::script('assets/backend/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('assets/backend/js/swiper/swiper.min.css')}}

    {{Html::script('assets/backend/js/script.js')}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('input.lcs_check').lc_switch();
            var category_idx = 0;
            var page = 0;
            var categorySwiper = new Swiper('.control-nav-preview .swiper-container', {
                speed: 400,
                spaceBetween: 0,
                slidesPerView: 1,
                nextButton: '.control-nav-preview .swiper-button-next',
                prevButton: '.control-nav-preview .swiper-button-prev',
                onSlideNextStart: function (swiper) {
                    ++category_idx;
                    page = 0;
                    $.ajax({
                        url: "/admin/photo-cate/nextcat",
                        data: {cat: category_idx, page: page}
                    }).done(function (data) {
                        console.log(data);
                        $('.wrapper-content').html(data);

                    });
                    $.ajax({
                        url: "/admin/photo-cate/nextpreview",
                        data: {cat: category_idx, page: page}
                    }).done(function (data) {
                        console.log(data);
                        $('.content-preview').html(data);

                    });
                },
                onSlidePrevStart: function (swiper) {
                    --category_idx;
                    page = 0;
                    $.ajax({
                        url: "/admin/photo-cate/nextcat",
                        data: {cat: category_idx, page: page}
                    }).done(function (data) {
                        console.log(data);
                        $('.wrapper-content').html(data);
                    });
                    $.ajax({
                        url: "/admin/photo-cate/nextpreview",
                        data: {cat: category_idx, page: page}
                    }).done(function (data) {
                        console.log(data);
                        $('.content-preview').html(data);

                    });
                }
            });
            $('.btn_upload_img.create').click(function () {
                $('.btn_upload_ipt.create').click();
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.new_img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_create").change(function () {
                readURL(this);
            });

            $('.wrapper-content').on('click', '.view-more-btn', function (event) {
                $.ajax({
                    url: "/admin/photo-cate/view_more",
                    data: {cat: category_idx, page: ++page}
                }).done(function (data) {
                    console.log(data);
                    $('.view-more-btn').remove();
                    $('.wrapper-content').append(data);
                });
            });


        })
    </script>
@stop