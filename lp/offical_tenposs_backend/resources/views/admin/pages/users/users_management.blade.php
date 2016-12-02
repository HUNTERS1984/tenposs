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
        <th class="center">ポジション</th><!-- Position -->
        <th class="center">クポン覧クポン</th><!-- Service connect -->
        <th class="center">真を確認</th><!-- Last login -->
    </tr>
    </thead>
    <tbody>
    @foreach( $users as $user )
    <tr>
        <th scope="row" class="center">
            <div>
                <input id="" value="{{ $user->id }}" class="checkbox-custom" name="checkbox_id[]" type="checkbox">
                <label for="" class="checkbox-custom-label"></label>
            </div>
        </th>
        <td class="center">
            @if( file_exists( public_path($user->profile->avatar_url) ) )
            <img src="{{ ( $user->profile->avatar_url != '' ) ? url($user->profile->avatar_url) : '' }}" alt="">
            @else
            <span class="fa-stack fa-lg">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-user fa-stack-2x fa-inverse"></i>
            </span>
            @endif
        </td>
        <td class="center">
            <a href="{{ route('admin.users.management.detail',$user->id) }}" title="" class="blue">
                {{ $user->profile->name }}
            </a>
        </td>
        <td class="center">
            {{ $user->id }}
        </td>
        <td class="center">{{ $user->profile->stage }}</td>
        <td class="center">
            @if( $user->profile->gender == 0 )
            利用不可
            @elseif( $user->profile->gender == 1 )
            男性
            @elseif( $user->profile->gender == 2 )
            女性
            @endif
        </td>
        <td class="center">{{ $user->profile->age }}</td>
        <td class="center">{{ $user->profile->position }}</td>
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
                <?php $session = $user->sessions()->orderBy('created_at','DESC')->first();  ?>
                @if( $session )
                {{ date('Y.m.d.H.i:s', strtotime( $session->created_at ) ) }}
                @endif
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
</section>
</aside>
<!-- /.right-side -->
@endsection