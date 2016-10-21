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

jQuery(document).scroll(function () {
    var y = jQuery(document).scrollTop(),
        header = $("#header");

    if (y >= 80) {
        header.addClass('sticky');
    } else {
        header.removeClass('sticky');
    }
});