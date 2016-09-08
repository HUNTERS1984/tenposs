<div class="container-fluid">
	<div class="row">
		@foreach($list_photo as $item)
			<div class="col-xs-4">
				<div class="each-menu each-common-pr">
					<p class="title-menu"><a href="{{route('admin.photo-cate.edit',$item->id)}}"><img src="{{asset($item->image_url)}}" class="img-responsive" alt="Photo"></a></p>
					{{Form::open(array('route'=>['admin.photo-cate.destroy',$item->id],'method'=>'DELETE'))}}
						{{Form::submit('削除',array('class'=>'btn-me btn-menu','style'=>'width:100%'))}}
					{{Form::close()}}
				</div>
			</div>
		@endforeach

		@if(!$list_photo->isEmpty())
			<button class="view-more-btn btn btn-primary btn-block">もっと見る</button>
		@endif
	</div>
</div>
