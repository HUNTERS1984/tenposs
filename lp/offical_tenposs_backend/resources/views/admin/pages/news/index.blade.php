@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>ニュース</span>
            <strong>
                最新の情報を登録・編集が可能です。
            </strong>
        </div>
        <div class="right">
            <span class="switch-button">
                <div class="lcs_wrap">
                    <input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable">
                    <div class="lcs_switch  lcs_checkbox_switch lcs_off">
                        <div class="lcs_cursor"></div>
                        <div class="lcs_label lcs_label_on">表示</div>
                        <div class="lcs_label lcs_label_off">非表示</div>
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
                        <h2 class="title-prview">ニュース</h2>
                    </div>
                    <div class="control-nav-preview">
                        <!-- Slider main container -->
                        <div class="swiper-container">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @if(count($news_cat) > 0)
                                    @foreach($news_cat as $item)
                                        <div class="swiper-slide">{{$item->name}}</div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                    <div class="content-preview" style="height:320px;">
                        @if(empty($list_preview_news))
                            <p align="center">データなし</p>
                        @else
                            @foreach($list_preview_news as $item_thumb)
                                <div class="each-coupon clearfix">
                                    <img src="{{asset($item_thumb->image_url)}}"
                                         class="img-responsive img-prview">
                                    <div class="inner-preview">
                                        <p class="title-inner"
                                           style="font-size:9px; color:#14b4d2">{{$item_thumb->title}}</p>
                                        <!-- <p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p> -->
                                        <p class="text-inner"
                                           style="font-size:9px;">{!! Str::words( strip_tags($item_thumb->description),10,'..') !!}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="{{ route('admin.news.cat') }}" class="btn-3">
                    <i class="glyphicon glyphicon-plus"></i> カテゴリ追加・編集
                </a>
                <a href="#" data-toggle="modal" data-target="#AddNews" class="btn-4">
                    <i class="glyphicon glyphicon-plus"></i> メニュー追加
                </a>
            </div>
            <div class="wrapp-news">

                @if(empty($news))
                            
                @else
                    @foreach($news as $item)
                    <div class="news-content">
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <a href="{{route('admin.news.edit',$item->id)}}">
                                    <center>
                                        <img src="{{ ($item->image_url != '') ? asset($item->image_url) : url('admin/images/img-news.jpg') }}" class="img-responsive" alt="">
                                    </center>
                                </a>
                            </div>
                            <div class="col-md-8 col-xs-12">
                                <div class="title-news">
                                    <div class="row">
                                        <div class="col-md-8 col-xs-12">
                                            <a href="{{route('admin.news.edit',$item->id)}}" class="text-news-left">{{$item->category->name}}</a>
                                            <p><a href="{{route('admin.news.edit',$item->id)}}" class="text-news-title">{{$item->title}}</a></p>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <a href="javascript:avoid()" data-toggle="modal" data-target="#DeleteConfirm" data-id="{{$item->id}}" class="btn-5 deleteConfirm">削除</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="des-news col-xs-12">
                                    <div class="row">
                                        <p>
                                            {!! Str::words( strip_tags($item->description), 50,'..') !!}

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @endforeach
                @endif



                <div class="page-bottom">
                    @if(count($news) > 0)
                        {{ $news->render() }}
                    @endif
                </div>
            </div>
        </div>

        <div class="modal fade" id="DeleteConfirm" tabindex="-1" role="dialog" aria-labelledby="DeleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="DeleteConfirmLabel">本当に削除しますか？</h4>
                    </div>
                    <div class="modal-body"> 
                        {{Form::open(array('route'=>'admin.news.delete'))}}
                        <input type="text" name="itemId" id="itemId" value="" hidden/>
                        <div class="col-md-6">
                            <center><a href="#" data-dismiss="modal" class="btn-user-poup-log-poup-left">キャンセル</a></center>
                        </div>
                        <div class="col-md-6">
                            <center>{{Form::submit('削除',['class'=>'btn-user-poup-log-poup-right'])}}</center>
                        </div>
                        {{Form::close()}}
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="AddNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                {{Form::label('store','カテゴリ名')}}
                                {{Form::select('new_category_id',$news_cat->pluck('name', 'id'),old('new_category_id'),['class'=>'form-control'])}}

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
                $.ajax({
                    url: "/admin/news/nextpreview",
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
                    url: "/admin/news/nextpreview",
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

        $(document).on("click", ".deleteConfirm", function () {
             var itemId = $(this).data('id');
             $(".modal-body #itemId").val(itemId );
        });       
    })
</script>
@endsection