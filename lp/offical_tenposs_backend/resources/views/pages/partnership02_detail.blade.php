@extends('layouts.default')

@section('title','PARTNERSHIP')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/partnership.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	{{Html::script(asset('assets/frontend').'/js/jquery.matchHeight-min.js')}}
	<script>
		$('.each-partner').matchHeight();
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
								<li class="active"><a href="#">公認パートナー</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="partnership">
					<div class="is-table-cell">
						<h1 class="title-page">Partner Ship</h1>
						<p class="sub-title-page">-　公認パートナー　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section parnert01-section">

				<div class="content-section">
					<div class="container">
						<p class="content-partner">私たちは、お客様に最高の体験をしていただくために、優れた技術的スキルや深い製品知識もつ 世界中のパートナーとチームを組んでいます。コンサルティング、技術的サポート、カスタム開発をはじめ、tenpossでのあらゆるサービスに関して、豊富な知識を持ったtenposs公認パートナーへご相談ください。</p>
						<div class="row">
							@if($data)
								<div class="col-sm-12">
									<div class="wrap-main-detail">
										<img src="{{$data->img_url}}" alt="">
										<h2 class="title">{{$data->title}}</h2>	
										<div class="content">
											<p>{{$data->content}}</p>
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
			<!-- END SEARCH -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop