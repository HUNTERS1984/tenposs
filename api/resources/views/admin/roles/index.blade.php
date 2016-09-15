@extends('admin.master')

@section('content')
    <div class="topbar-content">
        <div class="wrap-topbar clearfix">
            <div class="left-topbar">
                <h1 class="title">Roles</h1>
            </div>
        </div>
    </div>
    <!-- END -->

    <div class="main-content">
        @include('admin.partials.message')
        <div class="wrapper-content">
		    <div class="wrap-btn-content">
        	    <a href="{{ route('admin.roles.create') }}" class="btn-me btn-hong">Create new</a>
        	</div>	<!-- end wrap-btn-content-->
		    
		    <div class="panel panel-info">
    			<div class="panel-heading">Roles </div>
    			<div class="panel-body">
    				<table class="table table-responsive" >
            			<thead>
            				<tr>
            					<th>Name</th>
            					<th>Function</th>
            				</tr>
            			</thead>
            			
            			<tbody>
            			    @foreach( $roles as $role )
            			    <tr>
            			        <td>{{ $role->name }}</td>
            			        <td>
            			             <a class="btn btn-info" href="{{ route('admin.roles.edit',$role->id) }}">Edit</a>
            			        </td>
            			    </tr>
            			    @endforeach
            			</tbody>
            			
        			</table>
        		</div>
        	</div>	
        </div>			
        		
    </div>
    <!-- END -->



@endsection

