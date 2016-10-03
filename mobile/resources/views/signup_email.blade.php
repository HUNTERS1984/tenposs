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
        <form action="{{ route('signup.post') }}" class="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <input class="form-control" type="text" name="name" placeholder="Name"/>
            </div>
             <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Email"/>
            </div>
             <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="パスワード"/>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="パスワード (確認)"/>
            </div>
            <button class="btn btn-block  tenposs-button" type="submit">OK</button>
            
        </form>
        <p class="text-center">
            すでに会員の方は、こちらへ
        </p>
    </div>
</div><!-- End header -->                        
@endsection