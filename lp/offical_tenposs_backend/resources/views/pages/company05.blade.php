@extends('layouts.default')

@section('title','Company')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/company.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
@stop

@section('content')
	<div class="middle page">
		<div class="static-banner">
			<div class="breadcrum">
				<div class="container">
					<div class="row">
						<ul class="breadcrum-me">
							<li><a href="javascript:avoid()">Top</a></li>
							<li class="active"><a href="#">運営会社</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="company">
				<div class="is-table-cell">
					<h1 class="title-page">Company</h1>
					<p class="sub-title-page">-　運営会社　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section company-section company05">
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="wrap-tab">
								<ul class="tab-company">
									<li ><a href="{{url('company01')}}">会社概要</a></li>
									<li><a href="{{url('company02')}}">HUNTERS.Co.Ltdについて</a></li>
									<li><a href="{{url('company03')}}">tenpossのはじまり</a></li>
									<li><a href="{{url('company04-01')}}">tenpossチーム</a></li>
									<li class="active"><a href="{{url('company05')}}">tenpossブランド資産</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="wrap-top">
								<h3 class="title-company">tenposs チーム</h3>
								<div class="container-bg">
									<div class="is-table-cell">
										<p>わたしたちHUNTERS株式会社は、事業者さまに繁盛をお客さまに感動を
新しい未来へ創造を世界中にインパクトを全サービスで提供します。</p>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="howto">
								<h3 class="title-howto">THIS IS HOW YOU WRITE IT.</h3>
								<img src="{{asset('assets/frontend')}}/img/company/sub/company-sub-04.png" class="img-responsive" alt="">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="wrap-logo">
								<h3 class="title-logo">LOGO</h3>
								<p class="sub-logo">私たちは、tenpossのロゴの2つのバージョンを提供します。</p>
								<div class="container-logo clearfix">
									<div class="left">
										<img src="{{asset('assets/frontend')}}/img/company/sub/company-sub-03.png" class="img-responsive" alt="">

										<div class="wrap-btn">
											<a href="#" class="btn-download">ai</a>
											<a href="#" class="btn-download last">png</a>
										</div>
									</div>
									<div class="right">
										<img src="{{asset('assets/frontend')}}/img/company/sub/company-sub-02.png" class="img-responsive" alt="">

										<div class="wrap-btn">
											<a href="#" class="btn-download">ai</a>
											<a href="#" class="btn-download last">png</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>

				</div>
			</div>	<!-- end content section -->
		</div>
		<!-- END COMPANY -->

		@include('layouts.contact-section')
		<!-- END CONTACT -->
	</div>
	<!-- END MIDDLE -->
@stop