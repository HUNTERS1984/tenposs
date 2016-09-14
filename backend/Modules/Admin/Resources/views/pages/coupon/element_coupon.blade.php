@if(count($coupons) > 0)
    @foreach ($coupons as $coupon)
        <div class="each-coupon each-item clearfix">
            <a href="{{ URL::route('admin.coupon.show', $coupon->id) }}"><img src="{{url('/').'/'.$coupon->image_url}}"
                                                                              class="img-responsive img-prview" alt=""></a>
            <div class="main-title">
                <h2><a href="{{ URL::route('admin.coupon.show', $coupon->id) }}">{{$coupon->coupon_type->name}}</a></h2>
                <p><a href="{{ URL::route('admin.coupon.show', $coupon->id) }}">{{$coupon->title}}</a></p>
                <a href="#"
                   class="btn-me btn-each-item"
                   data-toggle="modal"
                   data-id="{{ $coupon->id }}"
                   data-coupontype="{{ $coupon->coupon_type->id }}"
                   data-title="{{ $coupon->title }}"
                   data-description="{{ $coupon->description }}"
                   data-hashtag="bbbbbbb"
                   data-startdate="{{ $coupon->start_date }}"
                   data-enddate="{{ $coupon->end_date }}"
                   data-image="{{ $coupon->image_url }}"
                   data-target="#EditCoupon">編集</a>
            </div>
            <p class="time">有効期間　{{$coupon->end_date}}まで</p>
            <div class="container-content">
                <p>{{$coupon->description}}</p>
            </div>
        </div>
    @endforeach
    <div class="clearfix">
        @if(!$coupons->isEmpty())
            {{ $coupons->render() }}
        @endif
    </div>
@endif