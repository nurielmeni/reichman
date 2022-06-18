"use strict";
jQuery(function () {

    var container = '.hs-container';

    // Init the image slider
    jQuery(container).slick({
        dots: false,
        infinite: true,
        autoplay: true,
        slidesToScroll: 1,
        nextArrow: 'button.nav.left',
        prevArrow: 'button.nav.right',
        centerMode: true,
        mobileFirst: true,
        centerPadding: '1rem',
        slidesToShow: 1,
        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }]
    });
});