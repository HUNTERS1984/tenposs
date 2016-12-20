@extends('master')

@section('headCSS')
<link href="{{ Theme::asset('css/login.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
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
 <div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter">ログイン</h1>
        <a href="{{URL::previous()}}" class="h_control-back"></a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content login-page" style="padding-top:5px">
        @include('partials.message')
        <form action="{{ route('login.normal.post') }}" class="form form-login-normal" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="wrap-input">
                <div class="wrap-inner">
                    <div class="form-group-login">
                        <input value="{{ old('email') }}" class="input-form input-lg" type="email" name="email" placeholder="メ一ルアドレス" />
                    </div>
                     <div class="form-group-login">
                        <input value="{{ old('password') }}" class="input-form input-lg last" type="password" name="password" placeholder="パスワード" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-login" type="submit">ログイン</button>
            </div>
        </form>
        <p class="text-center" style="font-size:14px">
            <a href="{{ route('register') }}">新規会員登録</a>
        </p>
    </div>
</div><!-- End header -->
@endsection