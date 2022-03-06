( function( $ ) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetTFIndexTestimonialsldHandler = function( $scope, $ ) {
        // console.log( $scope );
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            items: 2.5,
        });

        // Custom Button
        $('.customNextBtn').click(function() {
            owl.trigger('next.owl.carousel');
        });
        $('.customPreviousBtn').click(function() {
            owl.trigger('prev.owl.carousel');
        });
    };

    // Make sure you run this code under Elementor.
    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/tfindex.default', WidgetTFIndexldHandler );
    } );

} )( jQuery );
