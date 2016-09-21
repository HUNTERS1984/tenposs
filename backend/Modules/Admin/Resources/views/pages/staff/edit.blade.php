@extends('admin::layouts.default')


@section('title', 'スタッフ')
@section('content')
    <div class="content">
        {{Form::model($item,array('route'=>array('admin.staff.update',$item->id),'files'=>true,'method'=>'PUT') )}}
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">スタッフ</h1>
                </div>
            </div>
        </div>

        <div class="main-content news">
            @include('admin::layouts.message')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">

                        <div class="wrapper-content">
                            {{Form::model($item,array('route'=>array('admin.staff.update',$item->id),'method'=>'PUT','files'=>true))}}
                            <div class="form-group">
                                <img class="edit_img" src="{{asset($item->image_url)}}" width="100%">
                                <button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o"
                                                                                      aria-hidden="true"></i>画像アップロード
                                </button>
                                {!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
                            </div>
                            <div class="form-group">
                                {{Form::label('menu','名')}}
                                {{Form::select('staff_category_id',$staff_cat->pluck('name', 'id'),old('staff_category_id'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('name','タイトル')}}
                                {{Form::text('name',old('name'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('introduction','導入')}}
                                {{Form::textarea('introduction',old('introduction'),['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('gender','性別')}}
                                {{--{{ Form::radio('genre', '1', old('gender') == 0, array('id'=>'male',--}}
                                {{--'class'=>'radio')) }}--}}
                                <input type="radio" id="gender" name="gender"
                                       value="1" {{ old('gender')==1 ? 'checked='.'"'.'checked'.'"' : '' }} />男性
                                <input type="radio" id="gender" name="gender"
                                       value="0" {{ old('gender')==0 ? 'checked='.'"'.'checked'.'"' : '' }} />女性
                            </div>
                            <div class="form-group">
                                {{Form::label('tel','電話番号')}}
                                {{Form::text('tel',old('tel'),['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('price','価格')}}
                                {{Form::text('price',old('price'),['class'=>'form-control'])}}

                            </div>

                            <div class="form-group">
                                {{Form::submit('保存',array('class'=>'btn btn-primary'))}}
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
    </script>
@stop