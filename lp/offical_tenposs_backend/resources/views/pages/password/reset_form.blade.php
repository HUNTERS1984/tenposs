<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}">

	<title>RESET PASSWORD</title>
</head>
<body>
	<div class="page signupLogin">
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<a href="#" class="logo"><img src="{{asset('assets/frontend')}}/img/logo.png" class="img-responsive" alt="TENPOSS"></a>
					</div>
				</div>
			</div>
		</div>
		<!-- END HEADER -->
		<div class="container-wrap-form">
			<h2 class="title-container">パスワードを再設定します。</h2>
			<p class="content">下記の入力フォームに新しいパスワードを入力して下さい。</p>
			<div class="wrap-form-forgot">
				<form action="{{route('password.reset')}}" method="POST" class="formTenposs">
					{{Form::token()}}
					<input type="hidden" name="token" value="{{ $token }}">
					<input type="hidden" class="form-control" name="email" value="{{ $email or old('email') }}">
					<div class="form-group clearfix">
						<input type="password" name="password" class="form-control" placeholder="新しいパスワード">
						@if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
					</div>

					<div class="form-group">
						<input type="password" name="password_confirmation" class="form-control" placeholder="新しいパスワード (（確認用）) ">

						@if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
					</div>
					<div class="form-group text-center">
						<input type="submit" class="btn-me btn-xanhduong btn-submit" value="送信" >
					</div>
				</form>
				@if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
			</div>
		</div>
		<!-- END WRAP FORM -->
	</div>
	{{Html::style(asset('assets/frontend').'/css/bootstrap.min.css')}}
	{{Html::style(asset('assets/frontend').'/css/animate.css')}}
	{{Html::style(asset('assets/frontend').'/css/signup.css')}}
</body>
</html>