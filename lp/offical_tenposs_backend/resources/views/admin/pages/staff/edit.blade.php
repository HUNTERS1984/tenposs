@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>スタッフ</span>
            <strong>
                スタッフの登録・編集が可能
            </strong>
        </div>
        <div class="right">
            <a href="{{ URL::previous() }}" class="btn-1">戻る</a>
            <a href="#" class="btn-2" id="btn_submit_form">保存</a>
        </div>
    </div>
    <section class="content">
        @include('admin.layouts.messages')
        <div class="col-lg-8">
            <div class="wrapper-content">
                {{Form::model($item,array('route'=>array('admin.staff.update',$item->id),'method'=>'PUT','files'=>true, 'id' => 'form_app_new'))}}
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-xs-12">
                        <div class="form-group">
                            <img class="edit_img" src="{{asset($item->image_url)}}" width="100%">
                            <button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o"
                                                                                  aria-hidden="true"></i>画像アップロード
                            </button>
                            {!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-xs-12">
                        <div class="form-group">
                            {{Form::label('menu','カテゴリ')}}
                            {{Form::select('staff_category_id',$staff_cat->pluck('name', 'id'),old('staff_category_id'),['class'=>'form-control'])}}

                        </div>
                        <div class="form-group">
                            {{Form::label('name','名前')}}
                            {{Form::text('name',old('name'),['class'=>'form-control'])}}

                        </div>
                        <div class="form-group">
                            {{Form::label('introduction','説明')}}
                            {{Form::textarea('introduction',old('introduction'),['class'=>'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('gender','性別')}}
                            {{--{{ Form::radio('genre', '1', old('gender') == 0, array('id'=>'male',--}}
                            {{--'class'=>'radio')) }}--}}
                            <input type="radio" id="gender" name="gender"
                                   value="1" {{ $item->gender==1 ? 'checked='.'"'.'checked'.'"' : '' }} />男性
                            <input type="radio" id="gender" name="gender"
                                   value="0" {{ $item->gender==0 ? 'checked='.'"'.'checked'.'"' : '' }} />女性
                        </div>
                        <div class="form-group">
                            {{Form::label('tel','電話番号')}}
                            {{Form::text('tel',old('tel'),['class'=>'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('price','価格')}}
                            {{Form::text('price',old('price'),['class'=>'form-control'])}}

                        </div>
                    </div>
            </div>
        </div>    <!-- wrap-content-->
    </div>
    </section>
    {{Form::close()}}
</aside>

@stop

@section('footerJS')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}
    {{Html::script('assets/backend/js/script.js')}}
    <script type="text/javascript">
        $(document).ready(function(){

            $('.btn_upload_img.edit').click(function(){
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

            $("#image_edit").change(function(){
                readURL(this);
            });
            $('#btn_submit_form').click(function () {
                $('#form_app_new').submit();
            });
        })
    </script>
@stop