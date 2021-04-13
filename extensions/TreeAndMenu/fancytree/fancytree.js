/**
 * This code pre-processes trees and menus to integrate the third-party code into mediawiki without changing it
 */
$(document).ready(function(){

	"use strict";

	var id = 0; // unique ID for all tree LI elements

	// This can be called again later and any unprepared trees and menus will get prepared
	// - this was done so that trees and menus can work when received via Ajax such as in a live preview
	window.prepareTAM = function() {
		var inner;

		/**
		 * Prepare trees
		 */
		$('.fancytree.todo').each(function() {

			// Remove the todo class from this tree (allows new trees laoded via ajax to be processed too)
			$(this).removeClass('todo');

			// Get options passed to the parser-function from span
			var div = $('div.opts', $(this));
			var opts = {};
			if(div.length > 0) {
				opts = $.parseJSON(div.text());
				div.remove();
			}

			// Add the mediawiki extension
			if('extensions' in opts) opts['extensions'].push('mediawiki');
			else opts['extensions'] = ['mediawiki'];

			// Activate the tree
			$(this).fancytree(opts);
		});

		/**
		 * Prepare menus (add even and odd classes)
		 */
		$('.suckerfish.todo').each(function() {
			$(this).removeClass('todo');
			$('li', this).each(function() {
				var li = $(this);
				li.addClass( (li.index()&1) ? 'odd' : 'even' );
			});
		});
	};

	// Prepare any trees and menus loaded in page that need preparing now
	window.prepareTAM();

});

// Preload the tree icons and loader
var path = mw.config.get('wgExtensionAssetsPath') + '/TreeAndMenu/fancytree';
(new Image()).src = path + '/loading.gif';
(new Image()).src = path + '/icons.gif';
