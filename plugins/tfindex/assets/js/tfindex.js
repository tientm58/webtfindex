( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */

	var WidgetTestimonialsHandler = function( $scope, $ ) {
		var startScroll, touchStart, touchCurrent;
		var numOfSlides = 1;
		var slidesPerView = 2;
		var swiperThumbs = new Swiper(".testimonials-swiper", {
			loop: true,
			spaceBetween: 30,
			slidesPerView: slidesPerView,
			freeMode: false,
			watchSlidesProgress: false,
			direction: "vertical",
			paginationClickable: false,
			allowTouchMove: false,
			on: {
				beforeInit: function () {
					numOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
				}
			}
		});
		swiperThumbs.on('click', function (e) {
			let nexSlide = (e.clickedIndex + 1) % numOfSlides;
			swiperThumbs.slideTo(nexSlide, 1000);
		},true);

		var swiper2 = new Swiper(".testimonials-swiper-content", {
			loop: true,
			spaceBetween: 10,
			direction: "vertical",
			allowTouchMove: false,
			// autoplay: true,
			// navigation: {
			// 	nextEl: ".swiper-button-next",
			// 	prevEl: ".swiper-button-prev",
			// },
			thumbs: {
				swiper: swiperThumbs,
			},
		});
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonials.default', WidgetTestimonialsHandler );
	} );

} )( jQuery );
