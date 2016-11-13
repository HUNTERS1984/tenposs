@extends('admin::layouts.default')

@section('title', 'クーポン')

@section('content')
    <div class="content">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">クーポン</h1>
                </div>
                <div class="right-topbar">
                    <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check"
                                                       autocomplete="disable"/></span>
                    <a href="#" class="btn-me btn-topbar">保存</a>
                </div>
            </div>
        </div>
        <!-- END -->

        <div class="main-content coupon">
            @include('admin::layouts.message')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="wrap-preview">
                            <div class="wrap-content-prview">
                                <div class="header-preview">
                                    <a href="javascript:avoid()" class="trigger-preview"><img
                                                src="/assets/backend/images/nav-icon.png" alt=""></a>
                                    <h2 class="title-prview">Coupon</h2>
                                </div>
                                <div class="content-preview" style="height:320px;">
                                    @if(count($coupons) > 0)
                                        @foreach ($coupons as $coupon)
                                            <div class="each-coupon clearfix">
                                                <img src="{{$coupon->image_url}}"
                                                     class="img-responsive img-prview">
                                                <div class="inner-preview">
                                                    <p class="title-inner"
                                                       style="font-size:9px; color:#14b4d2">{{$coupon->coupon_type->name}}</p>
                                                    <p class="sub-inner"
                                                       style="font-weight:600px; font-size:9px;">{{$coupon->title}}</p>
                                                    <p class="text-inner"
                                                       style="font-size:9px;">{{$coupon->description}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="wrap-btn-content">
                            <a href="javascript:avoid()" class="btn-me btn-hong" data-toggle="modal"
                               data-target="#AddCouponType">クーポンタイプ追加</a>
                            <a style="margin-left: 10px;" href="{{ route('admin.category.index',array('type'=>'coupon')) }}" class="btn-me btn-hong">カテゴリ一一覧</a>
                            <a href="javascript:avoid()" class="btn-me btn-xanhduongnhat" data-toggle="modal"
                               data-target="#AddCoupon">クーポン追加</a>
                        </div>    <!-- end wrap-btn-content-->
                        <div class="wrapper-content">
                            @include('admin::pages.coupon.element_coupon')
                        </div>    <!-- wrap-content-->
                        <!-- 						<div class="row">
                                                    <div class="col-md-12">
                                                            <button class="btn-me btn-topbar btn-block view-more-btn">もっと見る</button>
                                                    </div>
                                                </div> -->
                    </div>
                </div>
            </div>

        </div>
        <!-- END -->
    </div>    <!-- end main-content-->

    <!-- Modal -->
    <div class="modal fade" id="AddCouponType" tabindex="-1" role="dialog" aria-labelledby="AddCouponType">
        <div class="modal-dialog" role="document">
            {{Form::open(array('route'=>'admin.coupon.store_type','files'=>true))}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="AddCouponTypeTitle">クーポンタイプ追加</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{Form::label('Select Store','ストア')}}
                        @if(count($list_store) > 0)
                            {{Form::select('store_id',$list_store->pluck('name', 'id'),old('store_id'),['class'=>'form-control'])}}
                        @endif
                    </div>
                    <div class="form-group">
                        {{Form::label('Title','クーポンタイプ名')}}
                        {{Form::text('title',old('title'),['class'=>'form-control'])}}

                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::submit('保存',['class'=>'btn btn-primary'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>

    <div class="modal fade" id="AddCoupon" tabindex="-1" role="dialog" aria-labelledby="AddCoupon">
        <div class="modal-dialog" role="document">
            {{Form::open(array('route'=>'admin.coupon.store','files'=>true))}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="AddCouponTitle">クーポン追加</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4" align="left">
                        <img class="new_coupon_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                        <button class="btn_upload_img create" type="button"><i class="fa fa-picture-o"
                                                                               aria-hidden="true"></i>画像アップロード
                        </button>
                        {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                    </div>
                    <div class="col-md-8" align="left">
                        <div class="form-group">
                            {{Form::label('Select Coupon Type','クーポンタイプ')}}
                            @if(count($list_coupon_type) > 0)
                                {{Form::select('coupon_type_id',$list_coupon_type->pluck('name', 'id'),old('coupon_type_id'),['class'=>'form-control'])}}
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('Title','クーポン名')}}
                            {{Form::text('title',old('title'),['class'=>'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('Description', '説明')}}
                            {{Form::textarea('description',old('description'),['class'=>'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('Hashtag','ハッシュタグ')}}
                            {{Form::text('hashtag',old('hashtag'),['class'=>'form-control'])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('Start Date','開始日')}}
                            {{ Form::date('start_date', \Carbon\Carbon::now(),['class'=>'form-control']) }}
                        </div>

                        <div class="form-group">
                            {{Form::label('End Date','終了日')}}
                            {{ Form::date('end_date', \Carbon\Carbon::now(),['class'=>'form-control']) }}
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

    <div class="modal fade" id="EditCoupon" tabindex="-1" role="dialog" aria-labelledby="EditCoupon">
        <div class="modal-dialog" role="document">
            {{Form::open(array('route'=>['admin.coupon.update', 0],'files'=>true, 'method' => 'PUT'))}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="EditCouponTitle">クーポン編集</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4" align="left">
                        <img class="edit_coupon_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                        <button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o"
                                                                              aria-hidden="true"></i>画像アップロード
                        </button>
                        {!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
                    </div>
                    <div class="col-md-8" align="left">
                        {{ Form::hidden('id', '0', array('id' => 'edit_id')) }}
                        <div class="form-group">
                            {{Form::label('Select Coupon Type','クーポンタイプ')}}
                            @if(count($list_coupon_type) > 0)
                                {{Form::select('coupon_type_id',$list_coupon_type->pluck('name', 'id'),old('store_id'),['class'=>'form-control')}}
                            @endif
                        </div>
                        <div class="form-group">
                            {{Form::label('Title','クーポン名')}}
                            {{Form::text('title',old('title'),['class'=>'form-control', 'id' => 'edit_title'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('Description', '説明')}}
                            {{Form::textarea('description',old('description'),['class'=>'form-control', 'id' => 'edit_description'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('Hashtag','ハッシュタグ')}}
                            {{Form::text('hashtag',old('hashtag'),['class'=>'form-control', 'id' => 'edit_hashtag'])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('Start Date','開始日')}}
                            {{ Form::date('start_date', \Carbon\Carbon::now(),['class'=>'form-control', 'id' => 'edit_startdate']) }}
                        </div>

                        <div class="form-group">
                            {{Form::label('End Date','終了日')}}
                            {{ Form::date('end_date', \Carbon\Carbon::now(),['class'=>'form-control', 'id' => 'edit_enddate']) }}
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::submit('保存',['class'=>'btn btn-primary'])}}
                    {{Form::close()}}
                    {{Form::open(array('route'=>array('admin.coupon.destroy',0),'method'=>'DELETE'))}}
                    {{ Form::hidden('id', '0', array('id' => 'delete_id')) }}
                    <input type="submit" class="btn btn-danger" value="削除"
                           onclick="return confirm('Are you sure you want to delete this item?');">
                    {{Form::close()}}
                </div>
            </div>

        </div>
    </div>
@stop

@section('script')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}

    {{Html::script('assets/backend/js/switch/lc_switch.js')}}
    {{Html::style('assets/backend/js/switch/lc_switch.css')}}

    {{Html::script('assets/backend/js/script.js')}}
    <script type="text/javascript">
        var page_num = 0;
        $(document).ready(function () {
            $('input.lcs_check').lc_switch();

            $('.view-more-btn').click(function () {
                $.ajax({
                    url: "/admin/coupon/view_more",
                    data: {page: ++page_num}
                }).done(function (data) {
                    console.log(data);
                    $('.wrapper-content').append(data);
                });
            });
            $('#EditCoupon').on('show.bs.modal', function (e) {

                var link = $(e.relatedTarget);
                var modal = $(this);
                modal.find("#edit_coupon_type_id").val(link.data("coupontype"));
                modal.find("#edit_title").val(link.data("title"));
                modal.find("#edit_description").val(link.data("description"));
                modal.find("#edit_hashtag").val(link.data("hashtag"));
                modal.find("#edit_startdate").val(link.data("startdate"));
                modal.find("#edit_enddate").val(link.data("enddate"));
                modal.find("#edit_id").val(link.data("id"));
                modal.find("#delete_id").val(link.data("id"));
                $('.edit_coupon_img').attr('src', link.data("image"));

            });

            $('.btn_upload_img.create').click(function () {
                $('.btn_upload_ipt.create').click();
            });

            $('.btn_upload_img.edit').click(function () {
                $('.btn_upload_ipt.edit').click();
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.edit_coupon_img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_edit").change(function () {
                readURL(this);
            });

            function readURLCreate(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.new_coupon_img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }


            $("#image_create").change(function () {
                readURLCreate(this);
            });

        })
    </script>
@stop
