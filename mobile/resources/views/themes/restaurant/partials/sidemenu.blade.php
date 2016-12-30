<div data-role="panel" id="outside" data-theme="b" style="background: #{{ $app_info->data->app_setting->menu_background_color}}">
    <ul data-role="listview" class="menu-left">
        <li class="user" style="background: #{{ $app_info->data->app_setting->menu_background_color}}">
            @if( Session::has('user') )
            <div class="user-left">
                <img style="max-height: 50px; object-fit: cover; " src="{{ Session::get('user')->profile->avatar_url ? Session::get('user')->profile->avatar_url : Theme::asset('img/user.png') }}" alt=""/>
            </div>
            <div class="user-right">
                <p><a data-ajax="false" style="padding-left: 0" href="{{ route('mypage') }}">{{ Session::get('user')->profile->name != '' ? Session::get('user')->profile->name : '不名' }}</a></p>
                <p>{{ Session::get('user')->email != '' ? Session::get('user')->email : '不名' }}</p>
            </div>
            @else

            <div class="user-left"><img src="{{ Theme::asset('img/user.png') }}"></div>
            <div class="user-right">
                <p><a data-ajax="false" style="padding-left: 0" href="{{ route('login') }}">マシュー</a></p>
                
            </div>

            @endif
        </li>

        @foreach ( $app_info->data->side_menu as $menu )
        <?php $menuItem = \App\Utils\Menus::page($menu->id) ?>
        @if( $menuItem['display'] )
        <li class="{{ $menu->icon }}">
            <a class="{{ $menuItem['classes'] }}" href="{{ $menuItem['href'] }}" style="
                    font-size: {{ $app_info->data->app_setting->menu_font_size }};
                    font-family: {{ $app_info->data->app_setting->menu_font_family }};
                    color: #{{ $app_info->data->app_setting->menu_font_color }};
                " data-ajax="false">{{ $menu->name }} </a>
        </li>
        @endif
        @endforeach
        <!--
        <li><a href="index.html" class="ui-icon-home ui-btn-icon-left" data-ajax="false">ホーム</a></li>
        <li><a href="menu.html" class="ui-icon-grid ui-btn-icon-left" data-ajax="false">メニュー</a></li>
        <li><a href="news.html" class="ui-icon-bullets ui-btn-icon-left" data-ajax="false">ニュース</a></li>
        <li><a href="photo.html" class="ui-icon-camera ui-btn-icon-left" data-ajax="false">写真</a></li>
        <li><a href="staff.html" class="ui-icon-user ui-btn-icon-left" data-ajax="false">スタッフ</a></li>
        <li><a href="coupon.html" class="ui-icon-star ui-btn-icon-left" data-ajax="false">クーポン</a></li>
        <li><a href="chat.html" class="ui-icon-comment ui-btn-icon-left" data-ajax="false">チャット</a></li>
        <li><a href="reserv.html" class="ui-icon-forward ui-btn-icon-left" data-ajax="false">予約</a></li>
        <li><a href="invitation.html" class="ui-icon-heart ui-btn-icon-left" data-ajax="false">招待コード</a></li>
        <li><a href="confi.html" class="ui-icon-gear ui-btn-icon-left" data-ajax="false">設定</a></li>
        -->
    </ul>
</div>