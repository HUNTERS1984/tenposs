<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    {{Html::style('assets/backend/css/bootstrap.min.css')}}
    {{Html::style('assets/backend/css/style.css')}}
	{{Html::style('assets/backend/css/jquery.fileupload.css')}}
	{{Html::style('assets/backend/css/jquery.fileupload-ui.css')}}
	<noscript>
		<link rel="stylesheet" href="{{URL::to('assets/backend/css/jquery.fileupload-noscript.css')}}">
	</noscript>
	<noscript>
		<link rel="stylesheet" href="{{URL::to('assets/backend/css/jquery.fileupload-ui-noscript.css')}}">
	</noscript>
	<title>@yield('title','TenPoss')</title>

</head>
<body>
	<div class="page">
		@include('admin::layouts.header')
		<div class="main common">

			@include('admin::layouts.sidebar')

			@yield('content')

			@yield('script')
		</div>

	</div>
</body>
</html>