<?php
/**
 * Email character filter
 *
 * Filters out the french characters in an email and replaces them with the english equivelant
 * Array key is the character to remove and the associated item is what will replace it.
 *
 * @param  $emailInput <string> users email address
 *
 * @return always returns "" because we use the response text directly
 *
 * @author Matthew April <Matthew.April@tbs-sct.gc.ca>
 */

class characterFilterAJAX extends ApiBase 
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

	function execute() {
		// extract request parameters
		$params = $this->extractRequestParams();
		$email = $params['emailinput'];

		$filter = array(
		
			'â' => 'a',
			'à' => 'a',
			'á' => 'a',
			'ç' => 'c',
			'ê' => 'e',
			'é' => 'e',
			'è' => 'e',
			'ô' => 'o',
			'Â' => 'A',
			'À' => 'A',
			'Á' => 'A',
			'Ç' => 'C',
			'Ê' => 'E',
			'É' => 'E',
			'È' => 'E',
			'Ô' => 'O',
		);
		
		foreach( $filter as $remove => $replace ) {
			if( strpos( $email, $remove) ) {
				$email = str_replace($remove, $replace, $email);
			}
		}
		$this->getResult()->addValue( null, $this->getModuleName(), $email );
		return "";
	}
}

?>