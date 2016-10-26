@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
    }
</style>
<!-- Custom styles for this template -->
<link href="{{ url('css/setting.css') }}" rel="stylesheet">
@endsection
@section('page')
<div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter" style="
            color: #{{ $app_info->data->app_setting->title_color}};
            background-color: #{{ $app_info->data->app_setting->header_color}};
            ">逼営会社</h1>
        <a href="{{URL::previous()}}" class="">
            <img src="img/icon/h_back-arrow.jpg" alt="nav"/>
        </a>
    </div>
</div><!-- End header -->
<div id="main">
    <div id="content">
        <div class="wrap-content-config">
            {!! $app_info->data->app_setting->company_info !!}
        </div>
    </div>
    @include('partials.sidemenu')
</div><!-- End main -->
@endsection
