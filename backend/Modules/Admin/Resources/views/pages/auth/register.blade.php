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
        <div style="text-align: center">
            <h2>Business user registration</h2>
        </div>
        {{ Form::open(array('route'=>'admin.postRegister', 'class'=>'form-horizontal','id'=>'register_form')) }}
        <div class="panel panel-default" style="border-radius: 0;margin-bottom: 0px;">
            <div class="panel-heading">User information</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Your name</label>
                    <div class="col-sm-9">
                        {{Form::text('name',old('name'), array('class'=>'form-control', 'placeholder'=>'type for here...'))}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" placeholder="type for here..." name="email"
                               value="{{old('email')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" placeholder="type for here..." name="password" id="password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Password confirmation</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" placeholder="type for here..."
                               name="password_confirmation" id="password_confirmation">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" style="border-radius: 0">
            <div class="panel-heading">Business information</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Company name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="company" name="company" value="{{old('company')}}"
                               placeholder="type for here...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Business type</label>
                    <div class="col-sm-9">
                        <select name="business_type" class="form-control">
                            <option value="">Select Role</option>
                            <option value="business">Business</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">App name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="app_name_register" name="app_name_register"  value="{{old('app_name_register')}}"
                               placeholder="type for here...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Domain</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="domain" name="domain" value="{{old('domain')}}"
                               placeholder="type for here...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Tel</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tel" name="tel" value="{{old('tel')}}"
                               placeholder="type for here...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Fax</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="fax" name="fax" value="{{old('fax')}}"
                               placeholder="type for here...">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary form-control" value="Register" id="btnRegister">
        </div>
    {{ Form::close()}}
    <!-- <div class="social-auth-links text-center">
				<p>- OR -</p>
				<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
				Facebook</a>
				<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
				Google+</a>
			</div> -->
        <a href="{{url('/admin/login')}}" class="text-center">I already have the account</a>
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