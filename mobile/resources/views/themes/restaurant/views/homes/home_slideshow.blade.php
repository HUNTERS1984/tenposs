<!-- Slides -->
<ul class="bxslider coupon">
    @if( isset( $app_top->data->images->data)  && count($app_top->data->images->data) > 0 )
    @foreach( $app_top->data->images->data as $img )
    <li>
        <img src="{{ $img->image_url }}" alt="">
        <!--
        <div class="bx-caption">
            <h3>15％の割引</h3>
            <p>最初の購入のための</p>
            <p>Code <span>GETTING15</span></p>
            <button>アクセス</button>
        </div>
        -->
    </li>
    @endforeach
    @endif
</ul>
