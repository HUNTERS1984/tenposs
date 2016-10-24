@extends('layouts.default')

@section('title','NEWS')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/news.css')}}
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
							<li class="active"><a href="#">ニュース</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="news">
				<div class="is-table-cell">
					<h1 class="title-page">NEWS</h1>
					<p class="sub-title-page">-　ニュース　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section news-section">
			<div class="section-content">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<div class="wrap-main-news">
								<h3 class="title-news">プレスリリース</h3>
								@if(!$data->isEmpty())
									@foreach($data as $item)
									<div class="each-news {{$item == $data->last() ? 'last' : ''}}">
										<p class="time">{{date_format($item->created_at,'Y.m.d')}}</p>
										<a href="{{route('news.detail',[$item->id,$item->slug])}}" class="name-news">{{$item->title}}</a>
									</div>
									@endforeach
								@endif
							</div>
							<div class="wrap-pagination text-center">
								{{$data->links()}}
							</div>
						</div>
						<div class="col-md-4">
							<div class="wrap-sidebar-news">
								<div class="box-news">
									<h4 class="title-box">
										プレスルーム
									</h4>
									<ul class="list-box">
										@if(!$random_news->isEmpty())
											@foreach($random_news as $item_ran)
												<li><a href="{{route('news.detail',[$item_ran->id,$item_ran->slug])}}">{{$item_ran->title}}</a></li>
											@endforeach
										@endif
									</ul>
								</div>
								<div class="box-news">
									<h4 class="title-box">
										プレスルーム
									</h4>
									<ul class="list-box">
										@if(!$top_news->isEmpty())
										@foreach($top_news as $item_top)
											<li><a href="{{route('news.detail',[$item_top->id,$item_top->slug])}}">{{$item_top->title}}</a></li>
										@endforeach
										@endif
									</ul>
								</div>
							</div>
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