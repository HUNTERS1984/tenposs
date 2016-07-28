@extends('layouts.default')

@section('title', 'News')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<div class="left-topbar">
					<h1 class="title">News</h1>
				</div>
				<div class="right-topbar">
					 <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
					<a href="#" class="btn-me btn-topbar">スタの新</a>
				</div>
			</div>
		</div>	
		<!-- END -->

		<div class="main-content news">
			<div class="wrap-btn-content">
				<a href="#" class="btn-me btn-hong">スタの新着情報</a>
				<a href="#" class="btn-me btn-xanhduongnhat">スタの新着情報 2</a>
			</div>	<!-- end wrap-btn-content-->
			<div class="wrapper-content">
				<div class="each-coupon each-item clearfix">
					<img src="{{asset(env('PATH_ASSETS'))}}/images/wall.jpg" class="img-responsive" alt="">
					<div class="main-title">
						<h2>Lorem ipsum dolor sit amet,</h2>
						<p>Lorem ipsum dolor </p>
						<a href="#" class="btn-me btn-each-item">スタの新</a>
					</div>
					<div class="container-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae, iste voluptates quam dolor esse doloribus doloremque modi, et nobis laborum quasi reprehenderit reiciendis voluptatibus quaerat earum ipsum asperiores at dignissimos?</p>
					</div>
				</div>

			</div>	<!-- wrap-content-->
		</div>
		<!-- END -->
	</div>	<!-- end main-content-->
@stop

@section('script')
	{{Html::script(env('PATH_ASSETS').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('PATH_ASSETS').'/js/bootstrap.min.js')}}

	{{Html::script(env('PATH_ASSETS').'/js/switch/lc_switch.js')}}
	{{Html::style(env('PATH_ASSETS').'/js/switch/lc_switch.css')}}

	{{Html::script(env('PATH_ASSETS').'/js/script.js')}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.lcs_check').lc_switch();
		})
	</script>
@stop