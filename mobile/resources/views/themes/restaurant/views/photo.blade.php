@extends('layouts.master')
@section('title')
写真
@stop
@section('header')
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
    <h1>写真</h1>
</div>

<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
        <div class="grid">
            <!-- Slides -->
            @if(isset($photo_detail) && count($photo_detail) > 0)
                @foreach($photo_detail as $photo)
                @if($photo)
                    @if( $photo !== null)
                        @foreach($photo->data->photos as $item)
                        <div class="grid-item">
                            <a href="#photo{{ $item->id }}" data-rel="popup" data-position-to="window" data-transition="fade">
                                <figure>
                                    <img class="popphoto" src="{{$item->image_url}}" alt="">
                                </figure>
                            </a>
                            <div data-role="popup" id="photo{{ $item->id }}" data-overlay-theme="a"
                            data-theme="a"
                            data-corners="false"><a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
                                <img class="popphoto" src="{{$item->image_url}}" alt="">
                                </div>
                        </div>
                        @endforeach
                    @endif
                @endif
                @endforeach
            @endif
        
        </div>
    </div>    
</div>
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
