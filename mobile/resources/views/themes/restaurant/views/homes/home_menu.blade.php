<div id="menu">
    <div class="ui-grid-a">
        <div class="ui-block-a">
            <h3 class="icon">メニュー</h3>
        </div>
        <div class="ui-block-b">
            <div class="outside">
                <p><!--<span id="slider-prev"></span> | --><span id="slider-next"></span></p>
            </div>
        </div>

    </div><!---gib-a-->
    <div class="menu">
        @if( isset( $app_top->data->items->data)
        && count($app_top->data->items->data) > 0 )

        @foreach( $app_top->data->items->data as $item )
        <div class="slide">
            <figure>
                <a data-ajax="false" href="{{ route('menus.detail', [ 'id' =>  $item->id ]) }}">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                </a>
            </figure>
            <a data-ajax="false" href="{{ route('menus.detail', [ 'id' =>  $item->id ]) }}"> {{ $item->title }}</a><br>
            <span class="">{{ $item->menu }}</span>
            <div class="price">¥{{number_format($item->price, 0, '', ',')}}</div>
        </div>
        @endforeach
        @endif
    </div><!--menu-->
</div><!--menu-->