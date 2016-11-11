<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Select line accounts</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
     <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/chat.css') }} "/>
  </head>
  <body>
    <div class="container">
      <div class="panel panel-info" style="border-color: white;">
        <div class="panel-body">
          @foreach($datas as $d)
            <div class="media">
              <div class="media-left">
                <a href="{{ route('line.verifined.token',['id' => $d->mid ]) }}">
                  <img class="media-object" src="{{ $d->pictureUrl.'/small' }}" alt="{{ $d->displayName }}">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">{{ $d->displayName }}</h4>
                {{ $d->statusMessage }}
              </div>
            </div>
          @endforeach
        </div>
        <div class="panel-footer" style="border-top: 0px;padding: 0px;">
          <a onclick="login()" class="btn tenposs-btn">ログイン</a>
        </div>
      </div><!--end panel --> 
    </div><!--end container -->  
  </body>
</html>

<script type="text/javascript">
    function login() {
        window.parent.location.href = 'https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id={{ Config::get('line.LINE_CHANEL_ID') }}&redirect_uri={{Config::get('line.LINE_LOGIN_CALLBACK_URL')}}&state=';
    }
</script>