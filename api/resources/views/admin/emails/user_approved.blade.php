<p>Dear, <strong>{{ $user->name }}</strong></p>

<h2 style="text-align:center">Congragulation!</h2>
<h3>Your account are approved.</h3>
<br>
<br>
<p>Login info:</p>
<p>Click <a href="{{ $link }}">here</a> to login:</p>
<p>Email: {{ $user->email }}</p>
<p>Password: {{ $password }}</p>
<br>
<br>

<p>Best regards!</p>


