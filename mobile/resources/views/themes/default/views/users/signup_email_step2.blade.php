@extends('master')
@section('headCSS')
<link href="{{ Theme::asset('css/login.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: '{{ $app_info->data->app_setting->font_family }}';
    }
    .h_control-back:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }
    #header h1{
        color: #{{ $app_info->data->app_setting->title_color }};
        }
    #header > .container-fluid{
        background-color:#{{ $app_info->data->app_setting->header_color }};
        }
</style>
@stop

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
    <div class="container-fluid">
        <h1 class="aligncenter">新規会員登録 (2/2)</h1>
        <a href="{{route('register')}}" class="h_control-back"></a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content">
        @include('partials.message')
        <form action="{{ route('register.step2.post') }}" class="form form-login-normal" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="wrap-input">
                <div class="wrap-inner">
                    <div class="form-group-login">
                        <input readonly value="{{ Session::get('user')->email }}" class="input-form last input-lg" type="text"
                               name="email" placeholder="メール" />
                    </div>
                    <div class="form-group-login">
                         <select name="address" id="" class="input-form input-lg">
                             @foreach( $arrAddress as $key => $val )
                             <option {{ ($key == old('address') ) ? 'selected' : '' }} value="{{ $key }}">{{ $val }}</option>
                             @endforeach
                         </select>　        
                     </div>
                    <div class="form-group-login">
                        <input data-date-format="yyyy/mm/dd" value="{{ old('birthday') }}"
                                class="input-form input-lg" type="date" name="birthday" placeholder="お誕生日" />
                    </div>

<!--                      <div class="form-group-login">
                         <select name="gender" id="" class="input-form input-lg" >
                             <option value="0" {{ ( old('gender') == 0) ? 'selected' : '' }}>男性</option>
                             <option value="1" {{ ( old('gender') == 1) ? 'selected' : '' }}>女性</option>
                             <option value="2" {{ ( old('gender') == 2) ? 'selected' : '' }}>他の</option>
                         </select>
                     </div> -->
                    <div class="form-group-login">
                        <input value="{{ old('code') }}" class="input-form input-lg" type="text" name="code" placeholder="招待コード" />
                    </div>

                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-login" type="submit">こちらの内容で登録</button>
            </div>
        </form>
        <p class="text-center" style="font-size:14px">
            すでに会員の方は、<a href="{{ route('login.normal') }}">こちらへ</a>
        </p>
    </div>
</div><!-- End header -->
@endsection

@section('footerJS')
@endsection