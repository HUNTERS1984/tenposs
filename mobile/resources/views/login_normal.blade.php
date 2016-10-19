@extends('master')

@section('page')
 <div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter">ログイン</h1>
        <a href="{{ route('login') }}">
            <img src="{{ url('img/icon/h_back-arrow.jpg') }}" alt="arrow"/>
        </a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content">
        @include('partials.message')
        <form action="{{ route('login.normal.post') }}" class="form form-login-normal" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
             <div class="form-group">
                <input value="{{ old('email') }}" class="form-control input-lg" type="email" name="email" placeholder="メ一ルアドレス" />
            </div>
             <div class="form-group">
                <input value="{{ old('password') }}" class="form-control input-lg" type="password" name="password" placeholder="パスワード" />
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