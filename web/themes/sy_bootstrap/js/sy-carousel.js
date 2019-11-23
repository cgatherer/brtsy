(function ($) {
	var touchSensitivity = 5;

	$('#sy-carousel').carousel({
  		interval: 3000,
  		pause: null
	});

	$(".carousel").on("touchstart", function (event) {
	    var xClick = event.originalEvent.touches[0].pageX;
	    $(this).one("touchmove", function (event) {
	        var xMove = event.originalEvent.touches[0].pageX;
	        if (Math.floor(xClick - xMove) > touchSensitivity) {
	            $(this).carousel('next');
	        } else if (Math.floor(xClick - xMove) < -(touchSensitivity)) {
	            $(this).carousel('prev');
	        }
	    });
	    $(".carousel").on("touchend", function () {
	        $(this).off("touchmove");
	    });
	});
})(jQuery);