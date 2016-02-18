/**
 * Javascript handler for the Lingo extension
 *
 * @author Stephan Gambke
 */

/*global jQuery, mediaWiki */
/*global confirm */

( function ( $, mw ) {

	'use strict';

	$( function ( $ ) {

		$( '.mw-lingo-tooltip' ).each( function ( index ) {

			var tooltip = $( this ).find( '.mw-lingo-tooltip-tip' );

			$( this ).qtip( {
				content : tooltip.html(),
				position: {
					my: 'top left',  // Position tooltip's top left...
					at: 'bottom left' // at the bottom left of target
				},
				hide    : {
					fixed: true,
					delay: 300
				},
				style   : {
					classes: tooltip.attr( 'class' ) + ' qtip-shadow',
					def    : false
				}

			} );

			tooltip.remove();

		} );

	} );
}( jQuery, mediaWiki ) );
