@extends('admin::layouts.default')


@section('title', 'メニュー')
@section('content')
    <div class="content">
        {{Form::model($item,array('route'=>array('admin.menus.update',$item->id),'files'=>true,'method'=>'PUT','id'=>'form_app_new') )}}
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">メニュー</h1>
                </div>
                <div class="right-topbar">
                    <input type="button" id="btn_submit_form" name="btn_submit_form" value="保存" class="btn btn-primary">
                </div>
            </div>
        </div>

        <div class="main-content global">
            @include('admin::layouts.message')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="global-tab" style="width: 40%">
                            <ul class="nav-tab clearfix">
                                <li><a href="#" alt="tab1" class="active">アイテムの詳細</a></li>
                                <li><a href="#" alt="tab2">サイズ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8">

                        <div class="wrapper-content">
                            <div class="content-global" id="tab1">
                                {{Form::model($item,array('route'=>array('admin.menus.update',$item->id),'method'=>'PUT','files'=>true))}}
                                <div class="form-group">
                                    <img class="edit_img" src="{{asset($item->image_url)}}" width="100%">
                                    <button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o"
                                                                                          aria-hidden="true"></i>画像アップロード
                                    </button>
                                    {!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
                                </div>
                                <div class="form-group">
                                    {{Form::label('menu','メニュー')}}
                                    {{Form::select('menu_id',$menus->pluck('name', 'id'),old('menu_id'),['class'=>'form-control'])}}

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
                                {{--<div class="form-group">--}}
                                {{--{{Form::submit('保存',array('class'=>'btn btn-primary'))}}--}}
                                {{--</div>--}}
                            </div>
                        </div>
                        <!-- end item detail -->
                        <div class="content-global" id="tab2">
                            <div class="table">
                                <table class="table table-bordered">
                                    <thead>
                                    <th style="text-align: center;">#</th>
                                    @for ($t = 0; $t < count($size_categories); $t++)
                                        <th style="text-align: center;">{{$size_categories[$t]->name}}</th>
                                    @endfor
                                    </thead>
                                    <tbody>
                                    @for ($i = 0; $i < count($size_type); $i++)
                                        <tr>
                                            <td style="text-align: center;" class="col-md-2">{{$size_type[$i]->name}} </td>
                                            @for ($j = 0; $j < count($size_categories); $j++)
                                                <td class="col-md-2">
                                                    <input style="width: 100%;text-align: center;" type="number" name="size_value[{{$size_type[$i]->id}}][{{$size_categories[$j]->id}}]" value="{{\App\Utils\Convert::get_value_size_from_type_category_id($size_value,$size_type[$i]->id,$size_categories[$j]->id)}}" ></td>
                                            @endfor
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!---end size ->
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
            $('.content-global').not(':first').hide();

            $('.nav-tab li a').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('alt');
                $('.nav-tab li a').removeClass('active');
                $('.content-global').slideUp();
                $(this).addClass('active');
                $('#' + id).slideDown();
            })

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
        $('#btn_submit_form').click(function () {
//            $('ul.nav-left li').each(function () {
//                var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_component[]">';
//                $('.main-content').append(tmp);
//            });
            $('#form_app_new').submit();
        });
    </script>
@stop