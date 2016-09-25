@extends('admin::layouts.default')

@section('title', 'News')

@section('content')
    <div class="content">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">ニュース</h1>
                </div>
                <div class="right-topbar">
                    <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check"
                                                       autocomplete="disable"/></span>
                    <a href="javascript:avoid()" class="btn-me btn-topbar" data-toggle="modal"
                       data-target="#myModal">保存</a>
                </div>
            </div>
        </div>
        <!-- END -->

        <div class="main-content news">
            @if (Session::has('success'))
                <div class="alert alert-info">{{ Session::get( 'success' ) }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get( 'error' ) }}</div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="wrap-preview">
                            <div class="wrap-content-prview">
                                <div class="header-preview">
                                    <a href="javascript:avoid()" class="trigger-preview"><img
                                                src="/assets/backend/images/nav-icon.png" alt=""></a>
                                    <h2 class="title-prview">NEWS</h2>
                                </div>
                                <!-- 								<div class="control-nav-preview">
                                                                    <div class="swiper-container">
                                                                        <div class="swiper-wrapper">
                                                                            <div class="swiper-slide">Spring</div>
                                                                            <div class="swiper-slide">Summer</div>
                                                                        </div>

                                                                        <div class="swiper-button-prev"></div>
                                                                        <div class="swiper-button-next"></div>
                                                                    </div>
                                                                </div> -->
                                <div class="content-preview" style="height:320px;">
                                    @if(empty($news))
                                        No data
                                    @else
                                        @foreach($news as $item_thumb)
                                            <div class="each-coupon clearfix">
                                                <img src="{{asset($item_thumb->image_url)}}"
                                                     class="img-responsive img-prview">
                                                <div class="inner-preview">
                                                    <p class="title-inner"
                                                       style="font-size:9px; color:#14b4d2">{{$item_thumb->title}}</p>
                                                    <!-- <p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p> -->
                                                    <p class="text-inner"
                                                       style="font-size:9px;">{{Str::words($item_thumb->description,20)}}</p>
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
                            <a href="javascript:avoid()" class="btn-me btn-xanhduongnhat" data-toggle="modal"
                               data-target="#myModal">追加</a>
                        </div>    <!-- end wrap-btn-content-->
                        <div class="wrapper-content">
                            <div class="grip">
                                @if(empty($news))
                                    No data
                                @else
                                    @foreach($news as $item)
                                        <div class="each-coupon each-item clearfix">
                                            <div class="wrap">
                                                <a href="{{route('admin.news.edit',$item->id)}}"><img
                                                            src="{{asset($item->image_url)}}" class="img-responsive"
                                                            alt=""></a>
                                                <div class="main-title">
                                                    <h2>
                                                        <a href="{{route('admin.news.edit',$item->id)}}">{{$item->title}}</a>
                                                    </h2>
                                                    {{Form::open(array('route'=>array('admin.news.destroy',$item->id),'method'=>'DELETE'))}}
                                                    <input type="submit" class="btn-me btn-each-item" value="削除"
                                                           onclick="return confirm('Are you sure you want to delete this item?');">
                                                    {{Form::close()}}
                                                </div>
                                                <div class="container-content">
                                                    <p>{{$item->description}}</p>
                                                </div>
                                            </div>

                                        </div>


                                    @endforeach
                                @endif
                            </div>
                            <div class="clearfix">
                                @if(count($news) > 0)
                                    {{ $news->render() }}
                                @endif
                            </div>
                        </div>    <!-- wrap-content-->
                    </div>
                </div>
            </div>

        </div>
        <!-- END -->
    </div>    <!-- end main-content-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            {{Form::open(array('route'=>'admin.news.store','files'=>true))}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ニュース追加</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4" align="left">
                        <img class="new_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                        <button class="btn_upload_img create" type="button">
                            <i class="fa fa-picture-o" aria-hidden="true"></i> 画像アップロード
                        </button>
                        {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                    </div>
                    <div class="col-md-8" align="left">
                        <div class="form-group">
                            {{Form::label('store','ストア')}}
                            {{Form::select('store_id',$list_store,old('store_id'),['class'=>'form-control'])}}

                        </div>
                        <div class="form-group">
                            {{Form::label('title','タイトル')}}
                            {{Form::text('title',old('title'),['class'=>'form-control'])}}

                        </div>
                        <div class="form-group">
                            {{Form::label('description','説明')}}
                            {{Form::textarea('description',old('description'),['class'=>'form-control'])}}
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

    {{Html::script('assets/backend/js/Masonry.js')}}

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
        })
    </script>
@stop
