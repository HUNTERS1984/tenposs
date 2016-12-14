@extends('admin.layouts.master')
@section('main')
<aside class="right-side">
<div class="wrapp-breadcrumds">
    <div class="left">
        <span>顧客管理</span>
        <span class="circle-bre">{{ $users->total() }}</span>&nbsp;&nbsp;
        <strong>顧客情報の管理於可能</strong>
    </div>
</div>
<section class="content">
<div class="col-md-12">
    <div class="main-search-btn">
        <div class="row">
            <div class="col-md-6">
                <div class="wrapp_search_btn">
                    {{Form::open(array('route'=>'admin.users.management', 'class' => 'form-group', 'method' => 'GET'))}}
                    {{Form::text('search_pattern',old('search_pattern'),['class'=>'form-control has-feedback-left', 'id' => 'searchBox', 'placeholder' => 'ユーザー名を入力してください'])}}
                    <span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>
                    
                    {{Form::button('検索',['class'=>'btn right', 'type' => 'submit'])}}
                    {{Form::close()}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="search-right">
                  <a href="javascript:avoid()" class="btn-s-1" data-toggle="modal" data-target="#DeleteConfirm">
                      <i class="glyphicon glyphicon-plus"></i> 選択したユーザーを削除
                  </a>
                </div>
              </div>
        </div>
    </div>
</div>
<div class="col-md-12">
<div class="tab-content">
<div class="wrapp_table">
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
    @foreach( $users as $user )
    <tr>
        <th scope="row" class="center">
            <div>
                <input id="{{$user->id}}" class="checkbox-custom" name="checkbox-1" type="checkbox">
                <label for="{{$user->id}}" class="checkbox-custom-label"></label>
            </div>
        </th>
        <td class="center">
            <!-- @if( file_exists( public_path($user->profile->avatar_url) ) )
            <img src="{{ ( $user->profile->avatar_url != '' ) ? url($user->profile->avatar_url) : '' }}" alt="">
            @else
            <img src="{{ url('admin/images/icon-user.png') }}" alt="">
            @endif -->
        </td>
        <td class="center">
            <a href="{{ route('admin.users.management.detail',$user->id) }}" title="" class="blue">
                {{ $user->profile->name }}
            </a>
        </td>
        <td class="center">
            {{ $user->id }}
        </td>
        <td class="center">
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

        </td>
        <td class="center">
            @if( $user->profile->gender == 0 )
            不定義
            @elseif( $user->profile->gender == 1 )
            男性
            @elseif( $user->profile->gender == 2 )
            女性
            @endif
        </td>
        <td class="center">{{ $user->profile->age }}</td>
        <td class="center">{{ $user->profile->address }}</td>
        <td class="center">
            @if( $user->profile->facebook_status == 1 )
            <a href="#"><span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-facebook fa-stack-1x"></i>
            </span> </a>
            @endif
            @if( $user->profile->twitter_status == 1 )
            <a href="#"><span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-twitter fa-stack-1x"></i>
            </span> </a>
            @endif
            @if( $user->profile->instagram_status == 1 )
            <a href="#"><span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-instagram fa-stack-1x"></i>
            </span> </a>
            @endif
        </td>
        <td class="center">
            <a href="#" title="" class="blue-noneline">
                {{ $user->last_login }}
            </a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
<!-- //table -->
    {{ $users->render() }}
</div>
</div>
</div>
<div class="modal fade" id="DeleteConfirm" tabindex="-1" role="dialog" aria-labelledby="DeleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="DeleteConfirmLabel">本当に削除しますか？</h4>
            </div>
            <div class="modal-body"> 
                <div class="col-md-6">
                    <center><a href="#" data-dismiss="modal">キャンセル</a></center>
                </div>
                <div class="col-md-6">
                    <center><a href="#" id="btn_del" style="color:red; font-weight:bold;">承認</a></center>
                </div>
            </div>
            
        </div>
    </div>
</div>
</section>
</aside>
<!-- /.right-side -->
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function () {
        var del_list = [];
        $('#btn_del').click(function () {
            $("input[type=checkbox]:checked").each(function(){
                del_list.push($(this).attr('id'));
            });

            console.log(del_list);

            $.ajax({
                type: "POST",
                url: "/admin/users/management",
                data: {del_list: del_list}
            }).done(function (data) {
                ret = JSON.parse(data);
                if (ret.status == 1)
                    location.reload();
                else
                    alert('Cannot delete user');
            });
            del_list = [];

        });
        $('#searchBox').val(getParameterByName('search_pattern'));
    })
</script>
@endsection