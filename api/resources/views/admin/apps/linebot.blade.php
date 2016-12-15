@extends('admin.master')

@section('content')
<div class="topbar-content">
    <div class="wrap-topbar clearfix">
        <div class="left-topbar">
            <h1 class="title">Clients/Apps/Config LINE BOT</h1>
        </div>
    </div>
</div>
<!-- END -->

<div class="main-content">

    @include('admin.partials.message')
    <form method="post" action="{{ route('admin.clients.bot.setting.save',['user_id' => $user_id, 'app_id' => $app_id ]) }}">
        <input type="hidden" value="{{ csrf_token() }}"/>
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <input type="hidden" name="user_id" value="{{ $app_id }}">

        <div class="wrap-btn-content">
            <button class="btn btn-primary" type="submit"><i class=""></i> Save</button>
            <a href="{{ route('admin.clients.show',['user_id' => $user_id]) }}" class="btn-me btn-xanhduongnhat">Back</a>
        </div>	<!-- end wrap-btn-content-->
        <div class="wrapper-content">
            <div class="form-group">
                <label for="">Chanel ID</label>
                <input type="text" class="form-control" name="chanel_id" value="{{ $linebot->chanel_id }}">
            </div>
            <div class="form-group">
                <label for="">Chanel Secret</label>
                <input type="text" class="form-control"  name="chanel_secret" value="{{ $linebot->chanel_secret }}">
            </div>
            <div class="form-group">
                <label for="">Chanel Access Token</label>
                <input type="text" class="form-control"  name="chanel_access_token" value="{{ $linebot->chanel_access_token }}">
            </div>

            <div class="form-group">
                <label for="">Add friend url</label>
                <textarea name="add_friend_href" id="" cols="30" rows="3" class="form-control">{{ $linebot->add_friend_href }}</textarea>
            </div>
            <div class="form-group">
                <label for="">QR Code url</label>
                <textarea name="qr_code_href" id="" cols="30" rows="3" class="form-control">{{ $linebot->qr_code_href }}</textarea>
            </div>
        </div>	<!-- wrap-content-->
    </form>
</div>
<!-- END -->
@endsection


@section('footer')
<script src="{{ url('adcp/js/script.js') }}"></script>
@endsection