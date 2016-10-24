@extends('layouts.default')

@section('title','Demo')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/demo.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	<script>
	$(document).ready(function(){

		$('.form-section').addClass('invisible').viewportChecker({
			classToAdd: 'visible animated slideInLeft',
			offset : 150,
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
							<li class="active"><a href="#">デモを見る</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="fee">
				<div class="is-table-cell">
					<h1 class="title-page">Fee</h1>
					<p class="sub-title-page">-　価格　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section demo-top-section bg-blue">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="container-top-demo">
						<h3 class="title-top">デモを体験する</h3>
						<p class="sub-top">機能を体験して頂けるデモアプリ・サイト・管理画面をご用意しております。</p>

						<div class="wrap-form">
							<form action="" method="" class="formTop">
								<div class="left">
									<input type="text" name="" class="form-control" placeholder="info@tenposs.com">
								</div>
								<div class="right">
									<input type="button" class="btn-button" value="申込み（無料）">
								</div>
							</form>
						</div>
					</div>
					</div>
				</div>
				
			</div>
		</div>
		<!-- END DEMO TOP -->

		<div class="section demo-section">
		<h2 class="title-section">価格表</h2>
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="wrap-table">
								<table class="table-fee fee1" border="0" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th colspan="2">お試しプラン</th>
										</tr>
									</thead>
									<tbody>
									<tr>
										<td class="wrap-td">
											<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tb-wrap">
												<tr>
													<td width="30%">
														<p class="title">価格</p>
													</td>
													<td width="70%">
														<p class="content">
															<span class="font32">0 円</span>
														</p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">月額</p>
													</td>
													<td>
														<p class="content"><span class="font32">0 円</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">納期</p>
													</td>
													<td>
														<p class="content"><span class="font24">着手日より３営業日〜</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">支給データ</p>
													</td>
													<td>
														<p class="content"><span class="font24">ロゴデータ （ai形式）</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">納品物</p>
													</td>
													<td>
														<p class="content">
															<ul>
																<li>スマホサイト<br/>（操作方法・各機能確認用）</li>
																<li>デモアプリ</li>
															</ul>
														</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									</tbody>
								</table>
							</div>
						</div>

						<div class="col-md-4">
							<div class="wrap-table">
								<table class="table-fee fee2" border="0" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th colspan="2">スマホプラン</th>
										</tr>
									</thead>
									<tbody>
									<tr>
										<td class="wrap-td">
											<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tb-wrap">
												<tr>
													<td width="30%">
														<p class="title">価格</p>
													</td>
													<td width="70%">
														<p class="content">
															<span class="font32">80,000 円<small>（税別）</small></span>
														</p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">月額</p>
													</td>
													<td>
														<p class="content"><span class="font32">8,000 円 <small>（税別）</small></span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">納期</p>
													</td>
													<td>
														<p class="content"><span class="font24">着手日より３営業日〜</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">支給データ</p>
													</td>
													<td>
														<p class="content"><span class="font24">ロゴデータ（ai形式）</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">納品物</p>
													</td>
													<td>
														<p class="content">
															<ul>
																<li>スマホサイト</li>
																<li>アプリ（iOS・Android）</li>
															</ul>
														</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									</tbody>
								</table>
							</div>
						</div>

						<div class="col-md-4">
							<div class="wrap-table">
								<table class="table-fee fee3" border="0" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th colspan="2">レスポンシブプラン</th>
										</tr>
									</thead>
									<tbody>
									<tr>
										<td class="wrap-td">
											<table width="100%" cellpadding="0" cellspacing="0" border="0" class="tb-wrap">
												<tr>
													<td width="30%">
														<p class="title">価格</p>
													</td>
													<td width="70%">
														<p class="content">
															<span class="font32">100,000 円 <small>（税別）</small></span>
														</p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">月額</p>
													</td>
													<td>
														<p class="content"><span class="font32">10,000 円 <small>（税別）</small></span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">納期</p>
													</td>
													<td>
														<p class="content"><span class="font24">着手日より３営業日〜</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">支給データ</p>
													</td>
													<td>
														<p class="content"><span class="font24">ロゴデータ （ai形式）</span></p>
													</td>
												</tr>
												<tr>
													<td>
														<p class="title">納品物</p>
													</td>
													<td>
														<p class="content">
															<ul>
																<li>スマホサイト</li>
																<li>レスポンシブサイト</li>
																<li>アプリ（iOS・Android）</li>
															</ul>
														</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END DEMO -->

		<div class="section testimonial-demo-section">
			<h2 class="title-section">導入事例・お客様の声</h2>
			<div class="wrap-testi-slide carousel slide" data-ride="carousel" id="slide-testimonial">
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<div class="container">
							<div class="row">
								<div class="col-md-3">
									<img src="{{asset('assets/frontend')}}/img/top/small-phone.png" class="img-responsive hidden-xs hidden-sm" alt="">
								</div>
								<div class="col-md-9">
									<div class="wrap-top-testi clearfix">
										<div class="wrap-img ">
											<img src="{{asset('assets/frontend')}}/img/top/img-top.png" class="img-responsive " alt=""/>
										</div>
										<div class="wrap-text">
											<span class="line"></span>
											<p class="content">“  テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入りますテ キストが入りますテキストが入りますテキストが入りますテキストが入りますテキ ストが入りますテキストが入りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入りますテキストが入ります  ”</p>
											<p class="sub">店名が入ります　オーナー　<span class="xanh">名前が入ります</span></p>
											<a href="http:///www.example.com" class="link">http:///www.example.com</a>
										</div>
									</div> <!-- end wrap-top-test-->
									<div class="wrap-img-mobile visible-xs visible-sm">
										<img src="{{asset('assets/frontend')}}/img/top/small-phone.png" class="img-responsive" alt="">
									</div>
									<div class="wrap-bottom-testi">
										<div class="row">
											<div class="col-md-6">
												<div class="each-testi">
													<p class="title-testi"><span>→</span>　導入によるメリット</p>
													<p>テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります</p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="each-testi">
													<p class="title-testi"><span>→</span>　効果</p>
													<p>テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="item">
						<div class="container">
							<div class="row">
								<div class="col-md-3">
									<img src="{{asset('assets/frontend')}}/img/top/small-phone.png" class="img-responsive hidden-xs hidden-sm" alt="">
								</div>
								<div class="col-md-9">
									<div class="wrap-top-testi clearfix">
										<div class="wrap-img">
											<img src="{{asset('assets/frontend')}}/img/top/img-top.png" class="img-responsive" alt=""/>
										</div>
										<div class="wrap-text">
											<span class="line"></span>
											<p class="content">“  テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入りますテ キストが入りますテキストが入りますテキストが入りますテキストが入りますテキ ストが入りますテキストが入りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入りますテキストが入ります  ”</p>
											<p class="sub">店名が入ります　オーナー　<span class="xanh">名前が入ります</span></p>
											<a href="http:///www.example.com" class="link">http:///www.example.com</a>
										</div>
									</div> <!-- end wrap-top-test-->
									<div class="wrap-img-mobile visible-xs visible-sm">
										<img src="{{asset('assets/frontend')}}/img/top/small-phone.png" class="img-responsive" alt="">
									</div>
									<div class="wrap-bottom-testi">
										<div class="row">
											<div class="col-md-6">
												<div class="each-testi">
													<p class="title-testi"><span>→</span>　導入によるメリット</p>
													<p>テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります</p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="each-testi">
													<p class="title-testi"><span>→</span>　効果</p>
													<p>テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入 りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入ります</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#slide-testimonial" role="button" data-slide="prev">
					<img src="{{asset('assets/frontend')}}/img/top/left-btn.png" height="40" width="41" alt="">
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#slide-testimonial" role="button" data-slide="next">
					<img src="{{asset('assets/frontend')}}/img/top/right-btn.png" height="40" width="41" alt="">
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
		<!-- END TESTIMONIAL -->

		@include('layouts.contact-section')
	</div>
	<!-- END MIDDLE -->
@stop