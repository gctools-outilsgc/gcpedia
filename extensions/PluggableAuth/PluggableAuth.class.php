<?php

/*
 * Copyright (c) 2015-2016 The MITRE Corporation
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

abstract class PluggableAuth {

	/**
	 * @since 1.0
	 *
	 * @param &$id
	 * @param &$username
	 * @param &$realname
	 * @param &$email
	 * @param &$errorMessage
	 */
	abstract public function authenticate( &$id, &$username, &$realname,
		&$email, &$errorMessage );

	/**
	 * @since 1.0
	 *
	 * @param User &$user
	 */
	abstract public function deauthenticate( User &$user );

	/**
	 * @since 1.0
	 *
	 * @param $id
	 */
	abstract public function saveExtraAttributes( $id );

	private static $instance = null;

	/**
	 * @since 2.0
	 */
	public static function singleton() {
		if ( !is_null( self::$instance ) ) {
			return self::$instance;
		} elseif ( isset( $GLOBALS['wgPluggableAuth_Class'] ) &&
			class_exists( $GLOBALS['wgPluggableAuth_Class'] ) &&
			is_subclass_of( $GLOBALS['wgPluggableAuth_Class'],
				'PluggableAuth' ) ) {
			self::$instance = new $GLOBALS['wgPluggableAuth_Class'];
			return self::$instance;
		}
		wfDebug( 'Could not get authentication plugin instance.' );
		return false;

	}
}
