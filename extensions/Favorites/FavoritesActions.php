<?php

class FavoriteAction {

	function __construct($action,$title,$article = null) {
		$user = User::newFromSession();
		
		if ($article) {
			$output = $article->getContext()->getOutput();
		} else {
			$output = false;
		}
		
		if ($action == 'favorite') {
			$result = $this->doFavorite($title, $user);
			$message = 'addedfavoritetext';
		} else {
			$result = $this->doUnfavorite($title, $user);
			$message = 'removedfavoritetext';
		}
		
		if ($result == true) {
			if ($output) {
				// don't do this if we are calling from the API
				$output->addWikiMsg( $message, $title->getPrefixedText() );
			}
			$user->invalidateCache();
			return true;
		} else {
			if ($output) {
				// don't do this if we are calling from the API
				$output->addWikiMsg( 'favoriteerrortext', $title->getPrefixedText() );
			}
			return false;
		}
		
		
	}
	
	function doFavorite( Title $title, User $user  ) {
		$success = false;
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'favoritelist',
				array(
						'fl_user' => $user->getId(),
						'fl_namespace' => MWNamespace::getSubject($title->getNamespace()),
						'fl_title' => $title->getDBkey(),
						'fl_notificationtimestamp' => null
				), __METHOD__, 'IGNORE' );
		
		wfProfileOut( __METHOD__ );
			if ( $dbw->affectedRows() > 0 ) {
			$success = true;
		}
		return $success;
	}
	
	function doUnfavorite( Title $title, User $user  ) {
		$success = false;
		
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'favoritelist',
				array(
						'fl_user' => $user->getId(),
						'fl_namespace' => MWNamespace::getSubject($title->getNamespace()),
						'fl_title' => $title->getDBkey()
				), __METHOD__
		);
		
		if ( $dbw->affectedRows() > 0) {
			$success = true;
		} 
		
		return $success;
	}
	

	
	
}



