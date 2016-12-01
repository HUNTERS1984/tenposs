@extends('layouts.default')
@section('SEO')
<title>企業理念｜スマホサイトとオリジナルアプリを簡単に無料で作れるTenposs</title>
<meta name="keywords" content="店舗アプリ,お店アプリ,店舗販促,集客方法,リピーター">
<meta name="description" content="スマホサイトとオリジナルアプリを簡単に無料で作れるTenposs（テンポス）の企業理念ページです。">
@stop
@section('css')
	{{Html::style(asset('assets/frontend').'/css/company.css')}}
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
								<li class="active"><a href="#">運営会社</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="company">
					<div class="is-table-cell">
						<h1 class="title-page">企業理念</h1>
						<p class="sub-title-page">-　運営会社　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section company-section company02">
				<div class="content-section">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<div class="wrap-tab">
									<ul class="tab-company">
										<li><a href="{{url('company01')}}">会社概要</a></li>
										<li class="active"><a href="{{url('company02')}}">HUNTERS.Co.Ltdについて</a></li>
										<li><a href="{{url('company03')}}">tenpossのはじまり</a></li>
										<li><a href="{{url('company04-01')}}">tenpossチーム</a></li>
										<li><a href="{{url('company05')}}">tenpossブランド資産</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="wrap-top">
									<h3 class="title-company">企業理念</h3>
									<p class="sub-title">”世の中に新たな価値と需要を創造します。”</p>
									<p class="content"> 私たちHUNTERS株式会社の企業理念は、グループ創業時に社訓として制定した「世の中に新たな価値と需要を創造します。」
を、全社員・全事業においての変わることのない使命として掲げ、この使命を実現させるべく常に意識するべき心構えとして、
社是の「有りたいを、有りうるに」の意識を常に持ち行動し企業理念を実現してまいります。</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<diw class="wrap-articles">
									<h3 class="title-company">企業理念</h3>
									<div class="wrap-article">
										<div class="row">
											<div class="col-md-4 col-sm-5">
												<img src="{{asset('assets/frontend')}}/img/company/img-company-02.png" class="img-responsive" alt="">
											</div>
											<div class="col-md-8 col-sm-7">
												<p class="sub-title">”世の中に新たな価値と需要を創造します。”</p>
												<div class="content-com02">
													<p>2007 年に福岡にて、代表である私がひとり個人事業主として創業致しました。 自宅の 1 室にて、ホームページを作ることからスタートし、今現在に至るまでに、 Web からアプリに大きく方向転換し変化させました。当時では考えられないような 新しい技術に、それを携えた素晴らしい製品がこの日本では沢山生まれてきています。</p>
													<p>我々も、過去の経験を活かし新しいサービス・アプリを開発しておりますが、常に変 わらないものがあります。お客さまに新しい価値を提供し需要を創出する事。そして、お客さまの「有りたいを有りうるに」実現させる事。</p>
													<p>創業以来、この想いは変わらず持ち続け、2020 年には、更に我々のサービス・製品に より、「有りたいを有りうるに」実現できたと言って頂けるお客さまを、日本全国に限 らず、世界中にその輪を広げていきます。</p>
													<p>2014 年 11 月 HUNTERS 株式会社 代表取締役社長 藤吉 良</p>
												</div>
											</div>
										</div>
									</div>
								</diw>
							</div>
						</div>

					</div>
				</div>	<!-- end content section -->
			</div>
			<!-- END COMPANY -->


			@include('layouts.contact-section')
			<!-- END CONTACT -->
		</div>
		<!-- END MIDDLE -->
@stop