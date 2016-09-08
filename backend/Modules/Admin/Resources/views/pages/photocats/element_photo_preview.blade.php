<div class="row-me fixHeight">
	@foreach($list_photo as $item_thumb)
	<div class="col-xs-4 padding-me">
		<div class="each-staff">
			<img src="{{asset($item_thumb->image_url)}}" class="img-responsive" alt="Photo">
		</div>
	</div>
	@endforeach
</div>