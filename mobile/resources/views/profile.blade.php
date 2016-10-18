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
<form action="{{ route('profile.save') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
<div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter" style="
            color: #{{ $app_info->data->app_setting->title_color}};
            background-color: #{{ $app_info->data->app_setting->header_color}};
            ">
            {{ Session::get('user')->profile->name }}
            <button type="submit" class="btn pull-right btn-lg" style="background-color:white">
            保存
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
                    
                    <label>
                    <img id="app-icon-review" class="img-circle" src="{{ $avatar }}" width="100px" height="100px" style="border: 2px solid #ddd; object-fit: cover;"></label> 
                    <label style="width: 60%;">
                        <a class="btn_upload_avatar create" href="javascript:void(0)">
                            <i class="fa fa-picture-o" aria-hidden="true"></i> プロフィール写真を変更
                        </a>
                        <input class="btn_upload_ipt create" style="display:none" type="file" name="avatar" value="{{ $profile->data->user->profile->avatar_url }}">
                    </label>
                </li>
                <li>
                    <label>ユーザー名</label>
                    <input type="text" name="name" value="{{ $profile->data->user->profile->name }}"/>
                    
                </li>
                <li>
                    <label>パスワード</label>
                    <input readonly type="text" value="******"/>
                    
                </li>
                <li>
                    <label>メールアドレス</label>
                    <input type="email" readonly name="email" value="{{ $profile->data->user->email }}"/>
                    
                </li>
                <li>
                    <label>性别</label>
                    <select name="gender" id="" class="slect-lg">
                        <option value="0">男性</option>
                        <option value="1">女性</option>
                        <option value="2">未定義</option>
                    </select>   
           
                </li>
                <li>
                    <label>住所</label>
                    <input type="text" name="address" value="{{ $profile->data->user->profile->address }}"/>
                   
                </li>
            </ul>
            <ul class="social">
                <li>
                    <i class="icon-face"></i>
                    Facebook
                    @if( $profile->data->user->profile->facebook_status == 1 )
                    <a href="{{ route('social.cancel', [ 'type' => 1 ]) }}" class="btn">キャンセル</a>
                    @else    
                    <a href="{{ $fb_url }}" class="btn">
                       連携
                    </a>
                    @endif
                    
                </li>
                <li>
                    <i class="icon-twitter"></i>
                    Twitter
                    @if( $profile->data->user->profile->twitter_status == 1 )
                    <a href="{{ route('social.cancel', [ 'type' => 2 ]) }}" class="btn">キャンセル</a>
                    @else    
                    <a id=""  href="{{ $tw_url }}" class="btn">
                       連携
                    </a>
                    @endif
                </li>
                <li>
                    <i class="icon-instagram"></i>
                    Instagram
                    @if( $profile->data->user->profile->instagram_status == 1 )
                    <a href="{{ route('social.cancel', [ 'type' => 3 ]) }}" class="btn">キャンセル</a>
                    @else    
                    <a href="{{ $instagram_login_url }}" class="btn">
                       連携
                    </a>
                    @endif
                </li>
            </ul>
        </div>
    </div><!-- End content -->
    @include('partials.sidemenu')
</div><!-- End main -->
<div id="footer"></div><!-- End footer -->
</form>
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function(){
        
        $('#twitterClick').oauthpopup({path:'/login/twitter'});
    
        $('.btn_upload_avatar').click(function () {
            $('.btn_upload_ipt').click();
        });
        
        $(".btn_upload_ipt").change(function () {
            if ( this.files && this.files[0]) {
               
                var reader = new FileReader();
                reader.onload = function (e) {
                    //console.log( e.target.result);
                    $('#app-icon-review').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        
    });
    
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '159391921181596',
            xfbml      : false, // disable reding dom
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };
    
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ja_JP/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    
    

    function FacebookLogin() {
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                
            }
            else {
                FB.logout();
                FB.login(function(response){
                    
                    if (response.authResponse) {
                        console.log('Welcome!  Fetching your information.... ');
                        FB.api('/me', function(response) {
                        console.log('Good to see you, ' + response.name + '.');
                        console.log(FB.getAuthResponse());
                        // call ajax to server
                        
                    });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                }, {scope: 'email'});
            }
        });
        
    }
    
(function($){
    //  inspired by DISQUS
    $.oauthpopup = function(options)
    {
        if (!options || !options.path) {
            throw new Error("options.path must not be empty");
        }
        options = $.extend({
            windowName: 'ConnectWithOAuth' // should not include space for IE
          , windowOptions: 'location=0,status=0,width=800,height=400'
          , callback: function(){ window.location.reload(); }
        }, options);

        var oauthWindow   = window.open(options.path, options.windowName, options.windowOptions);
        var oauthInterval = window.setInterval(function(){
            if (oauthWindow.closed) {
                window.clearInterval(oauthInterval);
                options.callback();
            }
        }, 1000);
    };

    //bind to element and pop oauth when clicked
    $.fn.oauthpopup = function(options) {
        $this = $(this);
        $this.click($.oauthpopup.bind(this, options));
    };
})(jQuery);

</script>
@endsection