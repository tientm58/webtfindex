( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */

	var owlResponsiveOne = {
		0 : {
			items:1,
		},
		480 : {
			items:2,
		},
		768 : {
			items:2,
		},
		1024 : {
			items:3,
		},
	}

	var owlResponsiveTwo = {
		0 : {
			items:1,
		},
		480 : {
			items: 1.3,
		},
		768 : {
			items: 1.75,
		},
		1024 : {
			items: 2.34,
		},
	}

	var WidgetTFIndexldHandler = function( $scope, $ ) {
		// console.log( $scope );
		var testimonials = $('.testimonials.owl-carousel');
		testimonials.owlCarousel({
			loop:true,
			margin:10,
			dots: false,
			nav:false,
			items: 3,
			responsive: owlResponsiveOne
		});

		// Custom Button
		$('.owl-custom-nav .owl-next').click(function() {
			// owl.trigger('next.owl.carousel');
			testimonials.trigger('next.owl.carousel');
		});
		$('.owl-custom-nav .owl-prev').click(function() {
			// owl.trigger('prev.owl.carousel');
			testimonials.trigger('prev.owl.carousel');
		});
	};

	var WidgetTFIndexServiceHandler = function( $scope, $ ) {
		var servicesStyleOne = $('.services-style-1.owl-carousel');
		var servicesStyleTwo = $('.services-style-2.owl-carousel');
		servicesStyleOne.owlCarousel({
			loop:true,
			margin:10,
			dots: false,
			nav:false,
			items: 3,
			responsive: owlResponsiveOne
		});

		servicesStyleTwo.owlCarousel({
			loop:true,
			margin:10,
			dots: false,
			nav:false,
			items: 2.34,
			responsive: owlResponsiveTwo
		});

		// Custom Button
		$('.owl-custom-nav .owl-next').click(function() {
			servicesStyleOne.trigger('next.owl.carousel');
			servicesStyleTwo.trigger('next.owl.carousel');
		});
		$('.owl-custom-nav .owl-prev').click(function() {
			servicesStyleOne.trigger('prev.owl.carousel');
			servicesStyleTwo.trigger('prev.owl.carousel');
		});
	};


	var WidgetTFIndexEventsHandler = function( $scope, $ ) {
		var events = $('.events.owl-carousel');
		events.owlCarousel({
			loop:true,
			margin:10,
			dots: false,
			nav:false,
			items: 2.34,
			responsive: owlResponsiveTwo
		});

		// Custom Button
		$('.owl-custom-nav .owl-next').click(function() {
			events.trigger('next.owl.carousel');
		});
		$('.owl-custom-nav .owl-prev').click(function() {
			events.trigger('prev.owl.carousel');
		});
	};

	var WidgetTFIndexQuestionsAnswerHandler = function( $scope, $ ) {
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var panel = this.nextElementSibling;
				if (panel.style.maxHeight) {
					panel.style.maxHeight = null;
				} else {
					panel.style.maxHeight = panel.scrollHeight + "px";
				}
			});
		}
	};

	var WidgetTFIndexPartners = function( $scope, $ ) {
		// var partners = $('.background-text');
		// console.log(partners)
	}
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/services.default', WidgetTFIndexServiceHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/testimonials.default', WidgetTFIndexldHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/events.default', WidgetTFIndexEventsHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/qas.default', WidgetTFIndexQuestionsAnswerHandler );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/partners.default', WidgetTFIndexPartners );
	} );

} )( jQuery );
