@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>メニュー</span></div>
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
            <a href="" class="btn-2">ポ覧</a>
        </div>
    </div>
    <section class="content">
        <div class="col-md-4">
            <div class="wrapp-phone">
                <center>
                    <img src="images/phone.jpg" class="img-responsive" alt="">
                </center>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="" class="btn-3">
                    <i class="glyphicon glyphicon-plus"></i> 項目追加
                </a>
                <a href="" class="btn-4">
                    <i class="glyphicon glyphicon-plus"></i> メニュー追加
                </a>
            </div>
            <div class="wrapp-menu-img">
                <div class="row">
                    @if(empty($list_item))
                        <p>No data</p>
                    @else
                        @foreach($list_item as $item)
                         <div class="col-md-4 col-xs-6">
                            <div class="content-menu-img">
                                <a href="{{route('admin.menus.edit',$item->id)}}">
                                    <img src="{{asset($item->image_url)}}" class="img-responsive" alt="">
                                </a>
                                <div class="text-menu">
                                    <p class="text-title-menu">
                                        {{$item->title}}
                                    </p>
                                    {{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
                                    {{Form::submit('削除',array('class'=>'','style'=>'width:100%'))}}
                                    {{Form::close()}}
                                </div>
                            </div>
                        </div>
                            
                        @endforeach

                    @endif
                 
                    <div class="page-bottom">
                        @if(!$list_item->isEmpty())
                            {{ $list_item->render() }}
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
        </div>
    </section>
</aside>
@endsection