<p>&nbsp;</p>
@if (Session::has('success'))
    <div class="alert alert-success }}">
        @if( is_array( Session::get('success') ) ) 
            @foreach( Session::get('success') as $key => $val )
             {{ $val }}
            @endforeach
        @else
        {{ Session::get('success') }}
        @endif
    </div>
@endif

@if (Session::has('danger'))
    <div class="alert alert-danger }}">
         @if( is_array( Session::get('danger') ) ) 
            @foreach( Session::get('danger') as $key => $val )
             {{ $val }}
            @endforeach
        @else
        {{ Session::get('danger') }}
        @endif
       
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif