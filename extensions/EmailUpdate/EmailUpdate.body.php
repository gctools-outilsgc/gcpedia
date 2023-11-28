<?php
///Special page class for the EmailUpdate Extension
/**
 * Allows admins to change a users email & send out a new confirmation email.
 *
 * @addtogroup Extensions
 * @author Matthew.April <Matthew.JApril@gmail.com>
 *
 */
class EmailUpdate extends SpecialPage {
	
		
	public function __construct() {
		parent::__construct('EmailUpdate','emailupdate');
	}
	
	///Main class function, handles logic and output
	/**
	 *
	 * @param $par optional string defined by the url
	 *
	 * @return returns true on execution, false on bad permission
	 */
	function execute( $par ) {
		global $wgRequest, $wgParser, $wgUser;
		
		$output = $this->getOutput();

		if( !$wgUser->isAllowed( 'emailupdate' ) ) {
			$output->showPermissionsErrorPage( ['emailupdate'] );
			return false;
		}
		
		$output->setPagetitle('Email Update'); //i18n
		$posted = $wgRequest->wasPosted();
		$out = "";
		
		if( $posted || isset( $par ) ) {
			
			if( isset( $par ) ) {
				$userName = $par;
			} else {
				$userName = $wgRequest->getText('UserSearch');
			}
			
			$newEmail = $wgRequest->getText('NewEmail');
			
			# page header
			$out .= $this->displaySearchForm( $userName );
			$out .= "<hr /><br />";
			
			if( isset( $userName ) ) { //should always be set, check anyway
				
				
				$userId = User::idFromName( $userName );
				
				if( isset( $userId ) && $userId != 0 ) {
				# user exists
					
					$user = new User();
					$user->mId = $userId;
					$user->loadFromId();
					
					if ( isset( $newEmail ) && $newEmail != '' ) { 
					# email was updated
						
						
						$autoConfirm = $wgRequest->getCheck( 'AutoConfirm' );
						
						$res = $this->updateEmail( $user, $newEmail, $autoConfirm );
						
					}
					
					$out .= $this->displayUpdateForm( $user );
					$out .= $this->displayInfoTable( $user );
					
					if( isset( $res ) ) {
						if( $res === true ) {
							$out .= "<div class='successbox'>". $this->msg('emailupdate-success') ."</div>";
						} elseif( $res === false) {
							$out .= "<div class='error'>". $this->msg( 'invalidemailaddress', 'parseinline' ) ."</div>";
						} else {
							$out .= "<div class='error'>". $res ."</div>";
						}
					}
					
					
				} else {
				# user does not exist
					$err = $this->msg('emailupdate-notfound');
					$out .= "<div class='error'>" . $err . "</div>";
				}
				
			}
			
			
		} else {
			
			# search form output
			$out .= $this->displaySearchForm();
		
		}
		
		$output->addHTML( $out );
		
		return true;
		
	}
	
	///Function to generate the HTML for the search form
	/**
	 *
	 * @param $value String search field value (optional)
	 *
	 * @return String HTML Form
	 */
	function displaySearchForm( $value = '' ) {
		global $wgTitle;
	
		$action = htmlspecialchars( $wgTitle->getLocalUrl() ); //form submit
		$usernameLabel = $this->msg('emailupdate-username');
		$searchButton = $this->msg('search');
		
		$form = "<br />
				<form method='POST' action='$action'>
					$usernameLabel <input type='text' name='UserSearch' id='UserSearch' value='$value' />
					<input type='submit' name='SearchSubmit' id='SearchSubmit' value='$searchButton' />
				</form>
				<br />";
		
		return $form;
	}
	
	///Function to generate the HTML for the email update form
	/**
	 *
	 * @param $user object
	 *
	 * @return String HTML Form
	 */
	function displayUpdateForm( $user ) {
		global $wgTitle;
		
		$action = htmlspecialchars( $wgTitle->getLocalUrl() ); //form submit
		$userEmail = $user->mEmail;
		$userName = $user->mName;
		
		$form = "<form method='POST' action='$action'>
					<input type='hidden' name='UserSearch' id='UserSearch' value='$userName'/>
					<input type='text' name='NewEmail' id='NewEmail' value='$userEmail' size='35'/>
					<input type='submit' name='UpdateEmail' id='UpdateEmail' value='UpdateEmail' />
					<p><input type='checkbox' name='AutoConfirm' id='AutoConfirm' /><label for='AutoConfirm'>Automatically confirm email address</label></p>
				</form>
				";
	
		return $form;
	}
	
