$(function(){
	'use-strict';

	// portfolio
	$('.portfolio-filter li').on('click',function() {
        $('.portfolio-filter li').removeClass('active');
        $(this).addClass('active');
    });

   $('.portfolio-item').imagesLoaded( function() {
	  	var filterizr = $('.portfolio-item').filterizr();
	});

});