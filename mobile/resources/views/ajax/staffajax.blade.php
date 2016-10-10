@foreach($staff_detail->data->staffs as $item)
<div class="item-photogallery" data-cate-id="{{$item->staff_category_id}}">
<input type="hidden" name="pagesize" value="{{$pagesize}}">
    <a href="{{route('staff.detail',$item->id)}}">
        <img src="{{$item->image_url}}" alt="Nakayo"/>
    </a>
</div>
@endforeach
