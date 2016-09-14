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

            @if( $user )
                <div class="wrap-btn-content">
                    @if( $user->status == 2)
                    <a href="#" data-toggle="modal" data-target="#modal-user" class="btn-me btn-hong">Approved</a>
                    @else
                    <a href="#" class="btn-me btn-hong">Edit</a>
                    <a href="#" class="btn-me btn-xanhduongnhat">Delete</a>
                    @endif
                </div>	<!-- end wrap-btn-content-->
                
                
                <div class="panel panel-info">
                    <div class="panel-heading">User informations</div>
                    <div class="panel-body">
                        <table class="table table-tripped">
                            <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Sex</td>
                                <td>{{ $user->sex }}</td>
                            </tr>
                            <tr>
                                <td>Birthday</td>
                                <td>{{ $user->birthday }}</td>
                            </tr>
                            <tr>
                                <td>Locale</td>
                                <td>{{ $user->locale }}</td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td>{{ $user->companny }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <td>Tel</td>
                                <td>{{ $user->tel }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if( $user->status == 2 )
                                    <span class="label label-danger">Not approved</span>
                                    @else
                                    <span class="label label-success">Active</span>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>   
                <div class="panel panel-info">
                    <div class="panel-heading">
                        App informations
                    </div>
                    <div class="panel-body">
                        @if( !$user->apps->isEmpty() )
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>App Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($user->apps as $app)
                                
                				<tr>
                					<td>{{ $app->name }}</td>
                					<td>{{ $app->status }}</td>
                				</tr>
                				
                				@endforeach
            				</tbody>
            			 </table>	
                        @endif
                    </div>
                </div>  
            @endif
        </div>
    </div>
    
@endsection


@section('footer')
    @if( isset($user) )
    <script type="text/javascript">
        function approvedUser(uid){
            $.ajax({
                url: '{{ route("admin.approved.users.process") }}',
                method: "POST",
                dataType: 'json',
                data: {
                    user_id: uid
                },
                success: function(response){
                    if( response.success ){
                        window.location.reload();
                    }else{
                        $('#msg').text(response.msg);
                    }
                }
            });
        }
    </script>
    <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="post" action="" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Confirm</h4>
                </div>
                <div class="modal-body">
                    Are you sure?
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button onclick="return approvedUser({{ $user->id }})" type="button" class="btn btn-primary">OK</button>
                    <label class="text-danger" for="" id="msg"></label>
                </div>
            </form>
        </div>
      </div>
    </div>
    
    
    @endif
@endsection

