@extends('admin::layouts.default')

@section('title', 'カテゴリー')

@section('content')
    <div class="content">
        {{Form::open(array('route'=> array('admin.category.store',$type), 'files'=>true))}}
        <input type="hidden" name="type" value="{{$type}}">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">カテゴリを追加</h1>
                </div>
                <div class="right-topbar">
                    <!-- <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span> -->
                    <!-- <a href="javascript:avoid()" class="btn-me btn-topbar">スタの新着情報</a> -->
                    <input type="submit" class="btn-me btn-topbar" value="保存">
                </div>
            </div>
        </div>

        <div class="main-content photography">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrapper-content clearfix">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="coupon_id">格納</label>
                                            {{Form::select('store_id',$list_store,old('store_id'),array('class'=>'form-control') )}}
                                        </div>
                                        <div class="form-group">
                                            <label for="title">名</label>
                                            {{Form::text('name',old('name'), array('class'=>'form-control') )}}
                                        </div>
                                        {{--<div class="form-group">--}}
                                            {{--{!! Form::submit('新しいカテゴリを作成します', ['class' => 'btn btn-primary']) !!}--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
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
        })
    </script>
@stop