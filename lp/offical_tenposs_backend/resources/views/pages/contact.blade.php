@extends('layouts.default')

@section('title','Contact')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/contact.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	{{Html::script(asset('assets/frontend').'/js/jquery.validate.min.js')}}
	<script>
	$(document).ready(function(){

		$('.form-section').addClass('invisible').viewportChecker({
			classToAdd: 'visible animated slideInLeft',
			offset : 150,
		})

		$('.formContact').validate({
			rules:{
				'company' : 'required',
				'bussiness' : 'required',
				'fullname' : 'required',
				'nickname' : 'required',
				'phone' : 'required',
				'email' : {
					'required': true,
					'email': true
				},
				'reason':'required'
			}
		})
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
							<li class="active"><a href="#">お問い合わせ</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="contact">
				<div class="is-table-cell">
					<h1 class="title-page">Contact</h1>
					<p class="sub-title-page">-　お問い合わせ　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section form-section">
			<h2 class="title-section">少しでも興味のある方は、こちらからご気軽にお問い合わせ下さい。</h2>
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="wrap-form-contact">
								@if(Session::has('mess'))
									<h2 class="title-thanks">{{Session::get('mess')}}</h2>
								@endif
								@if($errors->any())
								<div class="alert alert-danger">
									<ul style="padding-left:15px;">
										@foreach($errors->all() as $error)
										<li>{!! $error!!}</li>
										@endforeach
									</ul>
								</div>
								@endif
								<form action="{{route('postContact')}}" class="formContact" method="POST">
									{{Form::token()}}
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="company">店名/会社名</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<input type="text" name="company" class="form-control" placeholder="例）　株式会社HUNTERS">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="bussiness">業種</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<input type="text" name="bussiness" class="form-control" placeholder="例）　アパレル">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="fullname">名前</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<input type="text" name="fullname" class="form-control" placeholder="例）　山田 太郎">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="nickname">名前（フリガナ）</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<input type="text" name="nickname" class="form-control" placeholder="例）　ヤマダ タロウ">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="phone">電話番号</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<input type="text" name="phone" class="form-control" placeholder="例）　03-1234-5678">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="email">メールアドレス　</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<input type="text" name="email" class="form-control" placeholder="例）　example@example.com">
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="left-form">
											<label for="reason">OLOを利用したい理由</label>
											<span class="require-form">必須</span>
										</div>
										<div class="right-form">
											<select name="reason" class="form-control">
												<option value="新規顧客開拓">新規顧客開拓 1</option>
												<option value="新規顧客開拓">新規顧客開拓 2</option>
												<option value="新規顧客開拓">新規顧客開拓 3</option>
											</select>
										</div>
									</div>

									<div class="form-group clearfix">
										<div class="right-form">
											<textarea name="message" class="form-control" rows="5"></textarea>
										</div>
									</div>
									<div class="form-group text-note">
										<p class="note-form"><a href="{{url('policy')}}" target="_blank">利用規約</a> の内容をご確認・ご同意された上で</p>
									</div>
									<div class="form-group text-center">
										<input type="submit" value="送信する" class="btn-me btn-submit">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>	<!-- end content section -->
		</div>
		<!-- END CONTACT -->

		@include('layouts.contact-section')
		<!-- END CONTACT -->
	</div>
	<!-- END MIDDLE -->
@stop