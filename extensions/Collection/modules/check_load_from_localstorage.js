/*global confirm*/
( function ( mw, $ ) {

var script_url = mw.util.wikiScript();

$( function () {
	var c = $.jStorage.get( 'collection' ),
		num_pages = 0,
		shownTitle = '',
		message;
	if ( c ) {
		for ( var i = 0; i < c.items.length; i++ ) {
			if ( c.items[i].type === 'article' ) {
				num_pages++;
			}
		}
		if ( c.title ) {
			shownTitle = '("' + c.title + '")';
		}
		if ( num_pages ) {
			message = mw.msg( 'coll-load_local_book', shownTitle, num_pages );
			if ( confirm( message ) ) {
				$.post( script_url, {
					'action': 'ajax',
					'rs': 'wfAjaxPostCollection',
					'rsargs[]': [ JSON.stringify( c ) ]
				}, function ( result ) {
					location.href = result.redirect_url;
				}, 'json' );
			}
		}
	}
} );

} )( mw, jQuery );
