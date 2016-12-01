@extends('layouts.default')
@section('SEO')
<title>Tenpossのはじまり｜スマホサイトとオリジナルアプリを簡単に無料で作れるTenposs</title>
<meta name="keywords" content="店舗アプリ,お店アプリ,店舗販促,集客方法,リピーター">
<meta name="description" content="スマホサイトとオリジナルアプリを簡単に無料で作れるTenposs（テンポス）のTenpossのはじまりページです。">
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
					<h1 class="title-page">tenposs のはじまり</h1>
					<p class="sub-title-page">-　運営会社　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section company-section company03">
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="wrap-tab">
								<ul class="tab-company">
									<li ><a href="{{url('company01')}}">会社概要</a></li>
									<li><a href="{{url('company02')}}">HUNTERS.Co.Ltdについて</a></li>
									<li class="active"><a href="{{url('company03')}}">tenpossのはじまり</a></li>
									<li><a href="{{url('company04-01')}}">tenpossチーム</a></li>
									<li><a href="{{url('company05')}}">tenpossブランド資産</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="wrap-top">
								<h3 class="title-company">tenposs のはじまり</h3>
								<p class="sub-title">”すべてのはじまりは、ここから”</p>
								<div class="wrap-content-company03">
									<p>こんにちは。<br/>
										皆さまにお伝えしたいのはどうして私達がTenpossという商品を開発しこのような他社では実現できないような低価格で
販売しようと思ったのかということです。
									</p>
									<p>多くの人は、ランチや仕事帰りの一杯で外食する時、買い物に行くときもスマートフォンを使って調べることが当たり前。
そんななかで「どのお店に行こうか」ということは、常に考える悩みです。</p>
<p>多くの大手飲食チェーン店では、Wedサイトやメルマガなど、次から次へと新たなサービスを展開しています。
そして、今多くの飲食店が取り組んでいるのが「スマホサイトにオリジナルアプリ」です。
スマートフォンを持つ人が、半数を超えている今の日本で、スマートフォン向けのサービスへの対応は当然のこととも言
えます。</p>
<p>しかし、この「アプリ」というのは、独自で開発するのに、数百万、数千万円かかってしまうこともあります。そして、
「スマホサイト」も数十万かかってしまうというのが現状です。</p>
<p>そんなかかるのか？率直にそう思います。</p>
<p>それなら諦めよう。そうなっても仕方の無いことです。<br/>私たちは、その「仕方ない」を何とかしたい。他店にはないサービスをしているのに、発信できていない。 </p>
<p>『お店のスマートフォン向けのサービスを行いたい。そんなお店の力になりたい。』</p>
<p>そんな思いから、このtenpossは誕生したのです。</p>
<p>高機能で多機能だけじゃない。 <span>スマホ・タブレット・PC、</span>あらゆるデバイスユーザーを逃がしません。</p>
<p>我々の企業理念は、「有りたいを有りうるに」です。<br/>
お客さまの有りたい。リピーターを増やしたい。もっとこの商品を知ってほしいなどの<br/>
目的に対していかに高いコストパフォーマンスで結果を出していくか。</p>
<p>この点に創業以来、こだわり続けてきました。<br/>
高機能で多機能が良いわけではありません。しかし、お客様の目的にとって必要なもの。<br/>
それを付け加えていくうちにこれだけの機能になりました。</p>

<p>また最近では、スマホやタブレットに対応するのが当たり前の時代ですが。<br/>
いまだに自社サイトでのスマホサイト対応が完全に出来ている企業さまがまだまだ少ないと言う現状です。</p>

<p>これはやはり導入コストや導入障壁が高く運用出来るリソースもないと言う点にあります。<br/>
そして、アプリにも同様の事が言えます。</p>


<p>我々は、これらの問題をすべて解決しようと言う思いから。<br/>
Tenpossの開発をスタートさせ、今現在も常に改善と改良を加えてっております。</p>

<p>是非、デモアプリとお試し登録で我々のサービスをためしてみて下さい。<br/>
そして、これからもっと皆さまのお役に立てるよう我われに皆さまの貴重なフィードバックを頂ければ幸いです。</p>

<p>tenposs team　メンバー一同</p>

								</div>
							</div>
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