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
            @include('admin.partials.message')
           
            @if( $user )
                <form id="frm-approved-user" action="{{ route('admin.approved.users.process') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="wrap-btn-content">
                    @if( $user->active == 0)
                    <a href="#" data-toggle="modal" data-target="#modal-user" class="btn-me btn-hong">Approved User</a>
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
                            @if( $userInfos )
                            <tr>
                                <td>Sex</td>
                                <td>{{ $userInfos->sex }}</td>
                            </tr>
                            <tr>
                                <td>Birthday</td>
                                <td>{{ $userInfos->birthday }}</td>
                            </tr>
                            <tr>
                                <td>Locale</td>
                                <td>{{ $userInfos->locale }}</td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td>{{ $userInfos->company }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $userInfos->address }}</td>
                            </tr>
                            <tr>
                                <td>Tel</td>
                                <td>{{ $userInfos->tel }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if( $user->active == 0 )
                                    <span class="label label-danger">Not active</span>
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
                    <div class="panel-heading">Products informations</div>
                    <div class="panel-body">
                        <table class="table table-tripped">
                            <tbody>
                                @if( $userInfos )
                                <tr>
                                    <td>Business_type</td>
                                    <td>{{ $userInfos->business_type }}</td>
                                </tr>
                                <tr>
                                    <td>App name register</td>
                                    <td>{{ $userInfos->app_name_register }}</td>
                                </tr>
                                <tr>
                                    <td>Domain</td>
                                    <td>{{ $userInfos->domain }}</td>
                                </tr>
                                <tr>
                                    <td>Domain type</td>
                                    <td>{{ $userInfos->domain_type }}</td>
                                </tr>
                                <tr>
                                    <td>Shop info</td>
                                    <td>{{ $userInfos->shop_url }}</td>
                                </tr>
                                @else
                                 <tr>
                                    <td colspan="2">Null</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>   
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        App informations
                    </div>
                    <div class="panel-body">
                        @if( $apps )
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>App Name</th>
                                    <th>Status</th>
                                    <th>Functions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($apps as $app)
                                
                				<tr>
                					<td>{{ $app->name }}</td>
                					<td>{{ $app->status }}</td>
                					<td>
                					    <a href="{{route('admin.clients.apps.delete',['user_id'=>$user->id,'app_id' => $app->id])}}">
                					        <i class="fa fa-remove"></i> Remove</a>
                						<br />
                						<a href="{{route('admin.clients.apps.setting',['user_id'=>$user->id,'app_id' => $app->id])}}">
                						    <i class="fa fa-cog"></i> AppSetting</a><br />
                                        <a href="{{route('admin.clients.bot.setting',['user_id'=>$user->id,'app_id' => $app->id])}}">
                                            <i class="fa fa-cog"></i> LINE BOT Setting</a>
                					</td>
                				</tr>
                				
                				@endforeach
            				</tbody>
            			 </table>	
                        @endif
                        @if( $user->active != 0)
                        <a href="{{ route('admin.clients.apps.create',['user_id' => $user->id ]) }}" class="btn-me btn-hong">Add App</a>
                        @endif
                    </div>
                </div>
                </form>

            @endif
        </div>
    </div>
    
@endsection


@section('footer')
    @if( isset($user) )
    <script type="text/javascript">
        function approvedUser(){
            $('#frm-approved-user').submit();
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
                    <button onclick="return approvedUser()" type="button" class="btn btn-primary">OK</button>
                </div>
            </form>
        </div>
      </div>
    </div>
    @endif
@endsection