	///Function to generate the HTML for the user info table
	/**
	 * table gives relevant information about a user when changing their email.
	 *
	 * @param $user object
	 *
	 * @return String HTML table
	 */
	function displayInfoTable( $user ) {
		global $wgLang;
		
		$email = $user->mEmail;
		
		# email confirmation
		$AuthTS = $user->getEmailAuthenticationTimestamp();
		if($AuthTS) {
			$confirmStatus = $wgLang->timeanddate( $AuthTS ) . " (confirmed)";
		} else {
			$confirmStatus = "Not confirmed"; //i18n
		}
		
		# registration date
		$regTS = $user->getRegistration();
		$regDate = $wgLang->timeanddate( $regTS );
		
		$userName = $user->getName();
		$userPageTitle = Title::newFromText( "User:$userName" );
		$userPageUrl = $userPageTitle->getFullURL();
		$userPageLink = "<a href='$userPageUrl'>$userName</a>";
		
		$table = "<table class='wikitable'>
					<tr>
						<td colspan='2'><strong><center>User info for ". $userPageLink ."</center></strong></td>
					</tr>
					<tr>
						<td>E-mail address</td>
						<td>$email</td>
					</tr>
					<tr>
						<td>E-mail confirmation status</td>
						<td>$confirmStatus</td>
					</tr>
					<tr>
						<td>Registration date</td>
						<td>$regDate</td>
					</tr>
				</table>
		
				";
				
		return $table;
	}
	
	///Function to validate and update the users email address
	/**
	 * checks for a valid email, updates the address on success and 
	 * sends out a confirmation email.
	 *
	 * @param $user object
	 * @param $newEmail string Request email address
	 *
	 * @return true on success, error string on failure
	 */
	function updateEmail( $user, $newEmail, $autoConfirm=false ) {
		global $wgEnableEmail, $wgEmailAuthentication;
		
		if( !$wgEnableEmail ) {
			return $this->msg('Email functionality is not enabled'); //i18n
		}
		
		$oldEmail = $user->mEmail;
		
		# returns true on success, string on failure
		$validEmail = Sanitizer::validateEmail( $newEmail );
		
		if( $validEmail === true && $newEmail != $oldEmail ) {
			
			# set new email + invalidate it
			$user->setEmail( $newEmail );
			
			if( $wgEmailAuthentication ) {
			
				if( !$autoConfirm ) {
				
					$user->invalidateEmail();
					# send confirmation email
					$result = $user->sendConfirmationMail();
					if( $result->isOK() ) { //test me
						return $this->msg( 'mailerror', htmlspecialchars( $result->getMessage() ) );
					}
					
				} else {
					$user->confirmEmail();
				}
				
				# finalize changes
				$user->saveSettings();
			}
			
		} else {
			# get error
			if( $newEmail == $oldEmail ) {
				return $this->msg('emailupdate-duplicate-error');
			} else {
				return $this->msg('invalidemailaddress');
			}
			
		}
		
		return true;
	}
	
	/**
	 * adds specialpage link to user page
	 * 
	 * @param $template object
	 * 
	 * @return true on completion
	 */
	function emailUpdateToolbox( $template ) {
		global $wgTitle, $wgUser;
		
		if( !$wgUser->isAllowed( 'emailupdate' ) ) {
			return false;
		}
		
		$nameSpace = $wgTitle->getNsText();
		
		if ( $nameSpace === "User" ) {
			
			$userPage = $wgTitle->getBaseText();
			$specialPage = SpecialPage::getSafeTitleFor( 'EmailUpdate/'.$userPage );
			$URL = htmlspecialchars( $specialPage->getLocalUrl() );
			?> 	<li>
					<a href="<?php echo $URL; ?>"> <?php echo $template->msg( 'emailupdate' ); ?> </a>
				</li> 
			<?php
			
		}
		
		return true;
	}

	protected function getGroupName() {
		return 'users';
	}
	
}