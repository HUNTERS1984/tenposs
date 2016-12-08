@extends('admin.layouts.master')
@section('main')

<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
                    <span>
                        顧客管理
                        <i class="fa fa-angle-right"></i>
                        {{ $app_user->profile->name }}
                    </span>
        </div>
    </div>
    <section class="content">
        <div class="wrapp-user-re">
            <div class="col-md-4">
                <div class="left-user-re">
                    <div class="img-user-re">
                        @if( file_exists( public_path($app_user->profile->avatar_url)) )
                        <img src="{{ url($app_user->profile->avatar_url) }}" alt="">
                        @else
                        <img src="{{ url('admin/images/user-re.png') }}" alt="">
                        @endif
                        <span><img src="{{ url('admin/images/gold.png') }}" alt=""></span>
                    </div>
                    <ul class="nav-user-re">
                        <li>
                            <span>ユーザーID</span>
                            <p>{{ $app_user->id }}</p>
                        </li>
                        <li>
                            <span>ユーザーネーム</span>
                            <p>{{ $app_user->profile->name }}</p>
                        </li>
                        <li>
                            <span>メンバーステージ</span>
                            <p>{{ $app_user->profile->stage }}</p>
                        </li>
                        <li>
                            <span>性別</span>
                            <p>@if( $app_user->profile->gender == 0 )
                                利用不可
                                @elseif( $app_user->profile->gender == 1 )
                                男性
                                @elseif( $app_user->profile->gender == 2 )
                                女性
                                @endif</p>
                        </li>
                        <li>
                            <span>年齢</span>
                            <p>{{ $app_user->profile->age }}</p>
                        </li>
                        <li>
                            <span>ポジション</span>
                            <p>{{ $app_user->profile->position }}</p>
                        </li>
                        <li>
                            <span>クポン覧クポン</span>
                            <p>
                                @if( $app_user->profile->facebook_status == 1 )
                                <a href="#"><span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x"></i>
                                  <i class="fa fa-facebook fa-stack-1x"></i>
                                </span> </a>
                                                    @endif
                                                    @if( $app_user->profile->twitter_status == 1 )
                                                    <a href="#"><span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x"></i>
                                  <i class="fa fa-twitter fa-stack-1x"></i>
                                </span> </a>
                                                    @endif
                                                    @if( $app_user->profile->instagram_status == 1 )
                                                    <a href="#"><span class="fa-stack fa-lg">
                                  <i class="fa fa-square-o fa-stack-2x"></i>
                                  <i class="fa fa-instagram fa-stack-1x"></i>
                                </span> </a>
                                @endif
                            </p>
                        </li>

                        <li>
                            <span>真を確認</span>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="right-user-re">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="tab-no">
                                <p>来店回数</p>
                                <h3> 回</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="tab-no">
                                <p>保有ポイント</p>
                                <h3>7,823p</h3>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-ul-bottom">
                                <div class="title-right-user-re">
                                    ポイント别用 . 獲得履歷
                                </div>
                                <div id="vt1" class="vtimeline">
                                    <div class="vtimeline-point">
                                        <div class="vtimeline-icon"></div>
                                        <div class="vtimeline-block">
                                            <div class="vtimeline-content">
                                                <p class="text-year-blue">
                                                    2016プッシュ通知(客管理)
                                                </p>
                                                <p class="text-no-blue">20460p 通知</p>
                                                <p class="text-des-blue">
                                                    <span>グローバル</span><br>
                                                    <strong>顧客管理</strong>
                                                </p>
                                                <p class="text-img-blue">
                                                    <span>クポン覧クポン</span> <br>
                                                    <img src="images/p-user.png" alt="">
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="vtimeline-point vtimeline-right">
                                        <div class="vtimeline-icon"></div>
                                        <div class="vtimeline-block">
                                            <div class="vtimeline-content">
                                                <p class="text-year-yellow">
                                                    2016プッシュ通知(客管理)
                                                </p>
                                                <p class="text-no-yellow">2040p 用保</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="vtimeline-point vtimeline-right">
                                        <div class="vtimeline-icon"></div>
                                        <div class="vtimeline-block">
                                            <div class="vtimeline-content">
                                                <p class="text-year-yellow">
                                                    2016プッシュ通知(客管理)
                                                </p>
                                                <p class="text-no-yellow">300p 用保</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="vtimeline-point">
                                        <div class="vtimeline-icon"></div>
                                        <div class="vtimeline-block">
                                            <div class="vtimeline-content">
                                                <p class="text-year-blue">
                                                    2016プッシュ通知(客管理)
                                                </p>
                                                <p class="text-no-blue">20460p 通知</p>
                                                <p class="text-des-blue">
                                                    <span>グローバル</span><br>
                                                    <strong>顧客管理</strong>
                                                </p>
                                                <p class="text-img-blue">
                                                    <span>クポン覧クポン</span> <br>
                                                    <img src="images/p-user.png" alt="">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
<!-- /.right-side -->

@endsection