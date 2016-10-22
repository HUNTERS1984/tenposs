@extends('layouts.default')

@section('title','INTRODUCTION CASE')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/introcase.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	
	<script>
		$(document).ready(function(){
			setAnimation('.wrap-img-right');
			setAnimation('.box-intro-small');
		});
	</script>
@stop

@section('content')
	<div class="middle page">
			<div class="static-banner">
				<div class="breadcrum">
					<div class="container">
						<div class="row">
							<ul class="breadcrum-me">
								<li><a href="javascript:avoid()">Top</a></li>
								<li class="active"><a href="#">お客様ストーリー・導入事例</a></li>

							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner bg-blue" id="introcase02">
					<div class="is-table-cell">
						<div class="container">
						<div class="left-banner">
							<img src="{{asset('assets/frontend')}}/img/introduction/introcase02-02.png" class="img-responsive" alt="">
						</div>
						<div class="right-banner">
							<p class="text-right-banner">“  テキストが入りますテキストが入りますテキストが
入りますテキストが入りますテキストが入ります ”</p>
							<p class="normal-text">店名が入ります</p>
							<p class="normal-text">オーナー　名前が入ります</p>
							<div class="wrap-title">
								<p class="des"><b>業種</b>  ：  飲食店</p>
								<p class="des"><b>導入前の課題</b>  ：  テキストが入りますテキストが入りますテキストが入ります</p>
								<p class="des"><b>導入後の効果</b>  ：  テキストが入りますテキストが入りますテキストが入ります</p>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section introcase02-section">
				<div class="content-section">
					<div class="container">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<div class="box-intro-big">
									<img src="{{asset('assets/frontend')}}/img/introduction/introductioncase-banner-02.png" class="img-responsive" alt="">
									<p>テキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入りますテキストが入ります</p>
									<div class="wrap-social text-right">

									</div>
								</div>

								<div class="box-intro-small clearfix">
									<div class="left">
										<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introductioncase-02-01.png" class="img-responsive visible-sm visible-xs" alt="">
										<h3 class="title-intro-small">テキストが入ります</h3>
										<p>テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります</p>
									</div>
									<div class="right hidden-xs hidden-sm">
										<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introductioncase-02-01.png" class="img-responsive" alt="">
									</div>
								</div>	<!-- end box-intro-small -->

								<div class="box-intro-small im-left clearfix last">
									<div class="left">
										<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introductioncase-02-01.png" class="img-responsive" alt="">
									</div>
									<div class="right">
										<h3 class="title-intro-small">テキストが入ります</h3>
										<p>テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入ります </p>
									</div>
								</div> <!-- end box-intro-small -->

							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 text-center">
								<img src="{{asset('assets/frontend')}}/img/introduction/introductioncase-arrow.png" class="img-responsive arrow"  alt="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introductioncase-02-02.png" class="img-responsive ic-block" alt="">
							</div>
							<div class="col-md-6">
								<div class="wrap-img-right">
									<div class="block-img-right">
										<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introductioncase-02-03.png" alt="">
										<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introductioncase-02-04.png" alt="">
									</div>
									<p class="link">スマホサイト：　<a href="#">http://www.example.com</a></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="line"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="wrap-final">
									<h3 class="title-bot">他の業種を選択する</h3>
									<select id="selectBot">
										<option value="">け・レ</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END INTRO CASE -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop