@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>メニュー</span></div>
        <div class="right">
            <a href="{{ URL::previous() }}" class="btn-1">戻る</a>
        </div>
    </div>
    <section class="content">
        @include('admin::layouts.message')
        <div class="col-lg-12">
            <div class="btn-menu">
                <a href="javascript:avoid()" class="btn-3" data-toggle="modal" data-target="#AddMenu">
                  <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
            </div>
        </div>
    </section>
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
</aside>

@stop

@section('footerJS')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}
    {{Html::script('assets/backend/js/script.js')}}
    <script type="text/javascript">
        $(document).ready(function () {
            
        })

    </script>
@stop