@extends('admin.layouts.master')

@section('main')

<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
          <span>アカウント設定</span>
          <strong>ァカウント情報、ビジネス情報の設定が可能</strong>
        </div>
        <div class="right"><a href="" class="btn-2">保存</a></div>
    </div>
    <section class="content">
        <div class="col-md-12">
            <!-- wrapp_tab -->
            <div class="wrapp_tab">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                  <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">アカウント情報</a>
                </li>
                <li role="presentation">
                  <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">ビジネス情報</a>
                </li>   
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab1">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row wrapp_avar_btn">
                          <div class="col-md-4"><img src="images/img-account.jpg" alt=""></div>
                          <div class="col-md-8">
                            <div class="btn_setting_avatar">
                              <a href="" class="">アカウントイメージの変更</a>
                            </div>
                          </div>                  
                        </div>
                        <div class="form-setting">
                                <div class="form-group">
                                  <label for="ユーザーネーム">ユーザーネーム</label>
                                  <input type="text" class="form-control" id="ユーザーネーム" placeholder="ユーザーネーム">
                                </div>
                                <div class="form-group">
                                  <label for="パスワード">パスワード</label>
                                  <input type="password" class="form-control" id="パスワード" placeholder="パスワード">
                                </div>
                                <div class="form-group">
                                  <label for="パスワード(確認)">パスワード(確認)</label>
                                  <input type="password" class="form-control" id="パスワード(確認)" placeholder="パスワード(確認)">
                                </div>
                                <div class="form-group">
                                  <label for="事業形態">事業形態</label>
                                  <select class="form-control">
                                    <option>法人</option>
                                    <option>Option one</option>
                                    <option>Option two</option>
                                    <option>Option three</option>
                                    <option>Option four</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="事業カテゴリー">事業カテゴリー</label>
                                  <select class="form-control">
                                    <option>飲食</option>
                                    <option>Option one</option>
                                    <option>Option two</option>
                                    <option>Option three</option>
                                    <option>Option four</option>
                                  </select>
                                </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab2">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row wrapp_avar_btn">
                          <div class="col-md-4"><img src="images/img-account-2.jpg" alt=""></div>
                          <div class="col-md-8">
                            <div class="btn_setting_avatar">
                              <a href="" class="">アカウントイメージの変更</a>
                            </div>
                          </div>                  
                        </div>
                            <div class="form-setting">
                              <div class="form-group">
                                <label for="ブランド名・店舗名">ブランド名・店舗名</label>
                                <input type="text" class="form-control" id="ブランドネーム" placeholder="ブランドネーム">
                              </div>
                              <div class="form-group">
                                <label for="カテゴリー">カテゴリー</label>
                                <select class="form-control">
                                  <option>グルメ</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="住所">住所</label>
                                <input type="text" class="form-control" id="住所" placeholder="東京都新宿区">
                              </div>
                              <div class="form-group">
                                <label for="電話番号">電話番号</label>
                                <input type="text" class="form-control" id="電話番号" placeholder="03-1234-5678">
                              </div>
                              <div class="form-group">
                                <label for="電話番号">営業時間(例:AM10:00~PM21:00)</label>
                                <input type="text" class="form-control" id="電話番号" placeholder="AM10:00~PM21:00">
                              </div>
                              <div class="form-group">
                                <label for="定休日">定休日</label>
                                <select class="form-control">
                                  <option>土日</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                                </select>
                              </div>
                            </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="コメント・紹介文">コメント・紹介文</label>
                          <textarea class="form-control" rows="5"></textarea>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- //wrapp_tab -->
        </div>
    </section>
</aside>
<!-- /.right-side -->
@endsection    

@section('footerJS')
    
@endsection