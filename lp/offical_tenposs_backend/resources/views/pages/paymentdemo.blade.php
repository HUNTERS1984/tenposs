	<div class="container-wrap-form">
		<h2 class="title-container">PAID DEMO</h2>
		<div class="wrap-form">
			<form action="{{route('paymentdemo.post')}}" method="POST" class="formTenposs">
				{{Form::token()}}
				<div class="form-group">
					<label for="price">Price</label>
					<input type="text" class="form-control" name="price" placeholder="Input the price of item">
				</div>
				<div class="form-group text-center form-group-btn">
					<input type="submit" name="submit" class="form-control btn-submit btn-xanhduong" value="Confirm">
				</div>
			</form>
			@include('layouts.messages')
		</div>
	</div>