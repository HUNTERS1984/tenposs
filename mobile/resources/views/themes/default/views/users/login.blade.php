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
    <div id="sign-up-page">
        <h3 class="tenposs-title">{{$app_info->data->app_setting->title}}</h3>
        @include('partials.message')

        <div class="bottom-layout">
            <a href="{{ route('login.facebook') }}" class="btn tenposs-button bg-fb">
                Facebook ではじめる</a>
                
            <a href="{{ route('login.twitter') }}" class="btn tenposs-button bg-tw">
                Twitter ではじめる</a>
                
            <a href="{{ route('login.normal') }}" class="btn tenposs-button bg-mail">
                <i class="fa fa-facebook"></i>
                メールアドレスではじめる</a> 
            
            <a href="{{ route('index.redirect') }}" class="btn tenposs-button last bg-transparent">
                <i class="fa fa-facebook"></i>
                スキップ</a>
        </p>
    </div>
    @include('partials.sidemenu')    
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sign-up-page').css({ height: $(window).innerHeight()+'px' });
    })
</script>
    
@endsection