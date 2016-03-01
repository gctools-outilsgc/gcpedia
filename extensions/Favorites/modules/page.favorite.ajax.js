/*
 * Animate favorite/unfavorite links to use asynchronous API requests to
 * favorite pages, rather than navigating to a different URI.
 */
( function ( mw, $ ) {
	
	// The name of the page to favorite or unfavorite.
	var title = mw.config.get( 'wgRelevantPageName' );

	/**
	 * Update the link text, link href attribute and (if applicable)
	 * "loading" class.
	 *
	 * @param $link {jQuery} Anchor tag of (un)favorite link.
	 * @param action {String} One of 'favorite', 'unfavorite'.
	 * @param state {String} [optional] 'idle' or 'loading'. Default is 'idle'.
	 */
	function updateFavoriteLink( $link, action, state ) {
		var msgKey, $li, otherAction;

		// A valid but empty jQuery object shouldn't throw a TypeError
		if ( !$link.length ) {
			return;
		}

		// Invalid actions shouldn't silently turn the page in an unrecoverable state
		if ( action !== 'favorite' && action !== 'unfavorite' ) {
			throw new Error( 'Invalid action' );
		}

		// message keys 'favorite', 'favoriteing', 'unfavorite' or 'unfavoriteing'.
		msgKey = state === 'loading' ? action + 'ing' : action;
		otherAction = action === 'favorite' ? 'unfavorite' : 'favorite';
		$li = $link.closest( 'li' );

		if ( state === undefined ) {
			$li.trigger( 'favoritepage.mw', otherAction );
		}

		$link
			.text( mw.msg( msgKey ) )
			.attr( 'title', mw.msg( 'tooltip-ca-' + action ) )
			.updateTooltipAccessKeys()
			.attr( 'href', mw.util.wikiScript() + '?' + $.param( {
					title: title,
					action: action
				} )
			);

		// Most common ID style
		if ( $li.prop( 'id' ) === 'ca-' + otherAction ) {
			$li.prop( 'id', 'ca-' + action );
		}

		if ( state === 'loading' ) {
			$link.addClass( 'loading' );
		} else {
			$link.removeClass( 'loading' );
		}
	}

	/**
	 * TODO: This should be moved somewhere more accessible.
	 *
	 * @private
	 * @param {string} url
	 * @return {string} The extracted action, defaults to 'view'
	 */
	function mwUriGetAction( url ) {
		var action, actionPaths, key, i, m, parts;

		// TODO: Does MediaWiki give action path or query param
		// precedence? If the former, move this to the bottom
		action = mw.util.getParamValue( 'action', url );
		if ( action !== null ) {
			return action;
		}

		actionPaths = mw.config.get( 'wgActionPaths' );
		for ( key in actionPaths ) {
			if ( actionPaths.hasOwnProperty( key ) ) {
				parts = actionPaths[key].split( '$1' );
				for ( i = 0; i < parts.length; i++ ) {
					parts[i] = $.escapeRE( parts[i] );
				}
				m = new RegExp( parts.join( '(.+)' ) ).exec( url );
				if ( m && m[1] ) {
					return key;
				}

			}
		}

		return 'view';
	}

	// Expose public methods
	mw.page.favorite = {
		updateFavoriteLink: updateFavoriteLink
	};

	$( function () {
		var $links = $( '.mw-favoritelink a, a.mw-favoritelink, ' +
			'#ca-favorite a, #ca-unfavorite a, #mw-unfavorite-link1, ' +
			'#mw-unfavorite-link2, #mw-favorite-link2, #mw-favorite-link1' );

		// Allowing people to add inline animated links is a little scary
		$links = $links.filter( ':not( #bodyContent *, #content * )' );

		$links.click( function ( e ) {
			var action, api, $link;

			// Start preloading the notification module (normally loaded by mw.notify())
			mw.loader.load( ['mediawiki.notification'], null, true );

			action = mwUriGetAction( this.href );

			if ( action !== 'favorite' && action !== 'unfavorite' ) {
				// Could not extract target action from link url,
				// let native browsing handle it further
				return true;
			}
			e.preventDefault();
			e.stopPropagation();

			$link = $( this );

			if ( $link.hasClass( 'loading' ) ) {
				return;
			}

			updateFavoriteLink( $link, action, 'loading' );
			api = new mw.Api();

			api[action]( title )
			
				.done( function ( favoriteResponse ) {
					
					var otherAction = action === 'favorite' ? 'unfavorite' : 'favorite';
					mw.notify( $.parseHTML( favoriteResponse.favorite.message ), {
						tag: 'favorite-self'
					} );

					// Set link to opposite
					updateFavoriteLink( $link, otherAction );

				} )
				.fail( function () {
					var cleanTitle, msg, link;
					// Reset link to non-loading mode
					updateFavoriteLink( $link, action );

					// Format error message
					cleanTitle = title.replace( /_/g, ' ' );
					link = mw.html.element(
						'a', {
							href: mw.util.getUrl( title ),
							title: cleanTitle
						}, cleanTitle
					);
					msg = mw.message( 'favoriteerrortext', link );

					// Report to user about the error
					mw.notify( msg, { tag: 'favorite-self' } );
				} );
		} );
	} );

}( mediaWiki, jQuery ) );

