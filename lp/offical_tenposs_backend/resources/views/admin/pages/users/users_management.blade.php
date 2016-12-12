@extends('admin.layouts.master')
@section('main')
<aside class="right-side">
<div class="wrapp-breadcrumds">
    <div class="left">
        <span>顧客管理</span>
        <span class="circle-bre">{{ $users->total_users }}</span>&nbsp;&nbsp;
        <strong>顧客情報の管理於可能</strong>
    </div>
</div>

    <section class="content">
    <div class="col-md-12">
        <div class="main-search-btn">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="wrapp_search_btn">
                        <form class="form-group">
                            <input type="text" class="form-control has-feedback-left" id="" placeholder="ユーザー名を入力してください">
                            <span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="tab-content">
            <div class="wrapp_table">
                <form id="user-management-form" method="post" action="{{ route('admin.users.management.post') }}" class="form-group">
                    <div class="clearfix">
                        <input type="button" id="submit-delete" name="submit_delete" class="btn btn-danger pull-right" value="削除"/>

                    </div>
                    <p>&nbsp;</p>
                    <!-- table -->
                <div class="table-responsive">
                <table class="table accept_01">
                    <thead>
                    <tr>
                        <th class="center">選択</th>
                        <th></th>
                        <th class="center">ユーザーネーム</th>
                        <th class="center">ユーザーID</th>
                        <th class="center">メンバーステージ</th><!-- Member stage -->
                        <th class="center">性別</th><!-- Gender -->
                        <th class="center">年齢</th><!-- Age -->
                        <th class="center">地図</th><!-- Position -->
                        <th class="center">サービス連携</th><!-- Service connect -->
                        <th class="center">最終ログイン</th><!-- Last login -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $users->users as $key => $user )
                    <tr>
                        <th scope="row" class="center">
                            <div>
                                <input id="app-user-{{ $user->app_user_id }}" value="{{ $user->app_user_id }}" class="checkbox-custom checkbox-user-id" name="checkbox_user_id[]" type="checkbox">
                                <label for="app-user-{{ $user->app_user_id }}" class="checkbox-custom-label"></label>
                            </div>
                        </th>
                        <td class="center">
                            @if( in_array( substr($user->avatar_url, strrpos($user->avatar_url, '.')+1),array( 'png','jpg','gif' )  ))
                            <img src="{{ $user->avatar_url }}" alt="">
                            @else
                            <img src="{{ url('admin/images/icon-user.png') }}" alt="">
                            @endif
                        </td>
                        <td class="center">
                            <a href="{{ route('admin.users.management.detail',$user->id) }}" title="" class="blue">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="center">
                            {{ $user->id }}
                        </td>
                        <td class="center">
                            <?php /*
                            @if ($user->point->miles >= $client->point_setting->rank4)
                                <p>ダイアモンド会員</p>
                                @elseif ($user->point->miles >= $client->point_setting->rank3)
                                <p>プラチナ会員</p>
                                @elseif ($user->point->miles >= $client->point_setting->rank2)
                                <p>ゴールド会員</p>
                                @elseif ($user->point->miles >= $client->point_setting->rank1)
                                <p>シルバー会員</p>
                                @else
                                <p>普通会員</p>
                            @endif
                            */?>
                        </td>
                        <td class="center">
                            @if( $user->gender == 0 )
                            不定義
                            @elseif( $user->gender == 1 )
                            男性
                            @elseif( $user->gender == 2 )
                            女性
                            @endif
                        </td>
                        <td class="center">{{ $user->age }}</td>
                        <td class="center">{{ $user->address }}</td>
                        <td class="center">
                            @if( $user->facebook_status == 1 )
                            <a href="#"><span class="fa-stack fa-lg">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-facebook fa-stack-1x"></i>
                            </span> </a>
                            @endif
                            @if( $user->twitter_status == 1 )
                            <a href="#"><span class="fa-stack fa-lg">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-twitter fa-stack-1x"></i>
                            </span> </a>
                            @endif
                            @if( $user->instagram_status == 1 )
                            <a href="#"><span class="fa-stack fa-lg">
                              <i class="fa fa-square-o fa-stack-2x"></i>
                              <i class="fa fa-instagram fa-stack-1x"></i>
                            </span> </a>
                            @endif
                        </td>
                        <td class="center">
                            <a href="#" title="" class="blue-noneline">

                                </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                </form>
                <!-- //table -->
                <div class="text-center">
               {!! $pagination !!}
                </div>
            </div>
        </div>
    </div>
    </section>

</aside>
<!-- /.right-side -->
@endsection

@section('footerJS')
<script>
    $(document).ready(function(){
        $('#submit-delete').on('click',function(e){
            e.preventDefault();
            if( $('input.checkbox-user-id:checked').length <= 0 ){
                alert('Please select user'); return false;
            }else{
                $('form#user-management-form').submit();
            }
        });
    })
</script>

@endsection