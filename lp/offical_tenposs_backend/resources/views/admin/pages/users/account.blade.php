@extends('admin.layouts.master')

@section('main')

<aside class="right-side">
    <form id="user-form" enctype="multipart/form-data" action="{{route('admin.client.account.save')}}" method="post">
        {{ csrf_field() }}
        <div class="wrapp-breadcrumds">
            <div class="left">
              <span>アカウント設定</span>
              <strong>アカウント情報、ビジネス情報の設定が可能</strong>
            </div>
            <div class="right">
                <a href="#" id="form-submit" class="btn-2">保存</a></div>
        </div>
        <section class="content">
            <div class="col-xs-12">@include('admin.layouts.messages')</div>
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
                          <div class="col-md-4"><img class="user-avatar" src="{{ url($user->avatar) }}" alt=""></div>
                          <div class="col-md-8">
                            <div class="btn_setting_avatar">
                                <input id="input-avatar" type="file" name="avatar" class="hidden"/>
                               <a href="#" class="btn-select-avatar">アカウントイメージの変更</a>
                            </div>
                          </div>                  
                        </div>
                        <div class="form-setting">
                                <div class="form-group">
                                  <label for="">ユーザーネーム</label>
                                  <input type="text" class="form-control" id="" value="{{ Session::get('user')->name }}" name="name" placeholder="ユーザーネーム">
                                </div>
                                <div class="form-group">
                                  <label for="">パスワード</label>
                                  <input type="password" class="form-control" id="" value="" name="password" placeholder="パスワード">
                                </div>
                                <div class="form-group">
                                  <label for="">パスワード(確認)</label>
                                  <input type="password" class="form-control" id="" value="" name="password_confirmation" placeholder="パスワード(確認)">
                                </div>
                                <div class="form-group">
                                  <label for="">事業形態</label>
                                  <select name="business_form" class="form-control">
                                    <option {{ ($user->business_form == 'corporation') ? 'selected' : '' }}
                                       value="corporation">法人</option>
                                    <option {{ ($user->business_form == 'other') ? 'selected' : '' }}
                                        value="other">Other</option>

                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="">事業カテゴリー</label>
                                  <select name="business_category" class="form-control">
                                    @foreach( App\Models\BusinessCategories::all() as $cat )
                                    <option {{ ($cat->id == $user->business_category )?'selected':'' }}
                                      value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab2">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="row wrapp_avar_btn">
                          <div class="col-md-4"><img class="user-avatar" src="{{ url($user->avatar) }}" alt=""></div>
                          <div class="col-md-8">
                            <div class="btn_setting_avatar">
                              <a href="#" class="btn-select-avatar">アカウントイメージの変更</a>
                            </div>
                          </div>                  
                        </div>
                            <div class="form-setting">
                              <div class="form-group">
                                <label for="">ブランド名・店舗名</label>
                                <input name="brand_name" value="{{$user->brand_name}}" type="text" class="form-control" id="" placeholder="ブランドネーム">
                              </div>
                              <div class="form-group">
                                <label for="">カテゴリー</label>
                                <select class="form-control">
                                  <option>グルメ</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">住所</label>
                                <input name="street_address" value="{{$user->street_address}}" type="text" class="form-control" id="住所" placeholder="東京都新宿区">
                              </div>
                              <div class="form-group">
                                <label for="">電話番号</label>
                                <input type="text" class="form-control" name="tel" value="{{$user->tel}}" id="" placeholder="03-1234-5678">
                              </div>
                              <div class="form-group">
                                <label for="">営業時間(例:AM10:00~PM21:00)</label>
                                <input type="text" class="form-control" name="business_hours" value="{{$user->business_hours}}" id="" placeholder="AM10:00~PM21:00">
                              </div>
                              <div class="form-group">
                                <label for="">定休日</label>
                                <select name="regular_holiday" class="form-control">
                                  <option value="sunday">土日</option>
                                  <option value="other">Option one</option>
                                </select>
                              </div>
                            </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">コメント・紹介文</label>
                          <textarea name="testimonial" class="form-control" rows="5">{{ $user->testimonial }}</textarea>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>
            <!-- //wrapp_tab -->
        </div>
    </section>
    </form>
</aside>
<!-- /.right-side -->
@endsection    

@section('footerJS')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.user-avatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function(){
        $('#form-submit').on('click',function(e){
            e.preventDefault();
            $('form#user-form').submit();
        });
        $("#input-avatar").change(function () {
            readURL(this);
        });
        $('.btn-select-avatar').on('click',function(e){
            e.preventDefault();
            $("#input-avatar").click();
        })



    });
</script>
<style>
    .user-avatar{
        max-width: 100%;
        height: auto;
    }
</style>
@endsection