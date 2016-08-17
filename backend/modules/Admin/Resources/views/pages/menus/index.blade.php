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
				<div class="right-topbar">
					 <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
					<a href="javascript:avoid()" class="btn-me btn-topbar" data-toggle="modal" data-target="#myModal">Add New</a>
				</div>
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
									<h2 class="title-prview">Staff</h2>
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
										@if($menus->isEmpty())
											<p>No data</p>
										@else
											@foreach($menus as $item_thumb)
												<div class="col-xs-4 padding-me">
													<div class="each-staff">
														<!-- <img src="{{asset(env('ASSETS_BACKEND'))}}/images/wall.jpg" class="img-responsive" alt=""> -->
														<p>{{$item_thumb->name}}</p>
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
										<a href="#" class="btn-me btn-hong">スタの新着情報</a>
										<a href="#" class="btn-me btn-xanhduongnhat">スタの新着情報 2</a>
									</div>
								</div>
							</div>

						</div>	<!-- end wrap-btn-content-->
						<div class="wrapper-content clearfix">
							<div class="container-fluid">
								<div class="row">
									@if($menus->isEmpty())
											<p>No data</p>
										@else
											@foreach($menus as $item)
												<div class="col-xs-4">
													<div class="each-menu each-common-pr">
														<p class="title-menu"><a href="{{route('admin.menus.edit',$item->id)}}">{{$item->name}}</a></p>
														{{Form::open(array('route'=>['admin.menus.destroy',$item->id],'method'=>'DELETE'))}}
															{{Form::submit('Delete',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
														{{Form::close()}}
													</div>
												</div>
											@endforeach
										@endif
									
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
	    {{Form::open(array('route'=>'admin.menus.store'))}}
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Add More Menu</h4>
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