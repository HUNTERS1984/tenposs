<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}">
    @yield('SEO')
	{{Html::style(asset('assets/frontend').'/css/bootstrap.min.css')}}
	{{Html::style(asset('assets/frontend').'/css/animate.css')}}
	@yield('css')

</head>

<body>
	<div class="page">
		@include('layouts.header')
			@yield('content')
		@include('layouts.footer')
	</div>
	
	{{Html::script(asset('assets/frontend').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(asset('assets/frontend').'/js/bootstrap.min.js')}}
	@yield('script')
	{{Html::script(asset('assets/frontend').'/js/common.js')}}
</body>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2436302-60', 'auto');
  ga('send', 'pageview');

</script>
