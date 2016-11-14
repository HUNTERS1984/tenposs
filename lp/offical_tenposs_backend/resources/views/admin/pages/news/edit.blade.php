@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>ニュース</span></div>
        <div class="right">
            <a href="{{ URL::previous() }}" class="btn-1">戻る</a>
            <a href="#" class="btn-2" id="btn_submit_form">保存</a>
        </div>
    </div>
    <section class="content">
        @include('admin.layouts.messages')
        {{Form::model($news,array('route'=>array('admin.news.update',$news->id),'method'=>'PUT','files'=>true, 'id'=>'form_app_new'))}}
        <div class="col-lg-8">
            <div class="wrapper-content">
                <div class="col-lg-5 col-md-5 col-xs-12">
                        <div class="form-group">
                            <img class="edit_img" src="{{asset($news->image_url)}}" width="100%">
                            <button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o" aria-hidden="true"></i>画像アップロード</button>
                            {!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
                        </div>
                </div>
                <div class="col-lg-7 col-md-7 col-xs-12">
                        <div class="form-group">
                            {{Form::label('category','カテゴリ')}}
                            {{Form::select('new_category_id',$new_cat->pluck('name','id'),$news->new_category_id,array('class'=>'form-control'))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('title','タイトル')}}
                            {{Form::text('title',old('title'),array('class'=>'form-control', 'placeholder'=>'Type the title'))}}
                        </div>
                        <div class="form-group">
                            {{Form::label('description','説明')}}
                            {{Form::textarea('description',old('description'),array('class'=>'form-control', 'placeholder'=>'Type the description'))}}
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