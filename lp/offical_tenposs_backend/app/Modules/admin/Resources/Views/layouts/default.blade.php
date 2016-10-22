<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<title>AdminLTE 2 | Starter</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">


	{{Html::style(asset('assets/backend').'/bootstrap/css/bootstrap.min.css')}}
	{{Html::style(asset('assets/backend').'/js/datatable/css/jquery.dataTables.min.css')}}

		 <!-- Font Awesome -->
	{{Html::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css')}}

	<!-- Ionicons -->
	{{Html::style('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}
	<!-- Theme style -->
	{{Html::style(asset('assets/backend').'/css/AdminLTE.min.css')}}

	<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
	        page. However, you can choose any other skin. Make sure you
	        apply the skin class to the body tag so the changes take effect.
	  -->
	 {{Html::style(asset('assets/backend').'/css/skins/skin-blue.min.css')}}

	 <!-- CUSTOMIZE -->
	 {{Html::style(asset('assets/backend').'/css/style.css')}}

	<!-- Date Picker -->
	{{Html::style(asset('assets/backend').'/plugins/datepicker/datepicker3.css')}}

	<!-- Html5 Shiv and Respond.js for IE8 support of Html5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!--
	BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
</head>
<body class="skin-blue sidebar-mini">
	<div class="wrapper">
		<div class="wrap-loading">
			<img src="{{asset(asset('assets/backend').'/img/loading.gif')}}" alt="">
		</div>
		@include('admin::layouts.header')
		@include('admin::layouts.sidebar')
			<div class="content-wrapper">
				@yield('content')
			</div> <!-- end content-wrapper-->

		@include('admin::layouts.footer')
	</div>	<!-- end wrapper-->

	{{Html::script(asset('assets/backend').'/js/jQuery-2.1.4.min.js')}}
	 <!-- CORE JQUERY SCRIPTS -->
	{{Html::script(asset('assets/backend').'/bootstrap/js/bootstrap.min.js')}}
	{{Html::script(asset('assets/backend').'/js/datatable/jquery.dataTables.min.js')}}


	<!-- datepicker -->
	{{Html::style(asset('assets/backend').'/plugins/datepicker/bootstrap-datepicker.js')}}
	<!-- APP -->
	{{Html::script(asset('assets/backend').'/js/app.js')}}

	<!-- CKEDITOR + ALERT -->
	{{Html::script(asset('assets/backend').'/js/ckeditor/ckeditor.js')}}
	{{Html::script(asset('assets/backend').'/js/alert/alertify.js')}}
	{{Html::style(asset('assets/backend').'/js/alert/alertify.css')}}
	{{Html::style(asset('assets/backend').'/js/alert/semantic.min.css')}}
	
	@yield('script')
</body>
</html>