@extends('layouts.master')

@section('title')
{{ $detail->name }}
@stop

@section('header')
<link rel="stylesheet" href="{{ Theme::asset('css/jqm-demos.css') }}">
<script src="{{ Theme::asset('js/index.js') }}"></script>
<style>

    body {
        font-size: {{ $app_info->data->app_setting->font_size}};
        font-family: "{{ $app_info->data->app_setting->font_family }}"
    }
    div[data-role="header"] {
        background-color: #{{ $app_info->data->app_setting->header_color }}
    }
    div[data-role="header"] h1 {
        color: #{{ $app_info->data->app_setting->title_color }}
    }
    div[data-role="header"] a {
        color: #{{ $app_info->data->app_setting->menu_icon_color }}
    }
</style>
<script>
    $(document).on("pagecreate", function () {
        $("body > [data-role='panel']").panel();
        $("body > [data-role='panel'] [data-role='listview']").listview();
    });
    $(document).one("pageshow", function () {
        $("body > [data-role='header']").toolbar();
        $("body > [data-role='header'] [data-role='navbar']").navbar();
    });
</script>
@stop
@section('main')
<div data-role="header" data-position="fixed" data-theme="a">
    <a href="{{ URL::previous() }}" data-ajax="false" data-direction="reverse" data-icon="carat-l"
       data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>{{ $detail->name }}</h1>
</div>
<div data-role="page" id="pageone" data-ajax="false">
    <div data-role="main" class="ui-content" data-ajax="false">
        <div class="content-main">
            <figure>
                @if(count($detail) > 0)
                <img src="{{$detail->image_url}}" alt="{{$detail->name}}">
                @endif
            </figure>
            <div class="ui-body ">
                <p>{{$detail->name}}</p>
                <h3>{{$detail->staff_category_name}}</h3>
                <div data-role="tabs" id="tabs">
                    <div data-role="navbar">
                        <ul>
                            <li><a href="#one" data-ajax="false">自己紹介</a></li>
                            <li><a href="#two" data-ajax="false">プロフィール</a></li>
                        </ul>
                    </div>
                    <div id="one" class="">
                        
                            {!! $detail->introduction !!}
                       
                    </div>
                    <div id="two">
                       
                         <table data-role="table" id="movie-table-custom" data-mode="" class="movie-list ui-responsive" >
                      
                            <tr>
                                <td>性别</td>
                                <td>{{$detail->gender == '0' ? '女性' : '男性'}}</td>
                            </tr>
                            <tr>
                                <td>価格</td>
                                <td>¥{{number_format($detail->price)}}</td>
                            </tr>
                            <tr>
                                <td>電話番号</td>
                                <td> {{$detail->tel}}</td>
                            </tr>
                            
                        </table>
                       
                    </div>
                </div>
            </div>
        </div>
        <!--content-main-->
    </div>
</div>
<!-- /page -->
@stop
@section('footer')

@stop