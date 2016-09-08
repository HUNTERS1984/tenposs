@extends('admin::layouts.default')

@section('title', 'フォトギャラリー')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">フォトギャラリー</h1>
				</div>
				<div class="right-topbar">
					<a href="{{ URL::previous() }}" class="btn-me btn-topbar">戻る</a>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content news">
			@include('admin::layouts.message')
			<div class="container-fluid">
				<div class="row">
<<<<<<< HEAD
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
									@if($photo_all->isEmpty())
										No data
									@else
										@foreach($photo_all as $item_thumb)
											<div class="each-coupon clearfix">
												<!-- <img src="{{asset($item_thumb->image_url)}}" class="img-responsive img-prview"> -->
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
							{{Form::model($photo,array('route'=>array('admin.photo.update',$photo->id),'method'=>'PUT','files'=>true))}}
								<div class="form-group">
									{{Form::select('photo_category_id',array(''=>'Select Photo Category...')+$photocate_list,$photo->photo_category_id,array('class'=>'form-control'))}}
								</div>
								<div class="form-group">
									{{Form::hidden('img_bk',$photo->image_url)}}
									<div class="wrap-img-preview">
										<img src="{{asset($photo->image_url)}}" class="img-responsive" alt="">
									</div>
									{{Form::file('img')}}
=======
					<div class="col-lg-8">
						<div class="wrapper-content">
							{{Form::model($photo,array('route'=>array('admin.photo-cate.update',$photo->id),'method'=>'PUT','files'=>true))}}
								<div class="form-group">
									<img class="edit_img" src="{{asset($photo->image_url)}}" width="100%">
									<button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o" aria-hidden="true"></i>画像アップロード</button>
                					{!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
								</div>
								<div class="form-group">
									{{Form::label('Select Photo Category','カテゴリー')}}
		      						{{Form::select('photo_category_id',$photocat->pluck('name', 'id'),old('photo_category_id'),['class'=>'form-control'])}}
>>>>>>> 889e1ea40fdd0229517b26ca4105375d9e23ffbe
								</div>
								<div class="form-group">
									{{Form::submit('保存',array('class'=>'btn btn-primary'))}}
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

	       	$('.btn_upload_img.edit').click(function(){
	           $('.btn_upload_ipt.edit').click();
	        });

			function readURL(input) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();

			        reader.onload = function (e) {
			            $('.edit_img').attr('src', e.target.result);
			        }

			        reader.readAsDataURL(input.files[0]);
			    }
			}

			$("#image_edit").change(function(){
			    readURL(this);
			});
		})
	</script>
@stop