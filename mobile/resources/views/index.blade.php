@extends('master')

@section('page')
<div id="header">
    <div class="container-fluid">
            <h1 class="aligncenter" style="
                color: {{ $app_info->data->app_setting->title_color}};
                background-color: #{{ $app_info->data->app_setting->header_color}};
                ">
                {{ $app_info->data->name }}</h1>
            <a href="javascript:void(0)" class="h_control-nav">
                <img src="img/icon/h_nav.png" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="banner">
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
        <div id="content">
            <div id="recentry">
                <h2 class="aligncenter">Recentry</h2>
                <div class="container-fluid">
                    <div class="row">
                        @if( isset( $app_top->data->items->data)  
                            && count($app_top->data->items->data) > 0 )
                            @foreach( $app_top->data->items->data as $item )
                        <div class="item-product">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"/>
                            <p>{{ $item->title }}</p>
                            <span>$ {{ $item->price }}</span>
                        </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><!-- End recentry -->
            <div id="photogallery">
                <h2 class="aligncenter">Photo Gallery</h2>
                <div class="container-fluid">
                    <div class="row">
                        @if( isset( $app_top->data->photos->data)  
                            && count($app_top->data->photos->data) > 0 )
                            @foreach( $app_top->data->photos->data as $photo )
                        <div class="item-photogallery">
                            <img src="{{ $photo->image_url }}" alt=""/>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <a href="#" class="btn tenposs-readmore">Readmore</a>
                </div>
            </div><!-- End photogallery -->
            <div id="news">
                <h2 class="aligncenter">News</h2>
                <div class="container-fluid">
                     @if( isset( $app_top->data->news->data)  
                            && count($app_top->data->news->data) > 0 )
                        @foreach( $app_top->data->news->data as $news )
                    
                    <div class="item-coupon imageleft clearfix">
                        <div class="image">
                            <img src="{{ $news->image_url }}" alt="{{ $news->title }}"/>
                        </div>
                        <div class="info clearfix">
                            <a href="">{{ $news->title }}</a>
                            <h3>{{ $news->new_category_id }}</h3>
                            <p>{{ str_limit($news->description,100,'...') }}</p>
                        </div>
                    </div><!-- End item coupon -->
                        @endforeach
                    @endif

                    <a href="#" class="btn tenposs-readmore">Readmore</a>
                </div>
            </div><!-- End News -->
            <div id="contact">
                <script type="text/javascript">
                    var maps = [];
                </script>
                 @if( isset( $app_top->data->contact->data)  
                            && count($app_top->data->contact->data) > 0 )
                        @foreach( $app_top->data->contact->data as $contact )
                <div id="map-{{$contact->id}}" class="maps"></div>
                <ul>
                    
                    <li>
                        <div class="table-cell">
                            <img src="img/icon/f_location.png" alt="icon">
                            {{ $contact->title }}
                        </div>
                    </li>
                    <li>
                        <div class="table-cell">
                            <img src="img/icon/f_time.png" alt="icon">
                            {{ $contact->start_time }} - {{ $contact->end_time }}
                        </div>
                    </li>
                    <li>
                        <div class="table-cell">
                            <img src="img/icon/f_tel.png" alt="icon">
                            <a href="#">{{ $contact->tel }}</a>
                        </div>
                    </li>
                </ul>
                
                <div class="container-fluid">
                    <a href="phone:{{ $contact->tel }} " class="btn tenposs-button">Contact</a>
                </div>
                <script type="text/javascript">
                    maps.push({
                        id : '{{$contact->id}}',
                        lat : '{{$contact->latitude}}',
                        long : '{{$contact->longitude}}',
                        title: '{{$contact->title}}'
                    });
                    
                </script>
                
                
                @endforeach
                @endif
                
            </div><!-- End contact -->
        </div><!-- End content -->
        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
@section('footerJS')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrEF9NEPkuxtYouSqVqNj3KSoX__7Rm8g"></script>
<script src="{{ url('plugins/maps/jquery.googlemap.js') }}"></script>


<script type="text/javascript">
    var bannerSwiper = new Swiper('#banner .swiper-container', {
        autoplay: 2000,
        speed: 400,
        loop: true,
        spaceBetween: 0,
        slidesPerView: 1,
        pagination: "#banner .swiper-pagination",
        paginationClickable: true
    });
    
    $(document).ready(function(){
        $(maps).each(function(index, item){
            $("#map-"+item.id).googleMap();
            $("#map-"+item.id).addMarker({
              coords: [item.lat,item.long], // GPS coords
              title: item.title, // Title
              text: item.title
            });
        })
        
    })
    
   
        
        
        
</script>


@endsection