<?php

/*
 * Copyright (c) 2014-2016 The MITRE Corporation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

use \MediaWiki\Auth\AuthManager;

class PluggableAuthLogin extends UnlistedSpecialPage {

	const RETURNURL_SESSION_KEY = 'PluggableAuthLoginReturnToUrl';
	const USERNAME_SESSION_KEY = 'PluggableAuthLoginUsername';
	const REALNAME_SESSION_KEY = 'PluggableAuthLoginRealname';
	const EMAIL_SESSION_KEY = 'PluggableAuthLoginEmail';
	const ERROR_SESSION_KEY = 'PluggableAuthLoginError';

	public function __construct() {
		parent::__construct( 'PluggableAuthLogin' );
	}

	public function execute( $param ) {
		$authManager = AuthManager::singleton();
		$user = $this->getUser();
		$pluggableauth = PluggableAuth::singleton();
		$error = null;
		if ( $pluggableauth ) {
			if ( $pluggableauth->authenticate( $id, $username, $realname, $email,
					$error ) ) {
				if ( is_null( $id ) ) {
					$user->loadDefaults( $username );
					$user->mName = $username;
					$user->mRealName = $realname;
					$user->mEmail = $email;
					$user->mEmailAuthenticated = wfTimestamp();
					$user->mTouched = wfTimestamp();
					wfDebug( 'Authenticated new user: ' . $username );
				} else {
					$user->mId = $id;
					$user->loadFromId();
					wfDebug( 'Authenticated existing user: ' . $user->mName );
				}
				$authorized = true;
				Hooks::run( 'PluggableAuthUserAuthorization', [ $user, &$authorized ] );
				if ( $authorized ) {
					$authManager->setAuthenticationSessionData(
						self::USERNAME_SESSION_KEY, $username );
					$authManager->setAuthenticationSessionData(
						self::REALNAME_SESSION_KEY, $realname );
					$authManager->setAuthenticationSessionData(
						self::EMAIL_SESSION_KEY, $email );
					wfDebug( 'User is authorized.' );
				} else {
					wfDebug( 'Authorization failure.' );
					$error = wfMessage( 'pluggableauth-not-authorized', $username )->text();
				}
			} else {
				wfDebug( 'Authentication failure.' );
				if ( is_null( $error ) ) {
					$error = wfMessage( 'pluggableauth-authentication-failure')->text();
				} else {
					if ( !is_string( $error ) ) {
						$error = strval( $error );
					}
					wfDebug( 'ERROR: ' . $error );
				}
			}
		}
		if ( !is_null( $error ) ) {
			$authManager->setAuthenticationSessionData( self::ERROR_SESSION_KEY,
				$error );
		}
		$returnToUrl = $authManager->getAuthenticationSessionData(
			self::RETURNURL_SESSION_KEY );
		$this->getOutput()->redirect( $returnToUrl );
	}
}
