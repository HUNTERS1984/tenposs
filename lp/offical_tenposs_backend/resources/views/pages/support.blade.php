@extends('layouts.default')

@section('title','SUPPORT')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/support.css')}}
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
							<li class="active"><a href="#"> サポート</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="support">
				<div class="is-table-cell">
					<h1 class="title-page">Support</h1>
					<p class="sub-title-page">-　サポート　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section search-support-section bg-blue">
			<div class="container">
				<form action="" method="" class="formSearchSupport">
					<div class="form-search">
						<span class="icon"><span class="glyphicon glyphicon-search btn-lg"></span></span>
						<input type="text" name="keyword" class="form-control">
					</div>
				</form>
			</div>

		</div>

		<div class="section support-section">
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="each-support">
								<h3 class="title-support">はじめての使い方ガイド</h3>
								<div class="form-group">
									<select name="select1" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
								<div class="form-group">
									<select name="select2" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
								<div class="form-group">
									<select name="select3" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="each-support">
								<h3 class="title-support">ナレッジ</h3>
								<div class="form-group">
									<select name="select1" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
								<div class="form-group">
									<select name="select2" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
								<div class="form-group">
									<select name="select3" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="each-support">
								<h3 class="title-support">コミニュティ</h3>
								<div class="form-group">
									<select name="select1" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
								<div class="form-group">
									<select name="select2" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
								<div class="form-group">
									<select name="select3" id="">
										<option value="">テキストが入ります</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	<!-- end content section -->
		</div>
		<!-- END CONTACT -->

		@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop