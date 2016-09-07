@extends('admin::layouts.default')

@section('title', 'Menu')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">Menus</h1>
				</div>
				<!-- <div class="right-topbar">
					 <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
					<a href="javascript:avoid()" class="btn-me btn-topbar">Add New</a>
				</div> -->
			</div>
		</div>
		<!-- END -->

		<div class="main-content menu">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="header-preview">
									<a href="javascript:avoid()" class="trigger-preview"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/nav-icon.png"  alt=""></a>
									<h2 class="title-prview">Menus</h2>
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
								<div class="content-preview clearfix">
									<div class="row-me fixHeight">
										@if($item_thumbs->isEmpty())
											<p>No data</p>
										@else
											@foreach($item_thumbs as $item_thumb)
												<div class="col-xs-4 padding-me">
													<div class="each-staff">
														<img src="{{asset($item_thumb->image_url)}}" class="img-responsive" alt="">
													</div>
												</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="wrap-btn-content">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										<a href="#" class="btn-me btn-hong" data-toggle="modal" data-target="#myModal">Create Menu</a>
										<a href="{{route('admin.menus.create')}}" class="btn-me btn-xanhduongnhat">Create Item</a>
									</div>
								</div>
							</div>

						</div>	<!-- end wrap-btn-content-->
						<div class="wrapper-content clearfix">
							<div class="container-fluid">
								<div class="row">
									@if($items->isEmpty())
										<p>No data</p>
									@else
										@foreach($items as $item)
											<div class="col-xs-4">
												<div class="each-menu each-common-pr">
													<a href="{{route('admin.menus.edit',$item->id)}}" class="tooltip-menu" data-tooltip-content="#tooltip_content_{{$item->id}}">
														<img  src="{{asset($item->image_url)}}" class="img-responsive" alt="">
														<p class="title-menu" >{{$item->title}}</p>
														<p class="title-menu">{{number_format($item->price,2)}}</p>
													</a>
													{{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
														{{Form::submit('Delete',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
													{{Form::close()}}
												</div>
												<div class="tooltip_templates">
												    <span id="tooltip_content_{{$item->id}}">
												        <h2 class="title-tooltip">Coupon</h2>
												        <p class="text-tooltip"><b>Coupon name: </b>{{$item->coupons->title}}</p>
												        <p class="text-tooltip"><b>Start date: </b>{{$item->coupons->start_date}}</p>
												        <p class="text-tooltip"><b>End date: </b>{{$item->coupons->end_date}}</p>
												        <p class="text-tooltip"><b>Limit: </b>{{$item->coupons->limit}}</p>

												    </span>
												</div>
											</div>
										@endforeach
									@endif
								</div>
								<div class="row">
									<div class="text-right">
										{{$items->links()}}
									</div>
								</div>
							</div>
						</div>	<!-- wrap-content-->
					</div>
				</div>
			</div>

		</div>
		<!-- END -->
	</div>	<!-- end main-content-->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    {{Form::open(array('route'=>'admin.menus.storeMenu'))}}
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Add More Menus</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
	      		{{Form::label('Select Store')}}
	      		{{Form::select('store_id',$list_store,old('store_id'),['class'=>'form-control'])}}

	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Name')}}
	      		{{Form::text('name',old('name'),['class'=>'form-control'])}}
	      	</div>
	      </div>
	      <div class="modal-footer">
	      {{Form::submit('Save',['class'=>'btn btn-primary'])}}
	      </div>
	    </div>
	    {{Form::close()}}
	  </div>
	</div>
@stop

@section('script')
	{{Html::script(env('ASSETS_BACKEND').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/bootstrap.min.js')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/switch/lc_switch.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/switch/lc_switch.css')}}

	{{Html::script(env('ASSETS_BACKEND').'/js/swiper/swiper.jquery.min.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/swiper/swiper.min.css')}}

	<!-- TOOL TIPs -->
	{{Html::script(env('ASSETS_BACKEND').'/js/tooltip/tooltipster.bundle.min.js')}}
	{{Html::style(env('ASSETS_BACKEND').'/js/tooltip/tooltipster.bundle.min.css')}}

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

	        $('.tooltip-menu').tooltipster({
	        	side: ['right','left','top']
			});
		})
	</script>
@stop