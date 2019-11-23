(function ($) {

  $(document).ready(function(){
    (function () {
      if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
      if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
        s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
        s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
        //console.log(s.src);
        var h = d[g]('body')[0];h.appendChild(s); }
    })();

    if /* if we're on iOS, open directions in Apple Maps */
    ((navigator.platform.indexOf("iPhone") != -1) ||
      (navigator.platform.indexOf("iPad") != -1) ||
      (navigator.platform.indexOf("iPod") != -1)) {
      $('a.link-directions').each(function() {
        $(this).attr("href", function(index, old) {
          return old.replace("https://", "maps://");
        });
      });
    }

  });

})(jQuery);

var atc_flag = "off";
function AtcClose() {
  //alert(atc_flag);
  //alert($('.addtocalendar ul.atcb-list:first').is(':visible') + " " + atc_flag);
  if(atc_flag == "on") {
    jQuery('.addtocalendar ul.atcb-list').hide();
    //$('.addtocalendar ul.atcb-list:first').attr("visibility", "hidden")
    jQuery('body').off('click.calendar');
    atc_flag = "off";
    jQuery('.addtocalendar ul.atcb-list').removeClass('visible');
  }
  else {
    jQuery('.addtocalendar ul.atcb-list').show();
    jQuery('body').on('click.calendar', function(e) {
      if (!jQuery(e.target).parents('.addtocalendar').length) {
        jQuery('.addtocalendar ul.atcb-list').hide();
        // if($('.addtocalendar ul.atcb-list:first').is(':visible')) {
        //   $('.addtocalendar ul.atcb-list').hide();
        // }
        jQuery('body').off('click.calendar');
        atc_flag = "off";
        jQuery('.addtocalendar ul.atcb-list').removeClass('visible');
      }
    });
    atc_flag = "on";
    jQuery('.addtocalendar ul.atcb-list').addClass('visible');
  }
}