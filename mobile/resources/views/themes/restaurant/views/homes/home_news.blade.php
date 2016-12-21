
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
                @if( isset( $app_top->data->news->data)
                && count($app_top->data->news->data) > 0 )
                @foreach( $app_top->data->news->data as $news )
                <div class="items">
                    <figure>
                        <a data-ajax="false" href="{{ route('news.detail', [ 'id'=> $news->id ]) }}">
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}">
                        </a>
                    </figure>
                    <div class="text">
                        <h3><a data-ajax="false" href="{{ route('news.detail', [ 'id'=> $news->id ]) }}">{{ $news->title }}</a></h3>
                        <p>{{ $news->news_cat->name }}</p>
                        <p class="date">{{ date('m月d日 H時i分', strtotime($news->created_at)) }}</p>
                    </div>
                </div><!--items-->

                @endforeach
                @endif
            </div>
        </div>

    </div><!--slider1-->
</div><!--news-->