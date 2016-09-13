@extends('admin.master')
@section('content')
    <div class="topbar-content">
        <div class="wrap-topbar clearfix">
            <div class="left-topbar">
                <h1 class="title">Dashboard</h1>
            </div>
        </div>
    </div>
    <!-- END -->

    <div class="main-content news">
        <div class="wrap-btn-content">
            <a href="#" class="btn-me btn-hong">スタの新着情報</a>
            <a href="#" class="btn-me btn-xanhduongnhat">スタの新着情報 2</a>
        </div>	<!-- end wrap-btn-content-->
        <div class="wrapper-content">
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-success">
                    	<div class="panel-heading">
                    		<h3 class="panel-title">Users registration</h3>
                    	</div>
                    	<div class="panel-body">
                    	    You have  <span class="label label-danger">({{ App\Models\User::where('status','2')->count() }})</span>  not approved
                    	</div>
                    	<div class="panel-footer">
                    	    <a href="{{ route('admin.approved.users') }}" class="btn btn-block btn-primary">Approved Now</a>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



