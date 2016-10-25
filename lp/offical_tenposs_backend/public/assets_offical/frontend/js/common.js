$(document).ready(function(){
	$('.contact-section').addClass('invisible').viewportChecker({
		classToAdd: 'visible animated fadeInUp',
		offset : 150,
	})

	// SCROLL TOP
	$('.img-up').on('click',function(e){
		e.preventDefault();
		$('html, body').stop().animate({
			'scrollTop' : '0',
		},800);
	})
})

function setAnimation( target){
	$(target).addClass('invisible').viewportChecker({
		classToAdd: 'visible animated fadeInUp',
		offset : 150,
	})
}