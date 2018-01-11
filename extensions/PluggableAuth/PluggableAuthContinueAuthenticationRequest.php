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
use \MediaWiki\Auth\AuthManager;

class PluggableAuthContinueAuthenticationRequest extends AuthenticationRequest {

	public function getFieldInfo() {
		return [];
	}

	public function loadFromSubmission( array $data ) {
		$authManager = AuthManager::singleton();
		$error = $authManager->getAuthenticationSessionData(
			PluggableAuthLogin::ERROR_SESSION_KEY );
		if ( is_null( $error ) ) {
			$this->username = $authManager->getAuthenticationSessionData(
				PluggableAuthLogin::USERNAME_SESSION_KEY );
			$authManager->removeAuthenticationSessionData(
				PluggableAuthLogin::USERNAME_SESSION_KEY );
		}
		return true;
	}
}
