/*
 * Copyright (c) 2016 The MITRE Corporation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

( function ( mw ) {
	mw.loader.using( [ 'mediawiki.Uri', 'mediawiki.Title' ], function () {
		var pageName = mw.config.get( 'wgPageName' );
		var uri = new mw.Uri();
		if ( mw.config.get( 'wgCanonicalNamespace' ) === 'Special' ) {
			var specialPageName = mw.config.get( 'wgCanonicalSpecialPageName' );
			if ( specialPageName === 'Userlogin' ) {
				return;
			} else if ( specialPageName === 'Badtitle' ) {
				if ( uri.query.title === undefined ) {
					var articlePath = mw.config.get( 'wgArticlePath' );
					articlePath = articlePath.replace( '$1', '(.*)' );
					var re = new RegExp( articlePath );
					var path = uri.path;
					var matches = path.match( re );
					if ( matches.length > 1 ) {
						pageName = matches[1];
					} else {
						pageName = mw.config.get( 'wgMainPageName' );
					}
				} else {
					pageName = uri.query.title;
				}
			}
		}
		delete uri.query.title;
		var query = uri.getQueryString();
		var namespace = mw.config.get( 'wgNamespaceIds' ).special;
		var title = mw.Title.makeTitle( namespace, 'Userlogin' );
		var loginUrl = title.getUrl( { returnto: pageName, returntoquery: query } );
		window.location = loginUrl;
	} );
}( mediaWiki ) );
