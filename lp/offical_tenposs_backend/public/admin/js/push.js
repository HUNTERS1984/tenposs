$('#btnSubmit').click(function (e) {
    $('#customer_message').hide();
    var id = $('input[name=push_id]').val();
    var title = $('input[name=title]').val();
    var message = $('textarea[name=message]').val();
    var auth_user_id = $('select[name=auth_user_id]').val();
    var time_type = $('select[name=time_type]').val();
    var time_count_repeat = $('input[name=time_count_repeat]').val();
    var time_detail_year = $('select[name=time_detail_year]').val();
    var time_detail_month = $('select[name=time_detail_month]').val();
    var time_detail_day = $('select[name=time_detail_day]').val();
    var time_detail_type = $('select[name=time_detail_type]').val();
    var time_detail_hours = $('select[name=time_detail_hours]').val();
    var time_detail_minutes = $('select[name=time_detail_minutes]').val();
    var tags_input = $('select[name=tags-input]').val();
    var time_selected_type = $('select[name=time_selected_option]').val();
    var time_selected_detail_year = $('select[name=time_selected_detail_year]').val();
    var time_selected_detail_month = $('select[name=time_selected_detail_month]').val();
    var time_selected_detail_day = $('select[name=time_selected_detail_day]').val();

    var all_user = 0;
    var client_users = 0;
    var end_users = 0;
    var a_user = 0;
    if (tags_input != null && tags_input.length > 0) {
        if (tags_input.indexOf('all_users') > -1)
            all_user = 1;
        if (tags_input.indexOf('client_users') > -1)
            client_users = 1;
        if (tags_input.indexOf('end_users') > -1)
            end_users = 1;
        if (tags_input.indexOf('a_user') > -1)
            a_user = 1;
    }
    if (title == '' || message == '') {
        $('#customer_message ul li').first().text('タイトルと内容を入力してください');
        $('#customer_message').show();
        return false;
    }

    if (time_type == 0) {
        $('#customer_message ul li').first().text('配信時間指定を選択してください');
        $('#customer_message').show();
        return false;
    }

    if (a_user && auth_user_id == 0) {
        $('#customer_message ul li').first().text('ユーザーを選択してください');
        $('#customer_message').show();
        return false;
    }

    $.ajax({
        type: "POST",
        url: '/admin/push/store',
        data: {
            id: id,
            title: title,
            message: message,
            auth_user_id: auth_user_id,
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
            time_detail_minutes: time_detail_minutes,
            all_user: all_user,
            client_users: client_users,
            end_users: end_users,
            a_user: a_user,
            time_selected_detail_year: time_selected_detail_year,
            time_selected_detail_month: time_selected_detail_month,
            time_selected_detail_day: time_selected_detail_day,
            time_selected_type: time_selected_type
        },
        beforeSend: function() {
            $('#loading').fadeIn();
        },
        complete: function() {
            $('#loading').fadeOut();
        },
        success: function (msg) {
            // $("#ajaxResponse").append("<div>"+msg+"</div>");
            if (msg == 1) {
                $('#myModal').modal('show');
                $('input[name=push_id]').val(0);
                $('input[name=title]').val('');
                $('textarea[name=message]').val('');
                $('select[name=auth_user_id]').val(0);
                $('select[name=time_type]').val(0);
                $('#time_config').hide();
                $('input[name=time_count_repeat]').val(1);
                $('select[name=time_detail_year]').val(2017);
                $('select[name=time_detail_month]').val('01');
                $('select[name=time_detail_day]').val('01');
                $('select[name=time_detail_type]').val('am');
                $('select[name=time_detail_hours]').val('00');
                $('select[name=time_detail_minutes]').val('00');
                $('#date_config').hide();
                $('select[name=time_selected_option]').val('2h');
                $('select[name=time_selected_detail_year]').val(2017);
                $('select[name=time_selected_detail_month]').val('01');
                $('select[name=time_selected_detail_day]').val('01');
            }
            else {
                $('#customer_message ul li').first().text('プッシュに失敗しました');
                $('#customer_message').show();
            }
            $('#loading').fadeOut();
        }
    });

});
$(document).ready(function () {
    $('#time_config').hide();
    $('#repeat_config').hide();
    $('#date_config').hide();
    $('#time_type').on('change', function () {
        var selectVal = $("#time_type option:selected").val();
        if (selectVal == 2) {
            $('#time_config').show();
            $('#repeat_config').show();
            $('#date_config').hide();
        }
        else if (selectVal == 3) {
            $('#time_config').show();
            $('#repeat_config').hide();
            $('#date_config').show();
            $('#choose_day').hide();
        }
        else {
            $('#time_config').hide();
            $('#date_config').hide();
        }

    });

    $('#date_config_option').on('change', function () {
        var selectVal = $("#date_config_option option:selected").val();
        if (selectVal == 'choose_day')
            $('#choose_day').show();
        else
            $('#choose_day').hide();

    });

    $("#tags-input").on('itemAdded', function (event) {
        console.log('item added : ' + event.item);
    });

    $("#tags-input").on('itemRemoved', function (event) {
        console.log('item removed : ' + event.item);
        if (event.item == 'a_user') {
            $('#choose_a_user').hide();

        }
    });
    $('#tags-input').tagsinput({
      allowDuplicates: false,
        itemValue: 'id',  // this will be used to set id of tag
        itemText: 'label' // this will be used to set text of tag
    });
    $('select[name=tags-input]').tagsinput('add', {id: 'all_users', label: 'すべてのユーザー'});
    //$('select[name=tags-input]').tagsinput('add', {id: 'client_users', label: 'クライエント'});
    //$('select[name=tags-input]').tagsinput('add', {id: 'end_users', label: 'エンドユーザ'});
    $('select[name=tags-input]').tagsinput('add', {id: 'a_user', label: 'ユーザー'});
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
                // $('textarea[name=message]').val(obj.message);
                $('#editor').trumbowyg('html', obj.message);
                $('select[name=auth_user_id]').val(obj.auth_user_id);
                $('select[name=time_type]').val(obj.time_type);
                $('select[name=tags-input]').tagsinput('removeAll');
                if (obj.segment_all_user == 1)
                    $('select[name=tags-input]').tagsinput('add', {id: 'all_users', label: 'すべてのユーザー'});
                if (obj.segment_client_users == 1)
                    $('select[name=tags-input]').tagsinput('add', {id: 'client_users', label: 'クライエント'});
                if (obj.segment_end_users == 1)
                    $('select[name=tags-input]').tagsinput('add', {id: 'end_users', label: 'エンドユーザ'});
                if (obj.segment_a_user == 1)
                    $('select[name=tags-input]').tagsinput('add', {id: 'a_user', label: 'ユーザー'});
                if (obj.time_type == 2) {
                    $('#time_config').show();
                    $('#repeat_config').show();
                    $('#date_config').hide();
                    $('input[name=time_count_repeat]').val(obj.time_count_repeat);
                    if (obj.time_regular_string != null && obj.time_regular_string != '') {

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
                else if (obj.time_type == 3) {
                    $('#date_config').show();
                    $('#time_config').show();
                    $('#repeat_config').hide();
                    $('input[name=time_selected_option]').val(obj.time_selected_type);
                    if (obj.time_selected_string != null && obj.time_selected_string != '') {

                        var arrMain = obj.time_selected_string.split(" ");
                        if (arrMain.length > 0) {
                            var arrDate = arrMain[0].split('/');
                            if (arrDate.length > 0) {
                                $('select[name=time_selected_detail_year]').val(arrDate[0]);
                                $('select[name=time_selected_detail_month]').val(arrDate[1]);
                                $('select[name=time_selected_detail_day]').val(arrDate[2]);
                            }
                        }
                    }
                }
            }
        }
    });
}