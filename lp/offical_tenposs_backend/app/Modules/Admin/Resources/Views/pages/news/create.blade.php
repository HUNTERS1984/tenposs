@extends('admin::layouts.default')

@section('content')
<section class="content-header">
  <h1>Blog</h1>
</section>
<section class="content">
	<div class="box">
		{{Form::open(array('route'=>'admin.blog.store','class'=>'formAdmin form-horizontal','files'=>true))}}
			<div class="form-margin">
				<label for="name">Title</label>
				{{Form::text('title',old('title'),array('class'=>'form-control'))}}
			</div>

			<div class="form-margin">
				<label for="description">Content</label>
				{{Form::textarea('content',old('content'),array('class'=>'form-control ckeditor'))}}
			</div>
			<div class="form-margin">
				<label for="description">Upload Photo</label>
				{{Form::file('img')}}
			</div>

			<div class="form-margin">
				{{Form::submit('Save',array('class'=>'btn btn-primary'))}}
			</div>
		{{Form::close()}}
	</div>

</section>
@stop

@section('script')
	{{Html::script(env('PATH_BACKEND').'/js/ckfinder/ckfinder.js')}}
	{{Html::style('public/assets/backend/css/select.css')}}
@stop