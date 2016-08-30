"use strict";
/* jshint globalstrict: true */
/* global jQuery:false */

jQuery(document).ready(function($) {
	// carousel demo

	$('#myCarousel, #myCarousel2').carousel();
	$('.dropdown-toggle').dropdown();

	$(".datepicker").datepicker().on('changeDate', function() {
		$('.datepicker').datepicker('hide');
	});

	// menu fixed

	$(window).scroll(function() {
		if ($(this).scrollTop() > 1) {
			$("#header").addClass("menu_fixed");
		} else {
			$("#header").removeClass("menu_fixed");
		}
	});

	// resp menu

	$(".btn-navbar").click();

	// rating

	$.fn.raty.defaults.path = 'img';
	$('#star_rating_img').raty();
	$('.tours_result_img_0').raty({
		score : 0,
		readOnly : true
	});
	$('.tours_result_img_1').raty({
		score : 1,
		readOnly : true
	});
	$('.tours_result_img_2').raty({
		score : 2,
		readOnly : true
	});
	$('.tours_result_img_3').raty({
		score : 3,
		readOnly : true
	});
	$('.tours_result_img_4').raty({
		score : 4,
		readOnly : true
	});
	$('.tours_result_img_5').raty({
		score : 5,
		readOnly : true
	});

	// pagination

	var options = {
		currentPage : 1,
		totalPages : 7
	};

	$('#tours_pagination').bootstrapPaginator(options);
	
	$('[data-lightbox]').simpleLightbox();

}); 