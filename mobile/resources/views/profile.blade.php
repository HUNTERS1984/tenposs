@extends('master')

@section('headCSS')
<link href="{{ url('css/user.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: '{{ $app_info->data->app_setting->font_family }}';
    }
</style>
@endsection

@section('page')
<form action="{{ route('profile.save') }}" method="post">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
<div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter" style="
            color: #{{ $app_info->data->app_setting->title_color}};
            background-color: #{{ $app_info->data->app_setting->header_color}};
            ">
            {{ Session::get('user')->profile->name }}
            <button type="submit" class="btn pull-right">
            Save
        </button>
        
            </h1>
        <a href="javascript:void(0)" class="h_control-nav">
            <img src="{{ url('img/icon/h_nav.png') }}" alt="nav"/>
        </a>
        
        
    </div>
</div><!-- End header -->
<div id="main">
    <div id="content">
        @include('partials.message')
        <div id="user">
            <ul>
                <li>
                    
                        
                    <?php
                    $avatar = ($profile->data->user->profile->avatar_url != '') 
                        ? $profile->data->user->profile->avatar_url
                        : url('img/wall.jpg');
                    ?>
                    <div style="width:20%">
                    <label>
                    <img id="app-icon-review" class="new_img" src="{{ $avatar }}" width="100%"></label>
                    <button class="btn_upload_img create" type="button">
                        <i class="fa fa-picture-o" aria-hidden="true"></i> 画像アップロード
                    </button>
                    <input class="btn_upload_ipt create" style="display:none" type="file" name="avatar" value="{{ $profile->data->user->profile->avatar_url }}">
                    </div>
                </li>
                <li>
                    <label>Username</label>
                    <input type="text" name="name" value="{{ $profile->data->user->profile->name }}"/>
                    
                </li>
                <li>
                    <label>Password</label>
                    <input readonly type="text" value="******"/>
                    
                </li>
                <li>
                    <label>Email</label>
                    <input type="email" readonly name="email" value="{{ $profile->data->user->email }}"/>
                    
                </li>
                <li>
                    <label>Gender</label>
                    <select name="gender" id="">
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                        <option value="2">Orther</option>
                    </select>   
           
                </li>
                <li>
                    <label>Address</label>
                    <input type="text" name="address" value="{{ $profile->data->user->profile->address }}"/>
                   
                </li>
            </ul>
            <ul class="social">
                <li>
                    <i class="icon-face"></i>
                    Facebook
                    @if( $profile->data->user->profile->facebook_status == 1 )
                    <a href="#" class="btn">接続</a>
                    @else    
                    <a href="{{ route('auth.getSocialAuth',['provider' => 'facebook']) }}" class="btn">
                       接続します
                    </a>
                    @endif
                    
                </li>
                <li>
                    <i class="icon-twitter"></i>
                    Twitter
                    @if( $profile->data->user->profile->twitter_status == 1 )
                    <a href="#" class="btn">接続</a>
                    @else    
                    <a href="{{ route('auth.getSocialAuth',['provider' => 'twitter']) }}" class="btn">
                       接続します
                    </a>
                    @endif
                </li>
                <li>
                    <i class="icon-instagram"></i>
                    Instagram
                    @if( $profile->data->user->profile->instagram_status == 1 )
                    <a href="#" class="btn">接続</a>
                    @else    
                    <a href="{{ $instagram_login_url }}" class="btn">
                       接続します
                    </a>
                    @endif
                </li>
            </ul>
        </div>
    </div><!-- End content -->
    <div id="side">
        <div class="h_side">
            <div class="imageleft">
                <div class="image">
                    <img class="img-circle" src="{{ Session::get('user')->profile->avatar_url }}" alt=""/>
                </div>
                <p class="font32">
                    <strong>{{ $profile->data->user->profile->name }}</strong>
                    - <a href="{{ route('logout') }}">Logout</a>
                </p>
            </div>
        </div>
        <ul class="s_nav" style="
            background: #{{ $app_info->data->app_setting->menu_background_color}}
            ">
            @foreach ( $app_info->data->side_menu as $menu )
            <li class="s_icon-home">
                <a class="active" href="{{ \App\Utils\Menus::page($menu->id) }}" style="
                    font-size: {{ $app_info->data->app_setting->menu_font_size }};
                    font-family: {{ $app_info->data->app_setting->menu_font_family }};
                    color: #{{ $app_info->data->app_setting->menu_font_color }};
                ">
                {{ $menu->name }}
            </a></li>    
            @endforeach
        </ul>
        
    </div><!-- End side -->
</div><!-- End main -->
<div id="footer"></div><!-- End footer -->
</form>
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function(){
        
    
    
        $('.btn_upload_img.create').click(function () {
            $(this).next('.btn_upload_ipt.create').click();
        });
        $("input.btn_upload_ipt").change(function () {
            if ( this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#app-icon-review').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    })
</script>
@endsection