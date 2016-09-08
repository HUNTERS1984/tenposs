 @if(Session::has('errors'))
  <div class="alert alert-danger">
     @foreach($errors->all() as $error)
        <p >{{$error}}</p>
    @endforeach
  </div>
@endif