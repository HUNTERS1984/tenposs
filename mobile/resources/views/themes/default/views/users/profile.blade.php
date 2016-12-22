@extends('master')

@section('headCSS')
<link href="{{ Theme::asset('css/user.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: '{{ $app_info->data->app_setting->font_family }}';
    }

    .h_control-back:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }
</style>
@endsection

@section('page')
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
<div id="header">
    <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
        <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
            ">
            @if( Session::get('user')->profile->name != '' )
                {{ Str::words(Session::get('user')->profile->name,20) }}
            @else
                
            @endif
        </h1>
        <a href="{{route('configuration')}}" class="h_control-back"></a>
    </div>
</div><!-- End header -->
<form action="{{ route('profile.save') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
<div id="main">
    <div id="content">
        @include('partials.message')
        <div id="user">
            <div class="col-xs-12" style="padding:0px">
            <ul>
                <li>
                    <?php
                    $avatar = ($user->profile->avatar_url != '')
                        ? $user->profile->avatar_url
                        :  url('/img/icon/icon-user.png');
                    ?>

                    <label class="avatar">
                    <img id="app-icon-review" class="img-circle" src="{{ $avatar }}"></label>
                    <label class="label-title-user">
                        <a class="btn_upload_avatar create" href="javascript:void(0)">
                            <i class="fa fa-picture-o" aria-hidden="true"></i> プロフィール写真を変更
                        </a>
                        <input class="btn_upload_ipt create" style="display:none" type="file" name="avatar" value="{{ $user->profile->avatar_url }}">
                    </label>
                </li>
                <li>
                    <label>ユーザーID</label>
                    <input type="text" name="id" value="{{ $user->id }}" readonly/>

                </li>
                <li>
                    <label>ユーザー名</label>
                    <input type="text" name="name" value="{{ $user->profile->name }}"/>
                </li>
                <li>
                    <label>メールアドレス</label>
                    <input type="email" {{$is_social ? '' : 'readonly'}}  name="email" value="{{ $user->email }}"/>
                </li>
                <li>
                    <label>性别</label>
                    <select name="gender" id="" class="">
                        <option value="0" {{ ($user->profile->gender == 0) ? 'selected' : '' }}>男性</option>
                        <option value="1" {{ ($user->profile->gender == 1) ? 'selected' : '' }}>女性</option>
                        <option value="2" {{ ($user->profile->gender == 2) ? 'selected' : '' }}>他の</option>
                    </select>
                </li>
                <li>
                    <label>住所</label>
                    <select name="address" id="">
                        @foreach( $arrAddress as $key => $val )
                        <option {{ ($key == $user->profile->address ) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </li>
            </ul>
            </div>
            <div class="col-xs-12" style="padding:0px">
                <button type="submit" class="btn tenposs-button1">保存</button>
            </div>
            <div class="col-xs-12" style="padding:0px">
            <ul class="social">
                <li>
                    <i class="icon-face"></i>
                    <div class="wrap-ic">
                        <span >Facebook</span>
                        @if( $user->profile->facebook_status == 1 )
                        <a href="{{ route('social.cancel',[ 'type' => 1 ]) }}" class="btn">非接続</a>
                        @else
                        <a href="{{ $fb_url }}" class="btn">
                           連携
                        </a>
                        @endif
                    </div>
                </li>
                <li>
                    <i class="icon-twitter"></i>
                    <div class="wrap-ic">
                        <span >Twitter</span>
                        @if( $user->profile->twitter_status == 1 )
                        <a href="{{ route('social.cancel',[ 'type' => 2 ]) }}" class="btn">非接続</a>
                        @else
                        <a href="{{ $tw_url }}" class="btn">
                           連携
                        </a>
                        @endif
                    </div>
                </li>
                <li>
                    <i class="icon-instagram"></i>
                    <div class="wrap-ic">
                        <span >Instagram</span>
                        @if( $user->profile->instagram_status == 1 )
                        <a href="{{ route('social.cancel',[ 'type' => 3 ]) }}" class="btn">非接続</a>
                        @else
                        <a href="{{ $instagram_login_url }}" class="btn">
                           連携
                        </a>
                        @endif
                    </div>


                </li>
            </ul>
            </div>
        </div>
    </div><!-- End content -->
    @include('partials.sidemenu')
</div><!-- End main -->
<div id="footer"></div><!-- End footer -->
</form>
@endsection

@section('footerJS')
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
@endsection