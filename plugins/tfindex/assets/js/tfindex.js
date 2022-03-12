( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */

	let WidgetTFindexHandler = function( $scope, $ ) {
		let tfindexNumOfSlides = 1;
		let tfindexSlidesPerView = 4;
		let tfindexThumbs = new Swiper(".tfindex-swiper", {
			loop: true,
			spaceBetween: 30,
			slidesPerView: tfindexSlidesPerView,
			freeMode: false,
			watchSlidesProgress: false,
			direction: "vertical",
			paginationClickable: false,
			allowTouchMove: false,
			on: {
				beforeInit: function () {
					tfindexNumOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
				}
			}
		});
		// tfindexThumbs.on('click', function (e) {
		// 	let nexSlide = (e.clickedIndex + 1) % tfindexNumOfSlides;
		// 	tfindexThumbs.slideTo(nexSlide, 1000);
		// },true);

		new Swiper(".tfindex-swiper-content", {
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
				swiper: tfindexThumbs,
			},
		});
	};

	let WidgetTestimonialsHandler = function( $scope, $ ) {
		let numOfSlides = 1;
		let slidesPerView = 2;
		let swiperThumbs = new Swiper(".testimonials-swiper", {
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

		new Swiper(".testimonials-swiper-content", {
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
		elementorFrontend.hooks.addAction( 'frontend/element_ready/tfindex.default', WidgetTFindexHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonials.default', WidgetTestimonialsHandler );
	} );

} )( jQuery );
