@extends('admin.master')

@section('content')
    <div class="topbar-content">
        <div class="wrap-topbar clearfix">
            <div class="left-topbar">
                <h1 class="title">Clients/Apps/Setting</h1>
            </div>
        </div>
    </div>
    <!-- END -->

    <div class="main-content">
        @include('admin.partials.message')
        <div class="wrap-btn-content">
            {{--<a href="{{ route('admin.clients.apps.create',['user_id' => $user_id]) }}" class="btn-me btn-hong">Create--}}
            {{--App</a>--}}
            <a href="{{ route('admin.clients.show',['user_id' => $user_id]) }}"
               class="btn-me btn-xanhduongnhat">Back</a>
        </div>    <!-- end wrap-btn-content-->
        <div class="wrapper-content">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="80%">Platform App User</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td><img src="{{ url('adcp/images/ios.png') }}"/> Apple iOS</td>
                    <td style="text-align: center;vertical-align: middle;">
                        @if($ios_status == 1)
                            <span class="glyphicon glyphicon-ok"
                                  aria-hidden="true"
                                  style="color: blue;"></span></td>
                    @endif


                    <td>
                    {{--<a href="{{route('admin.clients.apps.edit',['user_id'=>$user_id,'app_id' => $app->id])}}">Configure</a>--}}
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ios">
                            configure
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><img src="{{ url('adcp/images/android.png') }}"/>Google Android</td>
                    <td style="text-align: center;vertical-align: middle;">
                        @if($android_status == 1)
                            <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: blue;"></span></td>
                    @endif
                    <td>
                    {{--<a href="{{route('admin.clients.apps.edit',['user_id'=>$user_id,'app_id' => $app->id])}}">Configure</a>--}}
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#google">
                            configure
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><img src="{{ url('adcp/images/web.png') }}"/>Google Chrome and Mozilla Firefox</td>
                    <td style="text-align: center;vertical-align: middle;">
                        @if($web_status == 1)
                            <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: blue;"></span></td>
                    @endif
                    <td>
                    {{--<a href="{{route('admin.clients.apps.edit',['user_id'=>$user_id,'app_id' => $app->id])}}">Configure</a>--}}
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#web">
                            configure
                        </button>
                    </td>
                </tr>


                <tr>
                    <th width="80%" colspan="3">Platform App Staff</th>

                </tr>


                <tr>
                    <td><img src="{{ url('adcp/images/ios.png') }}"/> Apple iOS</td>
                    <td style="text-align: center;vertical-align: middle;">
                        @if($staff_ios_status == 1)
                            <span class="glyphicon glyphicon-ok"
                                  aria-hidden="true"
                                  style="color: blue;"></span></td>
                    @endif


                    <td>
                    {{--<a href="{{route('admin.clients.apps.edit',['user_id'=>$user_id,'app_id' => $app->id])}}">Configure</a>--}}
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ios_staff">
                            configure
                        </button>
                    </td>
                </tr>
                <tr>
                    <td><img src="{{ url('adcp/images/android.png') }}"/>Google Android</td>
                    <td style="text-align: center;vertical-align: middle;">
                        @if($staff_android_status == 1)
                            <span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: blue;"></span></td>
                    @endif
                    <td>
                    {{--<a href="{{route('admin.clients.apps.edit',['user_id'=>$user_id,'app_id' => $app->id])}}">Configure</a>--}}
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#google_staff">
                            configure
                        </button>
                    </td>
                </tr>
                <tr>
                    <th width="80%" colspan="3">Other Platform</th>

                </tr>
                <tr>
                    <td><img src="{{ url('adcp/images/ga-icon.png') }}"/> Google Analytics</td>
                    <td style="text-align: center;vertical-align: middle;">
                        @if($ga_status == 1)
                            <span class="glyphicon glyphicon-ok"
                                  aria-hidden="true"
                                  style="color: blue;"></span></td>
                    @endif
                    <td>
                    {{--<a href="{{route('admin.clients.apps.edit',['user_id'=>$user_id,'app_id' => $app->id])}}">Configure</a>--}}
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" id="1" data-toggle="modal"
                                data-target="#ga">
                            configure
                        </button>
                       </td>
                </tr>
                </tbody>

            </table>
        </div>    <!-- wrap-content-->
    </div>
    <!-- END -->

    </div>


@endsection


