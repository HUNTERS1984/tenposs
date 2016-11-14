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
        <div class="content-cost-2">
            <div class="col-md-12">
                <div class="content-cost-2-1">
                    <div class="main-cost-2-1">
                        <ul>
                            <li>
                                <span>
                                    お客様がお店でポイントを貯めると売上の3%の請求額が発生します。(1円未満の端数が生じるときは、当該端数を四捨五入、 メニュー 切捨てとなります)
                                </span>
                            </li>
                            <li>
                                <span>
                                    お客様がポイントを使うと収益にプラスされます。(申請月の月末締めで翌月末振込です)。
                                </span>
                            </li>
                            <li>
                                <span>
                                    申請につきましては任意で、申請されない月の収益は繰越されます。
                                </span>
                            </li>
                            <li>
                                <span>また1万円以上から支払い対象となります。</span>
                            </li>
                        </ul>
                        <p>
                            ※振込手数料はお客様ご負担となります。ご了承ください。
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">月間契約</div>
                        <div class="panel-body">
                            <p>
                                1年以上の契約が条件となり、1年以上で月単位の契約を結ぶ 年単位での契約となります。最低金額は60000円/年、 プッシュ通知 ことができます。最低金額は60000円/年、5000円/月から 5000円/月からで、5000円/月を超えた際には予算設定し で、5000円/月を超えた際には予算設定した上限額内で利用 た上限額内で利用することができます。
                            </p>
                            <p class="cost-m-y">
                                ¥5,000~/month
                            </p>
                            <a href="cost-3.html" class="btn-cost-m-y">登録する</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">年間契約</div>
                        <div class="panel-body">
                            <p>
                                1年以上の契約が条件となり、1年以上で月単位の契約を結ぶ 年単位での契約となります。最低金額は60000円/年、 プッシュ通知 ことができます。最低金額は60000円/年、5000円/月から 5000円/月からで、5000円/月を超えた際には予算設定し で、5000円/月を超えた際には予算設定した上限額内で利用 た上限額内で利用することができます。
                            </p>
                            <p class="cost-m-y">
                                ¥60,000~/year
                            </p>
                            <a href="cost-3.html" class="btn-cost-m-y">登録する</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>
@endsection

@section('footerJS')
<script type="text/javascript">
  
</script>
@endsection