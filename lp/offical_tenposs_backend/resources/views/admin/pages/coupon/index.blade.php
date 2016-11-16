@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>クーポン</span>
            <strong>
                クーポンの登録・編集が可能
            </strong>
        </div>
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
            <div class="wrap-preview">
                <div class="wrap-content-prview">
                    <div class="header-preview">
                        <a href="javascript:avoid()" class="trigger-preview"><img
                                    src="/assets/backend/images/nav-icon.png" alt=""></a>
                        <h2 class="title-prview">クーポン</h2>
                    </div>
                    <div class="content-preview" style="height:340px;overflow: auto;">
                        @if(empty($coupons))
                            No data
                        @else
                            @foreach($coupons as $coupon)
                                <div class="each-coupon clearfix">
                                    <img src="{{asset($coupon->image_url)}}"
                                         class="img-responsive img-prview">
                                    <div class="inner-preview">
                                        <p class="title-inner"
                                           style="font-size:9px; color:#14b4d2">{{$coupon->title}}</p>
                                        <!-- <p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p> -->
                                        <p class="text-inner"
                                           style="font-size:9px;">{{Str::words($coupon->description,12)}}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <a href="#" class="btn tenposs-readmore">もっと見る</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="{{ route('admin.coupon.cat') }}" class="btn-3">
                    <i class="glyphicon glyphicon-plus"></i> カテゴリ追加
                </a>
                <a href="#" data-toggle="modal" data-target="#AddCoupon" class="btn-4">
                    <i class="glyphicon glyphicon-plus"></i> クーポン追加
                </a>
            </div>
            <div class="wrapp-news">
                
                @if(empty($coupons))
                        No data
                    @else
                        @foreach($coupons as $item)
                        <div class="coupon-content">
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <a href="{{route('admin.coupon.edit',$item->id)}}">
                                        <center>
                                            <img src="{{ ($item->image_url != '') ? asset($item->image_url) : url('admin/images/img-news.jpg') }}" class="img-responsive" alt="">
                                        </center>
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <div class="title-coupon">
                                        <div class="row">
                                            <div class="col-md-8 col-xs-12">
                                                <a href="{{route('admin.coupon.edit',$item->id)}}" class="text-coupon-left">{{$item->title}}</a>
                                                <p>{{$item->coupon_type->name}}</p>
                                                <p class="date-copon">有効期間　{{$item->end_date}}まで</p>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                 {{Form::open(array('route'=>array('admin.coupon.destroy',$item->id),'method'=>'DELETE'))}}
                                                <input type="submit" class="btn-5" value="削除"
                                                       onclick="return confirm('Are you sure you want to delete this item?');">
                                                {{Form::close()}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="des-coupon col-xs-12">
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
                    @if(count($coupons) > 0)
                        {{ $coupons->render() }}
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

        <div class="modal fade" id="AddCoupon" tabindex="-1" role="dialog" aria-labelledby="AddCoupon">
            <div class="modal-dialog" role="document">
                {{Form::open(array('route'=>'admin.coupon.store','files'=>true))}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="AddCouponTitle">クーポン追加</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-4" align="left">
                            <img class="new_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                            <button class="btn_upload_img create" type="button"><i class="fa fa-picture-o"
                                                                                   aria-hidden="true"></i>画像アップロード
                            </button>
                            {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
                        </div>
                        <div class="col-md-8" align="left">
                            <div class="form-group">
                                {{Form::label('Select Coupon Type','クーポンタイプ')}}
                                @if(count($list_coupon_type) > 0)
                                    {{Form::select('coupon_type_id',$list_coupon_type->pluck('name', 'id'),old('coupon_type_id'),['class'=>'form-control'])}}
                                @endif
                            </div>
                            <div class="form-group">
                                {{Form::label('Title','クーポン名')}}
                                {{Form::text('title',old('title'),['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('Description', '説明')}}
                                {{Form::textarea('description',old('description'),['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('Hashtag','ハッシュタグ')}}
                                {{Form::text('hashtag',old('hashtag'),['class'=>'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{Form::label('Start Date','開始日')}}
                                {{ Form::date('start_date', \Carbon\Carbon::now(),['class'=>'form-control']) }}
                            </div>

                            <div class="form-group">
                                {{Form::label('End Date','終了日')}}
                                {{ Form::date('end_date', \Carbon\Carbon::now(),['class'=>'form-control']) }}
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
<script type="text/javascript">
    $(document).ready(function () {
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
@endsection