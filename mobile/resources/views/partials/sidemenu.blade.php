<div id="side" style="background: #{{ $app_info->data->app_setting->menu_background_color}}">
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
                           $avatar_url = url('/img/icon/icon-user.png');
                       }
                    ?>
                    <img class="img-circle" src="{{ $avatar_url }}" alt=""/>
                </a>
            </div>
            <p class="font32">{{ Session::get('user')->profile->name != '' ? Session::get('user')->profile->name : '不名' }}</p>
            @else
            <div class="image">
                <a href="{{ route('login') }}">
                <img class="img-circle" src="{{ url('/img/icon/icon-user.png') }}" alt=""/>
                </a>
            </div>
            <p class="font32"><a href="{{ route('login') }}" style="
                font-size: {{ $app_info->data->app_setting->menu_font_size }};
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
        <?php $menuItem = \App\Utils\Menus::page($menu->id) ?>
        @if( $menuItem['display'] )
        <li class="{{ $menu->icon }}">
                <a class="active" href="{{ $menuItem['href'] }}" style="
                    font-size: {{ $app_info->data->app_setting->menu_font_size }};
                    font-family: {{ $app_info->data->app_setting->menu_font_family }};
                    color: #{{ $app_info->data->app_setting->menu_font_color }};
                ">{{ $menu->name }} </a>
        </li>
        @endif
        @endforeach
    </ul>
</div><!-- End side -->