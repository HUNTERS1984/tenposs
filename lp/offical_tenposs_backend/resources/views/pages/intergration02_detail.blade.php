@extends('layouts.default')

@section('title','INTERGRATION')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/intergration.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	<script>
	$(document).ready(function(){
		setAnimation('.function-top-section');
		setAnimation('.each-bottom');
	})
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

		<div class="section intergration02-section">
			<div class="content-section">
				<div class="container">
					<div class="row">
						@if($data)
							<div class="col-sm-12">
								<div class="wrap-main-detail">
									<h2 class="title">{{$data->title}}</h2>
									<img src="{{$data->img_url}}" alt="">
									<div class="content">
										<p>{{$data->content}}</p>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>	<!-- end content section -->
		</div>
		<!-- END CONTACT -->

		@include('layouts.contact-section')
	</div>
	<!-- END MIDDLE -->
@stop