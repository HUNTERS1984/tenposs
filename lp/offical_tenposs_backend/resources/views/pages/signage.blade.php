@extends('layouts.default')

@section('title','SIGNAGE')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/signage.css')}}
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
								<li class="active"><a href="#">特定商取引法に基づく表記</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="signage">
					<div class="is-table-cell">
						<h1 class="title-page">Signage</h1>
						<p class="sub-title-page">-　特定商取引法に基づく表記　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section signage-section">
				<h2 class="title-section">tenposs 特定商取引法に基づく表記</h2>
				<div class="section-content">
					<div class="container">
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">販売事業者：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">HUNTERS株式会社</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">運営統括責任者：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">藤吉 良</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">所在地：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">〒135-0063　東京都江東区有明3-7-26 有明フロンティアビル9階</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">お問い合せ先：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">03-5530-8148</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">商品代金：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">お支払手続きを行うページに記載（※消費税は、内税として税込の販売価格として表示しております。）</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">お支払い方法：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">銀行振込でご購入の場合、振込手数料はお客様負担にてお願いいたします。</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">お支払い期限：	</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">銀行振込をご利用の場合に<br/>
							は、注文確認メール発信日から1週間以内に商品代金を弊社指定銀行口座にお振込みください。当該期<br/>
							日までにお振込みを確認できない場合、契約をキャンセルさせていただく場合があります。</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">お支払い時期：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">・クレジットカード-  ご注文成立時において課金されます。</p>
								<p class="text-sign">・銀行振込 -  ご注文から1週間以内にお振り込みください。</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">キャンセル:</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">制作着手前のキャンセルは承りますが、制作着手後のキャンセルは受け付けておりませんので、予めご
							了承ください。</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-md-offset-1">
								<p class="text-sign">返品：</p>
							</div>
							<div class="col-md-8 col-md-offset-1">
								<p class="text-sign">商品の性質上、一旦お支払い完了後にお客様が誤って商品データを破損または紛失された場合の返品・
							返金、また他の商品データとの交換などは一切受け付けておりませんので、予めご了承ください。</p>
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