@foreach($items_detail['data']['items'] as $item)
<div class="item-product">
    <input type="hidden" name="pagesize{{$items_detail['data']['menu_id']}}" value="{{$pagesize}}">
    <a href="{{ route('menus.detail', $item['id'])}}">
        <img class="image_size center-cropped" src="{{$item['image_url']}}" alt="{{$item['title']}}"/>
        <p>{{$item['title']}}</p>
        <span>¥{{number_format($item['price'], 0, '', ',')}}</span>
    </a>
</div>
@endforeach
