<div class="header">
	<a href="{{ route('admin.home') }}">
		<img src="{{ url('adcp/images/logo.jpg') }}" class="img-responsive" alt="TenPoss">
	</a>
	<p class="pull-right">
		Welcome: {{ Auth::user()->email }}
		<a href="{{route('admin.logout')}}">Logout</a>
	</p>
</div>