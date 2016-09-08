@extends('admin::layouts.default')

@section('title', 'News')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">ニュース</h1>
				</div>
				<div class="right-topbar">
					<a href="{{ URL::previous() }}" class="btn-me btn-topbar">戻る</a>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content news">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-8">
						@if (Session::has('success'))
						    <div class="alert alert-info">{{ Session::get( 'success' ) }}</div>
						@endif
						@if (Session::has('error'))
						    <div class="alert alert-danger">{{ Session::get( 'error' ) }}</div>
						@endif
						<div class="wrapper-content">
							{{Form::model($news,array('route'=>array('admin.news.update',$news->id),'method'=>'PUT','files'=>true))}}
								<div class="form-group">
									{{Form::label('store','ストア')}}
									{{Form::select('store_id',$list_store,$news->store_id,array('class'=>'form-control'))}}
								</div>
								<div class="form-group">
									{{Form::label('title','タイトル')}}
									{{Form::text('title',old('title'),array('class'=>'form-control', 'placeholder'=>'Type the title'))}}
								</div>
								<div class="form-group">
									{{Form::label('description','説明')}}
									{{Form::textarea('description',old('description'),array('class'=>'form-control', 'placeholder'=>'Type the description'))}}
								</div>
								<div class="form-group">
									<img class="edit_img" src="{{asset($news->image_url)}}" width="100%">
									<button class="btn_upload_img edit " type="button"><i class="fa fa-picture-o" aria-hidden="true"></i>画像アップロード</button>
                					{!! Form::file('image_edit',['class'=>'btn_upload_ipt edit', 'hidden', 'type' => 'button', 'id' => 'image_edit']) !!}
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