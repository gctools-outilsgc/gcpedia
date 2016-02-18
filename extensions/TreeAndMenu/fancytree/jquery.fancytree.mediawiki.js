/*!
 * jquery.fancytree.mediawiki.js
 *
 * Add mediawiki-specific ajax loading and some mediawiki helper functions
 * (Extension module for jquery.fancytree.js: https://github.com/mar10/fancytree/)
 * - for samples of all events, see https://github.com/mar10/fancytree/blob/master/demo/sample-events.html
 *
 * Copyright (c) 2015, Aran Dunkley (http://www.organicdesign.co.nz/aran)
 *
 * Released under the GNU General Public Licence 2.0 or later
 *
 */
(function($, window, document, mw, undefined) {

	"use strict";

	/**
	 * Open the tree to the node containing the passed title, or current page if none supplied
	 */
	$.ui.fancytree._FancytreeClass.prototype.makeTitleVisible = function(title) {
		var local = this.ext.mediawiki;
		if(typeof(title) === 'undefined') title = mw.config.get('wgTitle');
		this.visit(function(node) {
			var nt = $('<div />').html(node.title);
			nt = $('a:first', nt).attr('title');
			if(nt == title) {
				node.makeVisible({ noAnimation: true, noEvents: true, scrollIntoView: false });
				node.setActive({ noEvents: true });
				return false;
			}
		});
	};

	/**
	 * Register the extension and set the lazy-loading up in a MediaWiki-friendly way
	 */
	$.ui.fancytree.registerExtension({

		name: "mediawiki",
		version: "1.0.0",
		options: {},

		// When a tree is initialised, do some modifications appropriate to mediawiki trees
		treeInit: function(ctx) {
			var tree = ctx.tree, opts = ctx.options;

			// If there's "ajax" in this nodes data, then it needs to be marked as lazy and the "ajax" removed
			opts.renderNode = function(event, data) {
				var node = data.node;
				if('ajax' in node.data) {
					node.lazy = true;
					node.children = null;
					node.setFocus(true);
					node.setFocus(false);
					node.data.url = node.data.ajax;
					delete node.data.ajax;
				}
			};

			// Lazy load event to collect child data from the supplied URL via ajax
			opts.lazyLoad = function(event, data) {
				var url = data.node.data.url;

				// Set result to a jQuery ajax options object
				data.result = {
					type: 'GET',
					dataType: 'text',
				};

				// If the ajax option is an URL, split it into main part and query-string
				if(url.match(/^(https?:\/\/|\/)/)) {
					var parts = url.split('?');
					data.result.url = parts[0];
					data.result.data = parts[1];
				}

				// Otherwise treat it as an article title to be read with action=render
				else {
					data.result.url = mw.util.wikiScript();
					data.result.data = { title: url, action: 'render' };
				}
			};

			// Parse the data collected from the Ajax response and make it into child nodes
			opts.postProcess = function(event, data) {
				var response = data.response, m;

				// If there's a UL section in it, parse it into nodes
				if(m = response.match(/^.*?(<ul[\s\S]+<\/ul>)/i)) data.result = $.ui.fancytree.parseHtml($(m[1]));

				// Otherwise see if it's as a JSON list of node data (need to extract as MediaWiki adds parser info)
				else if(m = response.match(/^.*?(\[[\s\S]+\])/i)) data.result = $.parseJSON(m[1]);

				// Otherwise see if it's as a JSON list of node data contained in an object (as it is in an API response)
				else if(m = response.match(/^\{/)) {
					var json = $.parseJSON(response);
					data.result = false;
					for( var k in json ) {
						if( data.result === false && typeof json[k] == 'array' ) data.result = json[k];
					}
				}

				// Otherwise just return an empty node set (should raise an error)
				else data.result = [];
			};

			return this._superApply(arguments);
		},
	});

}(jQuery, window, document, mw));
