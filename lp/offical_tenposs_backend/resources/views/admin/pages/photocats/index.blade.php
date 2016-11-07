@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>フォトギャラリー</span></div>
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
            <div class="wrapp-phone">
                <center>
                    <img src="images/phone.jpg" class="img-responsive" alt="">
                </center>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="#" data-toggle="modal" data-target="#AddCat" class="btn-3">
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
        <!-- Modal Category -->
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
                        {{Form::submit('保存',['class'=>'btn btn-primary btn_submit_form'])}}
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
<script src="{{ url('admin/js/lc_switch.js') }}" type="text/javascript"></script>
<script type="text/javascript">
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
    $(document).ready(function () {
        $('input.lcs_check').lc_switch();        
    })
</script>
@endsection