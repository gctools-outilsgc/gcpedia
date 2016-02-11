/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/*global confirm, prompt, collection_id, writer, wfCollectionSave */
( function ( $ ) {

/******************************************************************************/

/**
 * Return text of element with given selector. Optionally replace %PARAM% with value
 * of param. This allows usage of localization features in PHP from JavaScript.
 *
 * @param {string} id Element ID of element containing text
 * @param {string} [param] Text to replace %PARAM% with
 * @return {string} text of elment with ID id
 */
function gettext( sel, param ) {
	var txt = $( sel ).html();
	if ( param ) {
		txt = txt.replace( /%PARAM%/g, param );
	}
	return txt;
}

function req( func, args, callback ) {
	$.post( script_url, {
		'action': 'ajax',
		'rs': 'wfAjaxCollection' + func,
		'rsargs[]': args
	}, callback, 'json' );
}

var script_url = mw.util.wikiScript(),
	media_path = mw.config.get( 'wgExtensionAssetsPath' ) + '/Collection/images/',
	collapseicon = media_path + '/collapse.png',
	expandicon = media_path + '/expand.png',
	chapter_max_len = 200;

function getMWServeStatus() {
	$.getJSON( script_url, {
		'action': 'ajax',
		'rs': 'wfAjaxGetMWServeStatus',
		'rsargs[]': [ collection_id, writer ]
	}, function ( result ) {
		if ( result.state === 'progress' ) {
			if ( result.status.progress ) {
				$( '#renderingProgress' ).html(
					mw.language.convertNumber( result.status.progress )
				);
			}
			if ( result.status.status ) {
				var status = result.status.status;
				if ( result.status.article ) {
					status += gettext( '#renderingArticle', result.status.article );
				} else if ( result.status.page ) {
					status += gettext( '#renderingPage', result.status.page );
				}
				$( '#renderingStatus' ).html(
					gettext( '#renderingStatusText', status )
				);
			}
			setTimeout( getMWServeStatus, 500 );
		} else {
			location.reload( true );
		}
	} );
}

function clear_collection() {
	if ( confirm( gettext( '#clearCollectionConfirmText' ) ) ) {
		req( 'Clear',
			[],
			function ( result ) {
				$( '#titleInput, #subtitleInput' ).val( '' );
				refresh_list( result );
				req( 'GetBookCreatorBoxContent', [
					'showbook',
					null,
					mw.config.get( 'wgPageName' )
				], function ( result2 ) {
					$( '#coll-book_creator_box' ).html( result2.html );
				} );
			} );
	}
	return false;
}

function create_chapter() {
	var name = prompt( gettext( '#newChapterText' ) );
	if ( name ) {
		name = name.substring( 0, chapter_max_len );
		req( 'AddChapter', [ name ], refresh_list );
		update_buttons();
	}
	return false;
}

function rename_chapter( index, old_name ) {
	var new_name = prompt( gettext( '#renameChapterText' ), old_name );
	if ( new_name ) {
		new_name = new_name.substring( 0, chapter_max_len );
		req( 'RenameChapter', [ index, new_name ], refresh_list );
	}
	return false;
}

function remove_item( index ) {
	req( 'RemoveItem',
		[ index ],
		function ( result ) {
			refresh_list( result );
			req( 'GetBookCreatorBoxContent', [
				'showbook',
				null,
				mw.config.get( 'wgPageName' )
			], function ( result2 ) {
				$( '#coll-book_creator_box' ).html( result2.html );
			} );
		} );
	return false;
}

function set_titles() {
	var settings = {};
	$( '[id^="coll-input-setting-"]' ).each( function ( i, e ) {
		if ( $( e ).is( ':checkbox' ) ) {
			settings[e.name] = $( e ).is( ':checked' );
		} else {
			settings[e.name] = $( e ).val();
		}
	} );
	req( 'SetTitles', [
		$( '#titleInput' ).val(),
		$( '#subtitleInput' ).val(),
		JSON.stringify( settings )
	], function ( result ) {
		wfCollectionSave( result.collection );
	} );
	update_buttons();
	return false;
}

function set_sorting( items_string ) {
	req( 'SetSorting', [ items_string ], refresh_list );
	return false;
}

function update_buttons() {
	if ( $( '#collectionList .article' ).length === 0 ) {
		$( '#saveButton, #downloadButton, input.order' ).attr( 'disabled', 'disabled' );
		return;
	} else {
		$( '#downloadButton, input.order' ).removeAttr( 'disabled' );
	}
	if ( !$( '#saveButton' ).length ) {
		return;
	}
	if ( !$( '#communityCollTitle' ).length || $( '#personalCollType:checked' ).val() ) {
		$( '#personalCollTitle' ).removeAttr( 'disabled' );
		$( '#communityCollTitle' ).attr( 'disabled', 'disabled' );
		if ( !$.trim( $( '#personalCollTitle' ).val() ) ) {
			$( '#saveButton' ).attr( 'disabled', 'disabled' );
			return;
		}
	} else if ( !$( '#personalCollTitle' ).length || $( '#communityCollType:checked' ).val() ) {
		$( '#communityCollTitle' ).removeAttr( 'disabled' );
		$( '#personalCollTitle' ).attr( 'disabled', 'disabled' );
		if ( !$.trim( $( '#communityCollTitle' ).val() ) ) {
			$( '#saveButton' ).attr( 'disabled', 'disabled' );
			return;
		}
	}
	$( '#saveButton' ).removeAttr( 'disabled' );
}

function make_sortable() {
	$( '#collectionList' ).sortable( {
		axis: 'y',
		update: function () {
			set_sorting( $( '#collectionList' ).sortable( 'serialize' ) );
		}
	} );
	$( '#collectionList .sortableitem' ).css( 'cursor', 'move' );
}

function refresh_list( data ) {
	wfCollectionSave( data.collection );
	$( '#collectionListContainer' ).html( data.html );
	$( '.makeVisible' ).css( 'display', 'inline' );
	make_sortable();
	update_buttons();
}

function sort_items() {
	req( 'SortItems', [], refresh_list );
	return false;
}

$( function () {
	if ( $( '#collectionList' ).length ) {
		$( '.makeVisible' ).css( 'display', 'inline' );
		window.coll_create_chapter = create_chapter;
		window.coll_remove_item = remove_item;
		window.coll_rename_chapter = rename_chapter;
		window.coll_clear_collection = clear_collection;
		window.coll_sort_items = sort_items;
		update_buttons();
		make_sortable();
		$( '#coll-orderbox li.collection-partner.coll-more_info.collapsed' ).css(
			'list-style',
			'url("' + collapseicon + '")'
		);
		$( '#coll-orderbox' ).on(
			'click',
			'li.collection-partner.coll-more_info a.coll-partnerlink',
			function ( event ) {
			event.preventDefault();
			event.stopPropagation();
			var p = $( this ).parents( 'li.collection-partner' );
			if ( p.hasClass( 'collapsed' ) ) {
				p.css( 'list-style',  'url("' + expandicon + '")' );
				p.find( '.coll-order_info' ).css( 'display', 'block' );
				p.removeClass( 'collapsed' );
			} else {
				p.css( 'list-style', 'url("' + collapseicon + '")' );
				p.find( '.coll-order_info' ).css( 'display', 'none' );
				p.addClass( 'collapsed' );
			}
		} );
		$( '#personalCollTitle, #communityCollTitle' )
			.val( $( '#titleInput' ).val() )
			.change( update_buttons );
		$( '#personalCollType, #communityCollType' )
			.change( update_buttons );
		$( '#titleInput, #subtitleInput, [id^="coll-input-setting-"]' )
			.change( set_titles );
	}
	if ( typeof collection_rendering !== 'undefined' ) {
		getMWServeStatus();
	}
} );

} )( jQuery );
