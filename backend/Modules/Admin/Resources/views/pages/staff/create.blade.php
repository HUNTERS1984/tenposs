@extends('admin::layouts.default')

@section('title', 'スタッフ')

@section('content')
<div class="content">
		{{Form::open(array('route'=>'admin.staff.store', 'files'=>true))}}
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">スタッフ</h1>
				</div>
				<div class="right-topbar">
					 <!-- <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span> -->
					<!-- <a href="javascript:avoid()" class="btn-me btn-topbar">スタの新着情報</a> -->
					<input type="submit" class="btn-me btn-topbar" value="Save">
				</div>
			</div>
		</div>

		<div class="main-content photography">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="/assets/backend/images/nav-icon.png"  alt=""></a>
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
										@if($staff_thumbs->isEmpty())
											No Data
										@else
											@foreach($staff_thumbs as $item_thumb)
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
										{{--<div class="form-group">--}}
											{{--<label for="coupon_id">Coupon</label>--}}
											{{--{{Form::select('coupon_id',$list_coupons,old('coupon_id'),array('class'=>'form-control') )}}--}}
										{{--</div>--}}
										<div class="form-group">
											<label for="title">Title</label>
											{{Form::text('title',old('title'), array('class'=>'form-control') )}}
										</div>
										<div class="form-group">
											<label for="price">Price</label>
											{{Form::text('price',old('price'), array('class'=>'form-control') )}}
										</div>
										<div class="form-group">
											<label for="description">Description</label>
											{{Form::textarea('description',old('description'),array('class'=>'form-control'))}}
										</div>
										<div class="form-group">
											<label for="menu">Select menu</label>
											<div class="container-fluid">
													<div class="row">
													@foreach($staff_cat as $item)
														<div class="col-xs-4">
															<p>{{Form::checkbox('menu_id[]',$item->id)}} {{$item->name}}</p>
														</div>
													@endforeach
											</div>
												</div>
										</div>
										<div class="form-group">
											{{Form::file('img')}}
										</div>
									</div>
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
		})
	</script>
@stop