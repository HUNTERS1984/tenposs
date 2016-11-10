<div id="template-5" class="content-preview photos">
    <p class="title-top-preview">
        フォトギャラリー
    </p>
    <div class="row-me fixHeight">
        @foreach($photos as $photo)
            <div class="col-xs-4 padding-me">
                <div class="each-staff">
                    <img src="{{asset($photo->image_url)}}" class="img-responsive" alt="Photo">
                </div>
            </div>
        @endforeach
        
    </div>
    <a href="#" class="btn tenposs-readmore">もっと見る</a>
</div>