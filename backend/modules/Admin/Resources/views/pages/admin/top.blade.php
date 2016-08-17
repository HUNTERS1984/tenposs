@extends('admin::layouts.default')

@section('title', 'Top')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">Top</h1>
				</div>
				<div class="right-topbar">
					<a href="#" class="btn-me btn-topbar">スタの新</a>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/nav-icon.png"  alt=""></a>
									<h2 class="title-prview">Global Work</h2>
								</div>
								<div class="banner-preview">
									<img src="{{asset(env('ASSETS_BACKEND'))}}/images/banner-prview.jpg" class="img-responsive" alt="">
								</div>
								<div class="content-preview">
									<p class="title-top-preview">
										Recently
									</p>
									<div class="row-me clearfix">
										<div class="each-top">
											<img src="{{asset(env('ASSETS_BACKEND'))}}/images/h1.jpg" class="img-responsive " alt="">
											<p class="name">Product 1</p>
											<p class="price">10$</p>
										</div>
										<div class="each-top">
											<img src="{{asset(env('ASSETS_BACKEND'))}}/images/h1.jpg" class="img-responsive " alt="">
											<p class="name">Product 1</p>
											<p class="price">10$</p>
										</div>
										<div class="each-top">
											<img src="{{asset(env('ASSETS_BACKEND'))}}/images/h1.jpg" class="img-responsive " alt="">
											<p class="name">Product 1</p>
											<p class="price">10$</p>
										</div>
										<div class="each-top">
											<img src="{{asset(env('ASSETS_BACKEND'))}}/images/h1.jpg" class="img-responsive " alt="">
											<p class="name">Product 1</p>
											<p class="price">10$</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="wrapper-content">
							<form action="" method="" class="formCommon">
								<div class="form-group margin-bottom">
									<label for="">スタの新</label>
									<select name="" class="select1" >
										<option value="">スタの新 1</option>
										<option value="">スタの新 2</option>
									</select>
									<a href="javascript:avoid()" class="note">+ スタの新スタの新</a>
								</div>
								<div class="form-group clearfix">
									<label for="">スタの新 スタの新</label>
									<div class="wrap-table">
										<div class="wrap-transfer col">
											<p class="title-form">スタの新</p>
											<ul class="nav-left from-nav">
												<li>TEST 1</li>
												<li>TEST 2</li>
												<li>TEST 3</li>
											</ul>
										</div>
										<div class="wrap-btn-control col">
											<a href="javascript:moveTo('from-nav','to-nav')" ><span class="glyphicon glyphicon-triangle-right"></span></a>
											<a href="javascript:moveTo('to-nav','from-nav')" ><span class="glyphicon glyphicon-triangle-left"></span></a>
										</div>
										<div class="wrap-transfer col">
											<p class="title-form">スタの新</p>
											<ul class="nav-right to-nav">
											</ul>
										</div>
									</div>
								</div>
							</form>
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

			$('.nav-left, .nav-right').on('click','li',function(){
				$(this).toggleClass('selected');
			});

		})
		function moveTo(from,to){
			$('ul.'+from+' li.selected').remove().appendTo('ul.'+to);
			$('.'+to+' li').removeAttr('class');
		}
	</script>
@stop