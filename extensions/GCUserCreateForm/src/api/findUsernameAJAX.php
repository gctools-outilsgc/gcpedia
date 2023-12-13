<?php
/**
 * FindUsernameAJAX.php
 * User search by email
 * 		php file for ajax
 * 
 * Author: Ilia Salem
 * updated for MW1.40
 */
use MediaWiki\MediaWikiServices;
 
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

		if ( !Sanitizer::validateEmail( $emailInput ) ){
			$this->getResult()->addValue( null, $this->getModuleName(), "418" );
			return 1;
		}
		
		$dbProvider = MediaWikiServices::getInstance()->getDBLoadBalancerFactory();
		$dbr = $dbProvider->getReplicaDatabase();
		
		// find and return the FIRST username associated with the email
		$row = $dbr->newSelectQueryBuilder()
		->select( ['user_name'] )
		->from( 'user' )
		->where( [ 'user_email' => $emailInput ] )
		->caller( __METHOD__ )->fetchRow();
		
		if($row){
			$output = $row->user_name;
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