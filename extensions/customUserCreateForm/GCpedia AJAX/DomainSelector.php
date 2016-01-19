<?php
/**
 * Used to create a text input field to replace the dropdown menu on the account creation page
 *
 * @return always returns "" because we use the response text directly
 *
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 */

$wgAjaxExportList[] = 'insertTextField';

function insertTextField() {
	
	$js = " var emailName = EmailName.value.replace(/ /g, '');
			if( emailName != '' && EmailDomain.value != ''){
				var email = emailName + '@' + EmailDomain.value;
				sajax_do_call( 'characterFilter', [email], function( strin ) { document.getElementById('wpEmail').value = strin.responseText; } );
				
				sajax_do_call( 'AJAXtest', [email] , function( strin ) { document.getElementById('wpName2').value = strin.responseText.replace(/^\s+|\s+$/g,''); document.getElementById('AJAXtest').value = strin.responseText; 
					if ( acceptv.value == 1  && wpPassword.value != '' && wpPassword.value == wpRetype.value ){
						wpCreateaccount.disabled=0;
					}
					else{
						wpCreateaccount.disabled=1;
					}
				}  );
			} else {
				wpName2.value = ''
				wpCreateaccount.disabled=1;
			}";
			
	$output = "<input type='text' name='EmailDomain' id='EmailDomain' tabindex='2' onblur=\"$js\" /> ";
	
	echo $output;
	
	return "";
}

?>
