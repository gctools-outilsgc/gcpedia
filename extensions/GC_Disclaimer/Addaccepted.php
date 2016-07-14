<?php
/**
 *
 * adds user to the accepted table
 *
 */


$wgHooks['AddNewAccount'][] = 'Addnewuser';
function Addnewuser( $user )
{

	$dbr = wfGetDB( DB_MASTER );
	
	$queryString = "INSERT INTO `accepted` (Username, date) VALUES (\"". $user->getName() ."\", '".date("d.m.y")."')";
	
	$result = $dbr->query($queryString);
	
	
	return true;
	
}

class AddAccepted extends ApiBase {
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
			'username' => '');
	}
	function execute()
	{
		require_once('dbdisclaimer.php');
		$dbw = wfGetDB( DB_MASTER );
		
		// extract request parameters
		$params = $this->extractRequestParams();
		$q = $params['username'];

		$queryString = "SELECT 1 FROM `accepted`  WHERE Username = '".$q."'";
		$result = $dbw->query($queryString);
		$row = $dbw->fetchRow( $result );
		
		if($row[0]!='')
		{
			$queryString = "UPDATE IGNORE `accepted` SET date = '".date("d.m.y")."' WHERE Username = '".$q."'";
			$dbw->query($queryString);
		}	
		else
		{
			$queryString = "INSERT INTO `accepted` (Username, date) VALUES (\"".$q."\", '".date("d.m.y")."')";
			$dbw->query($queryString);
		}	
		
		return true;
		
	}
}

?>