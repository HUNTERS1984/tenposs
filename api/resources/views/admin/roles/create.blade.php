
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
        		<a href="{{ route('admin.roles.index') }}" class="btn-me btn-hong">Cancel</a>
        	</div>	<!-- end wrap-btn-content-->
		    <div class="panel panel-info">
    			<div class="panel-heading">Create Roles </div>
    			<div class="panel-body">
        			<form action="{{ route('admin.roles.store') }}" method="post">
                        <input name="_token" type="hidden" value="{{csrf_token()}}" />
                        <div class="form-group">
                            <label for="">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            <label for="" class="text-muted">Only a-z character, no space and no specified character.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
        		</div>
        	</div>	
        </div>			
        		
    </div>
    <!-- END -->



@endsection
