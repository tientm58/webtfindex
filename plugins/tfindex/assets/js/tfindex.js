( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */

	let WidgetTFindexHandler = function( $scope, $ ) {
		let tfindexNumOfSlides = 1;
		let tfindexSlidesPerView = 4;
		let tfindexThumbs = new Swiper(".tfindex-swiper-thumb", {
			loop: true,
			spaceBetween: 30,
			// slidesPerView: tfindexSlidesPerView,
			slidesPerView: 1,
			freeMode: true,
			watchSlidesProgress: false,
			// direction: "vertical",
			direction: getDirection(),
			paginationClickable: false,
			allowTouchMove: true,
			navigation: {
				nextEl: ".slide-arrow-down",
				prevEl: ".slide-arrow-up",
			},
			breakpoints: {
				720: {
					slidesPerView: 3,
					allowTouchMove: false,
					freeMode: false,
				},
				1024: {
					slidesPerView: 4,
					allowTouchMove: false,
					freeMode: false,
				}
			},
			on: {
				beforeInit: function () {
					tfindexNumOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
				},
				resize: function () {
					tfindexThumbs.changeDirection(getDirection());
				},
			},
		});
		// tfindexThumbs.on('click', function (e) {
		// 	// let nexSlide = (e.clickedIndex + 1) % tfindexNumOfSlides;
		// 	// tfindexThumbs.slideTo(nexSlide, 1000);
		// 	$('.tfindex-swiper-thumb .post-title').css({'color': '#BDBDBD'});
		// 	$(e.clickedSlide).find('.post-title').css({'color': '#F5B236'});
		// 	console.log('clicked: ', 'tfindexThumbs')
		// },true);

		$('.item.swiper-slide').on('click', function (event) {
			event.preventDefault();
			$('.tfindex-swiper-thumb .post-title').css({'color': '#BDBDBD'});
			$( event.currentTarget ).find( '.post-title' ).css( "color", "#F5B236" );
			let currentIndexClicked = $(event.currentTarget).data('swiper-slide-index');
			tfindexSwiper.slideTo(currentIndexClicked + 1);
		})

		const tfindexSwiper = new Swiper(".tfindex-swiper-content", {
			loop: true,
			freeMode: true,
			spaceBetween: 10,
			direction: "vertical",
			allowTouchMove: false,
			// autoplay: true,
			navigation: {
				nextEl: ".slide-arrow-down",
				prevEl: ".slide-arrow-up",
			},
			// thumbs: {
			// 	swiper: tfindexThumbs,
			// },
		});

		$('.slide-arrow').on('click', function (e) {
			e.preventDefault();
			let activeIndex = (tfindexSwiper.activeIndex - 1) % tfindexNumOfSlides;
			if (activeIndex === -1 ) {
				activeIndex += tfindexNumOfSlides;
			}
			$('.tfindex-swiper-thumb .post-title').css({'color': '#BDBDBD'});
			$(`.swiper-slide[data-swiper-slide-index="${activeIndex}"] .post-title`).css({'color': '#F5B236'});
		})

		function getDirection() {
			let windowWidth = window.innerWidth;
			let direction = window.innerWidth > 760 ? 'vertical' : 'horizontal';

			return direction;
		}
	};

	let WidgetTFTalkHandler = function( $scope, $ ) {
		const TFTalkSwiper = new Swiper('.tftalk-swiper', {
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			// direction: getDirection(),
			// navigation: {
			// 	nextEl: '.swiper-button-next',
			// 	prevEl: '.swiper-button-prev',
			// },
			breakpoints: {
				730: {
					slidesPerView: 2,
				},
				1024: {
					slidesPerView: 3,
					spaceBetween: 30,
				},
			},
			navigation: {
				nextEl: '.slide-arrow-right',
				prevEl: '.slide-arrow-left',
			},
			on: {
				// resize: function () {
				// 	tftalkSwiper.changeDirection(getDirection());
				// },
			},
		});

		let modal = $("#tfindex-form-popup");
		let closeBtn = $(".close")[0];

		closeBtn.onclick = function() {
			modal.hide();
		}

		$('.tftalk-swiper .tfindex-register').on('click', function (e) {
			const eventName = $(this).data("event");
			const tfindexEvent = $('#tfindex-event');
			tfindexEvent.val(eventName);
			tfindexEvent.prop( "disabled", true );
			modal.show();

			$( "#tfindex-form-events" ).submit(function( event ) {
				event.preventDefault();
				const url = 'https://script.google.com/macros/s/AKfycbxbE12PumehGNulS71v1yk8qxFauYJ92tDPNbtxK-MqdvrsIguUagzk5PGy6mKgoQOM/exec';
				const data = {
					event: eventName,
					name: $('#tfindex-register-name').val(),
					email: $('#tfindex-register-email').val(),
					phone: $('#tfindex-register-phone').val(),
				};
				$.ajax({
					url: url,
					method: "GET",
					dataType: "json",
					data: data
				}).done(function() {
					modal.hide();
				});
			});
		});
	};

	let WidgetThuyenHandler = function( $scope, $ ) {
		new Swiper('.thuyen-swiper', {
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			breakpoints: {
				730: {
					slidesPerView: 2,
				},
				1024: {
					slidesPerView: 3,
					spaceBetween: 30,
				},
			},
			navigation: {
				nextEl: '.slide-arrow-right',
				prevEl: '.slide-arrow-left',
			},
			on: {
				// resize: function () {
				// 	tftalkSwiper.changeDirection(getDirection());
				// },
			},
		});

		let modal = $("#tfindex-thuyen-form-popup");
		let closeBtn = $(".close")[0];

		closeBtn.onclick = function() {
			modal.hide();
		}

		$('.thuyen-swiper .tfindex-register').on('click', function (e) {
			const eventName = $(this).data("event");
			const tfindexEvent = $('#tfindex-event');
			tfindexEvent.val(eventName);
			tfindexEvent.prop( "disabled", true );
			modal.show();

			$( "#tfindex-form-events" ).submit(function( event ) {
				event.preventDefault();
				const url = 'https://script.google.com/macros/s/AKfycbxbE12PumehGNulS71v1yk8qxFauYJ92tDPNbtxK-MqdvrsIguUagzk5PGy6mKgoQOM/exec';
				const data = {
					event: eventName,
					name: $('#tfindex-register-name').val(),
					email: $('#tfindex-register-email').val(),
					phone: $('#tfindex-register-phone').val(),
				};
				$.ajax({
					url: url,
					method: "GET",
					dataType: "json",
					data: data
				}).done(function() {
					modal.hide();
				});
			});
		});

		$('.thuyen-widget .tablinks').on('click', function (e) {
			// Declare all variables
			let i, tabcontent, tablinks;

			const active = e.currentTarget.getAttribute('data-value');
			const firstTab = document.querySelector(".first-tab");
			const secondTab = document.querySelector(".second-tab");

			if (active === 'first-tab') {
				firstTab.style.display = "block";
				secondTab.style.display = "none";
			} else {
				firstTab.style.display = "none";
				secondTab.style.display = "block";
			}

			// Get all elements with class="tablinks" and remove the class "active"
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			e.currentTarget.className += " active";
		});
	};

	let WidgetChartHandler = function( $scope, $ ) {
		let chartNumOfSlides = 1;
		let chartSlidesPerView = 3;
		let chartSwiperThumb = new Swiper(".chart-swiper-thumb", {
			loop: false,
			spaceBetween: 24,
			allowTouchMove: false,
			slidesPerView: 3,
			grid: {
				rows: 2
			},
			// autoplay: true,
			// navigation: {
			// 	nextEl: ".swiper-button-next",
			// 	prevEl: ".swiper-button-prev",
			// },
			on: {
				beforeInit: function () {
					chartNumOfSlides = this.wrapperEl.querySelectorAll(".swiper-slide").length;
				}
			}
		});

		chartSwiperThumb.on('click', function (e) {
			e.preventDefault();
			let nexSlide = (e.clickedIndex + 1) % chartNumOfSlides;
			chartSwiper.slideTo(nexSlide, 1000);
		},true);

		let chartSwiper = new Swiper(".chart-swiper", {
			loop: true,
			spaceBetween: 30,
			slidesPerView: 1,
			freeMode: false,
			watchSlidesProgress: false,
			direction: "vertical",
			paginationClickable: false,
			allowTouchMove: false,
			thumbs: {
				swiper: chartSwiperThumb,
			},
		});
	};

	let WidgetTestimonialsHandler = function( $scope, $ ) {
		let numOfSlides = 1;
		let slidesPerView = 2;
		let swiperThumbs = new Swiper(".testimonials-swiper", {
			loop: true,
			spaceBetween: 30,
			slidesPerView: 1,
			// freeMode: true,
			watchSlidesProgress: false,
			// direction: "vertical",
			paginationClickable: false,
			// allowTouchMove: false,
			allowTouchMove: true,
			breakpoints: {
				730: {
					slidesPerView: slidesPerView,
					allowTouchMove: false,
					direction: "vertical",
				}
			},
			navigation: {
				nextEl: ".testimonials-next",
				prevEl: ".testimonials-prev",
			},
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

		const testimonialSwiper = new Swiper(".testimonials-swiper-content", {
			loop: true,
			spaceBetween: 10,
			direction: "horizontal",
			allowTouchMove: true,
			breakpoints: {
				730: {
					// slidesPerView: 2,
					allowTouchMove: false,
					direction: "vertical",
				},
			},
			thumbs: {
				swiper: swiperThumbs,
			},
			navigation: {
				nextEl: ".testimonials-next",
				prevEl: ".testimonials-prev",
			},
			on: {
				resize: function () {
					testimonialSwiper.changeDirection(getDirection());
				},
			},
		});
		function getDirection() {
			return window.innerWidth > 760 ? 'vertical' : 'horizontal';
		}
	};

	let WidgetStaffHandler = function( $scope, $ ) {
		let modal = $("#staff-popup-template");
		let closeBtn = $(".close")[0];
		let resultArray = [];

		let staffSwiper = new Swiper(".swiper.staff-swiper", {
			loop: true,
			slidesPerView: 1,
			spaceBetween: 30,
			breakpoints: {
				730: {
					slidesPerView: 2,
				},
				1024: {
					slidesPerView: 4,
					spaceBetween: 30,
				},
			},
		});

		// When the user clicks anywhere outside of the modal, close it
		// window.onclick = function(event) {
		// 	if (event.target == modal) {
		// 		modal.style.display = "none";
		// 	}
		// }

		closeBtn.onclick = function() {
			modal.hide();
		}

		staffSwiper.on('click', function (e) {
			modal.show();
			$('#staff-popup-template .modal-body').replaceWith($(e.clickedSlide).find('.content').clone());
		},true);

	};

	let WidgetCommitmentsHandler = function( $scope, $ ) {
		let numOfSlides = 1;
		let slidesPerView = 4;
		let swiperThumbs = new Swiper(".commitment-swiper-thumb", {
			loop: false,
			spaceBetween: 30,
			slidesPerView: 4,
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

		new Swiper(".commitment-swiper-content", {
			loop: true,
			spaceBetween: 10,
			direction: "vertical",
			allowTouchMove: false,
			thumbs: {
				swiper: swiperThumbs,
			},
		});
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/tfindex.default', WidgetTFindexHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/tftalk.default', WidgetTFTalkHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/thuyen.default', WidgetThuyenHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/chart.default', WidgetChartHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonials.default', WidgetTestimonialsHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/staff.default', WidgetStaffHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/commitment.default', WidgetCommitmentsHandler );
	} );

} )( jQuery );
