$(document).ready(function(){
	$('.trigger').on('click', function(){
		$('.sidebar, .content').toggleClass('offset-sidebar-active');
	});
	
	 $.ajaxSetup({
    	headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#loading').fadeIn();
        },
        complete: function() {
            $('#loading').fadeOut();
        },
        success: function() {
            $('#loading').fadeOut();
        }
    });
})