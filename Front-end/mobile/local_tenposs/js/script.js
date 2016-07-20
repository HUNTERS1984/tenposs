jQuery('.h_control-nav').click(function () {
    jQuery('#page').addClass('active-scrollbar');
});
jQuery('.overfog').click(function () {
    jQuery('#page').removeClass('active-scrollbar');
});
jQuery('.noti_inside a').click(function(){
   jQuery('.notication').fadeOut();
});
jQuery('.form-mail a').click(function(){
   jQuery('.notication').fadeIn();
});