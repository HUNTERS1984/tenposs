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
@section('main')

<div data-role="header" data-position="fixed" data-theme="a">
    <a href="#outside" class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext">Menu</a>
    <h1>メニュー</h1>
</div>


<div data-role="page" id="pageone" >
    <div data-role="main" class="ui-content">
        <div data-role="tabs" class="tabs">
            <div data-role="navbar">
                <ul>
                    @if( isset($menus)  && count($menus) > 0 )
                    @foreach($menus as $cate)
                    <?php $i = 0; ?>
                    @foreach($cate->data->menus as $name_cate)
                    <li><a href="#cat{{$name_cate->id}}" data-theme="a" 
                    data-ajax="false" 
                    class="{{ ($i == 0)?'ui-btn-active':'' }}">{{$name_cate->name}}</a>
                    </li>
                    <?php $i++;?>
                    @endforeach
                    @endforeach
                    @endif
                </ul>
            </div>

            @if( isset($menus)  && count($menus) > 0 )
                @foreach($menus as $cate)
                    @foreach($cate->data->menus as $name_cate)
                    <div id="cat{{$name_cate->id}}" class="ui-content menuspage">
                        @if( isset( $menu_data )
                        && count($menu_data) > 0
                        && isset( $menu_data[$name_cate->id] )
                        && count( $menu_data[$name_cate->id]['data']) > 0 )

                            <?php $loops = array_chunk( $menu_data[$name_cate->id]['data']['items'], 2 )  ?>
                            @foreach( $loops as $datas )
                                <div class="ui-grid-a">
                                <?php $i = 0 ?>
                                @foreach($datas as $item)
                                    <div class="ui-block-{{ ($i%2 == 0) ? 'a' : 'b' }}">
                                        <div class="items">
                                            <figure>
                                                <a href="{{ route('menus.detail', $item['id'])}}" data-ajax="false">
                                                <img src="{{ $item['image_url'] }}" alt="">
                                                </a>
                                            </figure>
                                            <a title="{{ $item['title'] }}" href="{{ route('menus.detail', $item['id'])}}" data-ajax="false">{{ Str::words($item['title'],4,'..') }}</a><br>
                                            <span class="">{{ Str::words( strip_tags($item['description']), 4, '..') }}</span>
                                            <div class="price">¥{{ number_format($item['price']) }}</div>
                                        </div>
                                    </div>
                                <?php $i++ ?>
                                @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @endforeach
                @endforeach
            @endif

        </div>
    </div>
</div>
<!-- /page -->
@stop
@section('footer')

@stop
