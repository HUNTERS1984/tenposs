@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: {{ $app_info->data->app_setting->font_family }};
    }
    .h_control-nav:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
    }
</style>
@endsection
@section('page')
<div id="header">
    <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
        <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
                ">{{ $app_info->data->app_setting->title }}</h1>
        <a href="javascript:void(0)" class="h_control-nav"></a>
    </div>
    </div><!-- End header -->
    <div id="main">

        <div id="content">
            <div id="session">
            </div>
            <div class="template" style="display:none">
                <div id="template-1">
                    <div id="banner" style="margin-bottom:20px">
                        <!-- Slider main container -->
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                @if( isset( $app_top->data->images->data)  && count($app_top->data->images->data) > 0 )
                                    @foreach( $app_top->data->images->data as $img )
                                    <div class="swiper-slide"><img src="{{ $img->image_url }}" alt=""/></div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div><!-- End banner -->
                </div>
                <div id="template-2">
                    <div id="recentry">
                        @if( isset( $app_top->data->items->data)
                                    && count($app_top->data->items->data) > 0 )
                        <h2 class="aligncenter">メニュー</h2>
                       
                            <div class="container-photo-section clearfix">
                                
                                @foreach( $app_top->data->items->data as $item )
                                <div class="item-product">
                                    <a href="{{ route('menus.detail', [ 'id' =>  $item->id ]) }}">
                                        <img class="center-cropped" src="{{ $item->image_url }}" alt="{{ $item->title }}"/>
                                    </a>
                                    <p>{{ $item->title }}</p>
                                    <span>¥{{number_format($item->price, 0, '', ',')}}</span>
                                </div>
                                 @endforeach
                                
                            </div>
                            @if( isset( $app_top->data->photos->data)
                                    && count($app_top->data->photos->data) > 0 )
                                 <div class="component-fluid">
                                    <a href="{{ route('menus.index') }}" class="btn tenposs-readmore">もっと見る</a>
                                 </div>
                            @endif
                       
                        @endif
                    </div><!-- End recentry -->
                </div>
                <div id="template-5">
                    <div id="photogallery">
                        @if( isset( $app_top->data->photos->data)
                                    && count($app_top->data->photos->data) > 0 )
                        <h2 class="aligncenter">フォトギャラリー</h2>
                        
                            <div class="container-photo-section clearfix">
                                
                                @foreach( $app_top->data->photos->data as $photo )
                                <div class="item-photogallery">
                                    <div class="crop">
                                        <div class="inner-crop">
                                            <a href="{{$photo->image_url}}" data-lightbox="lightbox">
                                                <img src="{{$photo->image_url}}" class="img-responsive" alt="Nayako"/>
                                            </a>
                                        </div>

                                    </div>

                                </div>
                                @endforeach
                                
                            </div>
                            @if( isset( $app_top->data->photos->data)
                                    && count($app_top->data->photos->data) > 0 )
                                <div class="component-fluid">
                                <a href="{{ route('photo.gallery') }}" class="btn tenposs-readmore">もっと見る</a>
                                </div>
                            @endif
                        
                        @endif  
                    </div><!-- End photogallery -->
                </div>
                <div id="template-3">
                    <div id="news">
                        <div class="component-fluid">
                        @if( isset( $app_top->data->news->data)
                                    && count($app_top->data->news->data) > 0 )
                        <h2 class="aligncenter">ニュース</h2>
                            @foreach( $app_top->data->news->data as $news )

                            <div class="item-coupon imageleft clearfix">
                                <div class="image">
                                    <div class="crop">
                                        <a href="{{ route('news.detail', [ 'id'=> $news->id ]) }}">
                                            <img class="center-cropped" src="{{ $news->image_url }}" alt="{{ $news->title }}"/>
                                        </a>
                                    </div>

                                </div>
                                <div class="info">
                                    <a href="{{ route('news.detail', [ 'id'=> $news->id ]) }}">{{ $news->news_cat->name }}</a>
                                    <h3>{{ $news->title }}</h3>
                                    <p>{{ Str::words(strip_tags($news->description),20,'..') }}</p>
                                </div>
                            </div><!-- End item coupon -->
                            @endforeach
                            
                                <a href="{{ route('news') }}" class="btn tenposs-readmore">もっと見る</a>
                            
                         @endif
                         </div>
                    </div><!-- End News -->
                </div>
                <div id="template-4">
                    <div id="contact">
                        <script type="text/javascript">
                            var maps = [];
                        </script>
                         @if( isset( $app_top->data->contact->data)
                                    && count($app_top->data->contact->data) > 0 )
                        @foreach( $app_top->data->contact->data as $contact )
                        <div id="map-{{$contact->id}}" class="maps"></div>
                        <ul class="list-location">
                            <li>
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="left-table-cell text-left">
                                            <img src="{{ url('img/icon/f_location.png') }}" alt="icon">
                                        </div>
                                        <div class="right-table-cell text-left">
                                            {{ $contact->title }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="left-table-cell text-left">
                                            <img src="{{ url('img/icon/f_time.png') }}" alt="icon">
                                        </div>
                                        <div class="right-table-cell text-left">

                                            {{date('a h:i', strtotime($contact->start_time))}} - {{ date('a h:i', strtotime($contact->end_time)) }}
                                        </div>
                                    </div>
                                </div>

                            </li>
                            <li>
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="left-table-cell text-left">
                                            <img src="{{ url('img/icon/f_tel.png') }}" alt="icon">
                                        </div>
                                        <div class="right-table-cell text-left">
                                            <a class="text-phone" href="tel:{{ $contact->tel }}">{{ $contact->tel }}</a>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        </ul>

                        <div class="component-fluid">
                            <a href="{{ route('reservation') }} " class="btn tenposs-button">予約</a>
                        </div>
                        <script type="text/javascript">
                            maps.push({
                                id : '{{$contact->id}}',
                                lat : '{{$contact->latitude}}',
                                long : '{{$contact->longitude}}',
                                title: '{{$contact->title}}'
                            });

                        </script>
                        <?php break; ?>
                        @endforeach
                        @endif

                    </div><!-- End contact -->
                </div>
            </div>
        </div><!-- End content -->
        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
@section('footerJS')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrEF9NEPkuxtYouSqVqNj3KSoX__7Rm8g"></script>
<script src="{{ url('plugins/maps/jquery.googlemap.js') }}"></script>
<link rel="stylesheet" href="js/lightbox/css/lightbox.css">
<script src="js/lightbox/js/lightbox.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var components = [];
        @foreach ( $app_info->data->top_components as $component )
        components.push("{{ $component->id}}");
        @endforeach
        console.log(components);
        for (i = 0; i < components.length; i++) { 
            var html = '';

            var html = $('#template-'+components[i]).html();
            $('#session').append(html);
            var bannerSwiper = new Swiper('#banner .swiper-container', {
                autoplay: 2000,
                speed: 400,
                loop: true,
                spaceBetween: 0,
                slidesPerView: 1,
                pagination: ".swiper-pagination",
                paginationClickable: true
            });
        }

        $(maps).each(function(index, item){
            $("#map-"+item.id).googleMap();
            $("#map-"+item.id).addMarker({
              coords: [item.lat,item.long], // GPS coords
              title: item.title, // Title
              text: item.title
            });
        });
        lightbox.option({
          'showImageNumberLabel': false
        });

        @if( Session::has('user') && !Session::get('setpushkey') )
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
            url: '{{ route("setpushkey") }}',
            type: 'post',
            dataType: 'json',
            data: {
                key: notify.data.subscribe()
            },

            success: function(response){
                console.log('Setpushkey success');
            }
        })
        @endif
    });
</script>


@endsection