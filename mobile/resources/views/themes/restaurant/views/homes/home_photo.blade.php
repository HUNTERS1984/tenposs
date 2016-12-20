<div id="photo">
    <div class="ui-grid-a">
        <div class="ui-block-a">
            <h3 class="icon ">フォト</h3>
        </div>
        <div class="ui-block-b">
            <div class="outside">
                <p><!--<span id="slider-prev"></span> | --><span id="photo-next"></span></p>
            </div>
        </div>

    </div><!---gib-a-->
    <div class="photo">
        @if( isset( $app_top->data->photos->data)
        && count($app_top->data->photos->data) > 0 )
        @foreach( $app_top->data->photos->data as $photo )
        <div class="slide"><a href="#" data-ajax="false"><img src="{{$photo->image_url}}" alt="test"></a></div>
        @endforeach
        @endif

    </div><!--slider1-->
</div><!--news-->
