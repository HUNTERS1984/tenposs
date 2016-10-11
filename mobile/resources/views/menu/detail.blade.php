@extends('master')
@section('headCSS')
    <link href="{{ url('css/menu.css') }}" rel="stylesheet">
@endsection
@section('page')
    <div id="header">
        <div class="container-fluid">
            <h1 class="aligncenter" style="
                    color: {{ $app_info->data->app_setting->title_color}};
                    background-color: #{{ $app_info->data->app_setting->header_color}};
                    ">
                メニュー詳細</h1>

            <a href="javascript:void(0)" class="h_control-nav">
                <img src="{{ url('img/icon/h_nav.png') }}" alt="nav"/>
            </a>
        </div>
    </div><!-- End header -->
    <div id="main">
        <div id="content">
            @if(count($items_detail_data) > 0)
                <img src="{{$items_detail_data->image_url}}" alt="{{$items_detail_data->title}}"/>
                <div class="container-fluid">
                    <div class="info-productdetail">
                        <div class="container-fluid">
                            <span>ID: {{$items_detail_data->id}}</span>
                            <p class="font32"><strong>{{$items_detail_data->title}}</strong></p>
                            <span class="price">$ {{number_format($items_detail_data->price, 0, '', '.')}}</span>
                        </div>
                        <a href="{{$items_detail_data->item_link}}" class="btn pad20 tenposs-button">今買う</a>
                    </div>
                    <div class="entry-productdetail">
                        <div class="option">
                            {{--<span class="btn switch switch-on" alt="tab1">説明</span>--}}
                            {{--<span class="btn switch switch-off"  alt="tab2">サイズ</span>--}}
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active"><a href="#tab1">説明</a></li>
                                <li><a href="#tab2">サイズ</a></li>
                            </ul>
                        </div>
                        <div class="tab-content" style="padding-top: 20px; background: #fff;">
                            <div id="tab1" class="tab-pane fade in active">
                                {{$items_detail_data->description}}
                            </div>
                            <div id="tab2" class="tab-pane fade">
                                @if(count($items_detail_data->size) > 0)
                                    <table class="table table-bordered">
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
                                    <p>データなし</p>
                                @endif
                            </div>
                        </div>

                        {{--<div class="pad20">--}}
                            {{--<a href="{{$items_detail_data->item_link}}" class="btn pad20 tenposs-button">今買う</a>--}}
                        {{--</div>--}}
                    </div>
                </div><!-- End container fluid -->
            @else
                <div class="container-fluid" style="text-align: center;">
                    <p>データなし</p>
                </div>
            @endif
            @if(count($items_relate_data) > 0)
                <div id="related" style="margin-top: 50px;">
                    <div class="container-fluid">
                        <h2 class="aligncenter font32">関連しました</h2>
                        <div class="row clearfix">
                            @foreach($items_relate_data as $item_relate)
                                <div class="item-product">
                                    <img src="{{$item_relate->image_url}}" alt="{{$item_relate->title}}"/>
                                    <p>{{$item_relate->title}}</p>
                                    <span>$ {{number_format($item_relate->price, 0, '', '.')}}</span>
                                </div>
                            @endforeach

                        </div>
                    </div><!-- End container fluid -->
                    @if($load_more_releated)
                        <div class="row" style="text-align:center;" id="div_load_more">
                            <a href="javascript:void(0)" id="load_more"
                               class="btn tenposs-readmore">続きを読む</a>
                        </div>
                    @endif
                </div><!-- End related -->
            @endif
        </div><!-- End content -->

        @include('partials.sidemenu')
    </div><!-- End main -->
    <div id="footer">

    </div><!-- End footer -->
@endsection
@section('footerJS')

    <script type="text/javascript">

        $(document).ready(function () {
            $("#myTab a").click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>


@endsection