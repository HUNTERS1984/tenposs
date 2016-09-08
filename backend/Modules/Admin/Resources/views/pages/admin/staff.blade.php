@extends('admin::layouts.default')

@section('title', 'Staff')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">Coupon</h1>
				</div>
				<div class="right-topbar">
					 <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
					<a href="#" class="btn-me btn-topbar">スタの新</a>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content staff">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="/assets/backend/images/nav-icon.png"  alt=""></a>
									<h2 class="title-prview">Staff</h2>
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
										<div class="col-xs-4 padding-me">
											<div class="each-staff">
												<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="">
											</div>
										</div>
										<div class="col-xs-4 padding-me">
											<div class="each-staff">
												<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="">
											</div>
										</div>
										<div class="col-xs-4 padding-me">
											<div class="each-staff">
												<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="">
											</div>
										</div>
										<div class="col-xs-4 padding-me">
											<div class="each-staff">
												<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="">
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-8">
						<div class="wrap-btn-content">
							<a href="#" class="btn-me btn-hong">スタの新着情報</a>
							<a href="#" class="btn-me btn-xanhduongnhat">スタの新着情報 2</a>
						</div>	<!-- end wrap-btn-content-->
						<div class="wrapper-content clearfix">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-4">
										<div class="each-menu each-common-pr">
											<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="Product">
											<a href="#" class="btn-me btn-menu">スタの</a>
										</div>
									</div>
									<div class="col-xs-4">
										<div class="each-menu each-common-pr">
											<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="Product">
											<a href="#" class="btn-me btn-menu">スタの</a>
										</div>
									</div>
									<div class="col-xs-4">
										<div class="each-menu each-common-pr">
											<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="Product">
											<a href="#" class="btn-me btn-menu">スタの</a>
										</div>
									</div>
									<div class="col-xs-4">
										<div class="each-menu each-common-pr">
											<img src="/assets/backend/images/wall.jpg" class="img-responsive" alt="Product">
											<a href="#" class="btn-me btn-menu">スタの</a>
										</div>
									</div>
								</div>
							</div>


						</div>	<!-- wrap-content-->
					</div>
				</div>
			</div>

		</div>
		<!-- END -->
	</div>	<!-- end main-content-->
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