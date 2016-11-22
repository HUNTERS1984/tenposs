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

                                <div class="col-md-12 text-right">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <input style="margin-bottom: 10px;" name="daterange" type="text"
                                                   value="01/01/2015 - 01/31/2015" class="form-control date-time"
                                                   placeholder="Ngay thang"><br>

                                            <select class="form-control option-chart">
                                                <option>ユーザー数</option>
                                                <option>セッション</option>
                                                <option>スクリーンビュー</option>
                                                <option>離脱率</option>
                                                <option>平均セッション時間</option>
                                                <option>新規セッション率</option>
                                            </select>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">日</button>
                                                <button type="button" class="btn btn-default">月</button>
                                                <button type="button" class="btn btn-default">年</button>
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
    {{Html::script('admin/js/Chart.min.js')}}
    {{Html::script('admin/js/moment.min.js')}}
    {{Html::script('admin/js/daterangepicker.js')}}
    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                "opens": "left"
            });
        });
        //
        //        var ctx = document.getElementById('myChart').getContext('2d');
        //        var myLineChart = new Chart(ctx, {
        //            type: 'line',
        //            data: data
        //        });

        function drawChart(label, data, namechart) {
            var ctx = document.getElementById('myChart').getContext('2d');
            var data = {
                labels: label,
                datasets: [
                    {
                        label: namechart,
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: data,
                        spanGaps: false,
                    }
                ]
            };
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: data
            });
        }

        var GetChartData = function () {
            $.ajax({
                url: '/admin/get_data',
                method: 'GET',
                dataType: 'json',
                success: function (d) {
                    drawChart(d.label, d.data, "GA");
                }
            });
        };

        $(document).ready(function () {
            GetChartData();
        });
    </script>
@endsection