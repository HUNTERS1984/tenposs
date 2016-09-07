<div class="row">
	@foreach($list_item as $item)
		<div class="col-xs-4">
				<div class="each-menu each-common-pr">
					<p class="title-menu"><a href="{{route('admin.menus.edit',$item->id)}}"><img src="{{asset($item->image_url)}}" class="img-responsive" alt="Item"></a></p>
					<p class="">{{$item->title}}</p>
					{{Form::open(array('route'=>['admin.photo-cate.destroy',$item->id],'method'=>'DELETE'))}}
						{{Form::submit('削除',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
					{{Form::close()}}
				</div>

		</div>
	@endforeach
	@if(!$list_item->isEmpty())
		<button class="view-more-btn btn btn-primary btn-block">もっと見る</button>
	@endif
</div>
