@extends('master')

@section('page')
 <div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter">新規余員登錄</h1>
        <a href="{{ route('login') }}">
            <img src="img/icon/h_back-arrow.jpg" alt="arrow"/>
        </a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content">
        @include('partials.message')
        <form action="{{ route('register.post') }}" class="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <input value="{{ old('name') }}" class="form-control input-lg" type="text" name="name" placeholder="ユーザー名"/>
            </div>
             <div class="form-group">
                <input value="{{ old('email') }}" class="form-control input-lg" type="email" name="email" placeholder="メールアドレス"/>
            </div>
             <div class="form-group">
                <input value="{{ old('password') }}" class="form-control input-lg" type="password" name="password" placeholder="パスワード"/>
            </div>
            <div class="form-group">
                <input value="{{ old('password_confirm') }}" class="form-control input-lg" type="password" name="password_confirm" placeholder="パスワード (確認)"/>
            </div>
            <button class="btn btn-block  tenposs-button" type="submit">新規会員</button>
            
        </form>
        <p class="text-center">
            すでに会員の方は、<a href="{{ route('login.normal') }}">こちらへ</a> 
        </p>
    </div>
</div><!-- End header -->                        
@endsection