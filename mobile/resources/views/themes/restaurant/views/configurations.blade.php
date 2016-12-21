@extends('layouts.master')
@section('title')
設定
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
    <!--
    <a href="{{ route('index.redirect') }}" data-ajax="false" data-direction="reverse" data-icon="carat-l"
       data-iconpos="notext" data-shadow="false" data-icon-shadow="false">Back</a>-->
    <a href="#outside" class="ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext">Menu</a>
    <h1>設定</h1>
</div>

<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
        <div class="content-conf">
            <ul data-role="listview" data-ajax="false">
                <li>
                    <a href="{{ route('profile') }}" data-ajax="false">プロフィール編集</a></li>
                <li>
                    <form method="post" action="./">
                        <div class="ui-field-contain">
                            <label for="switch">お知らせを受け取る:</label>
                            <input {{ ($configs->news == 1 )? 'checked':'' }}
                            type="checkbox"
                            data-role="flipswitch"
                            class="ui-btn-icon-right" name="news" id="switch" value="{{ $configs->news }}">
                        </div>
                    </form>
                </li>
                <li>
                    <form method="post" action="./">
                        <div class="ui-field-contain">
                            <label for="switch">クーポン情報を受け取る:</label>
                            <input {{ ($configs->coupon == 1 )? 'checked': '' }}
                            type="checkbox" data-role="flipswitch" value="{{ $configs->coupon }}"
                            class="ui-btn-icon-right" name="coupon" id="switch">
                        </div>
                    </form>
                </li>
                <li>
                    <a href="{{ route('company.info') }}" data-ajax="false">機種変更時引継ぎコード発行</a></li>
                <li>
                    <a href="{{ route('user.privacy') }}" data-ajax="false">運営会社</a> </li>
                <li>
                    <a href="#" data-ajax="false">採用情報</a></li>
            </ul>
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
    <script type="text/javascript">
        $('input[type="checkbox"]').on('change',function(){

            var params = [];
            $('input[type="checkbox"]').each(function(index, item){
                params.push(
                    {
                        name: $(item).attr('name'),
                        value: $(item).is(':checked')
                    }
                )
            });

            $.ajax({
                url: '{{ route("configuration.save") }}',
                dataType: 'json',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: params,
                success: function( response ){
                    console.log(response);
                }
            })

        })
    </script>
    @stop