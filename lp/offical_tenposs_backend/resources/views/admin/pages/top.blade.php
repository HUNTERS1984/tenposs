@extends('admin.layouts.master')

@section('main')
<form class="form-top" id="form_app_setting" method="post" action="{{ route('admin.client.top.store') }}">
    {{ csrf_field() }}
    <aside class="right-side">
        <div class="wrapp-breadcrumds">
            <div class="left"><span>トップ</span></div>
            <div class="right">
                <a id="btn_submit_form" class="btn-2">保存</a>
            </div>
        </div>
        <section class="content">
            <div class="col-xs-12">@include('admin.layouts.messages')</div>
            
            <div class="col-md-4">
                <div class="wrap-preview top">
                    <div class="wrap-content-prview">
                        <div class="scroller scrollbar-macosx">
                            <div class="header-preview">
                                <a href="javascript:avoid()" class="trigger-preview"><img
                                            src="/assets/backend/images/nav-icon.png" alt=""></a>
                                <h2 class="title-prview">ホーム</h2>
                            </div>
                            <div id="mobile-1" class="banner-preview">
                               <!-- Slider main container -->
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach( $slides as $slide )
                                        <div class="swiper-slide">
                                            <img width="228" src="{{ url($slide->image_url) }}" alt=""/>
                                        </div>
                                        @endforeach
                                      
                                    </div>
                                    <!-- If we need pagination -->
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                            
                            <div id="mobile-2" class="content-preview menu">
                                <p class="title-top-preview">
                                    最近
                                </p>
                                <div class="row-me fixHeight">
                                    @foreach($items as $item_thumb)
                                        <div class="col-xs-6 padding-me">
                                            <div class="each-menu">
                                                <img src="{{asset($item_thumb->image_url)}}"
                                                     class="img-responsive img-item-prview"
                                                     alt="Item Photo">
                                                <p style="font-size:11px">{{$item_thumb->title}}</p>
                                                <p style="font-size:11px">¥{{$item_thumb->price}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="#" class="btn tenposs-readmore">もっと見る</a>
                            </div>
                            
                            <div id="mobile-5" class="content-preview photos">
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
                            
                            <div id="mobile-3" class="content-preview news">
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
                                           style="font-size:9px;">{{Str::words($new->description,12)}}</p>
                                    </div>
                                </div>
                                @endforeach
                                <a href="#" class="btn tenposs-readmore">もっと見る</a>
                            </div>
                            
                            <div id="mobile-4" class="content-preview contact">
                                <div id="map-1" class="maps" style="position: relative; overflow: hidden;"><div style="height: 100%; width: 100%; position: absolute; background-color: rgb(229, 227, 223);"><div class="gm-style" style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0;"><div style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0;"><div style="position: absolute; left: 0px; top: 0px; z-index: 1; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;"><div style="width: 256px; height: 256px; position: absolute; left: 179px; top: -215px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 179px; top: 41px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 435px; top: -215px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 435px; top: 41px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -77px; top: -215px;"></div><div style="width: 256px; height: 256px; position: absolute; left: -77px; top: 41px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 691px; top: -215px;"></div><div style="width: 256px; height: 256px; position: absolute; left: 691px; top: 41px;"></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: -1;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;"><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 179px; top: -215px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 179px; top: 41px;"><canvas draggable="false" height="512" width="512" style="user-select: none; position: absolute; left: 0px; top: 0px; height: 256px; width: 256px;"></canvas></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 435px; top: -215px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 435px; top: 41px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -77px; top: -215px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -77px; top: 41px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 691px; top: -215px;"></div><div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 691px; top: 41px;"></div></div></div></div><div style="position: absolute; z-index: 0; left: 0px; top: 0px;"><div style="overflow: hidden; width: 750px; height: 250px;"><img src="https://maps.googleapis.com/maps/api/js/StaticMapService.GetMapImage?1m2&amp;1i232525&amp;2i103127&amp;2e1&amp;3u10&amp;4m2&amp;1u750&amp;2u250&amp;5m5&amp;1e0&amp;5sen-US&amp;6sus&amp;10b1&amp;12b1&amp;token=19253" style="width: 750px; height: 250px;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;"><div style="position: absolute; left: 435px; top: 41px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i910!3i403!4i256!2m3!1e0!2sm!3i367042455!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=83799" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 179px; top: -215px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i909!3i402!4i256!2m3!1e0!2sm!3i367042724!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=118351" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 435px; top: -215px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i910!3i402!4i256!2m3!1e0!2sm!3i367042455!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=123520" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 691px; top: 41px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i911!3i403!4i256!2m3!1e0!2sm!3i367042418!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=67389" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 179px; top: 41px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i909!3i403!4i256!2m3!1e0!2sm!3i367042455!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=21058" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -77px; top: -215px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i908!3i402!4i256!2m3!1e0!2sm!3i367042724!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=67334" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: -77px; top: 41px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i908!3i403!4i256!2m3!1e0!2sm!3i367042455!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=101112" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div style="position: absolute; left: 691px; top: -215px; transition: opacity 200ms ease-out;"><img src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i10!2i911!3i402!4i256!2m3!1e0!2sm!3i367042418!3m9!2sen-US!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2&amp;token=107110" draggable="false" alt="" style="width: 256px; height: 256px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 2; width: 100%; height: 100%; transition-duration: 0.3s; opacity: 0; display: none;" class="gm-style-pbc"><p class="gm-style-pbt">Use two fingers to move the map</p></div><div style="position: absolute; left: 0px; top: 0px; z-index: 3; width: 100%; height: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 4; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div></div></div><div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;"><a target="_blank" href="https://maps.google.com/maps?ll=35.652832,139.839478&amp;z=10&amp;t=m&amp;hl=en-US&amp;gl=US&amp;mapclient=apiv3" title="Click to see this area on Google Maps" style="position: static; overflow: visible; float: none; display: inline;"><div style="width: 66px; height: 26px; cursor: pointer;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/google4_hdpi.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div></a></div><div style="background-color: white; padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 256px; height: 148px; position: absolute; left: 225px; top: 35px;"><div style="padding: 0px 0px 10px; font-size: 16px;">Map Data</div><div style="font-size: 13px;">Map data ©2016 Google, ZENRIN</div><div style="width: 13px; height: 13px; overflow: hidden; position: absolute; opacity: 0.7; right: 12px; top: 12px; z-index: 10000;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png" draggable="false" style="position: absolute; left: -2px; top: -336px; width: 59px; height: 492px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><img src="https://maps.gstatic.com/mapfiles/transparent.png" draggable="false" style="width: 37px; height: 37px; user-select: none; border: 0px; padding: 0px; margin: 0px; position: absolute; right: 0px; top: 0px; z-index: 10001; cursor: pointer;"></div><div class="gmnoprint" style="z-index: 1000001; position: absolute; right: 71px; bottom: 0px; width: 160px;"><div draggable="false" class="gm-style-cc" style="user-select: none; height: 14px; line-height: 14px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a style="color: rgb(68, 68, 68); text-decoration: none; cursor: pointer; display: none;">Map Data</a><span>Map data ©2016 Google, ZENRIN</span></div></div></div><div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;"><div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">Map data ©2016 Google, ZENRIN</div></div><div class="gmnoprint gm-style-cc" draggable="false" style="z-index: 1000001; user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;"><a href="https://www.google.com/intl/en-US_US/help/terms_maps.html" target="_blank" style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);">Terms of Use</a></div></div><div style="width: 25px; height: 25px; overflow: hidden; display: none; margin: 10px 14px; position: absolute; top: 0px; right: 0px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/sv9.png" draggable="false" class="gm-fullscreen-control" style="position: absolute; left: -52px; top: -86px; width: 164px; height: 175px; user-select: none; border: 0px; padding: 0px; margin: 0px;"></div><div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom" draggable="false" controlwidth="28" controlheight="55" style="margin: 10px; user-select: none; position: absolute; bottom: 69px; right: 28px;"><div class="gmnoprint" controlwidth="28" controlheight="55" style="position: absolute; left: 0px; top: 0px;"><div draggable="false" style="user-select: none; box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px; border-radius: 2px; cursor: pointer; width: 28px; height: 55px; background-color: rgb(255, 255, 255);"><div title="Zoom in" style="position: relative; width: 28px; height: 27px; left: 0px; top: 0px;"><div style="overflow: hidden; position: absolute; width: 15px; height: 15px; left: 7px; top: 6px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl_hdpi.png" draggable="false" style="position: absolute; left: 0px; top: 0px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 120px; height: 54px;"></div></div><div style="position: relative; overflow: hidden; width: 67%; height: 1px; left: 16%; top: 0px; background-color: rgb(230, 230, 230);"></div><div title="Zoom out" style="position: relative; width: 28px; height: 27px; left: 0px; top: 0px;"><div style="overflow: hidden; position: absolute; width: 15px; height: 15px; left: 7px; top: 6px;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl_hdpi.png" draggable="false" style="position: absolute; left: 0px; top: -15px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none; width: 120px; height: 54px;"></div></div></div></div></div><div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom" draggable="false" controlwidth="0" controlheight="0" style="margin: 10px; user-select: none; position: absolute; display: none; bottom: 26px; left: 0px;"><div class="gmnoprint" controlwidth="28" controlheight="0" style="display: none; position: absolute;"><div title="Rotate map 90 degrees" style="width: 28px; height: 28px; overflow: hidden; position: absolute; border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px; cursor: pointer; background-color: rgb(255, 255, 255); display: none;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl4_hdpi.png" draggable="false" style="position: absolute; left: -141px; top: 6px; width: 170px; height: 54px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div><div class="gm-tilt" style="width: 28px; height: 28px; overflow: hidden; position: absolute; border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px; top: 0px; cursor: pointer; background-color: rgb(255, 255, 255);"><img src="https://maps.gstatic.com/mapfiles/api-3/images/tmapctrl4_hdpi.png" draggable="false" style="position: absolute; left: -141px; top: -13px; width: 170px; height: 54px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div></div></div></div></div></div>
                                <ul class="list-location">
                                    <li>
                                        <div class="table">
                                            <div class="table-cell">
                                                <div class="left-table-cell">
                                                    <img src="https://m.ten-po.com/img/icon/f_location.png" alt="icon">
                                                </div>
                                                <div class="right-table-cell">
                                                    941 Mozelle Mountain
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="table">
                                            <div class="table-cell">
                                                <div class="left-table-cell">
                                                    <img src="https://m.ten-po.com/img/icon/f_time.png" alt="icon">
                                                </div>
                                                <div class="right-table-cell">
                                                    1999-09-30 23:07:00 - 0000-00-00 00:00:00
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                    <li>
                                        <div class="table">
                                            <div class="table-cell">
                                                <div class="left-table-cell">
                                                    <img src="https://m.ten-po.com/img/icon/f_tel.png" alt="icon">
                                                </div>
                                                <div class="right-table-cell">
                                                    <a class="text-phone" href="tel:(454) 543-1653 x9733">(454) 543-1653 x9733</a>
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                </ul>
                               
                                <a href="#" class="btn tenposs-button">予約</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                
                    <div class="form-group">
                        <label>オンライン</label>
                        <select name="" id="" class="form-control short">
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                        </select>
                        <a href="" class="link-top-1" title="">+ ユーザーネーム</a>
                    </div>
                    <div class="form-group arrow-select">
                        <label>トップページ表示項目</label>
                        <div class="wrapp-arrow-select">
                            <div class="wrap-table-top">
                                <div class="wrap-transfer col">
                                    <p class="title-form">表示</p>
                                    <ul class="nav-left link-top-2">
                                        @if(!is_null($app_components))
                                            @foreach ($app_components as $key => $value)
                                                <li data-id="{{$key}}" data-value="{{$key}}">
                                                    <a href="#">{{$value}}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="wrap-btn-control col">
                                    <a href="javascript:moveTo('nav-left','nav-right')">
                                        <span class="fa fa-caret-right"></span>
                                    </a>
                                    <a href="javascript:moveTo('nav-right','nav-left')">
                                        <span class="fa fa-caret-left"></span>
                                    </a>
                                </div>
                                <div class="wrap-transfer col">
                                    <p class="title-form">非表示</p>
                                    <ul class="nav-right link-top-2">
                                        @if(!is_null($available_components))
                                            @foreach ($available_components as $key => $value)
    
                                            <li data-id="{{$key}}" data-value="{{$key}}">
                                                <a href="#">{{$value}}</a></li>
                                            @endforeach
                                        @endif
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>                
        </section>
    </aside>
</form>
@endsection    

@section('footerJS')
    {{Html::script('admin/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('admin/js/swiper/swiper.min.css')}}
    {{Html::script('admin/js/plugins/jquery.scrollbar/jquery.scrollbar.min.js')}}
<script type="text/javascript">    
    $('#btn_submit_form').click(function () {
        $('ul.nav-left li').each(function () {
            var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_component[]">';
            $('#form_app_setting').append(tmp);
        });
        $('#form_app_setting').submit();
    });

    function moveTo(from, to) {
            
        $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
        $('.' + to + ' li').removeAttr('class');
        $('.' + to + ' li a').removeAttr('class');
        /*
        $('div[id^=mobile]').hide();
        $('.nav-left li').each(function(index,item){
            $('#mobile-'+$(item).attr('data-value')).show();
        })*/
    }
    $(document).ready(function () {
        $('.scroller').scrollbar();
        $('.nav-left, .nav-right').on('click', 'li', function (e) {
            e.preventDefault();
            $(this).toggleClass('selected');
            $(this).find('a').toggleClass('active');
        });


            
        var bannerSwiper = new Swiper('.swiper-container', {
            autoplay: 2000,
            speed: 400,
            loop: true,
            spaceBetween: 0,
            slidesPerView: 1,
            pagination: ".swiper-pagination",
            paginationClickable: true
        });
        
        $('div[id^=mobile]').hide();
        $('.nav-left li').each(function(index,item){
            $('#mobile-'+$(item).attr('data-value')).show();
        })
        
        
        
    });
    
</script>

@endsection