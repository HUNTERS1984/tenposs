@extends('admin::layouts.default')

@section('title', 'Staff')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">Staff</h1>
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
									<h2 class="title-prview">MENU</h2>
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
									@if($all_user->isEmpty())
										No data
									@else
										@foreach($all_user as $item_thumb)
											<div class="each-coupon clearfix">
												<img src="{{asset($item_thumb->image_user)}}" class="img-responsive img-prview">
												<div class="inner-preview">
													<p class="title-inner" style="font-size:9px; color:#14b4d2">{{$item_thumb->name}}</p>
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
							{{Form::model($user,array('route'=>array('admin.staff.update',$user->id),'method'=>'PUT','files'=>true))}}
								<div class="form-group">
									{{Form::hidden('img_bk',$user->image_url)}}
									<div class="wrap-img-preview">
										<img src="{{asset($user->image_user)}}" class="img-responsive" alt="">
									</div>
									{{Form::file('img')}}
								</div>
								<div class="form-group">
									{{Form::label('Role')}}
									{{Form::select('role',$list_role,$user->role,array('class'=>'form-control'))}}
								</div>
								<div class="form-group">
									{{Form::label('Name')}}
									{{Form::text('name',old('name'),array('class'=>'form-control', 'placeholder'=>'Type your Name'))}}
								</div>
								<div class="form-group">
									{{Form::label('Email')}}
									{{Form::text('email',old('email'),array('class'=>'form-control', 'placeholder'=>'Type your Email'))}}
								</div>
								<div class="form-group">
									{{Form::label('Fullname')}}
									{{Form::text('fullname',old('fullname'),array('class'=>'form-control', 'placeholder'=>'Type your Fullname'))}}
								</div>
								<div class="form-group">
									{{Form::label('Birthday')}}
									{{Form::text('birthday',old('birthday'),array('class'=>'form-control','id'=>'datepicker', 'readonly'=>true, 'placeholder'=>'Select your birthday'))}}
								</div>
								<div class="form-group">
									{{Form::label('Company')}}
									{{Form::text('company',old('company'),array('class'=>'form-control', 'placeholder'=>'Type your title'))}}
								</div>
								<div class="form-group">
									{{Form::label('Address')}}
									{{Form::text('address',old('address'),array('class'=>'form-control', 'placeholder'=>'Type your address'))}}
								</div>
								<div class="form-group">
									{{Form::label('Phone')}}
									{{Form::text('tel',old('tel'),array('class'=>'form-control', 'placeholder'=>'Type your phone'))}}
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
	{{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
	{{Html::script('assets/backend/js/bootstrap.min.js')}}

	{{Html::script('assets/backend/js/switch/lc_switch.js')}}
	{{Html::style('assets/backend/js/switch/lc_switch.css')}}

	{{Html::script('assets/backend/js/swiper/swiper.jquery.min.js')}}
	{{Html::style('assets/backend/js/swiper/swiper.min.css')}}

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

	{{Html::script('assets/backend/js/script.js')}}
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

	        $('#datepicker').datepicker({
	        	changeMonth: true,
                yearRange: '1905:2016',
                dateFormat: "yy-mm-dd",
                showAnim: 'drop',
                changeYear: true
	        });
		})
	</script>
@stop