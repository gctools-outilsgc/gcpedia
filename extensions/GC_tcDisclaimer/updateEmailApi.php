<?php



class updateEmailApi extends ApiBase {
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
			'newEmail'	=> '',
			'userId'	=> -1,
			'language'	=> '');
	}
	function execute()
	{
		global $wgEnableEmail, $wgEmailAuthentication, $wgLang;

		$params = $this->extractRequestParams();

		$user = User::newFromId($params['userId']);
		$newEmail = $params['newEmail'];
		$newEmail = trim($newEmail);
		$oldEmail = $user->getEmail();
		$oldEmail = trim($oldEmail);

		$wgLang = Language::factory($params['language']);

		# returns true on success
		$validEmail = Sanitizer::validateEmail( $newEmail );
		
		if( $validEmail === true && $newEmail != $oldEmail ) {

			# set new email + invalidate it
			$user->setEmail( $newEmail );

			# update var for form output
			$currentEmail = $user->getEmail(); // $newEmail;
			
			if( $wgEmailAuthentication ) {
				# send confirmation email
				$result = $user->sendConfirmationMail();
				
				if( !$result->isOK() ) { //test me
					$err = wfMsg( 'mailerror', htmlspecialchars( $result->getMessage() ) );
				} else {
					$confmessage = wfMsg( 'emailupdate-confirm' );
				}
			}
			$user->saveSettings();

		} else {
			# get error
			if( $newEmail == $oldEmail ) {
				$err = wfMsg('emailupdate-duplicate-error');
			} else {
				$err = wfMsg('invalidemailaddress');
			}
		}
		
		if( $oldEmail != $newEmail ) {
			wfRunHooks( 'PrefsEmailAudit', array( $user, $oldEmail, $newEmail ) );
		}

		if ( $confmessage )
			$this->getResult()->addValue( null, $this->getModuleName(), $confmessage );
		else
			$this->getResult()->addValue( null, $this->getModuleName(), $err );
	
		return true;
	}
}

?>