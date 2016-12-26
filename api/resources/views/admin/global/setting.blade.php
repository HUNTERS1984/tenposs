@extends('admin.master')

@section('content')
<div class="topbar-content">
	<div class="wrap-topbar clearfix">
		<div class="left-topbar">
			<h1 class="title">Clients</h1>
		</div>
	</div>
</div>	
<!-- END -->

<div class="main-content news">
	<div class="wrapper-content">
		 @include('admin.partials.message')
		<p>&nbsp;</p>
		<form action="" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="">Admin email</label>
                <input type="text" name="admin_email" value="{{ $setting->admin_email }}">
            </div>  
            <button type="submit" name="save">Save</button>    
        </form>
		
	</div>	<!-- wrap-content-->
</div>
<!-- END -->
@endsection


@section('footer')
<script src="{{ url('adcp/js/script.js') }}"></script>
@endsection