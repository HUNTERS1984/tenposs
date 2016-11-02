@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>グローバル</span></div>
        <div class="right"><a href="" class="btn-2">ポ覧</a></div>
    </div>
    <section class="content">
        <div class="col-md-12">
            <div class="tab-header-global">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <a href="#tab-global-1" aria-controls="tab-global-1" role="tab" data-toggle="tab">ヘッダー</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-global-2" aria-controls="tab-global-2" role="tab" data-toggle="tab">サイトメニュー</a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#tab-global-3" aria-controls="tab-global-3" role="tab" data-toggle="tab">Appストア</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane" id="tab-global-1">
                <div class="col-md-4">
                    <div class="wrapp-phone">
                        <center>
                            <img src="images/phone.jpg" class="img-responsive" alt="">
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                    <form class="form-global-1">
                        <div class="form-group">
                            <label>タイトル</label>
                            <input type="text" class="form-control middle" id="" placeholder="タイトル">
                        </div>
                        <div class="form-group">
                            <label>タイトルカラー</label>
                            <div class="wrapp-draw">
                                <input type="text" class="form-control supper-short" id="" placeholder="000000">
                                <img src="images/draw.jpg" class="left" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントタイプ・フォントファミリ</label>
                            <div class="two-select">
                                <select name="" id="" class="form-control short-1">
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                </select>
                                <select name="" id="" class="form-control short-2">
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ヘッダーカラー</label>
                            <div class="wrapp-draw">
                                <input type="text" class="form-control supper-short" id="" placeholder="000000">
                                <img src="images/draw.jpg" class="left" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>メニューイコンカラー</label>
                            <div class="wrapp-draw">
                                <input type="text" class="form-control supper-short" id="" placeholder="000000">
                                <img src="images/draw.jpg" class="left" alt="">
                            </div>
                        </div>
                    </form>                            
                </div>
            </div>
            <!-- //tab-global-1 -->

            <div role="tabpanel" class="tab-pane" id="tab-global-2">
                <div class="col-md-4">
                    <div class="wrapp-phone">
                        <center>
                            <img src="images/phone.jpg" class="img-responsive" alt="">
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                    <form class="form-global-1">
                        <div class="form-group">
                            <label>バックグラウンドカラー</label>
                            <div class="wrapp-draw">
                                <input type="text" class="form-control supper-short" id="" placeholder="000000">
                                <img src="images/draw.jpg" class="left" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントカラー</label>
                            <div class="wrapp-draw">
                                <input type="text" class="form-control supper-short" id="" placeholder="000000">
                                <img src="images/draw.jpg" class="left" alt="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントタイプ・フォントファミリ</label>
                            <div class="two-select">
                                <select name="" id="" class="form-control short-1">
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                </select>
                                <select name="" id="" class="form-control short-2">
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group arrow-select">
                            <label>サイトメニュー項目</label>
                            <div class="wrapp-arrow-select">
                                <div class="wrap-table-top">
                                    <div class="wrap-transfer col">
                                        <p class="title-form">表示</p>
                                        <ul class="link-top-2">
                                            <li><a href="" class="active">Home</a></li>
                                            <li><a href="">Home</a></li>
                                            <li><a href="">Home</a></li>
                                            <li><a href="">Home</a></li>
                                        </ul>
                                    </div>
                                    <div class="wrap-btn-control col">
                                        <a href="">
                                            <span class="fa fa-caret-right"></span>
                                        </a>
                                        <a href="">
                                            <span class="fa fa-caret-left"></span>
                                        </a>
                                    </div>
                                    <div class="wrap-transfer col">
                                        <p class="title-form">非表示</p>
                                        <ul class="link-top-2">
                                            <li><a href="">Home</a></li>
                                            <li><a href="">Home</a></li>
                                            <li><a href="">Home</a></li>
                                            <li><a href="">Home</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>                              
                </div>
            </div>
            <!-- //tab-global-2 -->

            <div role="tabpanel" class="tab-pane active" id="tab-global-3">
                <div class="wrapp-global-redesign">
                    <div class="col-md-4">
                        <div class="content-global-redesign">
                            <div class="title-global-redesign">オンライン</div>
                            <div class="img-global-redesign">
                                <center>
                                    <img src="images/phone.jpg" class="img-responsive" alt="">
                                </center>
                            </div>
                            <div class="btn-global-redesign">
                                <a href="" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn-gb-rd">
                                    顧客管理
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="content-global-redesign">
                            <div class="title-global-redesign">フォトギャラリー</div>
                            <div class="img-global-redesign">
                                <center>
                                    <img src="images/phone.jpg" class="img-responsive" alt="">
                                </center>
                            </div>
                            <div class="btn-global-redesign">
                                <a href="" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn-gb-rd">
                                    顧客管理
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //tab-global-3 -->

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-global-redesign-2" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">フォトギャラリー</h4>
                        </div>

                        <div class="modal-body">
                            <div class="tab-header-gb">
                                <ul class="nav nav-tabs tabs-center">
                                    <li class="active">
                                        <a href="#tab-gb-re-1" aria-controls="tab-gb-re-1" role="tab" data-toggle="tab">
                                            フォトギャラリー
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab-gb-re-2" data-toggle="tab">アカウント設定</a>
                                    </li>
                                </ul>   
                            </div>                   

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tab-gb-re-1">
                                   <div class="wrapp-form-tab-gb-1">
                                       <form>
                                            <label>フォントタイプ・フォントファミリ</label>
                                            <div class="content-tab-3-select-2">
                                                <label for="">1 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">2 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">3 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">4 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">5 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>  
                                            <div class="btn-tab-gb-1">
                                                <a href="">オンライン</a> 
                                            </div>              
                                        </form>
                                   </div>
                                </div>
                                
                                <div role="tabpanel" class="tab-pane" id="tab-gb-re-2">
                                    <div class="wrapp-form-tab-gb-2">
                                        <p>説明が入ります説明が入りまます説明</p>
                                        <p>
                                            が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入り
                                        </p>    
                                        <a href="">顧客管理</a>            
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
              </div>
            </div>
            <!-- //modal -->

        <div>
    </section>
</aside>
@endsection
