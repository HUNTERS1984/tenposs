@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>メニュー</span></div>
        <div class="right">
            <a href="{{ route('admin.menus.cat') }}" class="btn-1">戻る</a>
            <a href="#" class="btn-2" id="btn_submit_form">保存</a>
        </div>
    </div>
    <section class="content">
        
        {{Form::model($menu,array('route'=>array('admin.menus.updatecat',$menu->id),'method'=>'PUT', 'id'=>'form_app_new'))}}
        <div class="col-lg-8">
            <div class="wrapper-content">
                <div class="col-lg-7 col-md-7 col-xs-12">   
                    @include('admin::layouts.message')
                    <div class="form-group">
                        {{Form::label('Select Store','ストア')}}
                        {{Form::select('store_id',$list_store,old('store_id'),['class'=>'form-control'])}}

                    </div>
                    <div class="form-group">
                        {{Form::label('Name', 'タイトル')}}
                        {{Form::text('name',old('name'),['class'=>'form-control'])}}
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
        $('#btn_submit_form').click(function () {
            $('#form_app_new').submit();
        });
    </script>
@stop