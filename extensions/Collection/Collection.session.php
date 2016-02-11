<?php

/**
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

class CollectionSession {

	/**
	 * @return bool
	 */
	public static function hasSession() {
		if ( !session_id() ) {
			return false;
		}
		return isset( $_SESSION['wsCollection'] );
	}

	public static function startSession() {
		if ( session_id() == '' ) {
			wfSetupSession();
		}
		self::clearCollection();
	}

	public static function touchSession() {
		$collection = $_SESSION['wsCollection'];
		$collection['timestamp'] = wfTimestampNow();
		$_SESSION['wsCollection'] = $collection;
	}

	public static function clearCollection() {
		$_SESSION['wsCollection'] = array(
			'enabled' => true,
			'title' => '',
			'subtitle' => '',
			'settings' => array(),
			'items' => array(),
		);
		CollectionSuggest::clear();
		self::touchSession();
	}

	public static function enable() {
		if ( !self::hasSession() ) {
			self::startSession();
		} else {
			$_SESSION['wsCollection']['enabled'] = true;
			self::touchSession();
		}
	}

	public static function disable() {
		if ( !self::hasSession() ) {
			return;
		}
		self::clearCollection();
		$_SESSION['wsCollection']['enabled'] = false;
		self::touchSession();
	}

	/**
	 * @return bool
	 */
	public static function isEnabled() {
		return self::hasSession() && isset( $_SESSION['wsCollection']['enabled'] ) &&
			$_SESSION['wsCollection']['enabled'];
	}

	/**
	 * @return bool
	 */
	public static function hasItems() {
		return self::hasSession() && isset( $_SESSION['wsCollection']['items'] );
	}

	/**
	 * @return int
	 */
	public static function countArticles() {
		if ( !self::hasItems() ) {
			return 0;
		}
		$count = 0;
		foreach ( $_SESSION['wsCollection']['items'] as $item ) {
			if ( $item['type'] == 'article' ) {
				$count++;
			}
		}
		return $count;
	}

	/**
	 * @param $title
	 * @param $oldid int
	 * @return int
	 */
	public static function findArticle( $title, $oldid = 0 ) {
		if ( !self::hasItems() ) {
			return - 1;
		}

		foreach ( $_SESSION['wsCollection']['items'] as $index => $item ) {
			if ( $item['type'] == 'article' && $item['title'] == $title ) {
				if ( $oldid ) {
					if ( $item['revision'] == strval( $oldid ) ) {
						return $index;
					}
				} else {
					if ( $item['revision'] == $item['latest'] ) {
						return $index;
					}
				}
			}
		}
		return - 1;
	}

	/**
	 * @return bool
	 */
	public static function purge() {
		if ( !self::hasSession() ) {
			return false;
		}
		$coll = $_SESSION['wsCollection'];
		$newitems = array();
		if ( isset( $coll['items'] ) ) {
			$batch = new LinkBatch;
			$lc = LinkCache::singleton();
			foreach ( $coll['items'] as $item ) {
				if ( $item['type'] == 'article' ) {
					$t = Title::newFromText( $item['title'] );
					$batch->addObj( $t );
				}
			}
			$batch->execute();
			foreach ( $coll['items'] as $item ) {
				if ( $item['type'] == 'article' ) {
					$t = Title::newFromText( $item['title'] );
					if ( $t && !$lc->isBadLink( $t->getPrefixedDbKey() ) ) {
						$newitems[] = $item;
					}
				} else {
					$newitems[] = $item;
				}
			}
		}
		$coll['items'] = $newitems;
		$_SESSION['wsCollection'] = $coll;
		return true;
	}

	/**
	 * @return array
	 */
	public static function getCollection() {
		return self::purge() ? $_SESSION['wsCollection'] : array();
	}

	/**
	 * @param $collection
	 */
	public static function setCollection( $collection ) {
		$_SESSION['wsCollection'] = $collection;
		self::touchSession();
	}
}
