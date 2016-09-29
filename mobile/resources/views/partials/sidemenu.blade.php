<div id="side">
    <div class="h_side">
        <div class="imageleft">
            <div class="image">
                <img class="img-circle" src="img/tkNdnb1.jpg" alt="Thư kỳ"/>
            </div>
            <p class="font32">User name</p>
        </div>
    </div>
  
    <ul class="s_nav" style="
            background: #{{ $app_info->data->app_setting->menu_background_color}}
        ">
        @foreach ( $app_info->data->side_menu as $menu )
        <li class="s_icon-home">
            <a class="active" href="#" style="
                font-size: {{ $app_info->data->app_setting->menu_font_size }}px;
                font-family: {{ $app_info->data->app_setting->menu_font_family }}
            ">
            {{ $menu->name }}
        </a></li>    
        @endforeach
    </ul>
</div><!-- End side -->