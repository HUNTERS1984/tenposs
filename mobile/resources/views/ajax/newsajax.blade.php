@foreach($news_detail->data->news as $item)
<div class="item-coupon imageleft clearfix">
    <input type="hidden" name="pagesize{{$cate_id}}" value="{{$pagesize}}">
    <div class="image">
        <img class="center-cropped" src="{{$item->image_url}}" alt="Nakayo"/>
    </div>
    <div class="info clearfix">
        <a href="{{route('news.detail',[$item->id])}}">{{$item->title}}</a>
        <h3>{{$item->news_cat->name}}</h3>
        <p>{{Str::words($item->description,20)}}</p>
    </div>
</div><!-- End item coupon -->
@endforeach
