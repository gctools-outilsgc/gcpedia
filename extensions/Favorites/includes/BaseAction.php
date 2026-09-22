<?php

use MediaWiki\MediaWikiServices;
use MediaWiki\Title\Title;
use Wikimedia\Rdbms\DBConnRef;

abstract class BaseAction extends Action {
	public function show() {
		$user = $this->getUser();
		$out = $this->getOutput();

		$services = MediaWikiServices::getInstance();
		$dbw = $services->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$title = $this->getTitle();
		$subject = $services->getNamespaceInfo()->getSubject( $title->getNamespace() );

		if ( $this->doAction( $dbw, $subject, $user, $title ) ) {
			$out->addWikiMsg( $this->successMessage(), $title->getPrefixedText() );
			$user->invalidateCache();
		} else {
			$out->addWikiMsg( 'favoriteerrortext', $title->getPrefixedText() );
		}
	}

	abstract protected function successMessage();

	/**
	 * @param DBConnRef $dbw
	 * @param int $subject
	 * @param User $user
	 * @param Title $title
	 * @return bool
	 */
	abstract public function doAction( DBConnRef $dbw, int $subject, User $user, Title $title );
}
