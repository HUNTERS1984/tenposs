@extends('layouts.default')

@section('title','FUNCTION')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/function.css')}}
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
								<li class="active"><a href="#">機能</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="function">
					<div class="is-table-cell">
						<h1 class="title-page">Function</h1>
						<p class="sub-title-page">-　機能　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section function-top-section bg-blue">
				<div class="content-section">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="title-top">高機能で多機能だけじゃない。</h3>
								<p class="sub-title">
									アプリだけでなく、<span>スマホサイト・レスポンシブサイト </span>が出来る！<br/>
									<span>スマホ・タブレット・PC</span>あらゆるデバイスユーザーを逃がしません。
								</p>
								<img src="{{asset('assets/frontend')}}/img/function/tenposs-function-03.png" alt="" class="img-responsive">

								<p class="content">
									我々の企業理念は、「有りたいを有りうるに」です。<br/>
お客さまの有りたい。リピーターを増やしたい。もっとこの商品を知ってほしい等の目的に対していかに高いコストパフォーマンスで結果 を出していくか。この点に創業以来、こだわり続けてきました。<br/><br/>

高機能で多機能が良いわけではありません。<br/>
しかし、お客様の目的にとって必要なもの。それを付け加えていくうちにこれだけの機能になりました。<br/><br/>

また、最近ではスマホやタブレットに対応するのが当たり前の時代ですが、いまだに自社サイトでのスマホサイト対応が完全に出来ている 企業様がまだまだ少ないと言う現状です。<br/><br/>

これは、やはり導入コストや導入障壁が高く運用出来るリソースもないと言う点にあります。そして、アプリにも同様の事が言えます。<br/><br/>

我々は、これらの問題をすべて解決しようと言う思いから。tenpossの開発をスタートさせ、今現在も常に改善と改良を加えて行っており ます。是非、デモアプリとお試し登録で我々のサービスをためしてみて下さい。<br/><br/>

そして、これからもっと皆さまのお役に立てるよう我われに皆さまの貴重なフィードバックを頂ければ幸いです。<br/><br/>

tenposs team　メンバー一同
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END FUNCTION TOP -->

			<div class="section function-middle-section">
				<h2 class="title-section">主要機能</h2>
				<div class="content-section">
					<div class="container">
						<div class="row">
							<div class="col-md-4 col-xs-6">
								<div class="each-middle">
									<a href="#"><img src="{{asset('assets/frontend')}}/img/function/tenposs-function-img-02.png" class="img-responsive" alt=""></a>
									<h3 class="title-middle"><a href="#">SNSと連携できる</a></h3>
								</div>
							</div>

							<div class="col-md-4 col-xs-6">
								<div class="each-middle">
									<a href="#"><img src="{{asset('assets/frontend')}}/img/function/tenposs-function-img-03.png" class="img-responsive" alt=""></a>
									<h3 class="title-middle"><a href="#">クーポンを発行できる</a></h3>
								</div>
							</div>

							<div class="col-md-4 col-xs-6">
								<div class="each-middle">
									<a href="#"><img src="{{asset('assets/frontend')}}/img/function/tenposs-function-img-04.png" class="img-responsive" alt=""></a>
									<h3 class="title-middle"><a href="#">ユーザーにアピールできる</a></h3>
								</div>
							</div>

							<div class="col-md-4 col-xs-6">
								<div class="each-middle">
									<a href="#"><img src="{{asset('assets/frontend')}}/img/function/tenposs-function-img-05.png" class="img-responsive" alt=""></a>
									<h3 class="title-middle"><a href="#">シンプルなホーム画面</a></h3>
								</div>
							</div>

							<div class="col-md-4 col-xs-6">
								<div class="each-middle">
									<a href="#"><img src="{{asset('assets/frontend')}}/img/function/tenposs-function-img-06.png" class="img-responsive" alt=""></a>
									<h3 class="title-middle"><a href="#">アクセスや電話もアプリから</a></h3>
								</div>
							</div>

							<div class="col-md-4">
								<div class="each-middle">
									<a href="#"><img src="{{asset('assets/frontend')}}/img/function/tenposs-function-img-07.png" class="img-responsive" alt=""></a>
									<h3 class="title-middle"><a href="#">沢山の写真でお店の魅力を発信</a></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END MIDDLE FUNCTION -->

			<div class="section function-bottom-section">
				<h2 class="title-section">標準機能一覧</h2>
				<div class="container">
					<div class="each-bottom">
						<div class="left">
							<p>アプリ会員機能</p>
						</div>
						<div class="right">
							<p>アプリをインストールしたユーザーに、ユーザー名、会員No.、誕生日、来店回数・紹介回数<br/>
といった登録を促すことによって、会員として管理します。<br/>
様々なサービスを提供するきっかけになり、リピーター率を上げるきっかけを作ります。</p>
						</div>
					</div>

					<div class="each-bottom">
						<div class="left">
							<p>リマインダー機能</p>
						</div>
						<div class="right">
							<p>リマインダー通知でリピート来店率を大きくアップさせましょう！<br/>
例えば、来店した７日後にクーポン発行のお知らせをプッシュ配信することによって、お店の<br/>
存在をアピールできます。</p>
						</div>
					</div>

					<div class="each-bottom">
						<div class="left">
							<p>セグメント配信</p>
						</div>
						<div class="right">
							<p>特定の情報を、特定のユーザーに絞って配信することができます。<br/>
性別、年齢、来店きっかけ…ターゲットを絞ったお知らせをすることで、より確実性の高い<br/>
リピート率を実現します。</p>
						</div>
					</div>

					<div class="each-bottom">
						<div class="left">
							<p>お知らせ機能</p>
						</div>
						<div class="right">
							<p>イベント情報や新着情報、お知らせをカンタンに更新、配信できます。<Br/>
アプリをインストールしたユーザー（お客様）に向けて、いつでも最新の情報をよりタイム<br/>
リーにお知らせします。</p>
						</div>
					</div>

					<div class="each-bottom">
						<div class="left">
							<p>コメント機能</p>
						</div>
						<div class="right">
							<p>お客様とお店のつながりをもっと深く、楽しくするシステムがコメント機能です。<br/>
お互いの距離を縮め、お顧客のニーズを敏感に取り入れることも可能です。</p>
						</div>
					</div>

					<div class="each-bottom">
						<div class="left">
							<p>スタンプシステム</p>
						</div>
						<div class="right">
							<p>ユーザーがアプリを使用すれば使用するほど、ユーザーにとってお得なサービスと交換でき るスタンプサービス。アプリの利用率を上げるとともに、来店頻度にも直結する機能です。</p>
						</div>
					</div>
				</div>
			</div>
			<!-- END BOTTOM FUNCTION -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop