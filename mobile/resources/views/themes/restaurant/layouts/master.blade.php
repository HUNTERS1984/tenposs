<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include jQuery Mobile stylesheets -->
    <link rel="stylesheet" href="{{ Theme::asset('css/jquery.mobile-1.4.5.css')}}">
    <!-- Include the jQuery library -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Include the jQuery Mobile library -->
    <script src="{{ Theme::asset('js/jquery.mobile-1.4.5.min.js') }}"></script>
    <link rel="stylesheet" href="{{ Theme::asset('css/jquery.bxslider.css') }}" type="text/css" />
</head>
<body class="ui-nosvg">

<div data-role="header" data-position="fixed" data-theme="a">
    <a href="#outside" class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext">Menu</a>
    <h1>ホーム</h1>
</div>
<div data-role="page" id="pageone" class="coupon">
<div data-role="main" class="ui-content">
<ul class="bxslider coupon">
    <li><img src="img/photo01_detail.jpg" alt="photo01_detail">
        <div class="bx-caption">
            <h3>15％の割引</h3>
            <p>最初の購入のための</p>
            <p>Code <span>GETTING15</span></p>
            <button>アクセス</button>
        </div>
    </li>
    <li><img src="img/photo01_detail.jpg" alt="photo01_detail">
        <div class="bx-caption">
            <h3>15％の割引</h3>
            <p>最初の購入のための</p>
            <p>Code <span>GETTING15</span></p>
            <button>アクセス</button>
        </div>
    </li>
    <li><img src="img/photo01_detail.jpg" alt="photo01_detail">
        <div class="bx-caption">
            <h3>15％の割引</h3>
            <p>最初の購入のための</p>
            <p>Code <span>GETTING15</span></p>
            <button>アクセス</button>
        </div>
    </li>
</ul><!--bxslider-->
<div data-role="navbar">
    <ul>
        <li><a href="#" class="ui-icon-coupon ui-btn-icon-top">クーポン</a></li>
        <li><a href="#" class="ui-icon-chat ui-btn-icon-top">チャット</a></li>
        <li><a href="#" class="ui-icon-phone ui-btn-icon-top">電話</a></li>
        <li><a href="#" class="ui-icon-direction ui-btn-icon-top">道順</a></li>
    </ul>
</div>
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
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>
        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>

        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>

        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>
        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>
        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>

        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>

        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>
        </div>
        <div class="slide">
            <figure>
                <img src="img/product01.jpg" alt="product01">
            </figure>
            <a href="#">松阪牛コース 紅葉</a><br>
            <span class="">会席料理コース</span>
            <div class="price">¥20,000</div>

        </div>
    </div><!--menu-->
</div><!--menu-->
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
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo_index01.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo_index02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
        <div class="slide"><a href="photo_detail.html" data-ajax="false"><img src="img/photo02.jpg" alt="test"></a></div>
    </div><!--slider1-->
</div><!--news-->

<div id="news">
    <div class="ui-grid-a">
        <div class="ui-block-a">
            <h3 class="icon">ニュース</h3>
        </div>
        <div class="ui-block-b">
            <div class="outside">
                <p><!--<span id="slider-prev"></span> | --><span id="news-next"></span></p>
            </div>
        </div>

    </div><!---gib-a-->
    <div class="news">
        <div class="slide">
            <div class="listnews">
                <div class="items">
                    <figure>
                        <img src="img/product01.jpg" alt="product01">
                    </figure>
                    <div class="text">
                        <h3>顧客が店でパンを受信するには無料ドリンクを与えます</h3>
                        <p>アメリカ大統領選挙に向けた最後のテ</p>
                        <p class="date">10月20日 12時23分</p>
                    </div>
                </div><!--items-->
                <div class="items">
                    <figure>
                        <img src="img/product01.jpg" alt="product01">
                    </figure>
                    <div class="text">
                        <h3>顧客が店でパンを受信するには無料ドリンクを与えます</h3>
                        <p>アメリカ大統領選挙に向けた最後のテ</p>
                        <p class="date">10月20日 12時23分</p>
                    </div>
                </div><!--items-->
                <div class="items">
                    <figure>
                        <img src="img/product01.jpg" alt="product01">
                    </figure>
                    <div class="text">
                        <h3>顧客が店でパンを受信するには無料ドリンクを与えます</h3>
                        <p>アメリカ大統領選挙に向けた最後のテ</p>
                        <p class="date">10月20日 12時23分</p>
                    </div>
                </div><!--items-->
            </div>
        </div>

    </div><!--slider1-->
</div><!--news-->
</div>
</div>
</div>

@include('partials.sidemenu')

</body>
</html>