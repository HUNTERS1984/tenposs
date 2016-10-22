@extends('layouts.default')

@section('title','FAQ')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/faq.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	<script>
	$(document).ready(function(){

		$('.wrap-each').addClass('invisible').viewportChecker({
			classToAdd: 'visible animated fadeInUp',
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
								<li class="active"><a href="#">よくあるご質問</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="faq">
					<div class="is-table-cell">
						<h1 class="title-page">FAQ</h1>
						<p class="sub-title-page">-　よくあるご質問　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section faq-section">
				<div class="content-section">
					<div class="container">
						@if(!$type->isEmpty())
						@foreach($type as $item_faq)
						<div class="each-faq {{$item_faq == $type->last() ? 'last' : ''}}">
							<h3 class="title-each">{{$item_faq->title}}</h3>
							@if($item_faq->faqs()->first())
							@foreach($item_faq->faqs()->select('id','question','answer')->get() as $item)
								<div class="wrap-each">
									<div class="question">
										<span class="left">Q.</span>
										<span class="text">{{$item->question}}</span>
									</div>
									<div class="answer">
										<span class="left">A.</span>
										<span class="text">{{$item->answer}}</span>
									</div>
								</div>
							@endforeach
							@endif
						</div>
						@endforeach
						@endif
					</div>
				</div>	<!-- end content section -->
			</div>
			<!-- END CONTACT -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop