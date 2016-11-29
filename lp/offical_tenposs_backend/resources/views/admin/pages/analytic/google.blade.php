@extends('admin.layouts.master')

@section('main')
    <link href="{{ url('admin/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
    <aside class="right-side">
        <div class="wrapp-breadcrumds">
            <div class="left"><span>アクセス解析</span></div>
            <div class="left">
                <div class="tab-header-analytic">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="{{route('admin.analytic.google')}}" aria-controls="tab-analytic-1"
                               role="tab">アクセス解析</a>
                        </li>
                        <li role="presentation">
                            <a href="{{route('admin.analytic.coupon')}}" aria-controls="tab-analytic-2"
                               role="tab">クーポン動向</a>
                        </li>
                        <li role="presentation">
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

                        <div role="tabpanel" class="tab-pane active" id="tab-analytic-1">
                            <div class="row">

                                <div class="col-md-12 text-right" style="margin-bottom: 20px;">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <input style="margin-bottom: 10px;" id="date_range" name="date_range"
                                                   type="text"
                                                   value="01/01/2015 - 01/31/2015" class="form-control date-time"
                                                   placeholder="Ngay thang"><br>

                                            <select name="report_type" id="report_type"
                                                    class="form-control option-chart">
                                                <option value="ga:users">ユーザー数</option>
                                                <option value="ga:sessions">セッション</option>
                                                <option value="ga:screenviews">スクリーンビュー</option>
                                                <option value="ga:bounceRate">離脱率</option>
                                                <option value="ga:avgSessionDuration">平均セッション時間</option>
                                                <option value="ga:percentNewSessions">新規セッション率</option>
                                            </select>
                                            <div class="btn-group">
                                                <button type="button" name="time-type" data-time-type="D"
                                                        class="btn btn-default active">日
                                                </button>
                                                <button type="button" name="time-type" data-time-type="M"
                                                        class="btn btn-default">月
                                                </button>
                                                <button type="button" name="time-type" data-time-type="Y"
                                                        class="btn btn-default">年
                                                </button>
                                            </div>
                                        </div>


                                    </div>

                                </div>


                            </div>
                            <canvas id="myChart"></canvas>
                            <!-- //Tab panes -->
                            <!-- wrapp_analytics -->
                            <div class="wrapp_analytics">
                                <div class="tab_top">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>ユーザー数</p>
                                                <h3 id="ga_users">0</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>セッション</p>
                                                <h3 id="ga_sessions">0</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>スクリーンビュー</p>
                                                <h3 id="ga_screen_views">0</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>離脱率</p>
                                                <h3 id="ga_bounce_rate">0</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>平均セッション時間</p>
                                                <h3 id="ga_avg_session_duration">0</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <div class="content_tab_top">
                                                <p>新規セッション率</p>
                                                <h3 id="ga_percent_new_sessions">0</h3>
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
    {{Html::script('admin/js/Chart.min.js')}}
    {{Html::script('admin/js/moment.min.js')}}
    {{Html::script('admin/js/daterangepicker.js')}}
    {{Html::script('admin/js/chart_tenposs.js')}}
    {{Html::script('admin/js/chart_action_tenposs.js')}}
    <script>
        var type_chart = 'ga';
        $(function () {
            $('input[name="date_range"]').daterangepicker({
                "timePicker24Hour": true,
                locale: {
                    format: 'DD/MM/YYYY'
                },
                "startDate": moment().subtract(20, 'days'),
                "endDate": moment(),
                "opens": "left"
            });
        });

        $(document).ready(function () {
            tenposs_action.init();
            var from_date = tenposs_action.get_from_date();
            var to_date = tenposs_action.get_to_date();
            var time_type = tenposs_action.get_time_type();
            var report_type = $('select[name=report_type]').val();
            $("body").addClass("loading");
            tenposs.google_analytics.draw_chart(report_type, time_type, from_date, to_date);
            tenposs.google_analytics.get_total_data(time_type, from_date, to_date);
        });
    </script>
    <div class="modal modal-loading">
        <div class="preloader-wrapper">
            <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
        </div>
    </div>

@endsection