<div class="header">
	<a href="{{URL::to('top')}}">
		<img src="/assets/backend/images/logo.jpg" class="img-responsive" alt="TenPoss">
	</a>
	<a href="{{URL::to('admin/logout')}}" style="float: right;">
		{{ Auth::user()->name }} (ログアウト)
	</a>
</div>	<!-- end header -->