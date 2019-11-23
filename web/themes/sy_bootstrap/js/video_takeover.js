(function ($) {
	var w = window.innerWidth;
  	var h = window.innerHeight;

	if ($("body").find(".hero--fullscreen")) {
		$(".navbar" ).addClass("navbar--transparent");
    	$(".sy-main-nav" ).addClass("sy-main-nav--transparent");
    	$(".sy-top-bar" ).addClass("sy-top-bar--transparent");
    	
    	// Set container height & width
    	$(".hero--fullscreen").css({ height: h + 'px' });
    	$(".hero--fullscreen").css({ width: w + 'px' });

    	// Set container height & width
    	$(".video-container").css({ paddingTop: h + 'px' });
    	$(".video-container").css({ width: w + 'px' });

    	// resize container
    	$(window).resize(function() {
			$(".hero--fullscreen").css({ height: h + 'px' });
            $(".hero--fullscreen").css({ width: w + 'px' });
            $(".video-container").css({ paddingTop: h + 'px' });
            $(".video-container").css({ width: w + 'px' });
		});

        $(window).on("scroll", function() {
            // header color switch, header navigation desktop color switch, link menu color switch
            if ($(this).scrollTop() > 100) {
                $(".sy-main-nav").removeClass("sy-main-nav--transparent");
                $(".sy-top-bar").removeClass("sy-top-bar--transparent");
                $(".to-top-arrow").addClass("to-top-arrow--show");
            } else {
                $(".sy-main-nav").addClass("sy-main-nav--transparent");
                $(".sy-top-bar").addClass("sy-top-bar--transparent");
                $(".to-top-arrow").removeClass("to-top-arrow--show");
            }
        });
    }
})(jQuery);
