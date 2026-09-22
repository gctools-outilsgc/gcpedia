<?php

use MediaWiki\Title\Title;

class UnfavoriteAction extends BaseAction {
	/**
	 * @inheritDoc
	 */
	public function getName() {
		return 'unfavorite';
	}

	/**
	 * @return string
	 */
	protected function successMessage() {
		return 'removedfavoritetext';
	}

	/**
	 * @param \Wikimedia\Rdbms\DBConnRef $dbw
	 * @param int $subject
	 * @param User $user
	 * @param Title $title
	 * @return bool
	 */
	public function doAction(
		\Wikimedia\Rdbms\DBConnRef $dbw, int $subject, User $user, Title $title
	) {
		$dbw->delete( 'favoritelist', [
			'fl_user' => $user->getId(),
			'fl_namespace' => $subject,
			'fl_title' => $title->getDBkey(),
		], __METHOD__ );

		return $dbw->affectedRows() === 1;
	}
}
