<div class="row-me fixHeight" style="padding: 8px;">
	@foreach($list_news as $item_thumb)
		<div class="each-coupon clearfix">
			<img src="{{asset($item_thumb->image_url)}}"
				 class="img-responsive img-prview">
			<div class="inner-preview">
				<p class="title-inner"
				   style="font-size:9px; color:#14b4d2">{{$item_thumb->title}}</p>
				<!-- <p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p> -->
				<p class="text-inner"
				   style="font-size:9px;">{{Str::limit($item_thumb->description,55)}}</p>
			</div>
		</div>
	@endforeach
</div>