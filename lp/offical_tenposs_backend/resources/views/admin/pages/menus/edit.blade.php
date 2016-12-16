@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    {{Form::model($item,array('route'=>array('admin.menus.update',$item->id),'files'=>true,'method'=>'PUT','id'=>'form_app_new') )}}
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>メニュー</span>
            <strong>
                メニューの登緑・編集が可能
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
            <div class="col-md-12">
                <div class="tab-header-global">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab-global-1" aria-controls="tab-global-1" role="tab" data-toggle="tab">アイテムの詳細</a>
                        </li>
                        <li role="presentation">
                            <a href="#tab-global-2" aria-controls="tab-global-2" role="tab" data-toggle="tab">サイズ</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab-global-1">
                        {{Form::model($item,array('route'=>array('admin.menus.update',$item->id),'method'=>'PUT','files'=>true))}}
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
                                    {{Form::label('menu','メニュー')}}
                                    {{Form::select('menu_id',$menus->pluck('name', 'id'),$menu_id,['class'=>'form-control'])}}

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
                    </div>
                    <!-- end item detail -->
                    <div role="tabpanel" class="tab-pane" id="tab-global-2">
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
                </div>
                
                <!---end size ->
            </div>    <!-- wrap-content-->
            </div>
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