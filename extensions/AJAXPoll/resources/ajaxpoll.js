/*global $, mw, useAjax*/

var ajaxpollTmp;

var setupEventHandlers = function () {
	'use strict';
	$( '.ajaxpoll-answer-vote' ).on( 'mouseover', function () {
		var sp = $( this ).find( 'span' );
		ajaxpollTmp = sp.html();
		sp.text( sp.attr( 'title' ) );
		sp.attr( 'title', '' );
	} );

	$( '.ajaxpoll-answer-vote' ).on( 'mouseout', function () {
		var sp = $( this ).find( 'span' );
		sp.attr( 'title', sp.text() );
		sp.text( ajaxpollTmp );
	} );

	/* attach click handler */
	$( '.ajaxpoll-answer-name label' ).on( 'click', function ( event ) {
		var choice = $( this ).parent().parent(), poll, answer, token;
		event.preventDefault();
		event.stopPropagation();
		poll = choice.attr( 'poll' );
		answer = choice.attr( 'answer' );
		token = choice.parent().find( 'input[name="ajaxPollToken"]' ).val();
		choice.find( '.ajaxpoll-hover-vote' ).addClass( 'ajaxpoll-checkevent' );
		choice.find( 'input' ).prop( 'checked', 'checked' );
		$( '#ajaxpoll-ajax-' + poll ).text(mw.message( 'ajaxpoll-submitting' ).text() ).css( 'display', 'inline-block' );
		if ( useAjax ) {
			$.get( mw.util.wikiScript(), {
				action: 'ajax',
				rs: 'AJAXPoll::submitVote',
				rsargs: [ poll, answer, token ]
			}, function ( newHTML ) {
				$( '#ajaxpoll-container-' + poll ).html( newHTML );
				setupEventHandlers();
			} );
		} else {
			$( '#ajaxpoll-answer-id-' + poll ).submit();
		}
	} );

	$( '.ajaxpoll-answer-name:not(.ajaxpoll-answer-name-revoke) label').on( 'mouseover', function () {
		$( this ).addClass( 'ajaxpoll-hover-vote' );
	} );
	$( '.ajaxpoll-answer-name:not(.ajaxpoll-answer-name-revoke) label').on( 'mouseout', function () {
		$( this ).removeClass( 'ajaxpoll-hover-vote' );
	} );

	$( '.ajaxpoll-answer-name-revoke label' ).on( 'mouseover', function () {
		$( this ).addClass( 'ajaxpoll-hover-revoke' );
	} );
	$( '.ajaxpoll-answer-name-revoke label' ).on( 'mouseout', function () {
		$( this ).removeClass( 'ajaxpoll-hover-revoke' );
	} );
};
setupEventHandlers();