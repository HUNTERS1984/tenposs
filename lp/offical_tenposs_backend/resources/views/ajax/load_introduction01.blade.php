<div class="row">
	@foreach($data as $item)
	<div class="col-md-4">
		<div class="each-introcase">
			<a href="#"><img src="{{asset($item->img_url)}}" class="img-responsive"  alt="{{$item->img_alt}}"></a>
			<h3 class="title-each-introcase"><a href="#">{{$item->title}}</a></h3>
			<p class="content"><a href="#">{{Str::words($item->content,20)}}</a></p>
		</div>
	</div>
	@endforeach
</div>