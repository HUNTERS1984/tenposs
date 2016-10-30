<p>&nbsp;</p>
@if (Session::has('success'))
    <div class="alert alert-success }}">
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('danger'))
    <div class="alert alert-danger }}">
        {{ Session::get('danger') }}
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