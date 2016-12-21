@extends('layouts.master')
@section('title')
メニュー
@stop
@section('header')
<link rel="stylesheet" href="{{ Theme::asset('css/jqm-demos.css') }}">
<script src="{{ Theme::asset('js/index.js') }}"></script>
<style>

    body{
    font-size: {{ $app_info->data->app_setting->font_size }};
    font-family: "{{ $app_info->data->app_setting->font_family }}";
        }

    div[data-role="header"]{
        background-color:#{{ $app_info->data->app_setting->header_color }};
        }
    div[data-role="header"] h1{
        color: #{{ $app_info->data->app_setting->title_color }}
        }
    div[data-role="header"] a{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }

</style>
@stop
@section('main')

<div data-role="header" data-position="fixed" data-theme="a">
    <a href="#outside" class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext">Menu</a>
    <h1>メニュー</h1>
</div>


<div data-role="page" class="jqm-demos" data-quicklinks="true">
    <div data-role="main" class="ui-content">
        <div data-role="tabs" class="tabs">
            <div data-role="navbar">
                <ul>
                    @if( isset($menus)  && count($menus) > 0 )
                    @foreach($menus as $cate)
                    @foreach($cate->data->menus as $name_cate)
                    <li ><a href="#cat{{$name_cate->id}}" data-theme="a" data-ajax="false" class="ui-btn-active">{{$name_cate->name}}</a></li>
                    @endforeach
                    @endforeach
                    @endif
                </ul>
            </div>



            <div id="one" class="ui-content">
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <figure>
                                <img src="img/product01.jpg" alt="product01">					</figure>
                            <a href="product_detail.html" data-ajax="false">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <figure>
                                <img src="img/product02.jpg" alt="product02">					</figure>
                            <a href="product_detail.html" data-ajax="false">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <figure>
                                <img src="img/product03.jpg" alt="product03">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <figure>
                                <img src="img/product04.jpg" alt="product04">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
            </div><!--one-->
            <div id="two" class="ui-content">
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <figure>
                                <img src="img/product01.jpg" alt="product01">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <figure>
                                <img src="img/product02.jpg" alt="product02">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <figure>
                                <img src="img/product03.jpg" alt="product03">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <figure>
                                <img src="img/product04.jpg" alt="product04">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="three" class="ui-content">
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <figure>
                                <img src="img/product01.jpg" alt="product01">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <figure>
                                <img src="img/product02.jpg" alt="product02">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <figure>
                                <img src="img/product03.jpg" alt="product03">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <figure>
                                <img src="img/product04.jpg" alt="product04">					</figure>
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="four" class="ui-content">
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <div class="items">
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>

                    <div class="ui-block-b">
                        <div class="items">
                            <a href="#">松阪牛コース 紅葉</a><br>
                            <span class="">会席料理コース</span>
                            <div class="price">¥20,000</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page -->
@stop
@section('footer')
<script>
    $( document ).on( "pagecreate", function() {
        $( "body > [data-role='panel']" ).panel();
        $( "body > [data-role='panel'] [data-role='listview']" ).listview();
    });
    $( document ).one( "pageshow", function() {
        $( "body > [data-role='header']" ).toolbar();
        $( "body > [data-role='header'] [data-role='navbar']" ).navbar();
    });
</script>
@stop
