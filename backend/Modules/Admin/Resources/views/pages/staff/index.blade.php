@extends('admin::layouts.default')

@section('title', 'Staff')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">Coupon</h1>
				</div>
				<div class="right-topbar">
					 <span class="switch-button"><input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable" /></span>
					<a href="javascript:avoid()" class="btn-me btn-topbar" data-toggle="modal" data-target="#myModal">Add New</a>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content staff">
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
										@if($all_user->isEmpty())
											<p>No data</p>
										@else
											@foreach($all_user as $item_thumb)
												<div class="col-xs-4 padding-me">
													<div class="each-staff">
														<img src="{{asset($item_thumb->image_user)}}" class="img-responsive" alt="">
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
							<a href="#" class="btn-me btn-hong">スタの新着情報</a>
							<a href="#" class="btn-me btn-xanhduongnhat">スタの新着情報 2</a>
						</div>	<!-- end wrap-btn-content-->
						<div class="wrapper-content clearfix">
							<div class="grip">
								@if($all_user->isEmpty())
									<p>No data</p>
								@else
									@foreach($all_user as $item)
									<div class="each-menu each-common-pr">
										<a href="{{route('admin.staff.edit',$item->id)}}"><img src="{{asset($item->image_user)}}" class="img-responsive" alt="{{$item->fullname}}"></a>
										<p><a href="{{route('admin.staff.edit',$item->id)}}">{{$item->fullname}}</a></p>
										<p><a href="{{route('admin.staff.edit',$item->id)}}">{{$item->email}}</a></p>
										{{Form::open(array('route'=>['admin.staff.destroy',$item->id],'method'=>'DELETE') )}}
											{{Form::submit('Delete',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
										{{Form::close()}}
									</div>
									@endforeach
								@endif
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
	    {{Form::open(array('route'=>'admin.staff.store','files'=>true))}}
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Add More Staff</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
	      		{{Form::label('Select Role')}}
	      		{{Form::select('role',['admin'=>'Admin','staff'=>'Staff'],old('role'),['class'=>'form-control'])}}

	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Name')}}
	      		{{Form::text('name',old('name'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Email')}}
	      		{{Form::text('email',old('email'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Password')}}
	      		{{Form::password('password',['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Fullname')}}
	      		{{Form::text('fullname',old('fullname'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Sex')}}
	      		{{Form::select('sex',['0'=>'Female','1'=>'Male'],old('sex'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Birthday')}}
	      		{{Form::text('dob',old('dob'),['class'=>'form-control','id'=>'datepicker','readonly'=>true])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Company')}}
	      		{{Form::text('company',old('company'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Address')}}
	      		{{Form::text('address',old('address'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Phone number')}}
	      		{{Form::text('tel',old('tel'),['class'=>'form-control'])}}
	      	</div>
	      	<div class="form-group">
	      		{{Form::label('Avatar')}}
	      		{{Form::file('img')}}
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
	{{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
	{{Html::script('assets/backend/js/bootstrap.min.js')}}

	{{Html::script('assets/backend/js/switch/lc_switch.js')}}
	{{Html::style('assets/backend/js/switch/lc_switch.css')}}

	{{Html::script('assets/backend/js/swiper/swiper.jquery.min.js')}}
	{{Html::style('assets/backend/js/swiper/swiper.min.css')}}

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

	{{Html::script('assets/backend/js/Masonry.js')}}

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

	       $('.grip').masonry({
	       	 	itemSelector: '.each-menu',
				columnWidth: '.each-menu',
				percentPosition: true,
				gutter: 10
	       })
 		})
	</script>
@stop