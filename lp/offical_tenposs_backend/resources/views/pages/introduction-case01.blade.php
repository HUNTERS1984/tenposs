@extends('layouts.default')

@section('title','INTRODUCTION CASE')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/introcase.css')}}
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	{{Html::script(asset('assets/frontend').'/js/jquery.matchHeight-min.js')}}

	<script>
	$(document).ready(function(){
		$('.each-introcase').matchHeight();

		$("select[name='intro_type_id']").on('change',function(){
			var id = $(this).val();
			var token = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
				url : '{{route("introduction01.load")}}',
				type : 'POST',
				data : {id: id, _token: token},
				success:function(data){
					$('.wrap-ajax').html(data.msg);
				}
 			})
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
							<li ><a href="#">お客様ストーリー・導入事例</a></li>
							<li class="active"><a href="#">店名が入ります</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="page-banner" id="introcase">
				<div class="is-table-cell">
					<h1 class="title-page">Introduction Case</h1>
					<p class="sub-title-page">-　導入事例　-</p>
				</div>
			</div>
		</div>
		<!-- END STATIC BANNER -->

		<div class="section introcase-section">
			<h2 class="title-section">あなたの会社に近い業種を選択して下さい。</h2>
			<div class="content-section">
				<div class="container">
					@if(!$data->isEmpty())
					{{Form::select('intro_type_id',$list,'',['id'=>'choseCase'])}}
					<div class="wrap-ajax">
						<div class="row">
							@foreach($data as $item)
							<div class="col-md-4">
								<div class="each-introcase">
									<a href="#"><img src="{{asset($item->img_url)}}" class="img-responsive"  alt="{{$item->img_alt}}"></a>
									<h3 class="title-each-introcase"><a href="#">{{$item->title}}</a></h3>
									<p class="content"><a href="#">{{Str::words($item->content,20)}}</a></p>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					
					
					<div class="row">
						<div class="wrap-pagination text-center">
							{{$data->links()}}
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
		<!-- END SEARCH -->

		@include('layouts.contact-section')
	</div>
	<!-- END MIDDLE -->
@stop