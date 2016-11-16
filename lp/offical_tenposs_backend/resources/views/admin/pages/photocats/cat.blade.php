@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>フォトギャラリー</span>
            <strong>
                フォトギャラリーの登録・編集が可能
            </strong>
        </div>
        <div class="right">
            <a href="{{ route('admin.photo-cate.index') }}" class="btn-1">戻る</a>
        </div>
    </div>
    <section class="content modal-global-redesign">
        @include('admin.layouts.messages')
        <div class="col-lg-12">
            <div class="btn-menu">
                <a href="javascript:avoid()" class="btn-3" data-toggle="modal" data-target="#AddMenu">
                  <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
                <a href="javascript:avoid()" class="btn-4" data-toggle="modal" data-target="#DeleteConfirm">
                  <i class="glyphicon glyphicon-plus"></i> 選択した項目を削除
                </a>
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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list_photo_cat as $cat)
                            <tr>
                                <th width="15%" scope="row" class="center">
                                    <div>
                                        <input id="{{$cat->id}}" class="checkbox-custom" name="checkbox-1" type="checkbox">
                                        <label for="{{$cat->id}}" class="checkbox-custom-label"></label>
                                    </div>
                                </th>
                                
                                <td width="35%">{{$cat->name}}</td>
                                <td width="35%">
                                    {{ $cat->store->name }}
                                </td>
                               
                                <td width="15%" class="center"><a href="{{route('admin.photo-cate.editcat',['photo-cate_id'=>$cat->id])}}" title="">編集</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($list_photo_cat) > 0)
                    {{ $list_photo_cat->render() }}
                @endif
                <!-- //table -->
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="DeleteConfirm" tabindex="-1" role="dialog" aria-labelledby="DeleteConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="DeleteConfirmLabel">本当に削除しますか？</h4>
                    </div>
                    <div class="modal-body"> 
                        <div class="col-md-6">
                            <center><a href="#" data-dismiss="modal">キャンセル</a></center>
                        </div>
                        <div class="col-md-6">
                            <center><a href="#" id="btn_delete" style="color:red; font-weight:bold;">削除</a></center>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="AddMenu" tabindex="-1" role="dialog" aria-labelledby="AddMenuLabel">
            <div class="modal-dialog" role="document">
                {{Form::open(array('route'=>'admin.photo-cate.store'))}}
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
    </section>
    
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
                    url: "/admin/photo-cate/deletecat",
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