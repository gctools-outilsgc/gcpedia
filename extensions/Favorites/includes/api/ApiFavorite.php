<?php
/**
 * API module to allow users to favorite a page
 *
 * @ingroup API
 */

use MediaWiki\MediaWikiServices;
use MediaWiki\Title\Title;

class ApiFavorite extends ApiBase {

	/**
	 * @param ApiMain $main
	 * @param string $action
	 */
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$user = $this->getUser();
		if ( !$user->isRegistered() ) {
			$this->dieWithError( 'api-error-favorites-not-logged-in', 'notloggedin' );
		}

		$params = $this->extractRequestParams();
		$title = Title::newFromText( $params['title'] );

		if ( !$title || $title->getNamespace() < 0 ) {
			$this->dieWithError( [ 'invalidtitle', $params['title'] ] );
		}

		$res = [ 'title' => $title->getPrefixedText() ];

		$dbw = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_PRIMARY );

		if ( $params['unfavorite'] ) {
			$res['unfavorited'] = '';
			$res['message'] = $this->msg( 'removedfavoritetext', $title->getPrefixedText() )->title( $title )->parseAsBlock();
			$success = UnfavoriteAction::doAction( $dbw, $title->getNamespace(), $user, $title );
		} else {
			$res['favorited'] = '';
			$res['message'] = $this->msg( 'addedfavoritetext', $title->getPrefixedText() )->title( $title )->parseAsBlock();
			$success = FavoriteAction::doAction( $dbw, $title->getNamespace(), $user, $title );
		}

		// @todo FIXME: ...this is so confusing. WHY would you use that message???
		if ( !$success ) {
			$this->dieWithError( 'hookaborted', 'hookaborted' );
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $res );
	}

	/**
	 * @return bool
	 */
	public function mustBePosted() {
		return true;
	}

	/** @inheritDoc */
	public function isWriteMode() {
		return true;
	}

	/** @inheritDoc */
	public function needsToken() {
		return 'csrf';
	}

	/**
	 * @inheritDoc
	 */
	public function getAllowedParams() {
		return [
			'title' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			],
			'unfavorite' => false
		];
	}

	/**
	 * @return string[]
	 */
	public function getParamDescription() {
		return [
			'title' => 'The page to (un)favorite',
			'unfavorite' => 'If set the page will be unfavorited rather than favorited',
			'token' => 'A token previously acquired via prop=info',
		];
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return 'Add or remove a page from/to the current user\'s favoritelist';
	}

	/**
	 * @return string[]
	 */
	public function getExamples() {
		return [
			'api.php?action=favorite&title=Main_Page' => 'Favorite the page "Main Page"',
			'api.php?action=favorite&title=Main_Page&unfavorite=' => 'Unfavorite the page "Main Page"',
		];
	}

	/**
	 * @return string
	 */
	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/Special:MyLanguage/Extension:Favorites';
	}
}
