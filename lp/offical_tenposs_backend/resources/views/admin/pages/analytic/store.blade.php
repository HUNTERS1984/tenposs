@extends('admin.layouts.master')

@section('main')
    <link href="{{ url('admin/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <aside class="right-side">
        <div class="wrapp-breadcrumds">
            <div class="left"><span>アクセス解析</span></div>
            <div class="left">
                <div class="tab-header-analytic">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                            <a href="{{route('admin.analytic.google')}}" aria-controls="tab-analytic-1"
                               role="tab">アクセス解析</a>
                        </li>
                        <li role="presentation">
                            <a href="{{route('admin.analytic.coupon')}}" aria-controls="tab-analytic-2"
                               role="tab">クーポン動向</a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="{{route('admin.analytic.store')}}" aria-controls="tab-analytic-3"
                               role="tab">来店状况</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <section class="content">

            <div class="col-md-12">

                <!-- wrapp_tab -->
                <div class="wrapp_tab">

                    <div class="tab-content analytic">
                        <div role="tabpanel" class="tab-pane active" id="tab-analytic-3">
                            <div class="drop-analytic">
                                <select name="" id="" class="form-control">
                                    <option value="">客管理</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                    <option value="">オンライン</option>
                                </select>
                            </div>
                            <!-- wrapp_analytics -->
                            <div class="wrapp_analytics">
                                <div class="tab_top">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>ユーザー数</p>
                                                <h3>29,147</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>セッション</p>
                                                <h3>247,837</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>スクリーンビュー</p>
                                                <h3>1,002,719</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>離脱率</p>
                                                <h3>64.07%</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>平均セッション時間</p>
                                                <h3>00:01:48</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>新規セッション率</p>
                                                <h3>0.29%</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- //wrapp_analytics -->
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