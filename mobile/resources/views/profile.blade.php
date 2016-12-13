@extends('master')

@section('headCSS')
<link href="{{ url('css/user.css') }}" rel="stylesheet">
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: '{{ $app_info->data->app_setting->font_family }}';
    }

    .h_control-back:before{
        color: #{{ $app_info->data->app_setting->title_color }};
        }
</style>
@endsection

@section('page')
<form action="{{ route('profile.save') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
<div id="header">
    <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
        <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
            ">
            {{ Str::words(Session::get('user')->profile->name,20) }}</h1>
            <button type="submit" class="btn pull-right btn-lg btn-submit-profile" style="background-color:white">
            保存
            </button>

            </h1>
        <a href="{{URL::previous()}}" class="h_control-back"></a>
    </div>
</div><!-- End header -->
<div id="main">
    <div id="content">
        @include('partials.message')
        <div id="user">
            <ul>
                <li>
                    <?php
                    $avatar = ($user->profile->avatar_url != '')
                        ? $user->profile->avatar_url
                        : url('/img/wall.jpg');
                    ?>

                    <label class="avatar">
                    <img id="app-icon-review" class="img-circle" src="{{ $avatar }}"  style="border: 2px solid #ddd; object-fit: cover; width: 120px; height: 120px;"></label>
                    <label class="label-title-user">
                        <a class="btn_upload_avatar create" href="javascript:void(0)">
                            <i class="fa fa-picture-o" aria-hidden="true"></i> プロフィール写真を変更
                        </a>
                        <input class="btn_upload_ipt create" style="display:none" type="file" name="avatar" value="{{ $user->profile->avatar_url }}">
                    </label>
                </li>
                <li>
                    <label>ユーザー名</label>
                    <input type="text" name="name" value="{{ $user->profile->name }}"/>

                </li>
                <li>
                    <label>パスワード</label>
                    <input readonly type="text" value="******"/>
                </li>
                <li>
                    <label>メールアドレス</label>
                    <input type="email" readonly name="email" value="{{ $user->email }}"/>
                </li>
                <li>
                    <label>性别</label>
                    <select name="gender" id="" class="">
                        <option value="0" {{ ($user->profile->gender == 0) ? 'selected' : '' }}>男性</option>
                        <option value="1" {{ ($user->profile->gender == 1) ? 'selected' : '' }}>女性</option>
                        <option value="2" {{ ($user->profile->gender == 2) ? 'selected' : '' }}>未定義</option>
                    </select>
                </li>
                <li>
                    <label>住所</label>
                    <input type="text" name="address" value="{{ $user->profile->address }}"/>
                </li>
            </ul>
            <ul class="social">
                <li>
                    <i class="icon-face"></i>
                    <div class="wrap-ic">
                        <span >Facebook</span>
                        @if( $user->profile->facebook_status == 1 )
                        <a href="{{ route('social.cancel',[ 'type' => 1 ]) }}" class="btn">非接続</a>
                        @else
                        <a href="{{ $fb_url }}" class="btn">
                           連携
                        </a>
                        @endif
                    </div>
                </li>
                <li>
                    <i class="icon-twitter"></i>
                    <div class="wrap-ic">
                        <span >Twitter</span>
                        @if( $user->profile->twitter_status == 1 )
                        <a href="{{ route('social.cancel',[ 'type' => 2 ]) }}" class="btn">非接続</a>
                        @else
                        <a href="{{ $tw_url }}" class="btn">
                           連携
                        </a>
                        @endif
                    </div>
                </li>
                <li>
                    <i class="icon-instagram"></i>
                    <div class="wrap-ic">
                        <span >Instagram</span>
                        @if( $user->profile->instagram_status == 1 )
                        <a href="{{ route('social.cancel',[ 'type' => 3 ]) }}" class="btn">非接続</a>
                        @else
                        <a href="{{ $instagram_login_url }}" class="btn">
                           連携
                        </a>
                        @endif
                    </div>


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
    })
</script>
@endsection