@extends('layouts.default')

@section('title','Top')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/top.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	<script>
	$(document).ready(function(){

		$('.wrap-search, .function-section, .testimonial-section, .img-section').addClass('invisible').viewportChecker({
			classToAdd: 'visible animated fadeInUp',
			offset : 150,
		})
		// FIX HEADER
		var stickyHeader  = $('.header').offset().top;
		var stickyNav = function (){
			var scrolltop  = $(window).scrollTop();
			if (scrolltop > stickyHeader) {
			    $('.header').addClass('bg-color');
			} else {
			    $('.header').removeClass('bg-color');
			}
		}
		// HEADER
		$(window).on('scroll',function(){
			var win_width = $(window).width();
			if(win_width => 768 ){
				stickyNav();
			}
			
		})
	})
	</script>
@stop

@section('content')
	@include('layouts.banner')
	<div class="middle">
		<div class="section video-section">
			<div class="container">
				<div class="row">
					<a href="">
						<img src="{{asset('assets/frontend')}}/img/top/ic-video.png" height="56" width="59" alt="">
						<h2 class="title-video">Watch the video</h2>
					</a>
				</div>
			</div>
		</div>
		<!-- END VIDEO -->

		<div class="section search-section">
			<div class="container">
				<div class="row">
					<div class="col-md-9 col-md-offset-3">
						<div class="wrap-search">
							<h2 class="title-search"><img src="{{asset('assets/frontend')}}/img/top/small-img.png" alt=""> でお店の<span class="text-mobile"> ファンやリピーターを増やしましょう。</span></h2>
							<p class="content-search">tenpossなら、あなたのお店のオリジナルアプリがあなた自身の手で簡単に作れます。 作ったアプリはApp Store、Google Playで公開。</p>
							<p class="content-search">プッシュ通知機能搭載で、お客様へダイレクトに、確実に情報配信する事が出来ます。 日々の更新作業等もあなたのスマホで簡単にアップデート。即アプリに反映出来ます。</p>

							<div class="wrap-search clearfix">
								<form action="" method="" class="formSearch">
									<div class="left-form">
										<input type="text" name="keyword" class="form-control" placeholder="info@tenposs.com">
									</div>
									<div class="right-form">
										<input type="submit" class="btn-search" value="申込み（無料）">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END SEARCH -->

		<div class="section function-section">
			<h2 class="title-section">3分でわかる 「 tenposs 」</h2>
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<div class="each-function">
							<img src="{{asset('assets/frontend')}}/img/top/function01.png" class="img-responsive" alt="">
							<h3 class="title-function">アプリとスマホサイトが簡単に作れる</h3>
							<p class="content">大きなコストのかかるアプリ開発ですが、「tenposs」なら、あなたのお店オリジナルの アプリが素早く格安で作れます。tenpossで 作ったあなたのアプリは、App Store・Goog le Playから正式に配信。リリース後の更新も 思いのままで、顧客に強力なアピールが可能 です。</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="each-function">
							<img src="{{asset('assets/frontend')}}/img/top/function02.png" class="img-responsive" alt="">
							<h3 class="title-function">プッシュ通知でより確実なアピール</h3>
							<p class="content">「tenposs」は、スマホの大きな特徴である 「プッシュ通知」ももちろん搭載。スマホを 持つお客様に、新着情報やクーポンなどを配 信。配信対象条件や配信日時も細かく設定可 能。一度つかんだ顧客を、より確実にリピー ターへと促します。</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="each-function">
							<img src="{{asset('assets/frontend')}}/img/top/function03.png" class="img-responsive" alt="">
							<h3 class="title-function">デザインもとってもリッチ</h3>
							<p class="content">「tenposs」は、あなたのお店のイメージに合 わせて、アプリのデザインや機能もカスタマ イズできます。季節や流行、キャンペーン等 に合わせて、アプリも手軽に更新していけま す。顧客を飽きさせないアイデアをtenposs で活かしましょう。</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="wrap-button text-center">
						<a href="{{url('function')}}" class="btn-me btn-xanhduong">詳しい機能はこちら</a>
					</div>
				</div>
			</div>
		</div>
		<!-- END FUNCTION -->

		<div class="section img-section bg-blue">
			<h3 class="title-section">ワンストップで<span class="xanh"> アプリ・スマホサイト・レスポンシブサイト</span> が作れるため、<br/>
				モバイル・タブレット・PCとあらゆるデバイスに <span class="xanh">マルチ対応</span> 。
			</h3>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<img src="{{asset('assets/frontend')}}/img/top/top-06.png" class="img-responsive" alt="">
					</div>
				</div>
			</div>
		</div>
		<!-- END IMG -->
		<!--
		<div class="section testimonial-section">
			<h2 class="title-section">導入事例・お客様の声</h2>
			<div class="wrap-testi-slide carousel slide" data-ride="carousel" id="slide-testimonial">
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<div class="container">
							<div class="row">
								<div class="col-md-3">
									<img src="{{asset('assets/frontend')}}/img/top/small-phone.png" class="img-responsive hidden-sm hidden-xs" alt="">
								</div>
								<div class="col-md-9">
									<div class="wrap-top-testi clearfix">
										<div class="wrap-img">
											<img src="{{asset('assets/frontend')}}/img/top/img-top.png" class="img-responsive " alt=""/>
										</div>
										<div class="wrap-text">
											<span class="line"></span>
											<p class="content">“  テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入りますテ キストが入りますテキストが入りますテキストが入りますテキストが入りますテキ ストが入りますテキストが入りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入りますテキストが入ります  ”</p>
											<p class="sub">店名が入ります　オーナー　<span class="xanh">名前が入ります</span></p>
											<a href="http:///www.example.com" class="link">http:///www.example.com</a>
										</div>
									</div> <!-- end wrap-top-test--
									<div class="wrap-img-mobile visible-xs visible-sm visible-xs">
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
									<img src="{{asset('assets/frontend')}}/img/top/small-phone.png" class="img-responsive hidden-sm hidden-xs" alt="">
								</div>
								<div class="col-md-9">
									<div class="wrap-top-testi clearfix">
										<div class="wrap-img">
											<img src="{{asset('assets/frontend')}}/img/top/img-top.png" class="img-responsive " alt=""/>
										</div>
										<div class="wrap-text">
											<span class="line"></span>
											<p class="content">“  テキストが入りますテキストが入りますテキストが入りますテキストが入ります テキストが入りますテキストが入りますテキストが入りますテキストが入りますテ キストが入りますテキストが入りますテキストが入りますテキストが入りますテキ ストが入りますテキストが入りますテキストが入りますテキストが入りますテキス トが入りますテキストが入りますテキストが入りますテキストが入ります  ”</p>
											<p class="sub">店名が入ります　オーナー　<span class="xanh">名前が入ります</span></p>
											<a href="http:///www.example.com" class="link">http:///www.example.com</a>
										</div>
									</div> <!-- end wrap-top-test--
									<div class="wrap-img-mobile visible-xs visible-sm visible-xs">
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
				<!-- Controls --
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
		<!-- END TESTIMONIAL --
		-->

		@include('layouts.contact-section')
	</div>
@stop