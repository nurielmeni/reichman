var Hotjobs =
  Hotjobs ||
  (function ($) {
    "use strict";

    var container = '.hs-container';

    function init(config) {
      // Init the image slider
      jQuery(container).slick({
        dots: false,
        infinite: true,
        autoplay: true,
        nextArrow: 'button.nav.left',
        prevArrow: 'button.nav.right',
        centerMode: true,
        centerPadding: '2rem'
      });
    }

    return {
      init: init,
    };
  })(jQuery);

jQuery(function () {
  Hotjobs.init();
});
