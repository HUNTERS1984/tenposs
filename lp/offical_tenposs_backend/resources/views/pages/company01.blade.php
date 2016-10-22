@extends('layouts.default')

@section('title','Company')

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
					<h1 class="title-page">Company</h1>
					<p class="sub-title-page">-　運営会社　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section company-section company01">
			<div class="content-section">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div class="wrap-tab">
								<ul class="tab-company">
									<li class="active"><a href="{{url('company01')}}">会社概要</a></li>
									<li><a href="{{url('company02')}}">HUNTERS.Co.Ltdについて</a></li>
									<li><a href="{{url('company03')}}">tenpossのはじまり</a></li>
									<li><a href="{{url('company04-01')}}">tenpossチーム</a></li>
									<li><a href="{{url('company05')}}">tenpossブランド資産</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">社名</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">HUNTERS株式会社 </p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">設立</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">2014年2月10日 </p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">英文社名	</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">HUNTERS Co.,Ltd.</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">代表取締役</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">藤吉 良  [ Ryo Fujiyoshi ] </p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">本社</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">〒135-0063   東京都江東区有明3-7-26 有明フロンティアビル9階</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">福岡支社</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">〒812-0016　福岡県福岡市博多区博多駅南4-2-10 南近代ビル8階</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">ベトナム支社</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">162B Dien Bien Phu, Dist3, HCM</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">中国支社</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">安徽省合肥市明珠広場上海都市1#2602</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">TEL</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">03-5530-8148 </p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">TEL （代表）</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">092-292-0595</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">E-MAIL</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">info@hunters.co.jp</p>
										</div>
									</div>
								</div>
							</div>

							<div class="block-company">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-4">
											<p class="text-company">事業内容</p>
										</div>
										<div class="col-xs-8">
											<p class="text-company">スマートフォンサイト・アプリ制作・開発事業・スマートフォンメディア広告事業</p>
										</div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>	<!-- end content section -->
		</div>
		<!-- END COMPANY -->

		<div class="section map-section">
			<h2 class="title-section">本社</h2>
			<div class="content-section">
				<img src="{{asset('assets/frontend')}}/img/company/tenposs-company-03.png" class="img-responsive" style="width:100%; max-width:auto" alt="">
			</div>	<!-- end content section -->
		</div>
		<!-- END MAP -->

		<div class="section map-section">
			<h2 class="title-section">ベトナム支社</h2>
			<div class="content-section">
				<img src="{{asset('assets/frontend')}}/img/company/tenposs-company-04.png" class="img-responsive" style="width:100%; max-width:auto" alt="">
			</div>	<!-- end content section -->
		</div>
		<!-- END MAP -->

		<div class="section map-section">
			<h2 class="title-section">中国支社</h2>
			<div class="content-section">
				<img src="{{asset('assets/frontend')}}/img/company/tenposs-company-05.png" class="img-responsive" style="width:100%; max-width:auto" alt="">
			</div>	<!-- end content section -->
		</div>
		<!-- END MAP -->

		@include('layouts.contact-section')
		<!-- END CONTACT -->
	</div>
	<!-- END MIDDLE -->
@stop