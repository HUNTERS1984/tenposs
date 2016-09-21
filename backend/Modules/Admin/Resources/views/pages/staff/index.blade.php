@extends('admin::layouts.default')

@section('title', 'スタッフ')

@section('content')
    <div class="content">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">スタッフ</h1>
                </div>
                <!-- <div class="right-topbar">
                     <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
                    <a href="javascript:avoid()" class="btn-me btn-topbar">保存</a>
                </div>
            </div>
        </div>
        <!-- END -->

                <div class="main-content menu">
                    @include('admin::layouts.message')
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="wrap-preview">
                                    <div class="wrap-content-prview">
                                        <div class="header-preview">
                                            <a href="javascript:avoid()" class="trigger-preview"><img
                                                        src="/assets/backend/images/nav-icon.png" alt=""></a>
                                            <h2 class="title-prview">Menu</h2>
                                        </div>
                                        <div class="control-nav-preview">
                                            <!-- Slider main container -->
                                            <div class="swiper-container">
                                                <!-- Additional required wrapper -->
                                                <div class="swiper-wrapper">
                                                    <!-- Slides -->
                                                    @if(count($staff_cat) > 0)
                                                        @foreach($staff_cat as $item)
                                                            <div class="swiper-slide">{{$item->name}}</div>
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
                                                @if(count($list_staff) > 0)
                                                    <p>No data</p>
                                                @else
                                                    @foreach($list_staff as $item_thumb)
                                                        <div class="col-xs-6 padding-me">
                                                            <div class="each-menu">
                                                                <img src="{{asset($item_thumb->image_url)}}"
                                                                     class="img-responsive img-item-prview"
                                                                     alt="Item Photo">
                                                                <p style="font-size:11px">{{$item_thumb->title}}</p>
                                                                <p style="font-size:11px">¥{{$item_thumb->price}}</p>
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
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <a href="javascript:avoid()" class="btn-me btn-hong" data-toggle="modal"
                                                   data-target="#AddMenu">カテゴリを追加します</a>
                                                <a href="javascript:avoid()" class="btn-me btn-xanhduongnhat"
                                                   data-toggle="modal" data-target="#AddItem">人手を増やします</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>    <!-- end wrap-btn-content-->
                                <div class="wrapper-content clearfix">
                                    <div class="container-fluid">
                                        <div class="row">
                                            @if(count($list_staff) > 0)
                                                <p>No data</p>
                                            @else
                                                @foreach($list_staff as $item)
                                                    <div class="col-xs-4">
                                                        <div class="each-menu each-common-pr">
                                                            <p class="title-menu"><a
                                                                        href="{{route('admin.menus.edit',$item->id)}}"><img
                                                                            src="{{asset($item->image_url)}}"
                                                                            class="img-responsive" alt="Item"></a></p>
                                                            <p class="">{{$item->title}}</p>
                                                            {{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
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

        @stop
        <!-- Modal -->
            <div class="modal fade" id="AddMenu" tabindex="-1" role="dialog" aria-labelledby="AddMenuLabel">
                <div class="modal-dialog" role="document">
                    {{Form::open(array('route'=>'admin.staff.storeCat'))}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="AddMenuLabel">カテゴリを追加します</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                {{Form::label('Select Store','ストア')}}
                                {{Form::select('store_id',$list_store,old('store_id'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('Name', 'タイトル')}}
                                {{Form::text('name',old('name'),['class'=>'form-control'])}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{Form::submit('Save',['class'=>'btn btn-primary'])}}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>

            <div class="modal fade" id="AddItem" tabindex="-1" role="dialog" aria-labelledby="AddItem">
                <div class="modal-dialog" role="document">
                    {{Form::open(array('route'=>'admin.staff.storestaff','files'=>true))}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="AddItemTitle">人手を増やします</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-4" align="left">
                                <img class="new_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                                <button class="btn_upload_img create" type="button"><i class="fa fa-picture-o"
                                                                                       aria-hidden="true"></i> 画像アップロード
                                </button>
                                {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                            </div>
                            <div class="col-md-8" align="left">
                                <div class="form-group">
                                    {{Form::label('staff_category_id','カテゴリー')}}
                                    @if(count($staff_cat) > 0)
                                        {{Form::select('staff_category_id',$staff_cat->pluck('name', 'id'),old('staff_category_id'),['class'=>'form-control'])}}
                                    @endif
                                </div>
                                <div class="form-group">
                                    {{Form::label('name','名')}}
                                    {{Form::text('name',old('name'),['class'=>'form-control'])}}

                                </div>
                                <div class="form-group">
                                    {{Form::label('introduction','導入')}}
                                    {{Form::textarea('introduction',old('introduction'),['class'=>'form-control'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('gender','性別')}}
                                    <input type="radio" id="gender" name="gender"
                                           value="1" {{ old('gender')=="1" ? 'checked='.'"'.'checked'.'"' : '' }} />男性
                                    <input type="radio" id="gender" name="gender"
                                           value="0" {{ old('gender')=="0" ? 'checked='.'"'.'checked'.'"' : '' }} />女性
                                </div>
                                <div class="form-group">
                                    {{Form::label('tel','電話番号')}}
                                    {{Form::text('tel',old('tel'),['class'=>'form-control'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('price','価格')}}
                                    {{Form::text('price',old('price'),['class'=>'form-control'])}}


                                </div>
                                {{--<div class="form-group">--}}
                                {{--{{Form::label('item_link','URL')}}--}}
                                {{--{{Form::text('item_link',old('item_link'),['class'=>'form-control'])}}--}}

                                {{--</div>--}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{Form::submit('保存',['class'=>'btn btn-primary'])}}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>

        @section('script')
            {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
            {{Html::script('assets/backend/js/bootstrap.min.js')}}

            {{Html::script('assets/backend/js/switch/lc_switch.js')}}
            {{Html::style('assets/backend/js/switch/lc_switch.css')}}

            {{Html::script('assets/backend/js/swiper/swiper.jquery.min.js')}}
            {{Html::style('assets/backend/js/swiper/swiper.min.css')}}

            <!-- TOOL TIPs -->
                {{Html::script('assets/backend/js/tooltip/tooltipster.bundle.min.js')}}
                {{Html::style('assets/backend/js/tooltip/tooltipster.bundle.min.css')}}

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
                                    url: "/admin/staff/nextcat",
                                    data: {cat: category_idx, page: page}
                                }).done(function (data) {
                                    console.log(data);
                                    $('.wrapper-content').html(data);

                                });
                                $.ajax({
                                    url: "/admin/staff/nextpreview",
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
                                    url: "/admin/staff/nextcat",
                                    data: {cat: category_idx, page: page}
                                }).done(function (data) {
                                    console.log(data);
                                    $('.wrapper-content').html(data);
                                });
                                $.ajax({
                                    url: "/admin/staff/nextpreview",
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

                        $('.tooltip-menu').tooltipster({
                            side: ['right', 'left', 'top']
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
                                url: "/admin/staff/view_more",
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