@extends('layouts.default')

@section('title','FLOW')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/flow.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	<script>
	$(document).ready(function(){
		setAnimation('.each-flow');
		setAnimation('.wrap-top-section');
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
							<li class="active"><a href="#">導入までの流れ</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="flow">
				<div class="is-table-cell">
					<h1 class="title-page">Flow</h1>
					<p class="sub-title-page">-　導入までの流れ　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section flow-top-section bg-blue">
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-md-3 ">
							<img src="{{asset('assets/frontend')}}/img/flow/phone-01.png" class="img-responsive pull-md-right" alt="">
						</div>
						<div class="col-md-8 col-md-offset-1">
							<div class="wrap-top-section">
								<p class="title-top">高コストパフォーマンスの<span>高機能</span>を是非体験下さい！</p>
								<p class="content">
									集客からリピート獲得までをTenposs１つで実現して頂けるようスマホサイト・アプリ・ レスポンシブサイトが作れるツールとなっております。これにより、スマホからパソコンまで サイトとアプリであらゆるデバイスに最適化させてアプローチが実現出来ます。しかも、ただ のサイトやアプリではなく、性別や年齢、来店回数でセグメントしたプッシュ通知。クーポン 配信。スタンプ機能などなどこれまでになった機能でよりダイレクトにユーザーへのアプロー チを実現して頂けます。
								</p>
								<div class="wrap-btn clearfix">
									<a href="#" class="btn-xanhduong btn-me  btn-left">無料お試し登録</a>
									<a href="#" class="btn-trang btn-me  btn-right">まずはお話だけ聞く</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	<!-- end content section -->
		</div>
		<!-- END FLOW TOP -->

		<div class="section main-flow-section">
			<h2 class="title-section">導入までの流れ</h2>
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="container-top-content">
								<p class="title-container">１ヶ月無料お試し登録</p>
								<div class="row">
									<div class="col-md-5">
										<img src="{{asset('assets/frontend')}}/img/flow/tenposs-flow-04.png" class="img-responsive" alt="">
									</div>
									<div class="col-md-7">
										<p class="title-top-content">アプリの機能を除くすべての機能が１ヶ月間無料で使えます。</p>
										<p class="content">またアプリの機能やデザインをご覧になりたい方は、デモページよりアプリをイン ストール下さい。メールアドレスとパスワードを登録してアカウントを取得すれば、 いますぐTenpossをお使い頂けます。</p>
										<p class="content">ご登録日（アカウントを取得した日）から30日間は無料お試し期間としてご利用 頂けます。アプリの機能を含めた全機能をすぐにご利用になりたい場合、より詳し く内容を知りたい方は、『お問い合わせ』よりご連絡下さい。</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="each-flow clearfix">
								<div class="left-each" data-number="1">
									１か月無料お試し登録
								</div>
								<div class="right-each">
									トライアル申し込みフォームに必要事項を入力し１ケ月無料お試し登録を行います。
								</div>
							</div>

							<div class="each-flow clearfix">
								<div class="left-each" data-number="2">
									ご本人様確認
								</div>
								<div class="right-each">
									１か月お試し無料登録完了後メールが自動返信されます。メールに記載されたURLにアク セスしご本人様確認を行います。
								</div>
							</div>

							<div class="each-flow clearfix">
								<div class="left-each" data-number="3">
									tenpossアカウント の設定と発行
								</div>
								<div class="right-each">
									１ヶ月無料のお試しアカウントを発行致します。
								</div>
							</div>

							<div class="each-flow clearfix">
								<div class="left-each" data-number="4">初期設定</div>
								<div class="right-each">
									メールアドレス、パスワードを入力しログインします。店舗情報の入力などの初期設定を 行います。

								</div>
							</div>

							<div class="each-flow clearfix">
								<div class="left-each" data-number="5"><img src="{{asset('assets/frontend')}}/img/flow/small-logo-02.png" class="img-responsive" alt="">ご利用開始</div>
								<div class="right-each">
									管理画面上からお店の店内やスタッフ写真をアップロードし、簡単な文章を入れるだけ。 あっという間にアプリとスマホサイトが完成します！<br/>
									（※トライアル期間中は、スマホサイトのみの利用となります。本契約後にアプリ機能もご利用頂けます。）
								</div>
							</div>

							<div class="each-flow have-note clearfix" data-text=" 約３営業日 ">
								<div class="left-each" data-number="6">本契約・事前審査</div>
								<div class="right-each">弊社にて簡単な事前審査を行わさせて頂きます。審査によりご利用頂けない場合も御座い ますのでご了承下さい。</div>
							</div>

							<div class="each-flow have-note clearfix" data-text=" 約１週間 ">
								<div class="left-each" data-number="7">アプリ制作</div>
								<div class="right-each">tenpossアカウントを発行し、アプリ制作開始となります。オプションで弊社でも制作さ
せて頂きます。アカウント発行より2週間経過しても一度もアプリを制作されていない場
合は、アカウントを削除させて頂く場合がございます。</div>
							</div>

							<div class="each-flow have-note clearfix" data-text=" 約2週間 ">
								<div class="left-each" data-number="8">アプリ申請</div>
								<div class="right-each">アプリ完成後、AppStore・Google Playの両ストアに申請を行います。オプションで弊社
より申請代行を行います。</div>
							</div>

							<div class="each-flow last clearfix" >
								<div class="left-each" data-number="9">アプリリリース</div>
								<div class="right-each">アプリ公開後、マニュアルをお送りします。店舗オリジナルスマホアプリを利用したサー
ビスの始まりです！また、アプリを作れば、ワンストップでスマホサイト・レスポンシブ
サイトも公開するプランもあります。</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@include('layouts.contact-section')
	</div>
	<!-- END MIDDLE -->
@stop