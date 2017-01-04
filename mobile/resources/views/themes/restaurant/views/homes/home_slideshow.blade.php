<!-- Slides -->
<div id="template-1">
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
<div data-role="navbar">
    <ul>
        <li><a href="{{ route('coupon') }}" class="ui-icon-coupon ui-btn-icon-top">クーポン</a></li>
        <li><a href="{{ route('chat') }}" class="ui-icon-chat ui-btn-icon-top">チャット</a></li>
        <li><a href="{{ route('reservation') }}" class="ui-icon-phone ui-btn-icon-top">電話</a></li>
        <li><a href="{{ route('home') }}" class="ui-icon-direction ui-btn-icon-top">道順</a></li>
    </ul>
</div>
</div>