<div class="header">
	<a href="{{ route('admin.home') }}">
		<img src="{{ url('adcp/images/logo.jpg') }}" class="img-responsive" alt="TenPoss">
	</a>
	<p class="pull-right">
		@if( Auth::check() ) 
			{{ Auth::user()->email }}
			<a href="{{route('admin.logout')}}">出口</a>
		@endif
	</p>
</div>