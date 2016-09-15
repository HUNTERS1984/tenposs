
@extends('admin.master')

@section('content')
    <div class="topbar-content">
        <div class="wrap-topbar clearfix">
            <div class="left-topbar">
                <h1 class="title">Permissions</h1>
            </div>
        </div>
    </div>
    <!-- END -->

    <div class="main-content">
        @include('admin.partials.message')
        <div class="wrapper-content">
        	<div class="wrap-btn-content">
        		<a href="{{ route('admin.permissions.index') }}" class="btn-me btn-hong">Cancel</a>
        	</div>	<!-- end wrap-btn-content-->
		    <div class="panel panel-info">
    			<div class="panel-heading">Edit </div>
    			<div class="panel-body">
        			<form action="{{ route('admin.permissions.update',$pers->id) }}" method="post">
                        <input name="_method" type="hidden" value="PATCH" />
                        <input type="hidden" value="{{ $pers->id }}" name="id">
                        <input name="_token" type="hidden" value="{{csrf_token()}}" />
                        <div class="form-group">
                            <label for="">Permission Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $pers->name }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
        		</div>
        	</div>	
        </div>			
        		
    </div>
    <!-- END -->



@endsection
