/**
 * Created by bangnk on 11/23/16.
 */
var myLineChart = null;
var tenposs = {
        init: function () {

        },
        chart: {
            draw: function (label, data, namechart) {
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
                var option = {
                    showLines: true,
                    legend: {
                        display: false
                    }
                };
                if (myLineChart != null)
                    myLineChart.destroy();
                myLineChart = Chart.Line(ctx, {
                    data: data,
                    options: option
                });

            }
        },
        google_analytics: {
            draw_chart: function (report_type, time_type, from_date, to_date) {
                // var label = ['A', 'B', 'C', 'D', 'E', 'F'];
                // var namechart = "bangnk_test";
                // var data = [10, 30, 30, 40, 50, 20];
                // tenposs.chart.draw(label, data, namechart);
                var data_ajax = {
                    data_type: 'ga_detail',
                    time_type: time_type,
                    from_date: from_date,
                    to_date: to_date,
                    report_type: report_type
                };
                $("body").addClass("loading");
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/get_data',
                        type: 'GET',
                        cache: false,
                        async: false,
                        data: data_ajax,
                        timeout: 60000,
                        dataType: "json",
                        beforeSend: function () {
                            $("body").addClass("loading");
                        },
                        success: function (result) {
                            console.log(result);
                            if (result !== undefined || result !== null && result.code == 1000) {
                                tenposs.chart.draw(result.data.label, result.data.data_chart, result.data.name);
                                $("body").removeClass("loading");
                            }
                        }
                    });
                });
            },
            get_total_data: function (time_type, from_date, to_date) {
                var data_ajax = {
                    data_type: 'ga_total_all',
                    time_type: time_type,
                    from_date: from_date,
                    to_date: to_date
                };
                $("body").addClass("loading");
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/get_data',
                        type: 'GET',
                        cache: false,
                        async: false,
                        data: data_ajax,
                        timeout: 60000,
                        beforeSend: function () {
                            $("body").addClass("loading");
                        },
                        dataType: "json",
                        success: function (result) {
                            if (result !== undefined || result !== null && result.code == 1000) {
                                console.log(result);
                                for (var i = 0; i < result.data.length; i++)
                                    tenposs.google_analytics.bind_total_data(result.data[i].report_type, result.data[i].total);
                                $("body").removeClass("loading");
                            }
                        }
                    });
                });
            },
            bind_total_data: function (report_type, data_value) {
                data_value = parseFloat(data_value);
                data_value = Number(data_value.toFixed(2)).toLocaleString();
                switch (report_type) {
                    case 'ga:users':
                        $('#ga_users').html(data_value);
                        break;
                    case 'ga:sessions':
                        $('#ga_sessions').html(data_value);
                        break;
                    case 'ga:screenviews':
                        $('#ga_screen_views').html(data_value);
                        break;
                    case 'ga:bounceRate':
                        $('#ga_bounce_rate').html(data_value + '%');
                        break;
                    case 'ga:avgSessionDuration':
                        $('#ga_avg_session_duration').html(data_value);
                        break;
                    case 'ga:percentNewSessions':
                        $('#ga_percent_new_sessions').html(data_value + '%');
                        break;
                    default:
                        break;
                }
            }
        },
        coupon: {
            draw_chart: function (report_type, time_type, from_date, to_date) {
                // var label = ['A', 'B', 'C', 'D', 'E', 'F'];
                // var namechart = "bangnk_test";
                // var data = [10, 30, 30, 40, 50, 20];
                // tenposs.chart.draw(label, data, namechart);
                var data_ajax = {
                    data_type: 'cp_detail',
                    time_type: time_type,
                    from_date: from_date,
                    to_date: to_date,
                    report_type: report_type
                };
                $("body").addClass("loading");
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/get_data',
                        type: 'GET',
                        cache: false,
                        async: false,
                        data: data_ajax,
                        timeout: 60000,
                        dataType: "json",
                        beforeSend: function () {
                            $("body").addClass("loading");
                        },
                        success: function (result) {
                            console.log(result);
                            if (result !== undefined || result !== null && result.code == 1000) {
                                tenposs.chart.draw(result.data.label, result.data.data_chart, result.data.name);
                                $("body").removeClass("loading");
                            }
                        }
                    });
                }, 500);
            },
            get_total_data: function (time_type, from_date, to_date) {
                var data_ajax = {
                    data_type: 'cp_total_all',
                    time_type: time_type,
                    from_date: from_date,
                    to_date: to_date
                };
                $("body").addClass("loading");
                setTimeout(function () {
                    $.ajax({
                        url: '/admin/get_data',
                        type: 'GET',
                        cache: false,
                        async: false,
                        data: data_ajax,
                        timeout: 60000,
                        beforeSend: function () {
                            $("body").addClass("loading");
                        },
                        dataType: "json",
                        success: function (result) {
                            if (result !== undefined || result !== null && result.code == 1000) {
                                console.log(result);
                                for (var i = 0; i < result.data.length; i++)
                                    tenposs.coupon.bind_total_data(result.data[i].report_type, result.data[i].total);
                                $("body").removeClass("loading");
                            }
                        }
                    });
                }, 500);

            },
            bind_total_data: function (report_type, data_value) {
                data_value = parseFloat(data_value);
                data_value = Number(data_value.toFixed(2)).toLocaleString();
                switch (report_type) {
                    case 'coupon_use':
                        $('#cp_coupon_use').html(data_value);
                        break;
                    case 'post':
                        $('#cp_post').html(data_value);
                        break;
                    case 'coupon_created':
                        $('#cp_coupon_created').html(data_value);
                        break;
                    default:
                        break;
                }
            }
        }
    }
    ;