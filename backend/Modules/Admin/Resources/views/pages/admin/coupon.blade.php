@extends('admin::layouts.default')

@section('title', 'Coupon')

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

		<div class="main-content coupon">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/nav-icon.png"  alt=""></a>
									<h2 class="title-prview">Coupon</h2>
								</div>
								<div class="content-preview">
									<div class="each-coupon clearfix">
										<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive img-prview">
										<div class="inner-preview">
											<p class="title-inner" style="font-size:9px; color:#14b4d2">スタの新着情報</p>
											<p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p>
											<p class="text-inner" style="font-size:9px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
										</div>
									</div>

									<div class="each-coupon clearfix">
										<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive img-prview">
										<div class="inner-preview">
											<p class="title-inner" style="font-size:9px; color:#14b4d2">スタの新着情報</p>
											<p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p>
											<p class="text-inner" style="font-size:9px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
										</div>
									</div>
									<div class="each-coupon clearfix">
										<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive img-prview">
										<div class="inner-preview">
											<p class="title-inner" style="font-size:9px; color:#14b4d2">スタの新着情報</p>
											<p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p>
											<p class="text-inner" style="font-size:9px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
										</div>
									</div>
									<div class="each-coupon clearfix">
										<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive img-prview">
										<div class="inner-preview">
											<p class="title-inner" style="font-size:9px; color:#14b4d2">スタの新着情報</p>
											<p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p>
											<p class="text-inner" style="font-size:9px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
										</div>
									</div>
									<div class="each-coupon clearfix">
										<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive img-prview">
										<div class="inner-preview">
											<p class="title-inner" style="font-size:9px; color:#14b4d2">スタの新着情報</p>
											<p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p>
											<p class="text-inner" style="font-size:9px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
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
						<div class="wrapper-content">
							<div class="each-coupon each-item clearfix">
								<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive" alt="">
								<div class="main-title">
									<h2>Lorem ipsum dolor sit amet,</h2>
									<p>Lorem ipsum dolor </p>
									<a href="#" class="btn-me btn-each-item">スタの新</a>
								</div>
								<p class="time">10:30 2016/03/23</p>
								<div class="container-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, iste voluptates quam dolor esse doloribus doloremque modi, et nobis laborum quasi reprehenderit reiciendis voluptatibus quaerat earum ipsum asperiores at dignissimos?</p>
								</div>
							</div>

							<div class="each-coupon each-item clearfix">
								<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive" alt="">
								<div class="main-title">
									<h2>Lorem ipsum dolor sit amet,</h2>
									<p>Lorem ipsum dolor </p>
									<a href="#" class="btn-me btn-each-item">スタの新</a>
								</div>
								<p class="time">10:30 2016/03/23</p>
								<div class="container-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, iste voluptates quam dolor esse doloribus doloremque modi, et nobis laborum quasi reprehenderit reiciendis voluptatibus quaerat earum ipsum asperiores at dignissimos?</p>
								</div>
							</div>

							<div class="each-coupon each-item clearfix">
								<img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive" alt="">
								<div class="main-title">
									<h2>Lorem ipsum dolor sit amet,</h2>
									<p>Lorem ipsum dolor </p>
									<a href="#" class="btn-me btn-each-item">スタの新</a>
								</div>
								<p class="time">10:30 2016/03/23</p>
								<div class="container-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, iste voluptates quam dolor esse doloribus doloremque modi, et nobis laborum quasi reprehenderit reiciendis voluptatibus quaerat earum ipsum asperiores at dignissimos?</p>
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
	{{Html::script(env('ASSETS_BACKEND').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/bootstrap.min.js')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/switch/lc_switch.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/switch/lc_switch.css')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/script.js')}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.lcs_check').lc_switch();
		})
	</script>
@stop