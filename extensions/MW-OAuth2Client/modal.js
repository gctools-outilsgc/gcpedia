/* Any JavaScript here will be loaded for all users on every page load. */
$('li#pt-anon_oauth_login a').click(function(){
	articlePath = mw.config.get('wgArticlePath');
	url = articlePath.replace('$1', 'Special:OAuth2Client/redirect?returnto=Special:OAuth2Client/close');
	var left = (screen.width/2) - 200;
	var above = (screen.height/2) - 200;
	newwindow = window.open(url, "_blank", "resizable=yes, scrollbars=yes, titlebar=yes, width=400, height=400, top="+above+", left="+left);
	return false;
})

if (mw.config.get('wgTitle') == 'OAuth2Client/close') {
	window.opener.location.reload();
	window.close();
}
