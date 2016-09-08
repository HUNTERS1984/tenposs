@extends('admin::layouts.default')

<<<<<<< HEAD
@section('title', 'Edit Item')
=======
@section('title', 'メニュー')
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe

@section('content')
<div class="content">
		{{Form::model($item,array('route'=>array('admin.menus.update',$item->id),'files'=>true,'method'=>'PUT') )}}
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
<<<<<<< HEAD
					<h1 class="title">Edit Item</h1>
				</div>
				<div class="right-topbar">
					 <!-- <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span> -->
					<!-- <a href="javascript:avoid()" class="btn-me btn-topbar">スタの新着情報</a> -->
					<input type="submit" class="btn-me btn-topbar" value="Save">
=======
					<h1 class="title">メニュー</h1>
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
				</div>
			</div>
		</div>

<<<<<<< HEAD
		<div class="main-content photography">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/nav-icon.png"  alt=""></a>
									<h2 class="title-prview">Items</h2>
								</div>
								<div class="control-nav-preview">
									<!-- Slider main container -->
		                            <div class="swiper-container">
		                                <!-- Additional required wrapper -->
		                                <div class="swiper-wrapper">
		                                    <!-- Slides -->
		                                    <div class="swiper-slide">Spring</div>
		                                    <div class="swiper-slide">Summer</div>
		                                </div>

		                                <!-- If we need navigation buttons -->
		                                <div class="swiper-button-prev"></div>
		                                <div class="swiper-button-next"></div>
		                            </div>
								</div>
								<div class="content-preview clearfix">
									<div class="row-me fixHeight">
										@if($item_thumbs->isEmpty())
											No Data
										@else
											@foreach($item_thumbs as $item_thumb)
											<div class="col-xs-4 padding-me">
												<div class="each-staff">
													<img src="{{asset($item_thumb->image_url)}}" class="img-responsive" alt="Product">
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
						<div class="wrapper-content clearfix">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											{{Form::hidden('img_bk',$item->image_url)}}
												<div class="wrap-img-preview">
													<img src="{{asset($item->image_url)}}" class="img-responsive" alt="">
												</div>
											{{Form::file('img')}}
											@include('admin::errors.listError')
										</div>
										<div class="form-group">
											<label for="coupon_id">Coupon</label>
											{{Form::select('coupon_id',$list_coupons,$item->coupon_id,array('class'=>'form-control') )}}
										</div>
										<div class="form-group">
											<label for="title">Title</label>
											{{Form::text('title',$item->title, array('class'=>'form-control') )}}
										</div>
										<div class="form-group">
											<label for="price">Price</label>
											{{Form::text('price',$item->price, array('class'=>'form-control') )}}
										</div>
										<div class="form-group">
											<label for="description">Description</label>
											{{Form::textarea('description',$item->description,array('class'=>'form-control'))}}
										</div>
										<div class="form-group">
											<label for="menu">Select menu</label>
											<div class="container-fluid">
													<div class="row">
													@foreach($menus as $menu)
														<div class="col-xs-4">
															<p>{{Form::checkbox('menu_id[]',$menu->id,in_array($menu->id,$data_menu)? true : false )}} {{$menu->name}}</p>
														</div>
													@endforeach
											</div>
												</div>
										</div>
										
									</div>
=======
		<div class="main-content news">
			@include('admin::layouts.message')
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-8">
						
						<div class="wrapper-content">
							{{Form::model($item,array('route'=>array('admin.menus.update',$item->id),'method'=>'PUT','files'=>true))}}
								<div class="form-group">
									<img class="edit_img" src="{{asset($item->image_url)}}" width="100%">
									<button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o" aria-hidden="true"></i>画像アップロード</button>
                					{!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
								</div>
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
								<div class="form-group">
									{{Form::submit('保存',array('class'=>'btn btn-primary'))}}
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
								</div>
							</div>
						</div>	<!-- wrap-content-->
					</div>
				</div>
			</div>

		</div>
		{{Form::close()}}
</div>
@stop

@section('script')
	{{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
	{{Html::script('assets/backend/js/bootstrap.min.js')}}

	{{Html::script('assets/backend/js/switch/lc_switch.js')}}
	{{Html::style('assets/backend/js/switch/lc_switch.css')}}

	{{Html::script('assets/backend/js/swiper/swiper.jquery.min.js')}}
	{{Html::style('assets/backend/js/swiper/swiper.min.css')}}

	{{Html::script('assets/backend/js/script.js')}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.lcs_check').lc_switch();

			var categorySwiper = new Swiper('.control-nav-preview .swiper-container', {
	            speed: 400,
	            spaceBetween: 0,
	            slidesPerView: 1,
	            nextButton: '.control-nav-preview .swiper-button-next',
	            prevButton: '.control-nav-preview .swiper-button-prev'
	        });

	        $('.btn_upload_img.edit').click(function(){
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

			$("#image_edit").change(function(){
			    readURL(this);
			});
		})
	</script>
@stop