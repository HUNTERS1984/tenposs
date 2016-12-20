@foreach($staff_detail->data->staffs as $item)
<div class="item-photogallery" data-cate-id="{{$item->staff_category_id}}">
<input type="hidden" name="pagesize{{$item->staff_category_id}}" value="{{$pagesize}}">
  <div class="crop">
        <div class="inner-crop">
            <a href="{{route('staff.detail',$item->id)}}">
                <img src="{{$item->image_url}}" alt="Nakayo"/>
            </a>
        </div>

    </div>
</div>

@endforeach
