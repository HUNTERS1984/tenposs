@extends('admin::layouts.default')


@section('title', 'リザーブ')
@section('content')
    <div class="content">
        {{Form::model($item,array('route'=>array('admin.reserve.update',$item->id),'files'=>true,'method'=>'PUT') )}}
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">リザーブ</h1>
                </div>
                <div class="right-topbar">
                    <a href="{{ URL::previous() }}" class="btn-me btn-topbar">戻る</a>
                    <input type="submit" class="btn-me btn-topbar" value="保存">
                </div>
            </div>
        </div>

        <div class="main-content news">
            @include('admin::layouts.message')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="wrapper-content">
                            {{Form::model($item,array('route'=>array('admin.reserve.update',$item->id),'method'=>'PUT','files'=>true))}}

                            <div class="form-group">
                                <label for="coupon_id">格納</label>
                                {{Form::select('store_id',$list_store->pluck('name', 'id'),old('store_id'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('title','リザーブリンク')}}
                                {{Form::text('reserve_url',old('reserve_url'),['class'=>'form-control'])}}

                            </div>
                            {{--<div class="form-group">--}}
                            {{--{{Form::submit('保存',array('class'=>'btn btn-primary'))}}--}}
                            {{--</div>--}}
                        </div>
                    </div>    <!-- wrap-content-->
                </div>
            </div>
        </div>

    </div>
    {{Form::close()}}
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

            var categorySwiper = new Swiper('.control-nav-preview .swiper-container', {
                speed: 400,
                spaceBetween: 0,
                slidesPerView: 1,
                nextButton: '.control-nav-preview .swiper-button-next',
                prevButton: '.control-nav-preview .swiper-button-prev'
            });

            $('.btn_upload_img.edit').click(function () {
                $('.btn_upload_ipt.edit').click();
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.edit_img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image_edit").change(function () {
                readURL(this);
            });
        })
    </script>
@stop