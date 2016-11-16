@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>フォトギャラリー</span>
            <strong>
                フォトギャラリーの登録・編集が可能
            </strong>
        </div>
        <div class="right">
            <span class="switch-button">
                <div class="lcs_wrap">
                    <input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable">
                    <div class="lcs_switch  lcs_checkbox_switch lcs_off">
                        <div class="lcs_cursor"></div>
                        <div class="lcs_label lcs_label_on">表示項</div>
                        <div class="lcs_label lcs_label_off">表示項</div>
                    </div>
                </div>
            </span>
            <a href="#" class="btn-2">保存</a>
        </div>
    </div>
    <section class="content modal-global-redesign">
        <div class="col-xs-12">@include('admin.layouts.messages')</div>
        <div class="col-md-4">
            <div class="wrap-preview">
                <div class="wrap-content-prview">
                    <div class="header-preview">
                        <a href="javascript:avoid()" class="trigger-preview"><img
                                    src="/assets/backend/images/nav-icon.png" alt=""></a>
                        <h2 class="title-prview">フォトギャラリー</h2>
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
                            @if(empty($list_preview_photo))
                                No Data
                            @else
                                @foreach($list_preview_photo as $item_thumb)
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
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="{{ route('admin.photo-cate.cat') }}" class="btn-3">
                    <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
                <a href="#" data-toggle="modal" data-target="#AddImage" class="btn-4">
                    <i class="glyphicon glyphicon-plus"></i> メニュー追加
                </a>
            </div>
            <div class="wrapp-photo-img">
                    <div class="row">
                        @if(empty($list_photo))
                            No Data
                        @else
                            @foreach($list_photo as $item)
                                <div class="col-md-4 col-xs-6">
                                    <div class="content-photo-img">
                                        <a href="{{route('admin.photo-cate.edit',$item->id)}}"><img
                                                        src="{{asset($item->image_url)}}"
                                                        class="img-responsive img-prview" alt="Photo"></a>
                                        <div class="text-photo">
                                        {{Form::open(array('route'=>['admin.photo-cate.destroy',$item->id],'method'=>'DELETE'))}}
                                        {{Form::submit('削除',array())}}
                                        {{Form::close()}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="clearfix">
                        @if(!$list_photo->isEmpty())
                            {{ $list_photo->render() }}
                        @endif
                    </div>
            </div>    <!-- wrap-content-->
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
                        {{Form::submit('保存',['class'=>'btn btn-primary btn_submit_form'])}}
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </section>
</aside>
<!-- /.right-side -->
@endsection

@section('footerJS')
    {{Html::script('admin/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('admin/js/swiper/swiper.min.css')}}
<script src="{{ url('admin/js/lc_switch.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
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
                // $.ajax({
                //     url: "/admin/photo-cate/nextcat",
                //     data: {cat: category_idx, page: page}
                // }).done(function (data) {
                //     console.log(data);
                //     $('.wrapper-content').html(data);

                // });
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
                // $.ajax({
                //     url: "/admin/photo-cate/nextcat",
                //     data: {cat: category_idx, page: page}
                // }).done(function (data) {
                //     console.log(data);
                //     $('.wrapper-content').html(data);
                // });
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
        
    })
</script>
@endsection