<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    {{Html::style('assets/backend/css/bootstrap.min.css')}}
    {{Html::style('assets/backend/css/style.css')}}

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