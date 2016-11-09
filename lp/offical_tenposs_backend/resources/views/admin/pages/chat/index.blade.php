@extends('admin.layouts.master')

@section('main')

 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>顧客管理</span><span class="circle-bre">19</span></div>
    </div>
    <section class="content">
        <div class="wrapp-user-chat">
            <div class="left-user-chat">
                    <div class="wrapp_search_user_chat">
                        <form class="form-horizontal">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="ユーザーネ">
                                <a href="" class="input-group-addon">
                                    <img src="images/search.png" alt="">
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="list-user" data-ss-container>
                        <ul class="nav-list-user" ></ul>
                    </div>
            </div>
            <div class="right-user-chat">
                <div class="wrapp-thumb-user-chat">
                    <div class="img-thumb-user-chat">
                        <img src="images/user-chat.png" alt="">
                    </div>
                    <div class="title-thumb-user-chat">
                        <span>ユーザーネーム</span>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="log-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog user-poup-log" role="document">
                        <div class="modal-content">
                            <h4>アカウント設定?</h4>
                            <div class="col-md-6 col-xs-6">
                                <a href="" class="btn-user-poup-log-poup-left">表示項</a>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <a href="" class="btn-user-poup-log-poup-right">表示項</a>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="dropdown drop-user-top">
                        <a href="" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-cog"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li>
                                <a href="" data-toggle="modal" data-target="#log-user">
                                    ムまでお問何かお困りです
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-middle-user">
                    <div class="con-scroll-right" data-ss-container>
                        <div class="chat-body">
                            <div class="answer right">
                                <div class="text">
                                    までお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer right">
                                <div class="text">
                                    何かお困りですか?詳しくはサポートチームまでお問何かお困りですか?詳しくはサポートチームまでお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer right">
                                <div class="text">
                                    何かお困りですか?詳しくはサポーせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer left">
                                <div class="avatar">
                                    <img src="images/user-chat.png" alt="">
                                </div>
                                <div class="text">
                                    までお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer left">
                                <div class="avatar">
                                    <img src="images/user-chat.png" alt="">
                                </div>
                                <div class="text">
                                    何かお困りですか?詳しくはサポ困りですか?詳しくはサポートチームまでお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer left">
                                <div class="avatar">
                                    <img src="images/user-chat.png" alt="">
                                </div>
                                <div class="text">
                                    かお困りですか?詳しくはサポートチームまでお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer left">
                                <div class="avatar">
                                    <img src="images/user-chat.png" alt="">
                                </div>
                                <div class="text">
                                    ムまでお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                            <div class="answer left">
                                <div class="avatar">
                                    <img src="images/user-chat.png" alt="">
                                </div>
                                <div class="text">
                                    何かお困りですか?詳しくはサポートチームまでお問何かお困りですか?詳しくはサポートチームまでお問い合わせ下さい。
                                </div>
                                <div class="time"><span>2:03 PM</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-text-user">
                    <form class="form-add-text">
                        <div class="row">
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="" placeholder="">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">ポ覧</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</aside>
<!-- /.right-side -->
@endsection

