<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                 <img src="{{ url('admin/images/avatar.png') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>ユーザーネーム</p>
                <a href="#"><i class="fa fa-circle text-success"></i> オンライン</a>
            </div>
        </div>
                
        <ul class="sidebar-menu">
            <li class="none">
                <span>Page</span>
            </li>
            <li>
                <a href="{{ route('admin.client.global') }}"><span>グローバル</span></a>
            </li>
            <li class="active">
                <a href="{{ route('admin.client.top') }}"><span>トップ</span></a>
            </li>
            <li>
                <a href="menu.html"><span>メニュー</span></a>
            </li>
            <li>
                <a href="news.html"><span>ニュース</span></a>
            </li>
            <li>
                <a href="coupon.html"><span>クーポン</span></a>
            </li>
            <li>
                <a href="photo.html"><span>フォトギャラリー</span></a>
            </li>
            <li>
                <a href="staff.html"><span>スタッフ</span></a>
            </li>
            <li>
                <a href="staff.html"><span>スタッフ</span></a>
            </li>
            <li>
                <a href="setting.html"><span>設定</span></a>
            </li>

            <li class="none">
                <span>Other</span>
            </li>
            <li>
                <a href="push.html"><span>プッシュ通知</span></a>
            </li>
            <li>
                <a href="analytic.html"><span>アクセス解析</span></a>
            </li>
            <li>
                <a href="user.html"><span>顧客管理</span></a>
            </li>
            <li>
                <a href="accept.html"><span>承認管理</span></a>
            </li>
            <li>
                <a href="account.html"><span>アカウント設定</span></a>
            </li>
            <li>
                <a href="help.html"><span>ヘルプ</span></a>
            </li>
            <li>
                <a href="contact.html"><span>お問い合わせ</span></a>
            </li>
            <li>
                <a href="http://pon.cm/" target="_blank" class="img-nav">
                    <img src="{{ url('admin/images/pon-nav-bottom.png') }}" alt="">
                </a>
            </li>
        </ul>
    </section>
</aside>