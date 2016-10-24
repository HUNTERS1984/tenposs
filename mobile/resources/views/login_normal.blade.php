@extends('master')

@section('headCSS')
    <link href="{{ url('/css/login.css') }}" rel="stylesheet">
@stop

@section('page')
 <div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter">ログイン</h1>
        <a href="{{ route('login') }}">
            <img src="{{ url('/img/icon/cross.png') }}" alt="arrow"/>
        </a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content login-page">
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