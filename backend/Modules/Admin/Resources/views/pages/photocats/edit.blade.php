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