/**
 * Created by bangnk on 11/25/16.
 */

var tenposs_action = {
    init: function () {
        tenposs_action.list_action.init();
    },
    list_action: {
        init: function () {
            $('#date_range').on('apply.daterangepicker', function (ev, picker) {
                var report_type = $('select[name=report_type]').val();
                var from_date = picker.startDate.format('YYYY-MM-DD');
                var to_date = picker.endDate.format('YYYY-MM-DD');
                var time_type = tenposs_action.get_time_type();
                if (tenposs_action.get_type_chart() == 'ga') {
                    tenposs.google_analytics.draw_chart(report_type, time_type, from_date, to_date);
                    tenposs.google_analytics.get_total_data(time_type, from_date, to_date);
                }
                else if (tenposs_action.get_type_chart() == 'cp') {
                    tenposs.coupon.draw_chart(report_type, time_type, from_date, to_date);
                    tenposs.coupon.get_total_data(time_type, from_date, to_date);
                }
            });
            $('button[name=time-type]').click(function () {
                var report_type = $('select[name=report_type]').val();
                var time_type = $(this).attr('data-time-type');
                $('button[name=time-type]').removeClass('active');
                $(this).addClass("active");
                var from_date = tenposs_action.get_from_date();
                var to_date = tenposs_action.get_to_date();
                if (tenposs_action.get_type_chart() == 'ga') {
                    tenposs.google_analytics.draw_chart(report_type, time_type, from_date, to_date);
                } else if (tenposs_action.get_type_chart() == 'cp') {
                    tenposs.coupon.draw_chart(report_type, time_type, from_date, to_date);
                }
            });

            $('#report_type').on('change', function () {
                var report_type = $('select[name=report_type]').val();
                var time_type = tenposs_action.get_time_type();
                var from_date = tenposs_action.get_from_date();
                var to_date = tenposs_action.get_to_date();
                if (tenposs_action.get_type_chart() == 'ga') {
                    tenposs.google_analytics.draw_chart(report_type, time_type, from_date, to_date);
                } else if (tenposs_action.get_type_chart() == 'cp') {
                    tenposs.coupon.draw_chart(report_type, time_type, from_date, to_date);
                }
            });
        }
    },
    get_type_chart: function () {
        return type_chart;
    }
    ,
    get_time_type: function () {
        var timetype = "";
        $('button[name=time-type]').each(function () {
            if ($(this).hasClass('active')) {
                timetype = $(this).attr('data-time-type');
            }
        });
        return timetype;
    },
    get_from_date: function () {
        var from_date = '';
        var date_range = $("#date_range").val();
        if (date_range != '' && date_range != undefined) {
            var arr_date = date_range.split('-');
            from_date = tenposs_action.parse_date(arr_date[0].trim());
        }
        return from_date;
    },
    get_to_date: function () {
        var to_date = '';
        var date_range = $("#date_range").val();
        if (date_range != '' && date_range != undefined) {
            var arr_date = date_range.split('-');
            to_date = tenposs_action.parse_date(arr_date[1].trim());
        }
        return to_date;
    },
    parse_date: function (str) { //str : dd/mm/yyyy
        var parts = str.split('/');
        return parts[2] + '-' + parts[1] + '-' + parts[0];
    }
};
