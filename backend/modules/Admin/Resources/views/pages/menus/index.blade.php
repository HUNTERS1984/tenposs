@extends('admin::layouts.default')

@section('title', 'メニュー')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">メニュー</h1>
				</div>
				<!-- <div class="right-topbar">
					 <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
<<<<<<< HEAD
					<a href="javascript:avoid()" class="btn-me btn-topbar">Add New</a>
				</div> -->
=======
					<a href="javascript:avoid()" class="btn-me btn-topbar">保存</a>
				</div>
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
			</div>
		</div>
		<!-- END -->

		<div class="main-content menu">
			@include('admin::layouts.message')
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/nav-icon.png"  alt=""></a>
<<<<<<< HEAD
									<h2 class="title-prview">Menus</h2>
=======
									<h2 class="title-prview">Menu</h2>
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
								</div>
								<div class="control-nav-preview">
									<!-- Slider main container -->
		                            <div class="swiper-container">
		                                <!-- Additional required wrapper -->
		                                <div class="swiper-wrapper">
		                                    <!-- Slides -->
		                                    @foreach($menus as $menu)
		                                    <div class="swiper-slide">{{$menu->name}}</div>
		                                    @endforeach
		                                </div>

		                                <!-- If we need navigation buttons -->
		                                <div class="swiper-button-prev"></div>
		                                <div class="swiper-button-next"></div>
		                            </div>
								</div>
								<div class="content-preview clearfix">
									<div class="row-me fixHeight">
<<<<<<< HEAD
										@if($item_thumbs->isEmpty())
											<p>No data</p>
										@else
											@foreach($item_thumbs as $item_thumb)
												<div class="col-xs-4 padding-me">
													<div class="each-staff">
														<img src="{{asset($item_thumb->image_url)}}" class="img-responsive" alt="">
=======
										@if($list_item->isEmpty())
											<p>No data</p>
										@else
											@foreach($list_item as $item_thumb)
												<div class="col-xs-6 padding-me">
													<div class="each-menu">
														<img src="{{asset($item_thumb->image_url)}}" class="img-responsive img-item-prview" alt="Item Photo">
														<p style="font-size:11px">{{$item_thumb->title}}</p>
														<p style="font-size:11px">¥{{$item_thumb->price}}</p>
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
													</div>
												</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="wrap-btn-content">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
<<<<<<< HEAD
										<a href="#" class="btn-me btn-hong" data-toggle="modal" data-target="#myModal">Create Menu</a>
										<a href="{{route('admin.menus.create')}}" class="btn-me btn-xanhduongnhat">Create Item</a>
=======
										<a href="javascript:avoid()" class="btn-me btn-hong"  data-toggle="modal" data-target="#AddMenu">メニュー追加</a>
										<a href="javascript:avoid()" class="btn-me btn-xanhduongnhat"  data-toggle="modal" data-target="#AddItem">項目追加</a>
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
									</div>
								</div>
							</div>

						</div>	<!-- end wrap-btn-content-->
						<div class="wrapper-content clearfix">
							<div class="container-fluid">
								<div class="row">
