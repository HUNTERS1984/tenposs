<div class="row-me fixHeight">
	@foreach($list_staff as $item_thumb)
		<div class="col-xs-6 padding-me">
			<div class="each-menu">
				<img src="{{asset($item_thumb->image_url)}}" class="img-responsive img-item-prview" alt="Item Photo">
			</div>
		</div>
	@endforeach
</div>