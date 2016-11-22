@foreach($photo_detail->data->photos as $item)
<div class="item-photogallery">
    <input type="hidden" name="pagesize{{$item->photo_category_id}}" value="{{$pagesize}}">
    <div class="crop">
        <div class="inner-crop">
             <a href="{{$item->image_url}}" data-lightbox="lightbox">
                <img src="{{$item->image_url}}" class="img-responsive" alt="Nayako"/>
            </a>
        </div>
    </div>
</div>
@endforeach
