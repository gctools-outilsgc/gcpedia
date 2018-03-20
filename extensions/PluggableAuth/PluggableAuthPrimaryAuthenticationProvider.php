<?php

/*
 * Copyright (c) 2016 The MITRE Corporation
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

use \MediaWiki\Auth\AuthenticationRequest;
use \MediaWiki\Auth\ButtonAuthenticationRequest;
use \MediaWiki\Auth\AbstractPrimaryAuthenticationProvider;
use \MediaWiki\Auth\AuthManager;
use \MediaWiki\Auth\AuthenticationResponse;

class PluggableAuthPrimaryAuthenticationProvider extends
	AbstractPrimaryAuthenticationProvider {

	public function beginPrimaryAuthentication( array $reqs ) {
		$request = ButtonAuthenticationRequest::getRequestByName( $reqs,
			'pluggableauthlogin' );
		if ( !$request ) {
			return AuthenticationResponse::newAbstain();
		}
		$url = Title::newFromText( 'Special:PluggableAuthLogin' )->getFullURL();
		$this->manager->setAuthenticationSessionData(
			PluggableAuthLogin::RETURNURL_SESSION_KEY, $request->returnToUrl );

		return AuthenticationResponse::newRedirect( [
			new PluggableAuthContinueAuthenticationRequest()
		], $url );
	}

	public function continuePrimaryAuthentication( array $reqs ) {
		$request = AuthenticationRequest::getRequestByClass( $reqs,
			PluggableAuthContinueAuthenticationRequest::class );
		if ( !$request ) {
			return AuthenticationResponse::newFail(
				wfMessage( 'pluggableauth-authentication-workflow-failure' ) );
		}
		$error = $this->manager->getAuthenticationSessionData(
			PluggableAuthLogin::ERROR_SESSION_KEY ) ;
		if ( !is_null( $error ) ) {
			$this->manager->removeAuthenticationSessionData(
				PluggableAuthLogin::ERROR_SESSION_KEY );
			return AuthenticationResponse::newFail( new RawMessage( $error ) );
		}
		$username = $request->username;
		$user = User::newFromName( $username );
		if ( $user && $user->getId() !== 0 ) {
			$this->updateUserRealnameAndEmail( $user );
		}
		return AuthenticationResponse::newPass( $username );
	}

	private function updateUserRealNameAndEmail( $user, $force = false ) {
		$realname = $this->manager->getAuthenticationSessionData(
			PluggableAuthLogin::REALNAME_SESSION_KEY );
		$this->manager->removeAuthenticationSessionData(
			PluggableAuthLogin::REALNAME_SESSION_KEY );
		$email = $this->manager->getAuthenticationSessionData(
			PluggableAuthLogin::EMAIL_SESSION_KEY );
		$this->manager->removeAuthenticationSessionData(
			PluggableAuthLogin::EMAIL_SESSION_KEY );
		if ( $user->mRealName != $realname || $user->mEmail != $email ) {
			$rights = $user->getRights();
			if ( in_array( 'editmyprivateinfo', $rights ) && !$force) {
				wfDebug( 'User has editmyprivateinfo right.' );
				wfDebug( 'Did not save updated real name and email address.' );
			} else {
				wfDebug( 'User does not have editmyprivateinfo right or has just been created.' );
				$user->mRealName = $realname;
				if ( $email && Sanitizer::validateEmail( $email ) ) {
					$user->mEmail = $email;
					$user->confirmEmail();
				}
				$user->saveSettings();
				wfDebug( 'Saved updated real name and email address.' );
			}
		} else {
			wfDebug( 'Real name and email address did not change.' );
		}
	}

	public function autoCreatedAccount( $user, $source ) {
		$this->updateUserRealNameAndEmail( $user, true );
		$pluggableauth = PluggableAuth::singleton();
		if ( $pluggableauth ) {
			$pluggableauth->saveExtraAttributes( $user->mId );
		}
	}

	public function testUserExists( $username, $flags = User::READ_NORMAL ) {
		return false;
	}

	public function providerAllowsAuthenticationDataChange(
		AuthenticationRequest $req, $checkData = true ) {
		return StatusValue::newGood( 'ignored' );
	}

	public function accountCreationType() {
		return self::TYPE_LINK;
	}

	public function beginPrimaryAccountCreation( $user, $creator, array $reqs ) {
		return AuthenticationResponse::newAbstain();
	}

	public function providerChangeAuthenticationData( AuthenticationRequest $req ) {
	}

	public function getAuthenticationRequests( $action, array $options ) {
		switch ( $action ) {
			case AuthManager::ACTION_LOGIN:
				return [
					 new PluggableAuthBeginAuthenticationRequest()
				];
			default:
				return [];
		}
	}
}
