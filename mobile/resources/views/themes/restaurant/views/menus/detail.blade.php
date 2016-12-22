@extends('layouts.master')
@section('title')

@if(count($items_detail_data) > 0)
{{ $items_detail_data->title }}
@else
商品詳細
@endif

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
    
     <a href="{{ URL::previous() }}" data-ajax="false" data-direction="reverse" data-icon="carat-l"
       data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>@if(count($items_detail_data) > 0)
        {{ $items_detail_data->title }}
        @else
        商品詳細
        @endif</h1>
</div>
<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
        <div class="content-main">
            <figure>
                @if(count($items_detail_data) > 0)
                <img src="{{$items_detail_data->image_url}}" alt="{{$items_detail_data->title}}">
                @endif
            </figure>
            <div class="ui-body">
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        {{$items_detail_data->title}}
                        <p>{{$items_detail_data->menu_name}}</p>
                    </div>
                    <div class="ui-block-b text-right">
                        ¥{{number_format($items_detail_data->price, 0, '', ',')}}
                    </div>
                </div><!--ui-grid-a-->
                <h3>商品詳細</h3>
                <div class="">
                    {!! $items_detail_data->description !!}
                </div>
                <div class="size">
                    <h3>商品詳細</h3>
                    @if(count($items_detail_data->size) > 0)
                    <table data-role="table" id="table-column-toggle" class="ui-responsive table-stroke">
                        <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <?php $category_start = $items_detail_data->size[0]->item_size_category_id;?>

                            @for($i = 0;$i <count($items_detail_data->size);$i++)
                            @if($i > 0 && $category_start == $items_detail_data->size[$i]->item_size_category_id)
                            @break;
                            @endif
                            <th style="text-align: center;">{{$items_detail_data->size[$i]->item_size_category_name}}</th>

                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        <?php $data_row = \App\Utils\Convert::convert_size_item_to_array($items_detail_data->size); ?>
                        @if(count($data_row) > 0)
                        @foreach($data_row as $item)
                        <tr>
                            <td style="text-align: center;"
                                class="col-md-2">{{$item[0]->item_size_type_name}}</td>
                            @for($t=0;$t <  count($item);$t++)
                            <td class="col-md-2"
                                style="text-align: center;">{{round($item[$t]->value,2)}}
                            </td>
                            @endfor
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                    @else
                    <p style="text-align:center; margin-top:20px; font-size:20px">データなし</p>
                    @endif

                </div>
            </div>    
        </div><!--content-main-->
        @if(count($items_relate_data) > 0)
        <div class="product-other">
            <h3>ゆかり</h3>
            <?php $loops = array_chunk( $items_relate_data, 2 )  ?>
            @foreach($loops as $items)
                <?php $i = 0 ?>
                <div class="ui-grid-a">
                    @foreach($items_relate_data as $item_relate)
                    <div class="ui-block-{{ ($i%2 == 0) ? 'a' : 'b' }}">
                        <div class="items">
                            <figure>
                                <a href="{{ route('menus.detail', $item['id'])}}" data-ajax="false">
                                    <img src="{{ $item['image_url'] }}" alt="">
                                </a>
                            </figure>
                            <a href="{{ route('menus.detail', $item['id'])}}" data-ajax="false">{{ $item['title'] }}</a><br>
                            <span class="">{{ Str::words( strip_tags($item['description']), 10, '..') }}</span>
                            <div class="price">¥{{ number_format($item['price']) }}</div>
                        </div>
                    </div>
                    @endforeach
                <?php $i++ ?>
                </div>
            @endforeach
        </div>
        @endif
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
