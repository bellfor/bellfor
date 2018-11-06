jQuery(document).ready(function($) {
// https://www.jqueryscript.net/demo/Powerful-Customizable-jQuery-Carousel-Slider-OWL-Carousel//
    var t = $(".slideshow-box .owl-carousel");
    t.owlCarousel({
        items: 1,
        autoplay: !0,
        autoplayHoverPause: !0,
        singleItem: !0,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true,
        loop: 1
    }), t.on("translated.owl.carousel", function(t) {
        $(t.target).find(".owl-item .element-animation-fi").removeAttr("style"), $(t.target).find(".owl-item .element-animation-bi").removeAttr("style"), $(t.target).find(".owl-item.active .element-animation-fi").css("display", "block"), $(t.target).find(".owl-item.active .element-animation-bi").css("display", "block")
    }), $(".slideshow-box .owl-carousel .owl-item.active .element-animation-fi").css("display", "block"), $(".slideshow-box .owl-carousel .owl-item.active .element-animation-bi").css("display", "block");


});