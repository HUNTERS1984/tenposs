@extends('admin::layouts.default')

@section('title', 'News')

@section('content')
    <div class="content">
        <div class="topbar-content">
            <div class="wrap-topbar clearfix">
                <span class="visible-xs visible-sm trigger"><span
                            class="glyphicon glyphicon-align-justify"></span></span>
                <div class="left-topbar">
                    <h1 class="title">ニュース</h1>
                </div>
                <div class="right-topbar">
                    {{--<span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check"--}}
                                                       {{--autocomplete="disable"/></span>--}}
                    {{--<a href="javascript:avoid()" class="btn-me btn-topbar" data-toggle="modal"--}}
                       {{--data-target="#myModal">保存</a>--}}
                </div>
            </div>
        </div>
        <!-- END -->

        <div class="main-content news">
            @if (Session::has('success'))
                <div class="alert alert-info">{{ Session::get( 'success' ) }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get( 'error' ) }}</div>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wrap-btn-content">
                            {{--<a href="javascript:avoid()" class="btn-me btn-xanhduongnhat" data-toggle="modal"--}}
                               {{--data-target="#myModal">追加</a>  --}}
                            <a href="{{ route($back_url,array('type'=>$type)) }}" class="btn-me btn-hong">バック</a>
                            <a href="{{ route('admin.category.create',array('type'=>$type)) }}" class="btn-me btn-xanhduongnhat">追加</a>
                        </div>    <!-- end wrap-btn-content-->
                        <div class="wrapper-content">
                            <div class="grip">
                                @if(empty($list_item))
                                    No data
                                @else
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>カテゴリー名</th>
                                                <th>店名</th>
                                                <th></th>
                                            </tr>
                                            @foreach($list_item as $item)
                                                <tr>
                                                    <td>
                                                        <a href="{{route('admin.category.edit',array('id'=> $item->id,'type'=>$type))}}">{{$item->name}}</a>
                                                    </td>
                                                    <td>
                                                        {{$list_store[$item->store_id]}}</a>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        {{Form::open(array('route'=>array('admin.category.deletetype',$item->id,$type),'method'=>'DELETE'))}}
                                                        <input type="submit" class="btn-me btn-each-item" value="削除"
                                                               onclick="return confirm('Are you sure you want to delete this item?');">
                                                        {{Form::close()}}
                                                    </td>
                                    </div>
                                    <div class="container-content">
                                        <p>{{$item->description}}</p>
                                    </div>
                                    </tr>

                                    @endforeach
                                    </table>
                            </div>
                            @endif
                        </div>
                        <div class="clearfix">
                            @if(count($list_item) > 0)
                                {{ $list_item->render() }}
                            @endif
                        </div>
                    </div>    <!-- wrap-content-->
                </div>
            </div>
        </div>

    </div>
    <!-- END -->
    </div>    <!-- end main-content-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <button class="btn_upload_img create" type="button"><i class="fa fa-picture-o"
                                                                               aria-hidden="true"></i> 画像アップロード
                        </button>
                        {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                    </div>
                    <div class="col-md-8" align="left">
                        <div class="form-group">
                            {{Form::label('store','ストア')}}
                            {{Form::select('store_id',$list_store,old('store_id'),['class'=>'form-control'])}}

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
                    {{Form::submit('保存',['class'=>'btn btn-primary'])}}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
@stop

@section('script')
    {{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
    {{Html::script('assets/backend/js/bootstrap.min.js')}}

    {{Html::script('assets/backend/js/switch/lc_switch.js')}}
    {{Html::style('assets/backend/js/switch/lc_switch.css')}}

    {{Html::script('assets/backend/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('assets/backend/js/swiper/swiper.min.css')}}

    {{Html::script('assets/backend/js/Masonry.js')}}

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
        })
    </script>
@stop
