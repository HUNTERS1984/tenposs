<div id="side">
    <div class="h_side">
        <div class="imageleft">
            @if( Session::has('user') )
            <div class="image">
                <a href="{{ route('profile') }}">
                    <img class="img-circle" src="{{ Session::get('user')->profile->avatar_url }}" alt=""/>
                </a>
            </div>
            <p class="font32">{{ Session::get('user')->profile->name }}</p>
            <p> <a href="{{ route('logout') }}">Logout</a> </p>
            @else
            <div class="image">
                <a href="{{ route('login') }}">
                <img class="img-circle" src="img/tkNdnb1.jpg" alt=""/>
                </a>
            </div>
            <p class="font32">User name</p>
            @endif
            
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