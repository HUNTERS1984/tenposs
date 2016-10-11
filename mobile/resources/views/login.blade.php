@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
    }
</style>
@endsection
@section('page')
<div id="main">    
    <div id="sign-up-page">
       
        <div class="bottom-layout">
            <a href="{{ route('auth.getSocialAuth',['provider' => 'facebook']) }}" class="btn btn-block tenposs-button bg-fb">
                <i class="fa fa-facebook"></i>
                Facebook ではじめる</a>
                
            <a href="{{ route('auth.getSocialAuth',['provider' => 'twitter']) }}" class="btn btn-block tenposs-button bg-tw">
                <i class="fa fa-facebook"></i>
                Twitter ではじめる</a>
                
            <a href="{{ route('login.normal') }}" class="btn btn-block tenposs-button bg-mail">
                <i class="fa fa-facebook"></i>
                メールアドレスではじめる</a> 
            
            <a href="{{ route('index') }}" class="btn btn-block tenposs-button bg-transparent">
                <i class="fa fa-facebook"></i>
                スキップ</a>
        </p>
    </div>
    @include('partials.sidemenu')
</div><!-- End main -->    
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sign-up-page').css({ height: $(window).innerHeight()+'px' });
    })
</script>
    
@endsection