<div id="template-2" class="content-preview menu">
    <p class="title-top-preview">
        最近
    </p>
    <div class="row-me fixHeight">
        @foreach($items as $item_thumb)
            <div class="col-xs-6 padding-me">
                <div class="each-menu">
                    <img src="{{asset($item_thumb->image_url)}}"
                         class="img-responsive img-item-prview"
                         alt="Item Photo">
                    <p style="font-size:11px">{{$item_thumb->title}}</p>
                    <p style="font-size:11px">¥{{$item_thumb->price}}</p>
                </div>
            </div>
        @endforeach
    </div>
    <a href="#" class="btn tenposs-readmore">もっと見る</a>
</div>