@extends('admin::layouts.default')

@section('title', 'News')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">News</h1>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content news">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/nav-icon.png"  alt=""></a>
									<h2 class="title-prview">NEWS</h2>
								</div>
								<div class="control-nav-preview">
									<!-- Slider main container -->
		                            <div class="swiper-container">
		                                <!-- Additional required wrapper -->
		                                <div class="swiper-wrapper">
		                                    <!-- Slides -->
		                                    <div class="swiper-slide">Spring</div>
		                                    <div class="swiper-slide">Summer</div>
		                                </div>

		                                <!-- If we need navigation buttons -->
		                                <div class="swiper-button-prev"></div>
		                                <div class="swiper-button-next"></div>
		                            </div>
								</div>
								<div class="content-preview">
									@if(empty($newsAll))
										No data
									@else
										@foreach($newsAll as $item_thumb)
											<div class="each-coupon clearfix">
												<img src="{{asset($item_thumb->image_url)}}" class="img-responsive img-prview">
												<div class="inner-preview">
													<p class="title-inner" style="font-size:9px; color:#14b4d2">{{$item_thumb->title}}</p>
													<!-- <p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p> -->
													<p class="text-inner" style="font-size:9px;">{{$item_thumb->description}}</p>
												</div>
											</div>
										@endforeach
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						
						<div class="wrapper-content">
							{{Form::model($news,array('route'=>array('admin.news.update',$news->id),'method'=>'PUT','files'=>true))}}
								<div class="form-group">
									{{Form::select('store_id',$list_store,$news->store_id,array('class'=>'form-control'))}}
								</div>
								<div class="form-group">
									{{Form::text('title',old('title'),array('class'=>'form-control', 'placeholder'=>'Type the title'))}}
								</div>
								<div class="form-group">
									{{Form::text('description',old('description'),array('class'=>'form-control', 'placeholder'=>'Type the description'))}}
								</div>
								<div class="form-group">
									{{Form::hidden('img_bk',$news->image_url)}}
									<div class="wrap-img-preview">
										<img src="{{asset($news->image_url)}}" class="img-responsive" alt="">
									</div>
									{{Form::file('img')}}
								</div>
								<div class="form-group">
									{{Form::submit('Save changes',array('class'=>'btn btn-primary'))}}
								</div>
							{{Form::close()}}
						</div>	<!-- wrap-content-->
					</div>
				</div>
			</div>

		</div>
		<!-- END -->

		
	</div>	<!-- end main-content-->
@stop

@section('script')
	{{Html::script(env('ASSETS_BACKEND').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/bootstrap.min.js')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/switch/lc_switch.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/switch/lc_switch.css')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/swiper/swiper.jquery.min.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/swiper/swiper.min.css')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/script.js')}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('input.lcs_check').lc_switch();

			var categorySwiper = new Swiper('.control-nav-preview .swiper-container', {
	            speed: 400,
	            spaceBetween: 0,
	            slidesPerView: 1,
	            nextButton: '.control-nav-preview .swiper-button-next',
	            prevButton: '.control-nav-preview .swiper-button-prev'
	        });
		})
	</script>
@stop