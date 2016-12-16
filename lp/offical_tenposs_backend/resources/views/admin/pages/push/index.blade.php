@extends('admin.layouts.master')

@section('main')
    <aside class="right-side">
        <div class="wrapp-breadcrumds">
            <div class="left">
                <span>プッシュ通知</span>
                <strong>プッシュ通知の登録・編集が可能</strong>
            </div>
            <div class="left">
                <div class="tab-header-push">
                    <ul class="nav nav-tabs" role="tablist">
                        @if($type == 'A')
                            <li role="presentation" class="active">
                        @else
                            <li role="presentation">
                                @endif
                                <a href="{{route('admin.push.index',array('type'=>'A'))}}" aria-controls="tab-push-1"
                                   role="tab">全て</a>
                            </li>
                            @if($type == 'T')
                                <li role="presentation" class="active">
                            @else
                                <li role="presentation">
                                    @endif
                                    <a href="{{route('admin.push.index',array('type'=>'T'))}}"
                                       aria-controls="tab-push-1"
                                       role="tab">予約中</a>
                                </li>
                                @if($type == 'R')
                                    <li role="presentation" class="active">
                                @else
                                    <li role="presentation">
                                        @endif
                                        <a href="{{route('admin.push.index',array('type'=>'R'))}}"
                                           aria-controls="tab-push-3"
                                           role="tab">定期配信</a>
                                    </li>
                                    @if($type == 'D')
                                        <li role="presentation" class="active">
                                    @else
                                        <li role="presentation">
                                            @endif
                                            <a href="{{route('admin.push.index',array('type'=>'D'))}}"
                                               aria-controls="tab-push-4"
                                               role="tab">配信済み</a>
                                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="col-md-12">
                <div class="main-search-btn">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="wrapp_search_btn">
                                <form class="form-group" href="{{route('admin.push.index',array('type'=>$type))}}"
                                      method="post">
                                    <input type="text" class="form-control has-feedback-left" id="search_value"
                                           name="search_value"
                                           placeholder="タイトルを入力してください" value="{{$search_value}}">
                                    <span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>

                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal_push" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="images/check_push.png" alt="">
                                        <p>プッシュ通知を送信しました</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- drop push -->
                        <div class="col-md-12" id="idcollapsed">
                            <a id="idAcollapsed" class="arrow_down collapsed" role="button" data-toggle="collapse"
                               href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <span>新しくプッシュ通知を配信</span>
                            </a>
                            <div class="collapse" id="collapseExample">
                                <div class="down_con">
                                    {{Form::open(array('route'=>'admin.push.store','files'=>true))}}
                                    <input type="hidden" name="push_id" value="">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="タイトル">タイトル</label>
                                            <input type="text" name="title" class="form-control" id="タイトルを入力してください"
                                                   placeholder="タイトルを入力してください">
                                        </div>
                                        <div class="form-group">
                                            <label for="メッセージ">メッセージ</label>
                                            <textarea name="message" class="form-control" rows="5" placeholder="メッセージ文を入力してください (○文字以内)"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="配信先のセグメント">配信先のセグメント</label>
                                            <select name="app_user_id" class="form-control">
                                            <option>お店から1キロ以内のユーザー</option>
                                            @if(count($app_user) > 0)
                                            @foreach($app_user as $item)
                                            <option value="{{$item->id}}">{{$item->profile->name}}</option>
                                            @endforeach

                                            @endif
                                            </select>
                                            <!-- {{Form::select('app_user_id',$app_user->pluck('email', 'id'),old('app_user_id'),['class'=>'form-control'])}} -->

                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<a href="" class="link_create"><i class="fa fa-plus" aria-hidden="true"></i> セグメントを作成する</a>--}}
                                        {{--</div>--}}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="配信時間指定">配信時間指定</label>
                                                    <select id="time_type" name="time_type" class="form-control">
                                                        <option>時間を指定して配信</option>
                                                        <option value="1">今</option>
                                                        <option value="2">定期配信</option>
                                                        <option value="3">意図されました</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="time_config">
                                                <div class="col-md-12 col-xs-6">
                                                    <div class="form-group">
                                                        <input class="form-control" name="time_count_repeat"
                                                               type="number" placeholder="繰り返し数">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <div class="form-group">
                                                        <select name="time_detail_year" class="form-control">
                                                            @for ($i = 2016; $i < 2023; $i++)
                                                                <option value="{{$i}}">{{$i}}年</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <div class="form-group">
                                                        <select name="time_detail_month" class="form-control">
                                                            @for ($i = 1; $i < 13; $i++)
                                                                @if($i < 10)
                                                                    <option value="0{{$i}}">{{$i}}月</option>
                                                                @else
                                                                    <option value="{{$i}}">{{$i}}月</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <div class="form-group">
                                                        <select name="time_detail_day" class="form-control">
                                                            @for ($i = 1; $i < 32; $i++)
                                                                @if($i < 10)
                                                                    <option value="0{{$i}}">{{$i}}日</option>
                                                                @else
                                                                    <option value="{{$i}}">{{$i}}日</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <div class="form-group">
                                                        <select name="time_detail_type" class="form-control">
                                                            <option value="am">午前</option>
                                                            <option value="pm">午後</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <div class="form-group">
                                                        <select name="time_detail_hours" class="form-control">
                                                            @for ($i = 0; $i < 13; $i++)
                                                                @if($i < 10)
                                                                    <option value="0{{$i}}">{{$i}}時</option>
                                                                @else
                                                                    <option value="{{$i}}">{{$i}}時</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-6">
                                                    <div class="form-group">
                                                        <select name="time_detail_minutes" class="form-control">
                                                            @for ($i = 0; $i < 61; $i++)
                                                                @if($i < 10)
                                                                    <option value="0{{$i}}">{{$i}}分</option>
                                                                @else
                                                                    <option value="{{$i}}">{{$i}}分</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="button_send">
                                            <button id="btnSubmit" type="button" class="btn btn-primary btn-send">
                                                このプッシュ通知を配信
                                            </button>
                                            {{--{{Form::submit('保存',['class'=>'btn btn-primary btn-send'])}}--}}
                                        </div>
                                    </div>
                                    {{Form::close()}}
                                </div>
                            </div>
                        </div>
                        <!-- //drop push -->
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab-push-1">
                        <!-- wrapp_push -->
                        <div class="wrapp_push">
                            <div class="row">
                                @if(count($list_notification) > 0)
                                    @foreach($list_notification as $item)
                                        <div class="col-md-12">
                                            <div class="content_push">
                                                <div class="top_push">
                                                    <div class="left_push">
                                                        <h2>{{$item->title}}</h2>
                                                        <div class="des_deliver">
                                                            <span class="des_push">{{$item->title}}</span>
                                                            @if($item->time_type == 1)
                                                                <span class="deliver_push">今</span>
                                                            @elseif($item->time_type == 2)
                                                                <span class="deliver_push">定期配信</span>
                                                            @elseif($item->time_type == 3)
                                                            <span class="deliver_push">意図されました</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="javascript:void(0);" onclick="clickEditPush({{$item->id}})"
                                                       class="link_blue">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </div>
                                                <div class="bottom_push">
                                                    <p>
                                                        {{$item->message}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- wrapp_push -->
                        @if(count($list_notification) > 0)
                            <div class="page-bottom">
                                {{ $list_notification->appends(['type' => $type,'search_value'=>$search_value])->render() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </aside>
    <!-- /.right-side -->
@endsection

@section('footerJS')
    {{Html::script('admin/js/push.js')}}
@endsection