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
			<h2 class="title-container">さあ、はじめましょう。</h2>
			<p class="content">ご登録済みのメールアドレスを入力ください。新規パスワード設定のメールが送信されます。</p>
			<div class="wrap-form-forgot">
				@if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
				<form action="{{route('password.sendEmail')}}" method="POST" class="formTenposs">
					{{Form::token()}}
					<div class="form-group clearfix">
						<div class="left-form">
							<input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="メールアドレス">
						</div>
						<div class="right-form">
							<input type="submit" class="btn-xanhduong btn-submit" value="送信">
						</div>
					</div>
				</form>
			</div>
			@if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
		</div>
		<!-- END WRAP FORM -->
	</div>

	{{Html::style(asset('assets/frontend').'/css/bootstrap.min.css')}}
	{{Html::style(asset('assets/frontend').'/css/animate.css')}}
	{{Html::style(asset('assets/frontend').'/css/signup.css')}}
</body>
</html>