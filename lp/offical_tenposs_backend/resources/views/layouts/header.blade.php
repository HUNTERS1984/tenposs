<div class="header {{Request::path() != 'top' ? 'bg-color' : ''}} ">
	<div class="container">
		<div class="row">
			<div class="col-md-4 clearfix">
				<a href="{{url('/')}}" class="logo"><img src="{{asset('assets/frontend')}}/img/logo.png" class="img-responsive" alt="TENPOSS"></a>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed collapse-me" data-toggle="collapse" data-target="#mainMenu" aria-expanded="false">Menu</button>
				</div>
			</div>
			<div class="col-md-8">
				<div class="collapse navbar-collapse navbar-me" id="mainMenu">
					<ul class="main-navigation">
						<li><a href="{{url('/')}}">Top</a></li>
						<li><a href="{{url('function')}}">機能</a></li>
						<li><a href="{{url('fee')}}">価格</a></li>
						<li><a href="{{url('faq')}}">よくあるご質問</a></li>
						<li><a href="{{url('contact')}}">お問い合わせ</a></li>
						<li><a href="{{url('login')}}">ログイン</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>