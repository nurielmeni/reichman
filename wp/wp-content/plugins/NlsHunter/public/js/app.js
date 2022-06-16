var App = App || function ($) {
  var version = '2.0.0';

  function ver() {
    return version;
  }

  $(function () {
    // Hot Jobs slider
    // Init the image slider
    jQuery('.hs-container').slick({
      dots: false,
      infinite: true,
      variableWidth: true,
      centerMode: true,
      autoplay: true,
      nextArrow: 'button.nav.left',
      prevArrow: 'button.nav.right',
      centerPadding: '32px'
    });
  });

  return {
    ver: ver
  }
}(jQuery);