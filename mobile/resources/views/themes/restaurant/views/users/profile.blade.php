@extends('layouts.master')
@section('title')
プロフィール編集
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
<?php
$arrAddress = array(
    "hokkaido" =>"北海道",
    "aomori" =>"青森県",
    "iwate" =>"岩手県",
    "miyagi" =>"宮城県",
    "akita" =>"秋田県",
    "yamagata" =>"山形県",
    "fukushima" =>"福島県",
    "ibaraki" =>"茨城県",
    "tochigi" =>"栃木県",
    "gunma" =>"群馬県",
    "saitama" =>"埼玉県",
    "chiba" =>"千葉県",
    "tokyo" =>"東京都",
    "kanagawa" =>"神奈川県",

    "niigata" =>"新潟県",
    "toyama" =>"富山県",
    "ishikawa" =>"石川県",
    "fukui" =>"福井県",
    "yamanashi" =>"山梨県",
    "nagano" =>"長野県",
    "gifi" =>"岐阜県",
    "shizouka" =>"静岡県",
    "aichi" =>"愛知県",

    "mie" =>"三重県",
    "shiga" =>"滋賀県",
    "kyoto" =>"京都府",
    "osaka" =>"大阪府",
    "hyogo" =>"兵庫県",
    "nara" =>"奈良県",
    "wakayama" =>"和歌山県",

    "tottori" =>"鳥取県",
    "shimane" =>"島根県",
    "okayama" =>"岡山県",
    "hiroshima" =>"広島県",
    "yamaguchi" =>"山口県",

    "tokushima" =>"徳島県",
    "kagawa" =>"香川県",
    "ehime" =>"愛媛県",
    "kochi" =>"高知県",

    "fukuoka" =>"福岡県",
    "saga" =>"佐賀県",
    "nagasaki" =>"長崎県",
    "kumamoto" =>"熊本県",
    "oita" =>"大分県",
    "miyazaki" =>"宮崎県",
    "kogoshima" =>"鹿児島県",
    "okinawa" =>"沖縄県",
);
?>
@section('main')
<div data-role="header" data-position="fixed" data-theme="a">
    <a href="{{ URL::previous() }}"
       data-ajax="false"
       class="ui-btn-left ui-btn ui-alt-icon ui-icon-delete ui-btn-icon-notext"
       data-shadow="false" data-icon-shadow="false">Back</a>
    <h1>プロフィール編集</h1>
</div>
<div data-role="page" id="pageone">
    <div data-role="main" class="ui-content">
       
        <div class="content-main">
            <form action="{{ route('profile.save') }}" method="post" enctype="multipart/form-data" data-ajax="false">
            <div class="edite_user">
                <figure>
                    <?php
                    $avatar = ($user->profile->avatar_url != '')
                        ? $user->profile->avatar_url
                        :  Theme::asset('img/user.png');
                    ?>
                    <img id="app-icon-review" src="{{ $avatar }}" class="img_circle" style="max-width: 86px; max-height: 86px;">

                    <br/>
                    <a data-ajax="false" class="btn_upload_avatar create" href="javascript:void(0)">
                        <i class="fa fa-picture-o" aria-hidden="true"></i> プロフィール写真を変更
                    </a>
                    <input class="btn_upload_ipt create"
                           style="display:none"
                           type="file"
                           name="avatar" value="{{ $user->profile->avatar_url }}">

                </figure>
            </div>
            <div class="des profile">
              
                    <div class="ui-field-contain">
                        <label for="name2">ユーザーID</label>
                        <div class="ui-text">{{ $user->id }}</div>
                    </div>
                    <div class="ui-field-contain">
                        <label for="textarea2">ユーザー名</label>
                        <input class="" type="text" name="name" value="{{ $user->profile->name }}"/>

                    </div>
                    <div class="ui-field-contain">
                        <label for="flip2">メールアドレス</label>
                        <input class="" type="email" {{$is_social ? '' : 'readonly'}} name="email" value="{{ $user->email }}"/>
                    </div>
                    <div class="ui-field-contain">
                        <label for="select-choice-1" class="select">性別</label>
                        <div class="ui-select">
                            <select name="gender" id="select-choice-mini" class="">
                                <option value="0" {{ ($user->profile->gender == 0) ? 'selected' : '' }}>男性</option>
                                <option value="1" {{ ($user->profile->gender == 1) ? 'selected' : '' }}>女性</option>
                                <option value="2" {{ ($user->profile->gender == 2) ? 'selected' : '' }}>他の</option>
                            </select>
                        </div>
                    </div>
                    <div class="ui-field-contain">
                        <label for="select-choice-1" class="select">年代</label>
                        <div class="ui-select">
                            <select name="address" id="select-choice-mini">
                                @foreach( $arrAddress as $key => $val )
                                <option {{ ($key == $user->profile->address ) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                <button data-ajax="false" type="submit" class="btn tenposs-button1">保存</button>
            </div>
            </form>
            <div class="social">
                <form class="from-froup">
                    <div class="form-input">
                        <div class="ui-field-contain">
                            <label for="user"><img src="{{ Theme::asset('img/facebook@2x.png') }}"></label>
                            <input type="text" name="textinput-4" id="user" placeholder="Facebook" value="" readonly>

                            @if( $user->profile->facebook_status == 1 )
                            <a data-ajax="false" href="{{ route('social.cancel',[ 'type' => 1 ]) }}" class="btn-white">非接続</a>
                            @else
                            <a data-ajax="false" href="{{ $fb_url }}" class="btn-white">
                                連携
                            </a>
                            @endif

                        </div>
                        <div class="ui-field-contain">
                            <label for="pwd"><img src="{{ Theme::asset('img/twitter@2x.png') }}"></label>
                            <input type="password" name="pwd" id="pwd" placeholder="Twitter" value="" readonly>
                            @if( $user->profile->twitter_status == 1 )
                            <a data-ajax="false" href="{{ route('social.cancel',[ 'type' => 2 ]) }}" class="btn-white">非接続</a>
                            @else
                            <a data-ajax="false" href="{{ $tw_url }}" class="btn-white">
                                連携
                            </a>
                            @endif
                        </div>
                        <div class="ui-field-contain">
                            <label for="pwd"><img src="{{ Theme::asset('img/instagram@2x.png') }}"></label>
                            <input type="password" name="pwd" id="pwd" placeholder="Instagram" value="" readonly>
                            @if( $user->profile->instagram_status == 1 )
                            <a data-ajax="false" href="{{ route('social.cancel',[ 'type' => 3 ]) }}" class="btn-white">非接続</a>
                            @else
                            <a data-ajax="false" href="{{ $instagram_login_url }}" class="btn-white">
                                連携
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div><!--content-main-->
        
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
    $(document).ready(function(){
        $('.btn_upload_avatar').click(function () {
            $('.btn_upload_ipt').click();
        });
        $(".btn_upload_ipt").change(function () {
            if ( this.files && this.files[0]) {

                var reader = new FileReader();
                reader.onload = function (e) {
                    //console.log( e.target.result);
                    $('#app-icon-review').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    })
</script>
@stop