@section('footer')
    <!-- Modal google-->
    <div class="modal fade" id="google" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="post" enctype="multipart/form-data"
              action="{{ route('admin.clients.apps.upload',['user_id' => $user_id,'app_id' => $app_id]) }}">
            <input type="hidden" value="{{ csrf_token() }}"/>
            <input type="hidden" name="flatform" value="android">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Configure Platform</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="title">Firebase Cloud Messaging (FCM) Configuration</h4>
                        <hr>
                        <h4>Genarate Firebase Cloud Message</h4>
                        <div class="well"
                             style="cursor: pointer; border: 1px solid #00acc1; padding: 10px; border-left: 3px solid #00acc1; background: transparent">
                            <a target="_blank" href="https://firebase.google.com/docs/cloud-messaging/">
                                Read the documentation to learn how to fill in the fields below
                            </a>
                        </div>

                        <h4 class="title" style="margin-top: 20px;">Create Firebase Cloud Messaging</h4>
                        <hr>
                        <p style="padding-left: 20px;">
                            Config file FCM<br>
                        <div class="form-group">
                            <input type="file" id="file" name="file"
                                   style="background: #eee; width: 100%; padding: 10px; outline: 0;">
                        </div>
                        </p>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">FCM server key</label>
                            <input type="text" class="form-control" id="apikey" name="apikey" placeholder="Server keys"
                                   value="{{$data['android_push_api_key']}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal ios-->
    <div class="modal fade" id="ios" tabindex="-1" role="dialog" aria-labelledby="myModalLabelIos">
        <form method="post" enctype="multipart/form-data"
              action="{{ route('admin.clients.apps.upload',['user_id' => $user_id,'app_id' => $app_id]) }}">
            <input type="hidden" value="{{ csrf_token() }}"/>
            <input type="hidden" name="flatform" value="ios">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Configure Platform</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="title">Apple iOS (APNS) Configuration</h4>
                        <hr>
                        <h4>Generate an iOS Push Certificate</h4>
                        <div class="well"
                             style="cursor: pointer; border: 1px solid #00acc1; padding: 10px; border-left: 3px solid #00acc1; background: transparent">
                            <a target="_blank"
                               href="https://developer.apple.com/library/mac/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/ApplePushService.html">
                                Read the documentation to learn how to fill in the fields below
                            </a>
                        </div>
                        <p>We recommend uploading only a production certificate</p>
                        <h4 class="title" style="margin-top: 20px;">Product Push Certificate</h4>
                        <hr>
                        <p style="padding-left: 20px;">
                            Production Certificate .p12 file<br>
                        <div class="form-group">
                            <input type="file" id="file" name="file"
                                   style="background: #eee; width: 100%; padding: 10px; outline: 0;">
                        </div>
                        </p>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">Password Certificate</label>
                            <input type="text" class="form-control" id="apikey" name="apikey" placeholder="Password"
                                   value="{{$data['apple_push_cer_password']}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal web-->
    <div class="modal fade" id="web" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="post" enctype="multipart/form-data"
              action="{{ route('admin.clients.apps.upload',['user_id' => $user_id,'app_id' => $app_id]) }}">
            <input type="hidden" value="{{ csrf_token() }}"/>
            <input type="hidden" name="flatform" value="web">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Configure Platform</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="title">Firebase Cloud Messaging (FCM) Configuration</h4>
                        <hr>
                        <h4>Genarate Firebase Cloud Message</h4>
                        <div class="well"
                             style="cursor: pointer; border: 1px solid #00acc1; padding: 10px; border-left: 3px solid #00acc1; background: transparent">
                            <a target="_blank" href="https://firebase.google.com/docs/cloud-messaging/">
                                Read the documentation to learn how to fill in the fields below
                            </a>
                        </div>

                        <h4 class="title" style="margin-top: 20px;">Create Firebase Cloud Messaging</h4>
                        <hr>
                        <p style="padding-left: 20px;">
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">FCM server key</label>
                            <input type="text" class="form-control" id="apikey" name="apikey" placeholder="Server keys"
                                   value="{{$data['web_push_server_key']}}">
                        </div>
                        </p>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">Sender ID</label>
                            <input type="text" class="form-control" id="senderid" name="senderid"
                                   placeholder="Sender ID" value="{{$data['web_push_sender_id']}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal google staff-->
    <div class="modal fade" id="google_staff" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="post" enctype="multipart/form-data"
              action="{{ route('admin.clients.apps.upload',['user_id' => $user_id,'app_id' => $app_id]) }}">
            <input type="hidden" value="{{ csrf_token() }}"/>
            <input type="hidden" name="flatform" value="android_staff">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Configure Platform</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="title">Firebase Cloud Messaging (FCM) Configuration</h4>
                        <hr>
                        <h4>Genarate Firebase Cloud Message</h4>
                        <div class="well"
                             style="cursor: pointer; border: 1px solid #00acc1; padding: 10px; border-left: 3px solid #00acc1; background: transparent">
                            <a target="_blank" href="https://firebase.google.com/docs/cloud-messaging/">
                                Read the documentation to learn how to fill in the fields below
                            </a>
                        </div>

                        <h4 class="title" style="margin-top: 20px;">Create Firebase Cloud Messaging</h4>
                        <hr>
                        <p style="padding-left: 20px;">
                            Config file FCM<br>
                        <div class="form-group">
                            <input type="file" id="file" name="file"
                                   style="background: #eee; width: 100%; padding: 10px; outline: 0;">
                        </div>
                        </p>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">FCM server key</label>
                            <input type="text" class="form-control" id="apikey" name="apikey" placeholder="Server keys"
                                   value="{{$data['staff_android_push_api_key']}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal ios staff-->
    <div class="modal fade" id="ios_staff" tabindex="-1" role="dialog" aria-labelledby="myModalLabelIos">
        <form method="post" enctype="multipart/form-data"
              action="{{ route('admin.clients.apps.upload',['user_id' => $user_id,'app_id' => $app_id]) }}">
            <input type="hidden" value="{{ csrf_token() }}"/>
            <input type="hidden" name="flatform" value="ios_staff">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Configure Platform</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="title">Apple iOS (APNS) Configuration</h4>
                        <hr>
                        <h4>Generate an iOS Push Certificate</h4>
                        <div class="well"
                             style="cursor: pointer; border: 1px solid #00acc1; padding: 10px; border-left: 3px solid #00acc1; background: transparent">
                            <a target="_blank"
                               href="https://developer.apple.com/library/mac/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/ApplePushService.html">
                                Read the documentation to learn how to fill in the fields below
                            </a>
                        </div>
                        <p>We recommend uploading only a production certificate</p>
                        <h4 class="title" style="margin-top: 20px;">Product Push Certificate</h4>
                        <hr>
                        <p style="padding-left: 20px;">
                            Production Certificate .p12 file<br>
                        <div class="form-group">
                            <input type="file" id="file" name="file"
                                   style="background: #eee; width: 100%; padding: 10px; outline: 0;">
                        </div>
                        </p>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">Password Certificate</label>
                            <input type="text" class="form-control" id="apikey" name="apikey" placeholder="Password"
                                   value="{{$data['staff_apple_push_cer_password']}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Model Google analytics -->
    <div class="modal fade" id="ga" tabindex="-1" role="dialog" aria-labelledby="myModalLabelIos">
        <form method="post" enctype="multipart/form-data"
              action="{{ route('admin.clients.apps.upload',['user_id' => $user_id,'app_id' => $app_id]) }}">
            <input type="hidden" value="{{ csrf_token() }}"/>
            <input type="hidden" name="flatform" value="ga">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Configure Platform</h4>
                    </div>
                    <div class="modal-body">
                        <h4 class="title">Google Analytics Report Configuration</h4>
                        <hr>
                        <h4>Generate an json credentials for service account get data</h4>
                        <div class="well"
                             style="cursor: pointer; border: 1px solid #00acc1; padding: 10px; border-left: 3px solid #00acc1; background: transparent">
                            <a target="_blank"
                               href="https://developers.google.com/analytics/devguides/reporting/core/v3/quickstart/service-php#clientId">
                                Read the documentation to learn how to fill in the fields below
                            </a>
                        </div>
                        <p>We recommend json credentials file</p>
                        <hr>
                        <p style="padding-left: 20px;">
                            service-account-credentials.json;<br>
                        <div class="form-group">
                            <input type="file" id="file" name="file"
                                   style="background: #eee; width: 100%; padding: 10px; outline: 0;">
                        </div>
                        </p>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">Mobile GA ID</label>
                            <input type="text" class="form-control" id="mobile_ga_id" name="mobile_ga_id" placeholder="Mobile"
                                   value="{{$mobile_ga_id}}">
                        </div>
                        <div class="form-group">
                            <label for="apikey" style="font-weight: normal">Web GA ID</label>
                            <input type="text" class="form-control" id="web_ga_id" name="web_ga_id" placeholder="Website"
                                   value="{{$web_ga_id}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
