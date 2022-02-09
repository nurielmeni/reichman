var Hotjobs =
  Hotjobs ||
  (function ($) {
    "use strict";

    var wrapper, nav, slider, item;

    function testme() {
      return "The module works!";
    }

    function init(config) {
      wrapper = config && "wrapper" in config ? config.wrapper : ".hs-wrapper";
      nav =
        config && "nav" in config !== "undefined"
          ? wrapper + " " + config.nav
          : wrapper + " button.nav";
      slider =
        config && "slider" in config !== "undefined"
          ? wrapper + " " + config.slider
          : wrapper + " .hs-container";
      item =
        config && "item" in config !== "undefined"
          ? slider + " " + config.item
          : slider + " .hot-job-card";
    }

    function sliderWidth() {
      var sliderEl = document.querySelector(slider);
      return sliderEl ? sliderEl.scrollWidth : 0;
    }

    function scrollSlider(direction, cbAfterAnimation) {
      if (!direction) return;

      var width = $(item).outerWidth(true);
      var sLeft = $(slider).scrollLeft() + direction * width;

      $(slider).animate({ scrollLeft: sLeft }, {
        duration: 600, complete: cbAfterAnimation
      });

      return sLeft;
    }

    // Event Listeners
    $(document).ready(function () {
      $(slider).scrollLeft((sliderWidth() - window.screen.width) / 2);

      if (mobileCheck()) {
        swipedetect(document.querySelector(slider), function (swipedir) {
          if (swipedir === 'none') return;
          var direction = swipedir === 'left'
            ? 1
            : swipedir === 'right'
              ? -1
              : null;

          scrollSlider(direction, null);
        });
      }
    });

    // Nav Buttons Clicked
    $(document).on("click", nav, function (e) {
      $(nav).prop('disabled', true);
      var direction = $(e.target).hasClass("left")
        ? -1
        : $(e.target).hasClass("right")
          ? 1
          : null;

      var sLeft = scrollSlider(direction, function () {
        $(nav).prop('disabled', false);
      });

      // Slider width + screen width
      if (sLeft + window.screen.width >= sliderWidth()) $(nav + '.right').hide()
      else $(nav + '.right').show();

      if (sLeft <= 0) $(nav + '.left').hide()
      else $(nav + '.left').show();
    });

    return {
      testme: testme,
      init: init,
    };
  })(jQuery);

Hotjobs.init();
