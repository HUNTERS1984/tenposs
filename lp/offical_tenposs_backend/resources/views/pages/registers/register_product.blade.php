@extends('layouts.default')

@section('title','Agree')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/agree.css')}}
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
								<li class="active"><a href="#">プライバシーポリシー</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="agree">
					<div class="is-table-cell">
						<h1 class="title-page">Privacy Policy</h1>
						<p class="sub-title-page">-　プライバシーポリシー　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section search-section">
				<h2 class="title-section">tenposs プライバシーポリシー</h2>
				<div class="container">
					
				</div>
			</div>
			<!-- END SEARCH -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop