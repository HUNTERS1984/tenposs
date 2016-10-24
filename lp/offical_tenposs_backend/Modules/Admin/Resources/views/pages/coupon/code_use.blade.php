<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Registration Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="noindex, nofollow" name="robots">
{{Html::style('assets/backend/css/bootstrap.min.css')}}

<!-- Font Awesome -->
{{Html::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css')}}

<!-- Ionicons -->
{{--{{Html::style('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}--}}
<!-- Theme style -->
{{Html::style('assets/backend/css/AdminLTE.min.css')}}
<!-- iCheck -->
<!--{{Html::style('assets/backend/plugins/iCheck/square/blue.css')}}-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box" style="width: 50%;margin: 0 auto;">
    <div class="register-logo">
        <a href="{{url('/')}}">TENPOSS</a>
    </div>
    <div class="register-box-body">
        @include('admin::errors.listError')
        @if($is_approve)
            <div style="text-align: center">
                <h2>ユーザーのためのクーポンを承認</h2>
            </div>
            {{ Form::open(array('route'=>'coupon.use.code.approve', 'class'=>'form-horizontal','id'=>'approve_form')) }}
            <input type="hidden" name="code" id="code" value="{{$code}}">
            <input type="hidden" name="sig" id="sig" value="{{$sig}}">
            <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
            <input type="hidden" name="coupon_id" id="coupon_id" value="{{$coupon_id}}">
            <div class="form-group">
                <input type="submit" class="btn btn-primary form-control" value="承認します" id="btnRegister">
            </div>
            {{ Form::close()}}
        @else
            <div style="text-align: center">
                <h2>誤った情報</h2>
            </div>
        @endif
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
<!-- jQuery 2.1.4 -->
{{Html::script('assets/backend/js/jquery-1.11.2.min.js')}}
<!-- CORE JQUERY SCRIPTS -->
{{Html::script('assets/backend/js/bootstrap.min.js')}}
<script>
    //    $('#btnRegister').click(function () {
    //        var pass = $('#password').val();
    //        var pass_confir = $('#password_confirmation').val();
    //        if(pass )
    //        $('#register_form').submit();
    //    });
</script>
</body>
</html>