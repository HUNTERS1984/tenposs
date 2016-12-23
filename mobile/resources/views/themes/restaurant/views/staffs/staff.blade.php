@extends('layouts.master')
@section('title')
スタッフ
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
    <h1>スタッフ</h1>
</div>
<div data-role="page" id="pageone" class="staff">
    <div data-role="main" class="ui-content">
        @if(isset($staff_detail) && count($staff_detail)>0)
        @foreach($staff_detail as $staff)
        @if($staff)

        @if( $staff !== null)
        <?php
            $loops = array_chunk($staff->data->staffs, 2);
        ?>
        @foreach($loops as $items)
            <div class="ui-grid-a ">
                <?php $i = 0 ?>
            @foreach($items as $item)
                <div class="ui-block-{{ ($i%2 == 0) ? 'a' : 'b' }}">
                    <div class="items">
                        <figure>
                            <a data-ajax="false" href="{{route('staff.detail',$item->id)}}">
                            <img src="{{$item->image_url}}" alt="">
                            </a>
                        </figure>
                        <a data-ajax="false" href="{{route('staff.detail',$item->id)}}">{{$item->name}}</a><br>
                        <span class="">{{$item->staff_categories->name}}</span>
                    </div>
                </div>
                <?php $i++ ?>
            @endforeach
            </div>
        @endforeach
        @endif

        @endif
        @endforeach
        @endif
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
