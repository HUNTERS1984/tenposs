@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>メニュー</span></div>
        <div class="right">
            <a href="{{ route('admin.menus.index') }}" class="btn-1">戻る</a>
        </div>
    </div>
    <section class="content">
        @include('admin::layouts.message')
        <div class="col-lg-12">
            <div class="btn-menu">
                <a href="javascript:avoid()" class="btn-3" data-toggle="modal" data-target="#AddMenu">
                  <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
                <a href="#" class="btn-4" id="btn_delete">選択した項目を削除</a>
            </div>
            <div class="wrapp_table">

                <!-- table -->
                <div class="table-responsive">
                    <table class="table accept_01">
                        <thead>
                        <tr>
                            <th class="center">選択</th>
                            <th>カテゴリ</th>
                            <th>ストア</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <th width="15%" scope="row" class="center">
                                    <div>
                                        <input id="{{$menu->id}}" class="checkbox-custom" name="checkbox-1" type="checkbox">
                                        <label for="{{$menu->id}}" class="checkbox-custom-label"></label>
                                    </div>
                                </th>
                                
                                <td width="35%">{{$menu->name}}</td>
                                <td width="35%">
                                    {{ $menu->store->name }}
                                </td>
                               
                                <td width="15%" class="center"><a href="{{route('admin.menus.editcat',['menu_id'=>$menu->id])}}" title="">編集</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($menus) > 0)
                    {{ $menus->render() }}
                @endif
                <!-- //table -->
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
            var del_list = [];
            $('#btn_delete').click(function () {
                $("input[type=checkbox]:checked").each(function(){
                    del_list.push($(this).attr('id'));
                });

                console.log(del_list);

                $.ajax({
                    type: "POST",
                    url: "/admin/menus/deletecat",
                    data: {data: del_list}
                }).done(function (data) {
                    ret = JSON.parse(data);
                    if (ret.status == 'success')
                        location.reload();
                });

            });
        })

    </script>
@stop