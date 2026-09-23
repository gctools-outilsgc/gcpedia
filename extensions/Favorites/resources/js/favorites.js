/**
 * Additional mw.Api methods to assist with (un)favoriting wiki pages.
 *
 * @param mw
 * @param $
 * @since 1.19
 */

( function ( mw, $ ) {

	/**
	 * @param page
	 * @param success
	 * @param err
	 * @param addParams
	 * @context {mw.Api}
	 * @return string
	 */
	function doFavoriteInternal( page, success, err, addParams ) {
		const params = {
			action: 'favorite',
			title: String( page ),
			token: mw.user.tokens.get( 'csrfToken' ),
			uselang: mw.config.get( 'wgUserLanguage' )
		};
		// eslint-disable-next-line no-unused-vars
		function ok( data ) {
			// this doesn't appear to be needed, and it breaks 1.23.
			// success( data.favorite );

		}
		if ( addParams ) {
			$.extend( params, addParams );
		}
		return this.post( params, { ok: ok, err: err } );
	}

	$.extend( mw.Api.prototype, {
		/**
		 * Convinience method for 'action=favorite'.
		 *
		 * @param page {String|mw.Title} Full page name or instance of mw.Title
		 * @param success {Function} Callback to which the favorite object will be passed.
		 * Favorite object contains properties 'title' (full pagename), 'favorited' (boolean) and
		 * 'message' (parsed HTML of the 'addedfavoritetext' message).
		 * @param err {Function} Error callback (optional)
		 * @return {jqXHR}
		 */
		favorite: function ( page, success, err ) {
			return doFavoriteInternal.call( this, page, success, err );
		},
		/**
		 * Convinience method for 'action=favorite&unfavorite=1'.
		 *
		 * @param page {String|mw.Title} Full page name or instance of mw.Title
		 * @param success {Function} Callback to which the favorite object will be passed.
		 * Favorite object contains properties 'title' (full pagename), 'favorited' (boolean) and
		 * 'message' (parsed HTML of the 'removedfavoritetext' message).
		 * @param err {Function} Error callback (optional)
		 * @return {jqXHR}
		 */
		unfavorite: function ( page, success, err ) {
			return doFavoriteInternal.call( this, page, success, err, { unfavorite: 1 } );
		}

	} );

}( mediaWiki, jQuery ) );
