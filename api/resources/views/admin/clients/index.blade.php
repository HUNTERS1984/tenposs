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
		<p>&nbsp;</p>
		<div class="clearfix">
            <p style="margin-bottom:10px;" class="">Showing {{$users->firstItem()}}/{{$users->lastItem()}} of {{$users->total()}}results</p>
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
					<th>Fullname</th>
					<th>Status</th>
					<th>Tel</th>
					<th>Function</th>
				</tr>
			</thead>
			<tbody>
				@if (count($users) > 0)
				@foreach($users as $user)
				<?php $class = ( $user->status == 2 ) ? 'bg-red' : '' ?>
				<tr class="{{ $class }}">
					<td><a href="{{ route('admin.clients.show',['user_id' => $user->id]) }}">{{ $user->name }}</a></td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->fullname }}</td>
					<td>{{ $user->status }}</td>
					<td>{{ $user->tel }}</td>
					<td>
						<a href="{{ route('admin.clients.apps',['id' => $user->id]) }}">Apps ({{ $user->apps()->count() }})</a><br>
						<a href="{{ route('admin.clients.show',['user_id' => $user->id]) }}">View</a>
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
		
		<div class="pagination pull-right">
			<div class="clearfix">
				{{ $users->render() }}
			</div>
			
		</div>
	</div>	<!-- wrap-content-->
</div>
<!-- END -->
@endsection


@section('footer')
<script src="{{ url('adcp/js/script.js') }}"></script>
@endsection