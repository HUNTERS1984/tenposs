<div id="template-1" class="banner-preview">
   <!-- Slider main container -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach( $slides as $slide )
            <div class="swiper-slide">
                <img width="100%" style="object-fit: cover; object-position: center; height: 80px; width: 210px;" src="{{ url($slide->image_url) }}" alt=""/>
            </div>
            @endforeach
          
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>