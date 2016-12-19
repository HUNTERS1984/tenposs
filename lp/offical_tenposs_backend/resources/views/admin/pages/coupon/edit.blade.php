@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>クーポン</span>
            <strong>
                クーポンの登録・編集が可能
            </strong>
        </div>
        <div class="right">
            <a href="{{ route('admin.coupon.index') }}" class="btn-1">戻る</a>
            <a href="#" class="btn-2" id="btn_submit_form">保存</a>
        </div>
    </div>
    <section class="content">
        @include('admin.layouts.messages')
        {{Form::model($coupon,array('route'=>array('admin.coupon.update',$coupon->id),'method'=>'PUT','files'=>true, 'id'=>'form_app_new'))}}
        <div class="col-lg-8">
            <div class="wrapper-content">
                <div class="col-lg-5 col-md-5 col-xs-12">
                        <div class="form-group">
                            <img class="edit_img" src="{{asset($coupon->image_url)}}" width="100%">
                            <button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o" aria-hidden="true"></i>画像アップロード</button>
                            {!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
                        </div>
                </div>
                <div class="col-lg-7 col-md-7 col-xs-12">
                    <div class="form-group">
                        {{Form::label('Select Coupon Type','クーポンタイプ')}}
                        @if(count($list_coupon_type) > 0)
                            {{Form::select('coupon_type_id',$list_coupon_type->pluck('name', 'id'),old('store_id'),['class'=>'form-control', 'id' => 'edit_coupon_type_id'])}}
                        @endif
                    </div>
                    <div class="form-group">
                        {{Form::label('Title','クーポン名')}}
                        {{Form::text('title',old('title'),['class'=>'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('Description', '説明')}}
                        {{Form::textarea('description',old('description'),['class'=>'form-control', 'id' => 'edit_description'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('Hashtag','ハッシュタグ')}}
                        <?php 
                        $tag_str = '';
                        foreach ($coupon->tags as $tag) {
                            $tag_str .= "#".$tag->tag. ' ';
                        
                        }?>
                        {{Form::text('hashtag', trim($tag_str),['class'=>'form-control', 'id' => 'edit_hashtag'])}}
                    </div>

                    <div class="form-group">
                        {{Form::label('Start Date','開始日')}}
                        {{ Form::date('start_date', old('start_date'),['class'=>'form-control', 'id' => 'edit_startdate']) }}
                    </div>

                    <div class="form-group">
                        {{Form::label('End Date','終了日')}}
                        {{ Form::date('end_date', old('end_date'),['class'=>'form-control', 'id' => 'edit_enddate']) }}
                    </div>
                </div>  <!-- wrap-content-->
            </div>
        </div>
        {{Form::close()}}
    </section>
</aside>

@stop

@section('footerJS')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}
    {{Html::script('assets/backend/js/script.js')}}
    <script type="text/javascript">
        $(document).ready(function () {
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
        $('#btn_submit_form').click(function () {
            $('#form_app_new').submit();
        });
    </script>
@stop