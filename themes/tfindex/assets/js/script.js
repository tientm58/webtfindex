// eslint-disable-next-line no-undef
jQuery( document ).ready( function( $ ) {
	'use strict';

	// Format currency input
	$( function() {
		const $form = $( '.wpforms-form' );
		const $input = $form.find( '.form-money input' );
		const $textarea = $form.find( 'textarea' );
		const $select = $form.find( '.wpforms-field-select select' );

		$input.on( 'keyup', function( event ) {
			// When user select text in the document, also abort.
			const selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}

			// When the arrow keys are pressed, abort.
			if ( $.inArray( event.keyCode, [ 38, 40, 37, 39 ] ) !== -1 ) {
				return;
			}

			const $this = $( this );

			// Get the value.
			let input = $this.val();

			input = input.replace( /[\D\s\._\-]+/g, '' );
			input = input ? parseInt( input, 10 ) : 0;

			$this.val( function() {
				return ( input === 0 ) ? '' : input.toLocaleString();
			} );
		} );

		$select.change( function( event ) {
			if ( $( this ).val() === 'Khác' ) {
				$textarea.show( 50 );
			} else {
				$textarea.hide( 50 );
			}
		} );
	} );
} );
