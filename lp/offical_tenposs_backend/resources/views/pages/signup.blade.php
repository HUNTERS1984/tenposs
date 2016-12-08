<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{!! csrf_token() !!}">
    <title>登録・サインアップ｜スマホサイトとオリジナルアプリを簡単に無料で作れるTenposs</title>
    <meta name="keywords" content="店舗アプリ,お店アプリ,店舗販促,集客方法,リピーター">
    <meta name="description" content="スマホサイトとオリジナルアプリを簡単に無料で作れるTenposs（テンポス）の登録・サインアップページです。">
	{{Html::style(asset('assets/frontend').'/css/bootstrap.min.css')}}
	{{Html::style(asset('assets/frontend').'/css/animate.css')}}
	{{Html::style(asset('assets/frontend').'/css/signup.css')}}
</head>
<body>
    <h1 class="hidden">さあ、はじめましょう。</h1>
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
				<form id="signup-form" action="{{route('signup.post')}}" method="POST" class="formTenposs">
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
						<input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirm">
					</div>
					<div class="form-group">
						<label for="terms">
                            <input id="terms" value="1" type="checkbox" class="" name="terms">
                            <a href="#" data-toggle="modal" data-target="#agreement-modal">規約と条件</a>
                        </label>
                        <span for="" id="terms-msg" class="text-danger"></span>
					</div>
					
					<div class="form-group text-center form-group-btn">
						<input id="submit" type="submit" class="form-control btn-submit btn-xanhduong" value="次へ">
					</div>
					<p class="register">もう登録されていますか?　<a href="{{url('login')}}" >ログイン</a></p>
					
				</form>
				@include('layouts.messages')
			</div>
		</div>
		<!-- END WRAP FORM -->
	</div>
	@include('pages.registers.agreement')
	{{Html::script(asset('assets/frontend').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(asset('assets/frontend').'/js/bootstrap.min.js')}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('#submit').on('click', function(e){
				var agreeBox = $('input#terms');
			    if ( !agreeBox.is(':checked') ){
			        $('#terms-msg').text('契約条件に同意してください');
			        return false;
			    }
			})
			 
		})
		
	</script>
</body>
</html>