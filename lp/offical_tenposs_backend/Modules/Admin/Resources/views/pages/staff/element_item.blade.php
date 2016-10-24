<div class="row">
	@foreach($list_staff as $item)
		<div class="col-xs-4">
				<div class="each-menu each-common-pr">
					<p class="title-menu"><a href="{{route('admin.staff.edit',$item->id)}}"><img src="{{asset($item->image_url)}}" class="img-responsive" alt="Item"></a></p>
					<p class="">{{$item->name}}</p>
					{{Form::open(array('route'=>['admin.staff.destroy',$item->id],'method'=>'DELETE'))}}
						{{Form::submit('削除',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
					{{Form::close()}}
				</div>

		</div>
	@endforeach
	@if(count($list_staff) > 0)
		<button class="view-more-btn btn btn-primary btn-block">もっと見る</button>
	@endif
</div>
