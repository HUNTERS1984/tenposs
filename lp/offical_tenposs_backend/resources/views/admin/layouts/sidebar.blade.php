<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                 <img src="{{ Session::has('user') && isset(Session::get('user')->user_info) ? url(Session::get('user')->user_info->avatar) : url('admin/images/icon-user.png')}}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ (Session::has('user') ? Session::get('user')->name : 'Welcome' ) }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> オンライン</a>
            </div>
        </div>
                
        <ul class="sidebar-menu">
            <li class="none">
                <span>Page</span>
            </li>
            <li class="{{ (Request::route()->getName() == 'admin.client.global') ? 'active' : '' }}">
                <a href="{{ route('admin.client.global') }}"><span>グローバル</span></a>
            </li>
            <li class="{{ (Request::route()->getName() == 'admin.client.top') ? 'active' : '' }}">
                <a href="{{ route('admin.client.top') }}"><span>トップ</span></a>
            </li>
            <li class="{{ (Request::route()->getName() == 'admin.menus.index') ? 'active' : '' }}">
                <a href="{{ route('admin.menus.index') }}"><span>メニュー</span></a>
            </li>
            <li class="{{ (Request::route()->getName() == 'admin.news.index') ? 'active' : '' }}">
                <a href="{{ route('admin.news.index') }}"><span>ニュース</span></a>
            </li>
            <li class="{{ (Request::route()->getName() == 'admin.coupon.index') ? 'active' : '' }}">
                <a href="{{ route('admin.coupon.index') }}"><span>クーポン</span></a>
            </li>
            <li class="{{ Request::is('admin/photo-cate*') ? 'active' : '' }}">
                <a href="{{route('admin.photo-cate.index')}}"><span>フォトギャラリー</span></a>
            </li>
            <li class="{{ Request::is('admin/staff*') ? 'active' : '' }}">
                <a href="{{route('admin.staff.index')}}"><span>スタッフ</span></a>
            </li>

            <li class="none">
                <span>Other</span>
            </li>
            <li class="{{ Request::is('admin/push*') ? 'active' : '' }}">
                <a href="{{route('admin.push.index')}}"><span>プッシュ通知</span></a>
            </li>
            <li class="{{ Request::is('admin/analytic*') ? 'active' : '' }}">
                <a href="{{route('admin.analytic.google')}}"><span>アクセス解析</span></a>
            </li>
            <li class="{{ Request::is('admin/cost*') ? 'active' : '' }}">
                <a href="{{ route('admin.cost.index') }}"><span>コスト管理</span></a>
            </li>
            <li class="{{ Request::is('admin/chat*') ? 'active' : '' }}">
                <a href="{{ route('admin.client.chat') }}"><span>チャット</span></a>
            </li>
            <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.management') }}"><span>顧客管理</span></a>
            </li>
            <li class="{{ Request::is('admin/coupon*') ? 'active' : '' }}">
                <a href="{{ route('admin.coupon.accept') }}"><span>承認管理</span></a>
            </li>
            <li class="{{ Request::is('admin/account*') ? 'active' : '' }}">
                <a href="{{ route('admin.client.account') }}"><span>アカウント設定</span></a>
            </li>
            <li class="{{ Request::is('admin/help*') ? 'active' : '' }}">
                <a href="{{route('admin.client.help')}}"><span>ヘルプ</span></a>
            </li>
            <li class="{{ Request::is('admin/contact*') ? 'active' : '' }}">
                <a href="{{route('admin.client.contact')}}"><span>お問い合わせ</span></a>
            </li>
            <li>
                <a href="http://pon.cm/" target="_blank" class="img-nav">
                    <img src="{{ url('admin/images/pon-nav-bottom.png') }}" alt="">
                </a>
            </li>
        </ul>
    </section>
</aside>