<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}">
	<title>SIGNUP</title>
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
			<div class="wrap-form">
				<form action="{{route('signup.post')}}" method="POST" class="formTenposs">
					{{Form::token()}}
					<div class="form-group">
						<label for="email">Eメールアドレス</label>
						<input type="text" class="form-control" name="email" placeholder="example@example.com" value="{{old('email')}}">
					</div>
					<div class="form-group">
						<label for="password">パスワード</label>
						<input type="password" class="form-control" name="password" placeholder="Password">
					</div>
					<div class="form-group">
						<label for="confirmed_password">パスワード （確認用）</label>
						<input type="password" class="form-control" name="password_confirmation" placeholder="Password">
					</div>
					<div class="form-group text-center form-group-btn">
						<input type="submit" name="submit" class="form-control btn-submit btn-xanhduong" value="次へ">
					</div>
					<p class="register">もう登録されていますか?　<a href="{{url('login')}}" >ログイン</a></p>
					
				</form>
				@include('admin::errors.listerror')
			</div>
		</div>
		<!-- END WRAP FORM -->
	</div>

	{{Html::style(asset('assets/frontend').'/css/bootstrap.min.css')}}
	{{Html::style(asset('assets/frontend').'/css/animate.css')}}
	{{Html::style(asset('assets/frontend').'/css/signup.css')}}
</body>
</html>