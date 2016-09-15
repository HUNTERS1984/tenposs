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
    <div>
        <h3>お申し込みは、まだ完了しておりません。
            入力いただいたメールアドレスに、本申し込みURLをお送りしておりますので必ずご確認ください。</h3>
    </div>
    <!-- <div class="social-auth-links text-center">
				<p>- OR -</p>
				<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
				Facebook</a>
				<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
				Google+</a>
			</div> -->
        <a href="{{url('/admin/login')}}" class="text-center">私はすでにアカウントを持っています</a>
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