<<<<<<< HEAD
									@if($items->isEmpty())
										<p>No data</p>
									@else
										@foreach($items as $item)
											<div class="col-xs-4">
												<div class="each-menu each-common-pr">
													<a href="{{route('admin.menus.edit',$item->id)}}" class="tooltip-menu" data-tooltip-content="#tooltip_content_{{$item->id}}">
														<img  src="{{asset($item->image_url)}}" class="img-responsive" alt="">
														<p class="title-menu" >{{$item->title}}</p>
														<p class="title-menu">{{number_format($item->price,2)}}</p>
													</a>
													{{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
														{{Form::submit('Delete',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
													{{Form::close()}}
												</div>
												<div class="tooltip_templates">
												    <span id="tooltip_content_{{$item->id}}">
												        <h2 class="title-tooltip">Coupon</h2>
												        <p class="text-tooltip"><b>Coupon name: </b>{{$item->coupons->title}}</p>
												        <p class="text-tooltip"><b>Start date: </b>{{$item->coupons->start_date}}</p>
												        <p class="text-tooltip"><b>End date: </b>{{$item->coupons->end_date}}</p>
												        <p class="text-tooltip"><b>Limit: </b>{{$item->coupons->limit}}</p>

												    </span>
												</div>
											</div>
										@endforeach
									@endif
								</div>
								<div class="row">
									<div class="text-right">
										{{$items->links()}}
									</div>
=======
									@if($list_item->isEmpty())
										<p>No data</p>
									@else
										@foreach($list_item as $item)
											<div class="col-xs-4">
													<div class="each-menu each-common-pr">
														<p class="title-menu"><a href="{{route('admin.menus.edit',$item->id)}}"><img src="{{asset($item->image_url)}}" class="img-responsive" alt="Item"></a></p>
														<p class="">{{$item->title}}</p>
														{{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
															{{Form::submit('削除',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
														{{Form::close()}}
													</div>

											</div>
										@endforeach
										<button class="view-more-btn btn btn-primary btn-block">もっと見る</button>
									@endif
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
								</div>
								
							</div>
						</div>	<!-- wrap-content-->
					</div>
				</div>
			</div>

		</div>
		<!-- END -->
	</div>	<!-- end main-content-->
	<!-- Modal -->
	<div class="modal fade" id="AddMenu" tabindex="-1" role="dialog" aria-labelledby="AddMenuLabel">
	  <div class="modal-dialog" role="document">
	    {{Form::open(array('route'=>'admin.menus.storeMenu'))}}
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<<<<<<< HEAD
	        <h4 class="modal-title" id="myModalLabel">Add More Menus</h4>
=======
	        <h4 class="modal-title" id="AddMenuLabel">メニュー追加</h4>
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
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
	      {{Form::submit('Save',['class'=>'btn btn-primary'])}}
	      </div>
	    </div>
	    {{Form::close()}}
	  </div>
	</div>

	<div class="modal fade" id="AddItem" tabindex="-1" role="dialog" aria-labelledby="AddItem">
	  <div class="modal-dialog" role="document">
	    {{Form::open(array('route'=>'admin.menus.storeitem','files'=>true))}}
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="AddItemTitle">項目追加</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="col-md-4" align="left">
                <img class="new_img" src="{{url('/')}}/assets/backend/images/wall.jpg" width="100%">
                <button class="btn_upload_img create" type="button"><i class="fa fa-picture-o" aria-hidden="true"></i> 画像アップロード</button>
                {!! Form::file('image_create',['class'=>'btn_upload_ipt create', 'hidden', 'type' => 'button', 'id' => 'image_create']) !!}
            </div>
            <div class="col-md-8" align="left">
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
	{{Html::script(env('ASSETS_BACKEND').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/bootstrap.min.js')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/switch/lc_switch.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/switch/lc_switch.css')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/swiper/swiper.jquery.min.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/swiper/swiper.min.css')}}

	<!-- TOOL TIPs -->
	{{Html::script(env('ASSETS_BACKEND').'/js/tooltip/tooltipster.bundle.min.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/tooltip/tooltipster.bundle.min.css')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/script.js')}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.lcs_check').lc_switch();
			var category_idx = 0;
			var page = 0;
			var categorySwiper = new Swiper('.control-nav-preview .swiper-container', {
	            speed: 400,
	            spaceBetween: 0,
	            slidesPerView: 1,
	            nextButton: '.control-nav-preview .swiper-button-next',
	            prevButton: '.control-nav-preview .swiper-button-prev',
	            onSlideNextStart : function(swiper) {
	            	++category_idx;
	            	page = 0;
					$.ajax({
			              url: "/admin/menus/nextcat",
			              data: {cat: category_idx, page: page}
			            }).done(function(data) {
			              console.log(data);
			            $('.wrapper-content').html(data);
			            
			        });
			        $.ajax({
			              url: "/admin/menus/nextpreview",
			              data: {cat: category_idx, page: page}
			            }).done(function(data) {
			              console.log(data);
			            $('.content-preview').html(data);
			            
			        });
				},
				onSlidePrevStart : function(swiper) {
					--category_idx;
					page = 0;
					$.ajax({
			              url: "/admin/menus/nextcat",
			              data: {cat: category_idx, page: page}
			            }).done(function(data) {
			              console.log(data);
			            $('.wrapper-content').html(data);
			        });
			        $.ajax({
			              url: "/admin/menus/nextpreview",
			              data: {cat: category_idx, page: page}
			            }).done(function(data) {
			              console.log(data);
			            $('.content-preview').html(data);
			            
			        });
				}
	        });

	       	$('.btn_upload_img.create').click(function(){
	           $('.btn_upload_ipt.create').click();
	        });

<<<<<<< HEAD
	        $('.tooltip-menu').tooltipster({
	        	side: ['right','left','top']
			});
=======

			function readURL(input) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();

			        reader.onload = function (e) {
			            $('.new_img').attr('src', e.target.result);
			        }

			        reader.readAsDataURL(input.files[0]);
			    }
			}
			$("#image_create").change(function(){
			    readURL(this);
			});

			$('.wrapper-content').on('click', '.view-more-btn', function(event) {
		        $.ajax({
		              url: "/admin/menus/view_more",
		              data: {cat: category_idx, page: ++page}
		            }).done(function(data) {
		              console.log(data);
		            $('.view-more-btn').remove();
		            $('.wrapper-content').append(data);
		        });
		    });
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
		})
	</script>
@stop