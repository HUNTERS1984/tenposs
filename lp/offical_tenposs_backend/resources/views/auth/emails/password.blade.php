こんにちは！BASEです。 <br/>
 <br/>
パスワードリセットのリクエストを受け付けました。 <br/>
以下のURLへアクセスし、設定画面にて任意のパスワードへご変更ください。 <br/>
 <br/>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">
    {{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}
     </a>
 <br/>
 <br/>
もし、このメールにお心当たりがない場合は以下のメールアドレスへご連絡ください。 <br/>
 <br/>
support@thebase.in <br/>
 <br/>
 <br/>
 <br/>
─────────────────────────────────── <br/>
BASE株式会社 <br/>
BASE, Inc. <br/>
 <br/>
〒150-0043 東京都渋谷区道玄坂2-11-1 Gスクエア4F <br/>
───────────────────────────────────