@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>ニュース</span></div>
        <div class="right">
            <span class="switch-button">
                <div class="lcs_wrap">
                    <input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable">
                    <div class="lcs_switch  lcs_checkbox_switch lcs_off">
                        <div class="lcs_cursor"></div>
                        <div class="lcs_label lcs_label_on">表示項</div>
                        <div class="lcs_label lcs_label_off">表示項</div>
                    </div>
                </div>
            </span>
            <a href="#" class="btn-2">保存</a>
        </div>
    </div>
    <section class="content modal-global-redesign">
        <div class="col-xs-12">@include('admin.layouts.messages')</div>
        <div class="col-md-4">
            <div class="wrapp-phone">
                <center>
                    <img src="images/phone.jpg" class="img-responsive" alt="">
                </center>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="#" data-toggle="modal" data-target="#AddCategory" class="btn-3">
                    <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
                <a href="#" data-toggle="modal" data-target="#AddNews" class="btn-4">
                    <i class="glyphicon glyphicon-plus"></i> メニュー追加
                </a>
            </div>
            <div class="wrapp-news">
                
                @if(empty($news))
                        No data
                    @else
                        @foreach($news as $item)
                        <div class="news-content">
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <a href="{{route('admin.news.edit',$item->id)}}">
                                        <center>
                                            <img src="{{ ($item->image_url != '') ? asset($item->image_url) : url('admin/images/img-news.jpg') }}" class="img-responsive" alt="">
                                        </center>
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <div class="title-news">
                                        <div class="row">
                                            <div class="col-md-8 col-xs-12">
                                                <a href="{{route('admin.news.edit',$item->id)}}" class="text-news-left">{{$item->title}}</a>
                                                <p>{{ $item->category->name }}</p>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                {{Form::open(array('route'=>array('admin.news.destroy',$item->id),'method'=>'DELETE'))}}
                                                <input type="submit" class="btn-5" value="削除"
                                                       onclick="return confirm('Are you sure you want to delete this item?');">
                                                {{Form::close()}}
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="des-news col-xs-12">
                                        <div class="row">
                                            <p>
                                                {{ Str::words($item->description, 68) }}
                                               
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           

                        @endforeach
                    @endif
               
                
                
                <div class="page-bottom">
                    @if(count($news) > 0)
                        {{ $news->render() }}
                    @endif
                    <!--
                    <ul class="pagination"> 
                        <li class="disabled">
                            <a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
                        </li> 
                        <li class="active">
                            <a href="#">1 <span class="sr-only">(current)</span></a>
                        </li>
                        <li><a href="#">2</a></li> 
                        <li><a href="#">3</a></li> 
                        <li><a href="#">4</a></li> 
                        <li><a href="#">5</a></li> 
                        <li>
                            <a href="#" aria-label="Next"><span aria-hidden="true">»</span></a>
                        </li> 
                    </ul>
                    -->
                </div>
            </div>
        </div>

        <!-- Modal Category -->
        <div class="modal fade" id="AddCategory" tabindex="-1" role="dialog" aria-labelledby="AddCategoryLabel">
            <div class="modal-dialog" role="document">
                {{Form::open(array('route'=>'admin.news.storeCat'))}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="AddCategoryLabel">カテゴリ追加</h4>
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
        <!-- Modal -->
        <div class="modal fade" id="AddNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                {{Form::open(array('route'=>'admin.news.store','files'=>true))}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">ニュース追加</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-4" align="left">
                            <img class="new_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                            <button class="btn_upload_img create" type="button">
                                <i class="fa fa-picture-o" aria-hidden="true"></i> 画像アップロード
                            </button>
                            {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                        </div>
                        <div class="col-md-8" align="left">
                            <div class="form-group">
                                {{Form::label('store','カテゴリー')}}
                                {{Form::select('new_category_id',$news_cat->pluck('name', 'id'),old('new_category_id'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('title','タイトル')}}
                                {{Form::text('title',old('title'),['class'=>'form-control'])}}

                            </div>
                            <div class="form-group">
                                {{Form::label('description','説明')}}
                                {{Form::textarea('description',old('description'),['class'=>'form-control'])}}
                            </div>
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
<!-- /.right-side -->
@endsection

@section('footerJS')
<script src="{{ url('admin/js/lc_switch.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.btn_upload_img.create').click(function () {
        $('.btn_upload_ipt.create').click();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.new_img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image_create").change(function () {
        readURL(this);
    });
    $(document).ready(function () {
        $('input.lcs_check').lc_switch();        
    })
</script>
@endsection