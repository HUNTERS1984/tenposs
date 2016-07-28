<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    {{Html::style(env('PATH_ASSETS').'/css/bootstrap.min.css')}}
    {{Html::style(env('PATH_ASSETS').'/css/style.css')}}

	<title>@yield('title','TenPoss')</title>

</head>
<body>
	<div class="page">
		@include('layouts.header')
		<div class="main common">

			@include('layouts.sidebar')

			@yield('content')

			@yield('script')
		</div>

	</div>
</body>
</html>