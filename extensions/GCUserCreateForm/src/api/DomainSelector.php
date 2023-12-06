<?php
/**
 * Used to create a text input field to replace the dropdown menu on the account creation page
 *
 * @return always returns "" because we use the response text directly
 *
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 */
class domainSelector extends ApiBase 
{

	function execute() {
		
		$js = " 
		const EmailName = document.getElementById('mw-input-wpemailname');
		const EmailDomain = document.getElementById('mw-input-wpemaildomain');
		const emailName = EmailName.value.replace(/ /g, '');
	
		if ( emailName != '' ){
			var email = emailName + '@' + EmailDomain.value;
			mw.loader.using( 'mediawiki.api', function () {
				( new mw.Api() ).get( {
					action: 'characterfilterajax',
					emailinput: email,
				} ).done( function ( data ) {
					document.getElementById('wpEmail').value = data.characterfilterajax;
				} );
			} );
			
			mw.loader.using( 'mediawiki.api', function () {
				( new mw.Api() ).get( {
					action: 'generateusernameajax',
					emailinput: email,
				} ).done( function ( data ) {
					document.getElementById('wpName2').value = data.generateusernameajax.replace(/^\s+|\s+$/g,'');
				} );
			} );
		}";
				
		$output = "@ <input type='text' name='EmailDomain' id='mw-input-wpemaildomain' tabindex='2' onblur=\"$js\" /> ";
		
		$this->getResult()->addValue( null, $this->getModuleName(), $output );
		
		return "";
	}
}

?>
