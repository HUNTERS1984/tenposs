@extends('admin::layouts.default')

@section('title', 'クーポン')

@section('content')
<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">クーポン</h1>
				</div>
				<div class="right-topbar">
					<a href="{{ URL::previous() }}" class="btn-me btn-topbar">戻る</a>
				</div>
			</div>
		</div>
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">{{$coupon->name}}</h1>
				</div>
			</div>
		</div>
			<div class="wrapper-content">
			@if (Session::has('success'))
			    <div class="alert alert-info">{{ Session::get( 'success' ) }}</div>
			@endif
			@if (Session::has('error'))
			    <div class="alert alert-danger">{{ Session::get( 'error' ) }}</div>
			@endif
				<table class="table table-striped table-bordered table-condensed table-hover table-th-block table-primary table-fixed" >
					<thead>
						<tr>
							<th>Name</a></th>
							<th>Image</th>
							<th>URL</th>
							<th>Caption</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if (count($posts) > 0)
						@foreach($posts as $post)
						<tr>
							<td>{{ $post->social_user_name }}</td>
							<td><img src="{{ $post->image_url }}" style="width:100%; height:auto"></td>
							<td>{{ $post->url }}</td>
							<td>{{ $post->caption }}</td>
							<td>
								@if ($post->status == 0)
								<a href="{{route('admin.coupon.approve',['coupon_id'=>$coupon->id, 'post_id'=>$post->id])}}">承認</a>
								@else
								<a href="{{route('admin.coupon.unapprove',['coupon_id'=>$coupon->id, 'post_id'=>$post->id])}}">キャンセル</a>
								@endif
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
				<div class="pagination pull-right">
					<div class="clearfix">
						{{ $posts->render() }}
					</div>
					
				</div>
			</div>	<!-- wrap-content-->
	
<!-- END -->
@endsection


@section('footer')
<script src="{{ url('adcp/js/script.js') }}"></script>
@endsection