@if($errors->any())
<div class="alert alert-danger">
	<ul style="list-style-type:none;padding: 0px;">
		@foreach($errors->all() as $error)
		<li>{!! $error!!}</li>
		@endforeach
	</ul>
</div>
@endif
@if (session('status'))
    <div class="alert alert-success">
        @if( is_array( session('status') ) )
            @foreach ( session('status') as $status )
                {{$status}}
            @endforeach
        @else
        {{ session('status') }}
        @endif

    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning">
        @if( is_array( session('warning') ) )
            @foreach ( session('warning') as $warning )
                {{$warning}}
            @endforeach
        @else
            {{ session('warning') }}
        @endif

    </div>
@endif
<div id="customer_message" style="display:none" class="alert alert-danger">
    <ul style="list-style-type:none;padding: 0px;">       
        <li></li>
    </ul>
</div>