@extends('admin.master')
@section('content')
    <div class="topbar-content">
        <div class="wrap-topbar clearfix">
            <div class="left-topbar">
                <h1 class="title">Dashboard</h1>
            </div>
        </div>
    </div>
    <!-- END -->

    <div class="main-content news">
        <div class="wrapper-content">
            @if( $users )
                <table class="table table-tripped">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Function</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $users as $user )
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('admin.clients.show',['user_id'=>$user->id] ) }}" class="btn btn-info" >View</a>
                                <!-- Modal -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            @else
                <p>You don't have any users to approved.!</p> 
            @endif
        </div>
    </div>
    
@endsection




