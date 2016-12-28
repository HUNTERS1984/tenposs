	<div class="container-wrap-form">
		<h2 class="title-container">PAYMENT INFO</h2>
		<label for="price">Payment: {{$payment->id}}</label> </br>
		<label for="price">Code: {{$payment->code}}</label> </br>
		<a class="btn btn-primary" href="{{route('paymentdemo.accept', $payment->id)}}">Accept</a>
		<a class="btn btn-primary" href="{{route('paymentdemo.cancel', $payment->id)}}">Cancel</a>
	</div>