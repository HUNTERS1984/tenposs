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
		<div class="clearfix">
            <p style="margin-bottom:10px;" class="">{{ count($usersLists) }} results</p>
			<p>
				<span class="noted-color bg-red block-20">User not approved</span>
			</p>
			<p>&nbsp;</p>
		</div>
		
		<div class="panel panel-info">
			<div class="panel-heading">Clients </div>
			<div class="panel-body">
                <table class="table table-responsive" >
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Function</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($usersLists) > 0)
                    @foreach($usersLists as $user)
                    <?php $class = ( $user->active == 0 ) ? 'bg-red' : '' ?>
                    <tr class="{{ $class }}">
                        <td><a href="{{ route('admin.clients.show',['user_id' => $user->id]) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->active }}</td>
                        <td>
                            <a href="{{ route('admin.clients.show',['user_id' => $user->id]) }}">
                                <i class="fa fa-search"></i>
                                View</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td></td>
                    </tr>
                    @endif
                    </tbody>
                </table>
			</div>
		</div>
		
	</div>	<!-- wrap-content-->
</div>
<!-- END -->
@endsection


@section('footer')
<script src="{{ url('adcp/js/script.js') }}"></script>
@endsection