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
			<h2 class="title-section">tenposs 連携アプリ</h2>
			<div class="content-section">
				<div class="container">
					<div class="row">
						@if(!$data->isEmpty())
							@foreach($data as $item)
							<div class="each-intergration02 clearfix">
								<div class="col-md-3">
									<a href="{{route('intergration02.detail',[$item->id, $item->slug])}}"><img src="{{$item->img_url}}" alt=""></a>
								</div>
								<div class="col-md-9">
									<div class="left">
										<a href="{{route('intergration02.detail',[$item->id, $item->slug])}}"><h3 class="title-inter">{{$item->title}}</h3></a>
										<p>{{Str::words($item->content,30)}}</p>
									</div>
								</div>
							</div>
							@endforeach
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