<div id="template-3" class="content-preview news">
    <p class="title-top-preview">
        ニュース
    </p>
    @foreach( $news as $new )
    <div class="each-coupon clearfix">
        <img src="{{asset($new->image_url)}}"
             class="img-responsive img-prview">
        <div class="inner-preview">
            <p class="title-inner"
               style="font-size:9px; color:#14b4d2">{{$new->title}}</p>
            <!-- <p class="sub-inner" style="font-weight:600px; font-size:9px;">スタの新着情報</p> -->
            <p class="text-inner"
               style="font-size:9px;">{{Str::words( strip_tags($new->description),12)}}</p>
        </div>
    </div>
    @endforeach
    <a href="#" class="btn tenposs-readmore">もっと見る</a>
</div>