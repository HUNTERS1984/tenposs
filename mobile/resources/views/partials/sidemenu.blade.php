<div id="side">
    <div class="h_side" style="
            background: #{{ $app_info->data->app_setting->menu_background_color}}
        ">
        <div class="imageleft clearfix">
            @if( Session::has('user') )
            <div class="image">
                <a href="{{ route('profile') }}">
                    <?php
                       if( strpos( Session::get('user')->profile->avatar_url , '.jpg' ) !== false ){
                            $avatar_url = Session::get('user')->profile->avatar_url;
                       }else{
                           $avatar_url = url('/img/tkNdnb1.jpg');
                       }
                    ?>
                    <img class="img-circle" src="{{ $avatar_url }}" alt=""/>
                </a>
            </div>
            <p class="font32">{{ Session::get('user')->profile->name }}</p>
            @else
            <div class="image">
                <a href="{{ route('login') }}">
                <img class="img-circle" src="{{ url('/img/icon/icon-user.png') }}" alt=""/>
                </a>
            </div>
            <p class="font32"><a href="{{ route('login') }}" style="
                font-family: {{ $app_info->data->app_setting->menu_font_family }};
                color: #{{ $app_info->data->app_setting->menu_font_color }};
            ">ログイン</a></p>
            @endif
            
        </div>
    </div>
  
    <ul class="s_nav" style="
            background: #{{ $app_info->data->app_setting->menu_background_color}}
        ">
        @foreach ( $app_info->data->side_menu as $menu )
        <li class="{{ $menu->icon }}">
            <a class="active" href="{{ \App\Utils\Menus::page($menu->id) }}" style="
                font-size: {{ $app_info->data->app_setting->menu_font_size }};
                font-family: {{ $app_info->data->app_setting->menu_font_family }};
                color: #{{ $app_info->data->app_setting->menu_font_color }};
            ">
            {{ $menu->name }}
        </a></li>            
        @endforeach
<!--         @if( Session::has('user') )
        <li class="ti-unlock">
            <a class="active" href="{{ route('logout') }}" style="
                font-size: {{ $app_info->data->app_setting->menu_font_size }};
                font-family: {{ $app_info->data->app_setting->menu_font_family }};
                color: #{{ $app_info->data->app_setting->menu_font_color }};
            ">
            ログアウト
        </a></li> 
        @endif -->
    </ul>
</div><!-- End side -->