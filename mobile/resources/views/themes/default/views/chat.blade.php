@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: {{ $app_info->data->app_setting->font_family }};
    }
    .h_control-nav:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
    }
</style>
@endsection
@section('page')
 <div id="header">
    <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
        <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
                ">チャット</h1>
        <a href="javascript:void(0)" class="h_control-nav"></a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content">
       <iframe width="100%" src="https://ten-po.com/chat/app/{{ Session::get('app')->id }}" frameborder="0"></iframe>
    </div>
    @include('partials.sidemenu')
</div><!-- End header -->                        
@endsection

@section('footerJS')

<script type="text/javascript">
    $(document).ready(function(){
        $('#content iframe').css({ height: $(window).innerHeight()+'px' });
    })
</script>
@endsection