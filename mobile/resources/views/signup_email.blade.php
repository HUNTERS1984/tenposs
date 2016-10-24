@extends('master')

@section('headCSS')
    <link href="{{ url('/css/login.css') }}" rel="stylesheet">
@stop

@section('page')
 <div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter">新規会員登録 (1/2)</h1>
        <a href="{{ route('login') }}">
            <img src="img/icon/cross.png" alt="arrow"/>
        </a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content">
        @include('partials.message')
        <form action="{{ route('register.post') }}" class="form form-login-normal" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="wrap-input">
                <div class="wrap-inner">
                    <div class="form-group-login">
                        <input value="{{ old('name') }}" class="input-form input-lg" type="text" name="name" placeholder="ユーザー名" />
                    </div>
                     <div class="form-group-login">
                        <input value="{{ old('email') }}" class="input-form input-lg" type="email" name="email" placeholder="メールアドレス" />
                    </div>
                     <div class="form-group-login">
                        <input value="{{ old('password') }}" class="input-form input-lg" type="password" name="password" placeholder="パスワード" />
                    </div>
                    <div class="form-group-login">
                        <input value="{{ old('password_confirm') }}" class="input-form last input-lg" type="password" name="password_confirm" placeholder="パスワード (確認)" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-login" type="submit">新規会員</button>
            </div>
        </form>
        <p class="text-center" style="font-size:14px">
            すでに会員の方は、<a href="{{ route('login.normal') }}">こちらへ</a>
        </p>
    </div>
</div><!-- End header -->
@endsection