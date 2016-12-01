@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>お問い合わせ</span>
            <strong>ポイントやコストの管理が可能</strong>
        </div>
        <div class="right">
            <a href="" class="btn-cost-bre">収益の支払い申請</a>
        </div>
    </div>
    <section class="content">

        <div class="col-md-12">
            <div class="row">
                <div class="tab-header-cost">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#tab-cost-1" aria-controls="tab-cost-1" role="tab" data-toggle="tab">プラン</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#tab-cost-2" aria-controls="tab-cost-2" role="tab" data-toggle="tab">ポイント設定</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#tab-cost-3" aria-controls="tab-cost-3" role="tab" data-toggle="tab">决滴方法</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="tab-cost-1">
                <div class="content-cost-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">月間契約(1年4ヶ月)</div>
                        <div class="panel-body">

                            <ol class="timeline_cost">
                                <li class="timeline__step">
                                    <span class="timeline__step-title-top">契約開始了月</span>
                                    <input class="timeline__step-radio" id="" name="" type="radio">        
                                    <span class="timeline__step-title-bottom">{{$start_month}}</span>
                                    <i class="timeline__step-marker"></i>
                                </li>
                                <li class="timeline__step done">
                                    <span class="timeline__step-title-top">今月</span>
                                    <input class="timeline__step-radio" id="" name="" type="radio">   
                                    <span class="timeline__step-title-bottom">{{date("Y.m")}}</span>
                                    <i class="timeline__step-marker"></i>
                                </li>
                                <li class="timeline__step">
                                    <span class="timeline__step-title-top">契約終了月</span>
                                    <input class="timeline__step-radio" id="" name="" type="radio">
                                    <span class="timeline__step-title-bottom">{{$end_month}}</span>
                                    <i class="timeline__step-marker"></i>
                                </li>
                            </ol>

                            <div class="content-cost-3-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="content-cost-3-2-1">
                                            <p class="title-cost-3-2-1-blue">現在のコスト</p>
                                            <p class="yen-cost-3-2-1-blue">{{"¥".number_format(200*25*$member_months, 0, '', ',')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="content-cost-3-2-1">
                                            <p class="title-cost-3-2-1-yellow">現在の収益</p>
                                            <p class="yen-cost-3-2-1-yellow">¥24,837</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="content-cost-3-2-1">
                                            <p class="title-cost-3-2-1-blue">現状のポイント</p>
                                            <p class="yen-cost-3-2-1-blue">200p</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="content-cost-3-2-1">
                                            <p class="title-cost-3-2-1-black">上限予算/月</p>
                                            <p class="yen-cost-3-2-1-black">¥15,000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="content-cost-3-1">
                        <ul>
                            <li>
                                <span>お客様がお店でポイントを貯めると売上の3%の請求額が発生します。</span>
                            </li>
                            <li>
                                <span>お客様がポイントを使うと収益にプラスされます。(申請月の月末締めで翌月末振込です)。</span>
                            </li>
                            <li>
                                <span>申請につきましては任意で、申請されない月の収益は繰越されます。</span>
                            </li>
                            <li>
                                <span>また1万円以上から支払い対象となります。</span>
                            </li>
                        </ul>
                        <p>
                            ※振込手数料はお客様ご負担となります。ご了承ください。
                        </p>
                    </div>
                    <div class="link-cost-tab-1">
                        <a href="cost-4.html">
                            年間契約に切り替える方、契約解除される方はこちら
                        </a>
                    </div>
                </div>
            </div>
            <!-- //tab cost 1 -->

            <div role="tabpanel" class="tab-pane" id="tab-cost-2">
                <div class="content-cost-tab-3">
                    <form action="" class="form-cost-tab-3">
                        <div class="form-group">                                    
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>付与金額(1マイルあたり)</label>
                                </div>
                                <div class="col-xs-10">
                                    <select name="" id="" class="form-control">
                                        <option value="1">1円</option>
                                        <option value="2">2円</option>
                                        <option value="3">3円</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="">利用可能金額(利用可能なマイル数)</label>
                                </div>
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" id="" placeholder="デフォルトでは10,000">
                                </div>
                                <label for="" class="col-xs-2 control-label text-left">マイル</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">会員ステージ設定</label>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="" class="col-xs-3 control-label text-left-first">紹介:</label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                    <label for="" class="col-xs-2 control-label text-left">マイル</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-3 control-label text-left-first">来店:</label>
                                    <div class="col-xs-7">
                                    <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                    <label for="" class="col-xs-2 control-label text-left">マイル</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">会員ステージ設定</label>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="" class="col-xs-3 control-label text-left-first">シルバー会員:</label>
                                    <div class="col-xs-7">
                                        <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                    <label for="" class="col-xs-2 control-label text-left">マイル以上</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-3 control-label text-left-first">ゴールド会員:</label>
                                    <div class="col-xs-7">
                                    <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                    <label for="" class="col-xs-2 control-label text-left">マイル以上</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-3 control-label text-left-first">プラチナ会員:</label>
                                    <div class="col-xs-7">
                                    <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                    <label for="" class="col-xs-2 control-label text-left">マイル以上</label>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-xs-3 control-label text-left-first">ダイアモンド会員:</label>
                                    <div class="col-xs-7">
                                    <input type="text" class="form-control" id="" placeholder="">
                                    </div>
                                    <label for="" class="col-xs-2 control-label text-left">マイル以上</label>
                                </div>
                            </div>
                        </div>
                        <center>
                            <button type="submit" class="btn-cost-tab-3">保存</button>
                        </center>
                    </form>
                </div>
            </div>
            <!-- //tab cost 2 -->

            <div role="tabpanel" class="tab-pane" id="tab-cost-3">
                <div class="content-cost-tab-4">
                    

                    <ul class="nav-cost-4">
                        <li>
                            <label class="control control--radio">Paypal
                              <input type="radio" name="radio" checked="checked">
                              <div class="control__indicator"></div>
                            </label>
                        </li>
                        <li>
                            <label class="control control--radio">銀行口座振り込み
                              <input type="radio" name="radio">
                              <div class="control__indicator"></div>
                            </label>
                        </li>
                    </ul>
                    <center>
                        <a href="{{ route('admin.cost.register') }}" class="btn-cos-tab-4">支払い申請</a>
                    </center>
                </div>
            </div>
            <!-- //tab cost 3 -->

        </div>

    </section>
</aside>
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn_approve').click(function () {
            $.ajax({
                type: "POST",
                url: "/admin/coupon/approve",
                data: {data: approve_list}
            }).done(function (data) {
                location.reload();
            });

        });
    })
</script>
@endsection