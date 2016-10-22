@extends('layouts.default')

@section('title','START GUIDE')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/startguide.css')}}
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
							<li class="active"><a href="#">スタートガイド</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="startguide">
				<div class="is-table-cell">
					<h1 class="title-page">Start Guide</h1>
					<p class="sub-title-page">-　スタートガイド　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section guide-section">
			<h2 class="title-section">今すぐスタートするための、tenposs 使い方ガイド</h2>
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="each-guide">
								<a href="#"><img src="{{asset('assets/frontend')}}/img/startguide/tenposs-startguide-03.png" alt=""></a>
								<h3 class="title-guide"><a href="#">テキストが入ります</a></h3>
								<p><a href="#">テキストが入りますテキストが入ります テキストが入りますテキストが入ります</a></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="each-guide">
								<a href="#"><img src="{{asset('assets/frontend')}}/img/startguide/tenposs-startguide-03.png" alt=""></a>
								<h3 class="title-guide"><a href="#">テキストが入ります</a></h3>
								<p><a href="#">テキストが入りますテキストが入ります テキストが入りますテキストが入ります</a></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="each-guide">
								<a href="#"><img src="{{asset('assets/frontend')}}/img/startguide/tenposs-startguide-03.png" alt=""></a>
								<h3 class="title-guide"><a href="#">テキストが入ります</a></h3>
								<p><a href="#">テキストが入りますテキストが入ります テキストが入りますテキストが入ります</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END SEARCH -->

		@include('layouts.contact-section')
	</div>
	<!-- END MIDDLE -->
@stop