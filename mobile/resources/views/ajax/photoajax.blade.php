@foreach($photo_detail->data->photos as $item)
<div class="item-photogallery">
    <input type="hidden" name="pagesize{{$item->photo_category_id}}" value="{{$pagesize}}">
    <a href="{{$item->image_url}}" data-toggle="lightbox" data-gallery="multiimages" data-title="People walking down stairs">
        <img src="{{$item->image_url}}" class="img-responsive" alt="Nayako"/>
    </a>
</div>
@endforeach
