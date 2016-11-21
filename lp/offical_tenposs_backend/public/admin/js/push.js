$('#btnSubmit').click(function (e) {
    var id = $('input[name=push_id]').val();
    var title = $('input[name=title]').val();
    var message = $('textarea[name=message]').val();
    var app_user_id = $('select[name=app_user_id]').val();
    var time_type = $('select[name=time_type]').val();
    var time_count_repeat = $('input[name=time_count_repeat]').val();
    var time_detail_year = $('select[name=time_detail_year]').val();
    var time_detail_month = $('select[name=time_detail_month]').val();
    var time_detail_day = $('select[name=time_detail_day]').val();
    var time_detail_type = $('select[name=time_detail_type]').val();
    var time_detail_hours = $('select[name=time_detail_hours]').val();
    var time_detail_minutes = $('select[name=time_detail_minutes]').val();
    if (title == '' || message == '') {
        alert("title or message is require")
        return false;
    }
    $.ajax({
        type: "POST",
        url: '/admin/push/store',
        data: {
            id: id,
            title: title,
            message: message,
            app_user_id: app_user_id,
            time_type: time_type
            ,
            time_count_repeat: time_count_repeat,
            time_detail_year: time_detail_year,
            time_detail_month: time_detail_month
            ,
            time_detail_day: time_detail_day,
            time_detail_type: time_detail_type,
            time_detail_hours: time_detail_hours
            ,
            time_detail_minutes: time_detail_minutes
        },
        success: function (msg) {
            // $("#ajaxResponse").append("<div>"+msg+"</div>");
            if (msg == 1) {
                $('#myModal').modal('show');
                $('input[name=push_id]').val(0);
                $('input[name=title]').val('');
                $('textarea[name=message]').val('');
                $('select[name=app_user_id]').val(0);
                $('select[name=time_type]').val(0);
                $('#time_config').hide();
                $('input[name=time_count_repeat]').val(0);
                $('select[name=time_detail_year]').val(2016);
                $('select[name=time_detail_month]').val('01');
                $('select[name=time_detail_day]').val('01');
                $('select[name=time_detail_type]').val('am');
                $('select[name=time_detail_hours]').val('00');
                $('select[name=time_detail_minutes]').val('00');
            }
            else
                alert('fail');
        }
    });

});
$(document).ready(function () {
    $('#time_config').hide();
    $('#time_type').on('change', function () {
        var selectVal = $("#time_type option:selected").val();
        if (selectVal == 2)
            $('#time_config').show();
        else
            $('#time_config').hide();
    });
});

function clickEditPush(id) {
    $.ajax({
        type: "GET",
        url: '/admin/push/edit/' + id,
        success: function (obj) {
            if (obj != null && obj != 'undefined' && obj != '') {
                $('#collapseExample').collapse('show');
                $('input[name=push_id]').val(obj.id);
                $('input[name=title]').val(obj.title);
                $('textarea[name=message]').val(obj.message);
                $('select[name=app_user_id]').val(obj.app_user_id);
                $('select[name=time_type]').val(obj.time_type);
                if (obj.time_type == 2) {
                    $('#time_config').show();
                    $('input[name=time_count_repeat]').val(obj.time_count_repeat);
                    if (obj.time_regular_string != '') {

                        var arrMain = obj.time_regular_string.split(" ");
                        if (arrMain.length > 0) {
                            var arrDate = arrMain[0].split('/');
                            var arrHours = arrMain[1].split(':');
                            if (arrDate.length > 0) {
                                $('select[name=time_detail_year]').val(arrDate[0]);
                                $('select[name=time_detail_month]').val(arrDate[1]);
                                $('select[name=time_detail_day]').val(arrDate[2]);
                            }
                            if (arrHours.length > 0) {
                                $('select[name=time_detail_type]').val(arrMain[2]);
                                $('select[name=time_detail_hours]').val(arrHours[0]);
                                $('select[name=time_detail_minutes]').val(arrHours[1]);
                            }
                        }
                    }
                }
            }
        }
    });
}