<?php
/**
 * FindUsernameAJAX.php
 * User search by email
 * 		php file for ajax
 * 
 * Author: Ilia Salem
 * updated for MW1.26
 */
 
class findUsernameAJAX extends ApiBase
{
	/**
	 * Returns an array of allowed parameters (parameter name) => (default
	 * value) or (parameter name) => (array with PARAM_* constants as keys)
	 * Don't call this function directly: use getFinalParams() to allow
	 * hooks to modify parameters as needed.
	 *
	 * Some derived classes may choose to handle an integer $flags parameter
	 * in the overriding methods. Callers of this method can pass zero or
	 * more OR-ed flags like GET_VALUES_FOR_HELP.
	 *
	 * @return array
	 */
	protected function getAllowedParams( /* $flags = 0 */ ) {
		// int $flags is not declared because it causes "Strict standards"
		// warning. Most derived classes do not implement it.
		return array(
			'emailinput' => '');
	}


	public function execute() {
		// extract request parameters
		$params = $this->extractRequestParams();
		$emailInput = $params['emailinput'];

		global $wgLang;
		$output = "";
		$dbr = wfGetDB( DB_SLAVE ); 
		
		// count the number of occurances of email - disabled, to be used later if necessary
		/*$queryc = "SELECT count(*) FROM " .$dbr->tableName('user') ." WHERE user_email = \"". $q ."\"";

		$resultc = $dbr->doQuery($queryc);
		$rowc = $dbr->fetchRow($resultc);*/
		$emailQuery = $dbr->addQuotes($emailInput);
		
		// find and return the FIRST username associated with the email
		$result = $dbr->select( $dbr->tableName('user'), 'user_name', 'user_email = ' . $emailQuery, __METHOD__, array() );
		
		$row = $dbr->fetchRow($result);
		
		if($row){
			$output = $row[0];
		}else{
			if($wgLang->getCode() == 'fr') {
				$output = "Nom d'utilisateur n'existe pas"; // Translated; verify
			}else{
				$output = "Username not found";
			}
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $output );
		
		return "";
	}
	
}
 
 ?>