@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>メニュー</span></div>
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
            <a href="" class="btn-2">保存</a>
        </div>
    </div>
    <section class="content modal-global-redesign">
        <div class="col-xs-12">@include('admin.layouts.messages')</div>
        <div class="col-md-4">
            <div class="wrapp-phone">
                <center>
                    <img src="images/phone.jpg" class="img-responsive" alt="">
                </center>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="javascript:avoid()" class="btn-3" data-toggle="modal" data-target="#AddMenu">
                    <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
                <a href="javascript:avoid()" class="btn-4" data-toggle="modal" data-target="#AddItem">
                    <i class="glyphicon glyphicon-plus"></i> メニュー追加
                </a>
            </div>
            <div class="wrapp-menu-img">
                <div class="row">
                    @if(empty($list_item))
                        <p>No data</p>
                    @else
                        @foreach($list_item as $item)
                         <div class="col-md-4 col-xs-6">
                            <div class="content-menu-img">
                                <a href="{{route('admin.menus.edit',$item->id)}}">
                                    <img src="{{asset($item->image_url)}}" class="img-responsive" alt="">
                                </a>
                                <div class="text-menu">
                                    <p class="text-title-menu">
                                        {{$item->title}}
                                    </p>
                                    {{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
                                    {{Form::submit('削除',array())}}
                                    {{Form::close()}}
                                </div>
                            </div>
                        </div>
                            
                        @endforeach

                    @endif
                 
                    <div class="page-bottom">
                        @if(!$list_item->isEmpty())
                            {{ $list_item->render() }}
                        @endif
                        <!--
                        <ul class="pagination"> 
                            <li class="disabled">
                                <a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
                            </li> 
                            <li class="active">
                                <a href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li><a href="#">2</a></li> 
                            <li><a href="#">3</a></li> 
                            <li><a href="#">4</a></li> 
                            <li><a href="#">5</a></li> 
                            <li>
                                <a href="#" aria-label="Next"><span aria-hidden="true">»</span></a>
                            </li> 
                        </ul>
                        -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="AddMenu" tabindex="-1" role="dialog" aria-labelledby="AddMenuLabel">
            <div class="modal-dialog" role="document">
                {{Form::open(array('route'=>'admin.menus.storeMenu'))}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="AddMenuLabel">カテゴリ追加</h4>
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
                        {{Form::submit('保存',['class'=>'btn btn-primary btn_submit_form'])}}
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>

        <div class="modal fade" id="AddItem" tabindex="-1" role="dialog" aria-labelledby="AddItem">
            <div class="modal-dialog" role="document">
                {{Form::open(array('route'=>'admin.menus.storeitem','files'=>true))}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="AddItemTitle">メニュー追加</h4>
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
                                {{Form::label('menu','メニュー')}}
                                @if(count($menus) > 0)
                                    {{Form::select('menu_id',$menus->pluck('name', 'id'),old('menu_id'),['class'=>'form-control'])}}
                                @endif
                            </div>
                            <div class="form-group">
                                {{Form::label('title','タイトル')}}
                                {{Form::text('title',old('title'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('description','説明')}}
                                {{Form::textarea('description',old('description'),['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('price','価格')}}
                                {{Form::text('price',old('price'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('item_link','URL')}}
                                {{Form::text('item_link',old('item_link'),['class'=>'form-control'])}}

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
@endsection
@section('footerJS')
<script type="text/javascript">
    $(document).ready(function () {
        // $('input.lcs_check').lc_switch();
        // var category_idx = 0;
        // var page = 0;
        // var categorySwiper = new Swiper('.control-nav-preview .swiper-container', {
        //     speed: 400,
        //     spaceBetween: 0,
        //     slidesPerView: 1,
        //     nextButton: '.control-nav-preview .swiper-button-next',
        //     prevButton: '.control-nav-preview .swiper-button-prev',
        //     onSlideNextStart: function (swiper) {
        //         ++category_idx;
        //         page = 0;
        //         $.ajax({
        //             url: "/admin/menus/nextpreview",
        //             data: {cat: category_idx, page: page}
        //         }).done(function (data) {
        //             console.log(data);
        //             $('.content-preview').html(data);

        //         });
        //     },
        //     onSlidePrevStart: function (swiper) {
        //         --category_idx;
        //         page = 0;
        //         // $.ajax({
        //         //     url: "/admin/menus/nextcat",
        //         //     data: {cat: category_idx, page: page}
        //         // }).done(function (data) {
        //         //     console.log(data);
        //         //     $('.wrapper-content').html(data);
        //         // });
        //         $.ajax({
        //             url: "/admin/menus/nextpreview",
        //             data: {cat: category_idx, page: page}
        //         }).done(function (data) {
        //             console.log(data);
        //             $('.content-preview').html(data);

        //         });
        //     }
        // });

        $('.btn_upload_img.create').click(function () {
            $('.btn_upload_ipt.create').click();
        });

        // $('.tooltip-menu').tooltipster({
        //     side: ['right', 'left', 'top']
        // });

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