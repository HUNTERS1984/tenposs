@extends('layouts.default')

@section('title','INTRODUCTION')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/introduction.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	
	<script>
		$(document).ready(function(){
			setAnimation('.each-introduction');
		});
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
							<li class="active"><a href="#">tenpossを紹介</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="introduction">
				<div class="is-table-cell">
					<h1 class="title-page">Introduction</h1>
					<p class="sub-title-page">-　tenpossを紹介　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section introduction-section">
			<h2 class="title-section">tenposs を友人や知人に紹介して、特典をGET！</h2>
			<div class="section-content">
				<div class="container">
					<p class="sub-section">友人または知人がtenpossに登録し、サインインすると、プレミアムプランに無料アップグレードされます。
紹介者のあなたにも、プレミアムプランやお得な特典に交換できるポイントを獲得できます。</p>
					<div class="row">
						<div class="col-sm-6">
							<div class="each-introduction">
								<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introduction-03.png" class="img-responsive" alt="">
								<h3 class="title-each">友人を招待</h3>
								<p class="content-each">最初の 3 回までは、紹介するたびに 10 ポイントずつが贈呈されます。
ポイントを貯めて、プレミアムプランにアップグレードしましょう！</p>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="each-introduction">
								<img src="{{asset('assets/frontend')}}/img/introduction/tenposs-introduction-03.png" class="img-responsive" alt="">
								<h3 class="title-each">さらにポイントを獲得</h3>
								<p class="content-each">紹介した友達が初めてプレミアム会員になった時は、 あなたにも 5 ポイントがさらに贈呈されます。</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="wrap-bottom">
								<div class="wrap-form-introduction clearfix">
									<div class="left">
										<input type="text" name="" class="form-control" placeholder="友人のメールアドレスを入力">
									</div>
									<div class="right">
										<input type="button" class="btn-xanhduong btn-button" value="招待">
									</div>
								</div>
								<p class="text-middle">または、下記の招待用URLをコピー</p>
								<div class="wrap-form-introduction clearfix">
									<div class="left">
										<input type="text" name="" class="form-control" placeholder="友人のメールアドレスを入力">
									</div>
									<div class="right">
										<input type="button" class="btn-xanhduong btn-button" value="コピー">
									</div>
								</div>

								<div class="wrap-icon">
									<a href="https://twitter.com/tenposs" target="_blank" class="ic"><img src="{{asset('assets/frontend')}}/img/introduction/twitter.png" height="64" width="64" alt=""></a>
									<a href="https://www.facebook.com/Tenposs-1433358063615210/" target="_blank" class="ic"><img src="{{asset('assets/frontend')}}/img/introduction/fb.png" height="64" width="64" alt=""></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END SEARCH -->

		@include('layouts.contact-section')
		<!-- END CONTACT -->
	</div>
	<!-- END MIDDLE -->
@stop