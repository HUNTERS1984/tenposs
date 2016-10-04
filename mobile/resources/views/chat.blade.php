@extends('master')

@section('page')
 <div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter" style="
                color: {{ $app_info->data->app_setting->title_color}};
                background-color: #{{ $app_info->data->app_setting->header_color}};
                ">
                {{ $app_info->data->name }} チャット</h1>
 
        <a href="javascript:void(0)" class="h_control-nav">
            <img src="img/icon/h_nav.png" alt="nav"/>
        </a>
    </div>
</div><!-- End header -->

<div id="main">
    <div id="content">
       <iframe width="100%" src="https://ten-po.com/chat/screen/{{ Session::get('app')->id }}" frameborder="0"></iframe>
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