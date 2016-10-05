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
        <form action="{{ route('login.normal.post') }}" class="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
             <div class="form-group">
                <input value="{{ old('email') }}" class="form-control" type="email" name="email" placeholder="メ一ルアドレス"/>
            </div>
             <div class="form-group">
                <input value="{{ old('password') }}" class="form-control" type="password" name="password" placeholder="パスワード"/>
            </div>
           
            <button class="btn btn-block  tenposs-button" type="submit">ログイン</button>
            
        </form>
        <p class="text-center">
            すでに会員の方は、こちらへ
        </p>
    </div>
</div><!-- End header -->                        
@endsection