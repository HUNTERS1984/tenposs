<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="ROBOTS" content="NOFOLLOW, NOINDEX">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  {!!Html::style('assets/backend/css/bootstrap.min.css')!!}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  {!!Html::style('assets/backend/css/AdminLTE.min.css')!!}

  <!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{!! url('/')!!}"><b>Admin</b>TENPOSS</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start Admin Session</p>
    
    {!! Form::open(array('url'=>'admin/login'))!!}
      <div class="form-group has-feedback">
        {!!Form::text('email',old('email'), array('class'=>'form-control', 'placeholder'=> 'Email') )!!}
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        {!!Form::password('password', array('class'=>'form-control', 'placeholder'=> 'Password') )!!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button> -->
          {!!Form::submit('Sign In',array('class'=>'btn btn-primary btn-block btn-flat') )!!}
        <!-- /.col -->
      </div>
    {!!Form::close()!!}

   @include('admin::errors.listError')

    @if(Session::has('flash_error'))
      <p class="alert alert-danger">{{Session::get('flash_error')}}</p>
    @endif

    <a href="{{route('admin.resetPassword')}}">I forgot my password</a><br>
    <a href="{{route('admin.register')}}" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


</body>
</html>
