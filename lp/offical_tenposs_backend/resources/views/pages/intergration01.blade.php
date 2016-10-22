@extends('layouts.default')

@section('title','INTERGRATION')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/intergration.css')}}
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
								<li class="active"><a href="#">tenposs連携アプリ</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="intergration">
					<div class="is-table-cell">
						<h1 class="title-page">Integrations</h1>
						<p class="sub-title-page">-　連携アプリ　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section intergration-section">
				<h2 class="title-section">tenposs 連携アプリ</h2>
				<div class="content-section">
					<div class="container">
						<h3 class="title-intergra">Coming soon</h3>
						<a href="#" class="btn-me btn-xanhduong">お問い合わせ</a>
						<p class="text">前のページへ戻る</p>
					</div>
				</div>	<!-- end content section -->
			</div>
			<!-- END CONTACT -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop