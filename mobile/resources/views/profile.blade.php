@extends('master')

@section('headCSS')
<link href="{{ url('css/user.css') }}" rel="stylesheet">
@endsection

@section('page')

<div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter" style="
            color: #{{ $app_info->data->app_setting->title_color}};
            background-color: #{{ $app_info->data->app_setting->header_color}};
            ">
            {{ Session::get('user')->profile->name }}</h1>
        <a href="javascript:void(0)" class="h_control-nav">
            <img src="{{ url('img/icon/h_nav.png') }}" alt="nav"/>
        </a>
    </div>
</div><!-- End header -->
<div id="main">
    <div id="content">
        <div id="user">
            <ul>
                <li>
                    <label><img src="img/icon/icon-user.png" alt="User"/></label>
                    Lorem Ipsum is simply dummy
                </li>
                <li>
                    <label>Username</label>
                    <input type="text" value="tenposs1234"/>
                    <i class="icon-clean"></i>
                </li>
                <li>
                    <label>Password</label>
                    <input type="text" value="********"/>
                    <i class="icon-clean"></i>
                </li>
                <li>
                    <label>Email</label>
                    <input type="text" value="Example@ex.com"/>
                    <i class="icon-clean"></i>
                </li>
                <li>
                    <label>Lorem Ipsum</label>
                    Lorem Ipsum
                    <i class="arrow-down"></i>
                </li>
                <li>
                    <label>Lorem Ipsum</label>
                    Lorem Ipsum
                    <i class="arrow-down"></i>
                </li>
            </ul>
            <ul class="social">
                <li>
                    <i class="icon-face"></i>
                    Facebook
                    <a class="btn">Lorem</a>
                </li>
                <li>
                    <i class="icon-twitter"></i>
                    Twitter
                    <a class="btn">Lorem</a>
                </li>
                <li>
                    <i class="icon-instagram"></i>
                    Instagram
                    <a class="btn">Lorem</a>
                </li>
            </ul>
        </div>
    </div><!-- End content -->
    <div id="side">
        <div class="h_side">
            <div class="imageleft">
                <div class="image">
                    <img class="img-circle" src="{{ Session::get('user')->profile->avatar_url }}" alt="Thư kỳ"/>
                </div>
                <p class="font32"><strong>{{ Session::get('user')->profile->name }}</strong></p>
            </div>
        </div>
        <ul class="s_nav" style="
            background: #{{ $app_info->data->app_setting->menu_background_color}}
            ">
            @foreach ( $app_info->data->side_menu as $menu )
            <li class="s_icon-home">
                <a class="active" href="{{ \App\Utils\Menus::page($menu->id) }}" style="
                    font-size: {{ $app_info->data->app_setting->menu_font_size }}px;
                    font-family: {{ $app_info->data->app_setting->menu_font_family }}
                ">
                {{ $menu->name }}
            </a></li>    
            @endforeach
        </ul>
        
    </div><!-- End side -->
</div><!-- End main -->
<div id="footer"></div><!-- End footer -->

@endsection

@section('footerJS')

@endsection