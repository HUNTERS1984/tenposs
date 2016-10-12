<div class="row" id="row-data" >
    @if(count($items_data) > 0)
        @foreach($items_data as $item)
            <div class="item-product">
                <a href="{{ route('menus.detail', $item->id)}}">
                    <img src="{{$item->image_url}}}" alt="{{$item->title}}"/>
                    <p>{{$item->title}}</p>
                    <span>$ {{number_format($item->price, 0, '', '.')}}</span>
                </a>
            </div>
        @endforeach
    @else
        <p style="text-align: center;">データなし</p>
    @endif
</div>
@if($total_page > 1)
    <div class="row"  style="text-align:center;"  id="div_load_more">
        <a href="javascript:void(0)" id="load_more" class="btn tenposs-readmore">もっと見る</a>
    </div>
@endif
