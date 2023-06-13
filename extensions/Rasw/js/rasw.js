(function () {
//Prototypes for IE
//console.log("Inside JS");
if (!String.prototype.startsWith) {
  String.prototype.startsWith = function(searchString, position) {
    position = position || 0;
    return this.indexOf(searchString, position) === position;
  };
}
if (!String.prototype.endsWith) {
  String.prototype.endsWith = function(searchString, position) {
    var subjectString = this.toString();
    if (typeof position !== 'number' || !isFinite(position) || Math.floor(position) !== position || position > subjectString.length) {
      position = subjectString.length;
    }
    position -= searchString.length;
    var lastIndex = subjectString.lastIndexOf(searchString, position);
    return lastIndex !== -1 && lastIndex === position;
  };
}
var oScrollbar = $('.recentactivity');
//Test if anchor exists on page before doing anything)
if (oScrollbar.length > 0) {
	//console.log("scrollbar length >0");
	// First time parse
	//setTimeout(function(){
		//Find if normal or category
		category = $('.rasw-param').attr('id');
		//console.log("Category="+category);
		if ( category ) {
			//Call our own API
			recentLinks = JSON.parse(
				$.ajax({
					url:mw.util.wikiScript('api'),
					//data: { action: 'query', format: 'json', list:'categoryrecentchanges',rcshow: '!minor', rclimit:100 },
					data: { action: 'query', format: 'json', list:'categoryrecentchanges',crccategory: category },
					async:false
				}).responseText
			);
		} else {
			//Call MW API
			recentLinks = JSON.parse(
				$.ajax({
					url:mw.util.wikiScript('api'),
					data: { action: 'query', format: 'json', list:'recentchanges',rcshow: '!minor', rclimit:100 },
					async:false
				}).responseText
			);
		}
		//console.log("After ajax call");
		placeholder = '<span id="recentchangebox">';
		// Store time of the most recent change as time anchor for the next iteration
		if (category) {
			timeanchor = new Date(recentLinks.query.categoryrecentchanges[0].timestamp).getTime()/1000+1;
		} else {
			timeanchor = new Date(recentLinks.query.recentchanges[0].timestamp).getTime()/1000+1;
		}
		now = parseInt(new Date().getTime()/1000);
		//console.log('Timeanchor='+timeanchor);
		// the page_ids array is used to prevent mutliple modifications for the same page from taking over the feed
		page_ids = [];
		if (category) {
			for (i=0; i < recentLinks.query.categoryrecentchanges.length; i++ ) {
				page_id = recentLinks.query.categoryrecentchanges[i].pageid;
				mw_type = recentLinks.query.categoryrecentchanges[i].type;
				//console.log('i='+i+' type='+mw_type);
				title = recentLinks.query.categoryrecentchanges[i].title;
				title_uri = encodeURIComponent(title);
				// Do not show certain types in mods
				if (title.endsWith(".js") ||
				    title.endsWith(".css") ||
				    title.startsWith("Template:") ||
				    title.startsWith("User:")) {
				    //title.startsWith("Sandbox:")) {
					continue;
				}
				// Format time
				unixtime = parseInt(new Date(recentLinks.query.categoryrecentchanges[i].timestamp).getTime()/1000);
				if (now-unixtime < 24*3600) {
					ts = moment(recentLinks.query.categoryrecentchanges[i].timestamp).fromNow();
				} else {
					ts = "on "+moment(recentLinks.query.categoryrecentchanges[i].timestamp).format("YYYY[/]MM[/]DD");
				}
				if (mw_type == 'edit') {
					if ( i == 0 || page_ids.indexOf(page_id) == -1 ) {
						placeholder = placeholder + "<div class='mw-page-item' id='"+page_id+"'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title_uri +"' class='mw-changeslist-title'>"+ title + "</a></span> was modified  "+ts+"</div>";
						page_ids.push(page_id);
					}
				} else if (mw_type == 'new') {
					placeholder = placeholder + "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title_uri +"' class='mw-changeslist-title'>"+ title + "</a></span> was created  "+ts+"</div>";
				} else if (mw_type == 'log') {
					if (title.startsWith('File:','')) {
						placeholder = placeholder + "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' class='mw-changeslist-title'>"+ title + "</a></span> was uploaded  "+ts+"</div>";
					}
				}
			};
		} else {
			for (i=0; i < recentLinks.query.recentchanges.length; i++ ) {
				page_id = recentLinks.query.recentchanges[i].pageid;
				mw_type = recentLinks.query.recentchanges[i].type;
				//console.log('i='+i+' type='+mw_type);
				title = recentLinks.query.recentchanges[i].title;
				title_uri = encodeURIComponent(title);
				// Do not show certain types in mods
				if (title.endsWith(".js") ||
				    title.endsWith(".css") ||
				    title.startsWith("Template:") ||
				    title.startsWith("User:")) {
				    //title.startsWith("Sandbox:")) {
					continue;
				}
				// Format time
				unixtime = parseInt(new Date(recentLinks.query.recentchanges[i].timestamp).getTime()/1000);
				if (now-unixtime < 24*3600) {
					ts = moment(recentLinks.query.recentchanges[i].timestamp).fromNow();
				} else {
					ts = "on "+moment(recentLinks.query.recentchanges[i].timestamp).format("YYYY[/]MM[/]DD");
				}
				if (mw_type == 'edit') {
					if ( i == 0 || page_ids.indexOf(page_id) == -1 ) {
						placeholder = placeholder + "<div class='mw-page-item' id='"+page_id+"'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title_uri +"' class='mw-changeslist-title'>"+ title + "</a></span> was modified  "+ts+"</div>";
						page_ids.push(page_id);
					}
				} else if (mw_type == 'new') {
					placeholder = placeholder + "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title_uri +"' class='mw-changeslist-title'>"+ title + "</a></span> was created  "+ts+"</div>";
				} else if (mw_type == 'log') {
					if (title.startsWith('File:','')) {
						placeholder = placeholder + "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' class='mw-changeslist-title'>"+ title + "</a></span> was uploaded  "+ts+"</div>";
					}
				}
			};
		};
		placeholder = placeholder + '</span>';
		$('.overview').append(placeholder);
		$('.viewport').height('22em');
		//console.log('scrollbar length='+oScrollbar.length);
		if (oScrollbar.length > 0) {
			oScrollbar.tinyscrollbar();
			oScrollbar.tinyscrollbar_update({size: 'auto'});
		}
	//},5000);
	mw_timeanchor=new Date(timeanchor*1000).toISOString();
	//console.log('mw_timeanchor='+mw_timeanchor);
	if (category) {
		setInterval(function(){
			//console.log("Inside setInterval");
			newRecentLinks = JSON.parse(
				$.ajax({
					url:mw.util.wikiScript('api'),
					//api.php?action=query&list=recentchanges&rcshow=!minor&rclimit=100&rcend=2017-03-24T17:11:35Z
					data: { action: 'query', format: 'json', list:'categoryrecentchanges',crccategory: category, crcend:mw_timeanchor },
					async:false
				}).responseText
			);
			now = parseInt(new Date().getTime()/1000);
			if (newRecentLinks.query.categoryrecentchanges && newRecentLinks.query.categoryrecentchanges.length>0) {
				timeanchor = new Date(newRecentLinks.query.categoryrecentchanges[0].timestamp).getTime()/1000+1;
				mw_timeanchor=new Date(timeanchor*1000).toISOString();
				//console.log("Results received");
				var i=0; var timer = setInterval(
					function() {
						mw_type = newRecentLinks.query.categoryrecentchanges[i].type;
						title = newRecentLinks.query.categoryrecentchanges[i].title;
						title_uri = encodeURIComponent(title);
						page_id = newRecentLinks.query.categoryrecentchanges[i].pageid;
						// Do not show certain types in mods
						if (!title.endsWith(".js") ||
						    !title.endsWith(".css") ||
						    !title.startsWith("Template:") ||
						    !title.startsWith("User:")) {
						    //!title.startsWith("Sandbox:")) {
							unixtime = parseInt(new Date(newRecentLinks.query.categoryrecentchanges[i].timestamp).getTime()/1000);
							if (now-unixtime < 24*3600) {
								ts = moment(newRecentLinks.query.categoryrecentchanges[i].timestamp).fromNow();
							} else {
								ts = "on "+moment(newRecentLinks.query.categoryrecentchanges[i].timestamp).format("YYYY[/]MM[/]DD");
							}
							if (mw_type == 'edit') {
								placeholder = "<div class='mw-page-item' id='"+page_id+"'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title_uri +"' class='mw-changeslist-title'>"+ title + "</a></span> was modified  "+ts+"</div>";
							} else if (mw_type == 'new') {
								placeholder = "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title +"' class='mw-changeslist-title'>"+ title + "</a></span> was created "+ts+"</div>";
							} else if (mw_type == 'log') {
								if (title.startsWith('File:','')) {
									placeholder = "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' class='mw-changeslist-title'>"+ title + "</a></span> was uploaded "+ts+"</div>";
								}
							}
							if (page_ids.indexOf(page_id) != -1 ) {
								$('#recentchangebox #'+page_id).remove();
								$('#recentchangebox').prepend(placeholder);
								$('#recentchangebox div:first').slideUp( function () { $(this).prependTo($('#recentchangebox')).slideDown(); });								
							} else {
								$('#recentchangebox').prepend(placeholder);
								$('#recentchangebox div:first').slideUp( function () { $(this).prependTo($('#recentchangebox')).slideDown(); });
								if (tbr_page_id = $('#recentchangebox>.mw-page-item:last').attr('id')) {
									page_ids.splice(page_ids.indexOf(tbr_page_id, 1));
								}
								if (mw_type == 'edit') {
									page_ids.push(page_id);
								}
								$('#recentchangebox>.mw-page-item:last').remove();
							}
						}
						if(++i > newRecentLinks.query.categoryrecentchanges.length-1) clearInterval(timer);
				},4900)
			}
		},60000);
	} else {
		setInterval(function(){
			//console.log("Inside setInterval");
			newRecentLinks = JSON.parse(
				$.ajax({
					url:mw.util.wikiScript('api'),
					//api.php?action=query&list=recentchanges&rcshow=!minor&rclimit=100&rcend=2017-03-24T17:11:35Z
					data: { action: 'query', format: 'json', list:'recentchanges',rcshow: '!minor', rcend:mw_timeanchor },
					async:false
				}).responseText
			);
			now = parseInt(new Date().getTime()/1000);
			if (newRecentLinks.query.recentchanges && newRecentLinks.query.recentchanges.length>0) {
				timeanchor = new Date(newRecentLinks.query.recentchanges[0].timestamp).getTime()/1000+1;
				mw_timeanchor=new Date(timeanchor*1000).toISOString();
				//console.log("Results received");
				var i=0; var timer = setInterval(
					function() {
						mw_type = newRecentLinks.query.recentchanges[i].type;
						title = newRecentLinks.query.recentchanges[i].title;
						title_uri = encodeURIComponent(title);
						page_id = newRecentLinks.query.recentchanges[i].pageid;
						// Do not show certain types in mods
						if (!title.endsWith(".js") ||
						    !title.endsWith(".css") ||
						    !title.startsWith("Template:") ||
						    !title.startsWith("User:")) {
						    //!title.startsWith("Sandbox:")) {
							unixtime = parseInt(new Date(newRecentLinks.query.recentchanges[i].timestamp).getTime()/1000);
							if (now-unixtime < 24*3600) {
								ts = moment(newRecentLinks.query.recentchanges[i].timestamp).fromNow();
							} else {
								ts = "on "+moment(newRecentLinks.query.recentchanges[i].timestamp).format("YYYY[/]MM[/]DD");
							}
							if (mw_type == 'edit') {
								placeholder = "<div class='mw-page-item' id='"+page_id+"'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title_uri +"' class='mw-changeslist-title'>"+ title + "</a></span> was modified  "+ts+"</div>";
							} else if (mw_type == 'new') {
								placeholder = "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' title='"+ title +"' class='mw-changeslist-title'>"+ title + "</a></span> was created "+ts+"</div>";
							} else if (mw_type == 'log') {
								if (title.startsWith('File:','')) {
									placeholder = "<div class='mw-page-item'><span class='mw-title'><a href='/index.php?title=" + title_uri + "' class='mw-changeslist-title'>"+ title + "</a></span> was uploaded "+ts+"</div>";
								}
							}
							if (page_ids.indexOf(page_id) != -1 ) {
								$('#recentchangebox #'+page_id).remove();
								$('#recentchangebox').prepend(placeholder);
								$('#recentchangebox div:first').slideUp( function () { $(this).prependTo($('#recentchangebox')).slideDown(); });								
							} else {
								$('#recentchangebox').prepend(placeholder);
								$('#recentchangebox div:first').slideUp( function () { $(this).prependTo($('#recentchangebox')).slideDown(); });
								if (tbr_page_id = $('#recentchangebox>.mw-page-item:last').attr('id')) {
									page_ids.splice(page_ids.indexOf(tbr_page_id, 1));
								}
								if (mw_type == 'edit') {
									page_ids.push(page_id);
								}
								$('#recentchangebox>.mw-page-item:last').remove();
							}
						}
						if(++i > newRecentLinks.query.recentchanges.length-1) clearInterval(timer);
				},4900)
			}
		},60000);
	}
};
})();
