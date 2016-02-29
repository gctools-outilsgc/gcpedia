<?php
/**
 * Poll_body - Body for the Special Page Special:Poll
 *
 * @ingroup Extensions
 * @author Jan Luca <jan@toolserver.org>
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported or later
 */


class Poll extends SpecialPage {

	public function __construct() {
		parent::__construct( 'Poll' );
	}

	public function execute( $par ) {
		$requestObject = $this->getRequest();
		$userObject = $this->getUser();
		$output = $this->getOutput();

		$this->setHeaders();

		# Get request data. Default the action to list if none given
		$action = htmlentities( $requestObject->getText( 'action', 'list' ) );
		$id = htmlentities( $requestObject->getText( 'id' ) );
		$page = htmlentities( $requestObject->getText( 'page', 1 ) );

		# Blocked users can't use this except to list
		if ( $userObject->isBlocked() && $action != 'list' ) {
			$output->addWikiMsg( 'poll-create-block-error' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(), array(), array( 'action' => 'list' ) ) );
			return;
		}

		$this->start();

		# Handle the action
		switch( $action ) {
			case 'create':
				$this->create();
				break;
			case 'vote':
			case 'score':
			case 'change':
			case 'delete':
			case 'submit':
				$this->$action( $id );
				break;
			case 'list_old':
				$this->list_old( $page );
				break;
			case 'list':
			default:
				$this->make_list();
		}
	}

	public function start() {
		global $wgMiserMode;

		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );

		$query_log = $dbr->select( 'poll_start_log', 'time', '', __METHOD__, array( 'ORDER BY' => 'time DESC', 'LIMIT' => '1' ) );
		while ( $row = $dbr->fetchObject( $query_log ) ) {
			$log_time = $row->time;
		}
		if ( !isset( $log_time ) OR $log_time == "" ) $log_time = 0;
		$log_diff = time() - $log_time;

		if ( !$wgMiserMode ) {
			// If miser mode is false then update old polls every hour
			if ( $log_diff <= 3600 ) return;
		} else {
			// If miser mode is true then update old polls every day
			if ( $log_diff <= 86400 ) return;
		}

		$query = $dbr->select( 'poll', 'id, starttime, runtime' );

		while ( $row = $dbr->fetchObject( $query ) ) {
			$starttime = $row->starttime;
			$runtime = $row->runtime;
			$id = $row->id;
			$sum = $starttime + $runtime;

			if ( $sum <= time() ) {
				$dbw->update( 'poll', array( 'end' => 1 ), array( 'id' => $id ) );
			}
		}

		$dbw->insert( 'poll_start_log', array( 'time' => time() ) );
	}

	// This function create a list with all polls that are in the DB
	public function make_list() {
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll' )->text() );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question, dis, id', array( 'end' => 0 ) );

		$output->addHtml( Html::openElement( 'ul' ) );
		$output->addHtml( Html::rawElement( 'li', array(), Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-create-link' )->escaped(),
			array(), array( 'action' => 'create' ) ) ) );
		$output->addHtml( Html::rawElement( 'li', array(), Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-list-old' )->escaped(),
			array(), array( 'action' => 'list_old' ) ) ) );
		$output->addHtml( Html::closeElement( 'ul' ) );

		$output->addWikiText( '== ' . wfMessage( 'poll-list-current' )->text() . ' ==' );

		$tableRows = array();
		$tableHeaders = array();

		$tableHeaders[] = wfMessage( 'poll-question' )->escaped();
		$tableHeaders[] = wfMessage( 'poll-dis' )->escaped();
		$tableHeaders[] = '&#160;';

		while ( $row = $dbr->fetchObject( $query ) ) {
			$tableRow = array();
			$tableRow[] = Linker::linkKnown( $this->getPageTitle(), htmlentities( $row->question, ENT_QUOTES, "UTF-8" ), array(),
				array( 'action' => 'vote', 'id' => $row->id ) );
			$tableRow[] = htmlentities( $row->dis, ENT_QUOTES, "UTF-8" );
			$tableRow[] = Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-title-score' )->escaped(), array(),
				array( 'action' => 'score', 'id' => $row->id ) );

			$tableRows[] = $tableRow;
		}

		$output->addHtml( self::buildTable( $tableRows, array(), $tableHeaders ) );

	}

	public function list_old( $page ) {
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll' )->text() );

		if ( $page > 1 ) {
			$page *= 50;
			$limit = $page . ', 50';
		}
		else {
			$limit = '50';
		}

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question, dis, id', array( 'end' => 1 ), __METHOD__, array( 'ORDER BY' => 'id DESC', 'LIMIT' => $limit ) );

		$output->addHtml( Html::openElement( 'ul' ) );
		$output->addHtml( Html::rawElement( 'li', array(), Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-create-link' )->escaped(),
			array(), array( 'action' => 'create' ) ) ) );
		$output->addHtml( Html::rawElement( 'li', array(), Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-list-current' )->escaped(),
			array(), array( 'action' => 'list' ) ) ) );
		$output->addHtml( Html::closeElement( 'ul' ) );

		$output->addWikiText( '== ' . wfMessage( 'poll-list-old' )->text() . ' ==' );

		$tableRows = array();
		$tableHeaders = array();

		$tableHeaders[] = wfMessage( 'poll-question' )->escaped();
		$tableHeaders[] = wfMessage( 'poll-dis' )->escaped();

		while ( $row = $dbr->fetchObject( $query ) ) {
			$tableRow = array();
			$tableRow[] = Linker::linkKnown( $this->getPageTitle(), htmlentities( $row->question, ENT_QUOTES, "UTF-8" ), array(),
				array( 'action' => 'score', 'id' => $row->id ) );
			$tableRow[] = htmlentities( $row->dis, ENT_QUOTES, "UTF-8" );
		}

		$output->addHtml( self::buildTable( $tableRows, array(), $tableHeaders ) );

	}

	// This function create a interface for create new polls
	public function create() {
		$userObject = $this->getUser();
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll-title-create' )->text() );

		if ( !$userObject->isAllowed( 'poll-create' ) ) {
			$output->addWikiMsg( 'poll-create-right-error' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
				array(), array( 'action' => 'list' ) ) );
		} else {
			$user = $userObject->getID();

			$ip_checked = ( $user == 0 ) ? true : false;

			$formFields = array();

			$output->addHtml( Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getPageTitle()->getFullURL( 'action=submit' ) ) ) );

			$runtimeSelect = new XmlSelect( 'runtime', 'runtime' );
			$runtimeSelect->setAttribute( 'size', '1' );
			$runtimeSelect->addOption( wfMessage( 'poll-runtime-1-day' )->escaped(), 86400 );
			$runtimeSelect->addOption( wfMessage( 'poll-runtime-2-days' )->escaped(), 172800 );
			$runtimeSelect->addOption( wfMessage( 'poll-runtime-1-week' )->escaped(), 604800 );
			$runtimeSelect->addOption( wfMessage( 'poll-runtime-2-weeks' )->escaped(), 1209600 );
			$runtimeSelect->addOption( wfMessage( 'poll-runtime-3-weeks' )->escaped(), 1814400 );
			$runtimeSelect->addOption( wfMessage( 'poll-runtime-4-weeks' )->escaped(), 2419200 );

			$formFields['poll-question'] = Xml::input( 'question' );
			$formFields['poll-option1'] = Xml::input( 'poll_alternative_1' );
			$formFields['poll-option2'] = Xml::input( 'poll_alternative_2' );
			$formFields['poll-option3'] = Xml::input( 'poll_alternative_3' );
			$formFields['poll-option4'] = Xml::input( 'poll_alternative_4' );
			$formFields['poll-option5'] = Xml::input( 'poll_alternative_5' );
			$formFields['poll-option6'] = Xml::input( 'poll_alternative_6' );
			$formFields['poll-dis'] = Xml::textarea( 'dis', '' );
			$formFields['poll-runtime'] = $runtimeSelect->getHTML();
			$formFields['poll-create-allow-more'] = Xml::check( 'allow_more' );
			$formFields['poll-create-allow-ip'] = Xml::check( 'allow_ip', $ip_checked );

			$output->addHtml( Xml::buildForm( $formFields, 'poll-submit' ) );
			$output->addHtml( Html::Hidden( 'type', 'create' ) );

			$output->addHtml( Xml::closeElement( 'form' ) );
		}
	}

	// This function create a interface for voting
	public function vote( $vid ) {
		$userObject = $this->getUser();
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll-title-vote' )->text() );

		if ( !$userObject->isAllowed( 'poll-vote' ) ) {
			$output->addWikiMsg( 'poll-vote-right-error' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
				array(), array( 'action' => 'list' ) ) );
		}
		else {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, multi',
				array( 'id' => $vid ), __METHOD__ );

			while ( $row = $dbr->fetchObject( $query ) ) {
				$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
				$alternative_1 = htmlentities( $row->alternative_1, ENT_QUOTES, 'UTF-8'  );
				$alternative_2 = htmlentities( $row->alternative_2, ENT_QUOTES, 'UTF-8'  );
				$alternative_3 = htmlentities( $row->alternative_3, ENT_QUOTES, 'UTF-8'  );
				$alternative_4 = htmlentities( $row->alternative_4, ENT_QUOTES, 'UTF-8'  );
				$alternative_5 = htmlentities( $row->alternative_5, ENT_QUOTES, 'UTF-8'  );
				$alternative_6 = htmlentities( $row->alternative_6, ENT_QUOTES, 'UTF-8'  );
				$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8'  );
				$multi = $row->multi;
			}

			if ( !isset( $question ) OR $question == "" ) {
				$output->addWikiMsg( 'poll-invalid-id' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
				return;
			}

			$output->addHtml( Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getPageTitle()->getFullURL( 'action=submit&id=' . $vid ) ) ) );

			$tableRows = array();
			$tableHeaders = array();

			$tableHeaders[] = $question;

			if ( $multi != 1 ) {
				$tableRows[] = array( Xml::radioLabel( $alternative_1, 'vote', '1', 'vote1' ) );
				$tableRows[] = array( Xml::radioLabel( $alternative_2, 'vote', '2', 'vote2' ) );
				if ( $alternative_3 != "" ) { $tableRows[] = array( Xml::radioLabel( $alternative_3, 'vote', '3', 'vote3' ) ); }
				if ( $alternative_4 != "" ) { $tableRows[] = array( Xml::radioLabel( $alternative_4, 'vote', '4', 'vote4' ) ); }
				if ( $alternative_5 != "" ) { $tableRows[] = array( Xml::radioLabel( $alternative_5, 'vote', '5', 'vote5' ) ); }
				if ( $alternative_6 != "" ) { $tableRows[] = array( Xml::radioLabel( $alternative_6, 'vote', '6', 'vote6' ) ); }
				$tableRows[] = array( Xml::inputLabel( wfMessage( 'poll-vote-other' )->escaped(), 'vote_other', 'vote_other' ) );
			}
			if ( $multi == 1 ) {
				$tableRows[] = array( Xml::checkLabel( $alternative_1, 'vote_1', 'vote_1' ) );
				$tableRows[] = array( Xml::checkLabel( $alternative_2, 'vote_2', 'vote_2' ) );
				if ( $alternative_3 != "" ) { $tableRows[] = array( Xml::checkLabel( $alternative_3, 'vote_3', 'vote_3' ) ); }
				if ( $alternative_4 != "" ) { $tableRows[] = array( Xml::checkLabel( $alternative_4, 'vote_4', 'vote_4' ) ); }
				if ( $alternative_5 != "" ) { $tableRows[] = array( Xml::checkLabel( $alternative_5, 'vote_5', 'vote_5' ) ); }
				if ( $alternative_6 != "" ) { $tableRows[] = array( Xml::checkLabel( $alternative_6, 'vote_6', 'vote_6' ) ); }
				$tableRows[] = array( Xml::inputLabel( wfMessage( 'poll-vote-other' )->escaped(), 'vote_other', 'vote_other' ) );
			}

			$tableRows[] = array( Xml::submitButton( wfMessage( 'poll-submit' )->escaped() ) . '&#160;' . Linker::linkKnown( $this->getPageTitle(),
				wfMessage( 'poll-title-score' )->escaped(), array(), array( 'action' => 'score', 'id' => $vid ) ) );

			$output->addHtml( self::buildTable( $tableRows, array(), $tableHeaders ) );

			$output->addHtml( Html::Hidden( 'type', 'vote' ) );
			$output->addHtml( Html::Hidden( 'multi', $multi ) );
			$output->addWikiText( '<small>' . wfMessage( 'poll-score-created', $creater )->text() . '</small>' );

			$output->addHtml( Xml::closeElement( 'form' ) );

			if ( $userObject->isAllowed( 'poll-admin' ) || ( $creater == $userObject->getName() ) ) {
				$output->addHtml( wfMessage( 'poll-administration' )->escaped() . '&#160;' . Linker::linkKnown( $this->getPageTitle(),
					wfMessage( 'poll-change' )->escaped(), array(), array( 'action' => 'change', 'id' => $vid ) ) . ' · ' .
					Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-delete' )->escaped(), array(),
					array( 'action' => 'delete', 'id' => $vid ) ) );
			}
		}
	}

	// This function create a score for the polls
	public function score( $sid ) {
		$userObject = $this->getUser();
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll-title-score' )->text() );

		if ( !$userObject->isAllowed( 'poll-score' ) ) {
			$output->addWikiMsg( 'poll-score-right-error' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
				array(), array( 'action' => 'list' ) ) );
		}
		else {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, multi',
				array( 'id' => $sid ), __METHOD__ );

			while ( $row = $dbr->fetchObject( $query ) ) {
				$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
				$alternative_1 = htmlentities( $row->alternative_1, ENT_QUOTES, 'UTF-8'  );
				$alternative_2 = htmlentities( $row->alternative_2, ENT_QUOTES, 'UTF-8'  );
				$alternative_3 = htmlentities( $row->alternative_3, ENT_QUOTES, 'UTF-8'  );
				$alternative_4 = htmlentities( $row->alternative_4, ENT_QUOTES, 'UTF-8'  );
				$alternative_5 = htmlentities( $row->alternative_5, ENT_QUOTES, 'UTF-8'  );
				$alternative_6 = htmlentities( $row->alternative_6, ENT_QUOTES, 'UTF-8'  );
				$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8'  );
				$multi = $row->multi;
			}

			if ( !isset( $question ) OR $question == "" ) {
				$output->addWikiMsg( 'poll-invalid-id' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
				return;
			}

			if ( $multi != 1 ) {
				$query_1 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '1', 'pid' => $sid ), __METHOD__ );
				$query_2 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '2', 'pid' => $sid ), __METHOD__ );
				$query_3 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '3', 'pid' => $sid ), __METHOD__ );
				$query_4 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '4', 'pid' => $sid ), __METHOD__ );
				$query_5 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '5', 'pid' => $sid ), __METHOD__ );
				$query_6 = $dbr->select( 'poll_answer', 'uid', array( 'vote' => '6', 'pid' => $sid ), __METHOD__ );

				$query_num_1 = $dbr->numRows( $query_1 );
				$query_num_2 = $dbr->numRows( $query_2 );
				$query_num_3 = $dbr->numRows( $query_3 );
				$query_num_4 = $dbr->numRows( $query_4 );
				$query_num_5 = $dbr->numRows( $query_5 );
				$query_num_6 = $dbr->numRows( $query_6 );
			}

			if ( $multi == 1 ) {
				$query_num_1 = 0;
				$query_num_2 = 0;
				$query_num_3 = 0;
				$query_num_4 = 0;
				$query_num_5 = 0;
				$query_num_6 = 0;

				$query_multi = $dbr->select( 'poll_answer', 'vote', array( 'pid' => $sid ), __METHOD__ );
				while ( $row = $dbr->fetchObject( $query_multi ) ) {
					$vote = $row->vote;
					$vote = explode( "|", $vote );

					if ( $vote[0] == "1" ) { $query_num_1++; }
					if ( $vote[1] == "1" ) { $query_num_2++; }
					if ( $vote[2] == "1" ) { $query_num_3++; }
					if ( $vote[3] == "1" ) { $query_num_4++; }
					if ( $vote[4] == "1" ) { $query_num_5++; }
					if ( $vote[5] == "1" ) { $query_num_6++; }
				}
			}

			$query_other = $dbr->select( 'poll_answer', 'vote_other', array( 'pid' => $sid, 'isset_vote_other' => 1 ), __METHOD__ );
			$score_other = array( );
			while ( $row = $dbr->fetchObject( $query_other ) ) {
				if ( !isset( $score_other[$row->vote_other]['first'] ) ) {
					$score_other[$row->vote_other]['first'] = 0;
					$score_other[$row->vote_other]['number'] = 1;
					continue;
				}
				$score_other[$row->vote_other]['number']++;
			}

			$tableRows = array();
			$tableHeaders = array();

			$tableHeaders[] = Xml::element( 'span', array( 'style' => 'text-align: center;' ), $question, false );

			$tableRows[] = array( $alternative_1, $query_num_1 );
			$tableRows[] = array( $alternative_2, $query_num_2 );
			if ( $alternative_3 != "" ) { $tableRows[] = array( $alternative_3, $query_num_3 ); }
			if ( $alternative_4 != "" ) { $tableRows[] = array( $alternative_4, $query_num_4 ); }
			if ( $alternative_5 != "" ) { $tableRows[] = array( $alternative_5, $query_num_5 ); }
			if ( $alternative_6 != "" ) { $tableRows[] = array( $alternative_6, $query_num_6 ); }

			foreach ( $score_other as $name => $value ) {
				$tableRows[] = array( htmlentities( $name, ENT_QUOTES, 'UTF-8' ), htmlentities( $value['number'], ENT_QUOTES, 'UTF-8' ) );
			}

			$output->addHtml( self::buildTable( $tableRows, array(), $tableHeaders ) );
			$output->addWikiText( '<small>' . wfMessage( 'poll-score-created', $creater )->text() . '</small>' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
		}
	}

	// This function create a interfache for deleting polls
	public function delete( $did ) {
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll-title-delete' )->text() );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question', array( 'id' => $did ), __METHOD__ );

		while ( $row = $dbr->fetchObject( $query ) ) {
			$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
		}

		if ( isset( $question ) && $question != "" ) {
			$output->addHtml( Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getPageTitle()->getFullURL( 'action=submit&id=' . $did ) ) ) );
			$output->addHtml( Xml::checkLabel( wfMessage( 'poll-delete-question', $question )->text(), 'controll_delete', 'controll_delete' ) . '<br />' ); # text() because Xml::element escapes another time
			$output->addHtml( Xml::submitButton( wfMessage( 'poll-submit' )->escaped() ) . '&#160;' .
				Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(), array(), array( 'action' => 'list' ) ) );
			$output->addHtml( Html::Hidden( 'type', 'delete' ) );
			$output->addHtml( Xml::closeElement( 'form' ) );
		} else {
			$output->addWikiMsg( 'poll-invalid-id' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
				array(), array( 'action' => 'list' ) ) );
		}
	}

	// This function create a interfache for changing polls
	public function change( $cid ) {
		$output = $this->getOutput();

		$output->setPagetitle( wfMessage( 'poll-title-change' )->text() );

		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, dis',
			array( 'id' => $cid ), __METHOD__ );

		while ( $row = $dbr->fetchObject( $query ) ) {
			$question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
			$alternative_1 = htmlentities( $row->alternative_1, ENT_QUOTES, 'UTF-8' );
			$alternative_2 = htmlentities( $row->alternative_2, ENT_QUOTES, 'UTF-8' );
			$alternative_3 = htmlentities( $row->alternative_3, ENT_QUOTES, 'UTF-8' );
			$alternative_4 = htmlentities( $row->alternative_4, ENT_QUOTES, 'UTF-8' );
			$alternative_5 = htmlentities( $row->alternative_5, ENT_QUOTES, 'UTF-8' );
			$alternative_6 = htmlentities( $row->alternative_6, ENT_QUOTES, 'UTF-8' );
			$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8' );
			$dis = htmlentities( $row->dis, ENT_QUOTES, 'UTF-8' );
		}

		if ( !isset( $question ) OR $question == "" ) {
			$output->addWikiMsg( 'poll-invalid-id' );
			$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
				array(), array( 'action' => 'list' ) ) );
			return;
		}
		else {
			$output->addHtml( Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getPageTitle()->getFullURL( 'action=submit&id=' . $cid ) ) ) );

			$formFields = array();
			$formFields['poll-question'] = Xml::input( 'question', false, $question );
			$formFields['poll-option1'] = Xml::input( 'poll_alternative_1', false, $alternative_1 );
			$formFields['poll-option2'] = Xml::input( 'poll_alternative_2', false, $alternative_2 );
			$formFields['poll-option3'] = Xml::input( 'poll_alternative_3', false, $alternative_3 );
			$formFields['poll-option4'] = Xml::input( 'poll_alternative_4', false, $alternative_4 );
			$formFields['poll-option5'] = Xml::input( 'poll_alternative_5', false, $alternative_5 );
			$formFields['poll-option6'] = Xml::input( 'poll_alternative_6', false, $alternative_6 );
			$formFields['poll-dis'] = Xml::textarea( 'dis', $dis );

			$output->addHtml( Xml::buildForm( $formFields, 'poll-submit' ) );
			$output->addHtml( Html::Hidden( 'type', 'change' ) );
			$output->addHtml( Xml::closeElement( 'form' ) );
		}
	}

	// This fucntion execute the order of the other function
	public function submit( $pid ) {
		$requestObject = $this->getRequest();
		$userObject = $this->getUser();
		$output = $this->getOutput();

		$type = $requestObject->getVal( 'type' );

		if ( $type == 'create' ) {
			if ( !$userObject->isAllowed( 'poll-create' ) ) {
				$output->addWikiMsg( 'poll-create-right-error' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
			}
			else {
				$dbw = wfGetDB( DB_MASTER );
				$question = $requestObject->getVal( 'question' );
				$question = preg_replace( "#\[\[#", "", $question );
				$question = preg_replace( "#\]\]#", "", $question );
				$alternative_1 = $requestObject->getVal( 'poll_alternative_1' );
				$alternative_1 = preg_replace( "#\[\[#", "", $alternative_1 );
				$alternative_1 = preg_replace( "#\]\]#", "", $alternative_1 );
				$alternative_2 = $requestObject->getVal( 'poll_alternative_2' );
				$alternative_2 = preg_replace( "#\[\[#", "", $alternative_2 );
				$alternative_2 = preg_replace( "#\]\]#", "", $alternative_2 );
				$alternative_3 = ( $requestObject->getVal( 'poll_alternative_3' ) != "" ) ? $requestObject->getVal( 'poll_alternative_3' ) : "";
				$alternative_3 = preg_replace( "#\[\[#", "", $alternative_3 );
				$alternative_3 = preg_replace( "#\]\]#", "", $alternative_3 );
				$alternative_4 = ( $requestObject->getVal( 'poll_alternative_4' ) != "" ) ? $requestObject->getVal( 'poll_alternative_4' ) : "";
				$alternative_4 = preg_replace( "#\[\[#", "", $alternative_4 );
				$alternative_4 = preg_replace( "#\]\]#", "", $alternative_4 );
				$alternative_5 = ( $requestObject->getVal( 'poll_alternative_5' ) != "" ) ? $requestObject->getVal( 'poll_alternative_5' ) : "";
				$alternative_5 = preg_replace( "#\[\[#", "", $alternative_5 );
				$alternative_5 = preg_replace( "#\]\]#", "", $alternative_5 );
				$alternative_6 = ( $requestObject->getVal( 'poll_alternative_6' ) != "" ) ? $requestObject->getVal( 'poll_alternative_6' ) : "";
				$alternative_6 = preg_replace( "#\[\[#", "", $alternative_6 );
				$alternative_6 = preg_replace( "#\]\]#", "", $alternative_6 );
				$dis = ( $requestObject->getVal( 'dis' ) != "" ) ? $requestObject->getVal( 'dis' ) : wfMsg( 'poll-no-dis' );
				$multi = ( $requestObject->getVal( 'allow_more' ) == 1 ) ? 1 : 0;
				$user = $userObject->getName();
				$ip = ( $requestObject->getVal( 'allow_ip' ) == 1 ) ? 1 : 0;
				$runtime = $requestObject->getVal( 'runtime' );

				if ( $question != "" && $alternative_1 != "" && $alternative_2 != "" ) {
					$dbw->insert( 'poll', array( 'question' => $question, 'alternative_1' => $alternative_1, 'alternative_2' => $alternative_2,
						'alternative_3' => $alternative_3, 'alternative_4' => $alternative_4, 'alternative_5' => $alternative_5,
						'alternative_6' => $alternative_6, 'creater' => $user, 'dis' => $dis, 'multi' => $multi, 'ip' => $ip,
						'starttime' => time(), 'runtime' => $runtime ), __METHOD__ );

					$log = new LogPage( "poll" );
					$title = $this->getPageTitle();
					$log->addEntry( "create", $title, "", array( htmlentities( $question, ENT_QUOTES, 'UTF-8' ) ), $userObject );

					$output->addWikiMsg( 'poll-create-pass' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
				}
				else {
					$output->addWikiMsg( 'poll-create-fields-error' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
				}
			}
		}

		if ( $type == 'vote' ) {
			if ( !$userObject->isAllowed( 'poll-vote' ) ) {
				$output->addWikiMsg( 'poll-vote-right-error' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
			}
			else {
				$dbw = wfGetDB( DB_MASTER );
				$dbr = wfGetDB( DB_SLAVE );
				$multi = $requestObject->getVal( 'multi' );
				$uid = $userObject->getId();
				$user = $userObject->getName();

				$query_ip = $dbr->select( 'poll', 'ip', array( 'id' => $pid ), __METHOD__ );
				while ( $row = $dbr->fetchObject( $query_ip ) ) {
					$ip = $row->ip;
				}

				if ( $uid == 0 && $ip == 0 ) {
					$output->addWikiMsg( 'poll-ip-error' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
					return;
				}

				if ( $ip == 1 ) {
					$query = $dbr->select( 'poll_answer', 'uid', array( 'uid' => $uid, 'pid' => $pid, 'ip' => $user ) );
					$num = $dbr->numRows( $query );
				}
				else {
					$query = $dbr->select( 'poll_answer', 'uid', array( 'uid' => $uid, 'pid' => $pid ) );
					$num = $dbr->numRows( $query );
				}

				if ( $multi != 1 ) {
					$vote = $requestObject->getVal( 'vote' );
					$vote_other = $requestObject->getVal( 'vote_other' );

					if ( $vote == "" AND $vote_other == "" ) {
						$vote = "err001";
					}
				}
				if ( $multi == 1 ) {
					$vote_1 = $requestObject->getVal( 'vote_1' );
					$vote_2 = $requestObject->getVal( 'vote_2' );
					$vote_3 = $requestObject->getVal( 'vote_3' );
					$vote_4 = $requestObject->getVal( 'vote_4' );
					$vote_5 = $requestObject->getVal( 'vote_5' );
					$vote_6 = $requestObject->getVal( 'vote_6' );
					$vote_other = ( $requestObject->getVal( 'vote_other' ) != "" ) ? $requestObject->getVal( 'vote_other' ) : "";

					$vote = "";
					$vote .= ( $vote_1 == 1 ) ? "1|" : "0|";
					$vote .= ( $vote_2 == 1 ) ? "1|" : "0|";
					$vote .= ( $vote_3 == 1 ) ? "1|" : "0|";
					$vote .= ( $vote_4 == 1 ) ? "1|" : "0|";
					$vote .= ( $vote_5 == 1 ) ? "1|" : "0|";
					$vote .= ( $vote_6 == 1 ) ? "1" : "0";

					if ( $vote == "0|0|0|0|0|0" AND $vote_other == "" ) {
						$vote = "err001";
					}
				}

				if ( $vote == "err001" ) {
					$output->addWikiMsg( 'poll-vote-empty-error' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );

					return;
				}

				if ( $vote_other != "" ) {
					$vote = "";
					$isset_vote_other = 1;
				}
				elseif ( $vote_other == "" ) {
					$isset_vote_other = 0;
				}

				if ( $num == 0 ) {
					if ( $ip == 1 ) {
						$dbw->insert( 'poll_answer', array( 'pid' => $pid, 'uid' => $uid, 'vote' => $vote, 'user' => $userObject->getName(), 'isset_vote_other' => $isset_vote_other, 'vote_other' => $vote_other, 'ip' => $user  ) );
					}
					else {
						$dbw->insert( 'poll_answer', array( 'pid' => $pid, 'uid' => $uid, 'vote' => $vote, 'user' => $userObject->getName(), 'isset_vote_other' => $isset_vote_other, 'vote_other' => $vote_other ) );
					}

					$output->addWikiMsg( 'poll-vote-pass' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
				}
				else {
					if ( $ip == 1 && $uid == 0 ) {
						$output->addWikiMsg( 'poll-vote-error-ip-change' );
						return;
					}
					else {
						$dbw->update( 'poll_answer', array( 'vote' => $vote, 'isset_vote_other' => $isset_vote_other, 'vote_other' => $vote_other ), array( 'uid' => $uid, 'pid' => $pid ) );
					}
					$output->addWikiMsg( 'poll-vote-changed' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
				}
			}
		}

		if ( $type == 'change' ) {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'creater', array( 'id' => $pid ) );

			while ( $row = $dbr->fetchObject( $query ) ) {
				$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8' );
			}

			if ( ( $creater != $userObject->getName() ) && !$userObject->isAllowed( 'poll-admin' ) ) {
				$output->addWikiMsg( 'poll-change-right-error' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
				return;
			}
			if ( ( $creater == $userObject->getName() ) || $userObject->isAllowed( 'poll-admin' ) )  {
				$dbw = wfGetDB( DB_MASTER );
				$question = $requestObject->getVal( 'question' );
				$question = preg_replace( "#\[\[#", "", $question );
				$question = preg_replace( "#\]\]#", "", $question );
				$alternative_1 = $requestObject->getVal( 'poll_alternative_1' );
				$alternative_1 = preg_replace( "#\[\[#", "", $alternative_1 );
				$alternative_1 = preg_replace( "#\]\]#", "", $alternative_1 );
				$alternative_2 = $requestObject->getVal( 'poll_alternative_2' );
				$alternative_2 = preg_replace( "#\[\[#", "", $alternative_2 );
				$alternative_2 = preg_replace( "#\]\]#", "", $alternative_2 );
				$alternative_3 = ( $requestObject->getVal( 'poll_alternative_3' ) != "" ) ? $requestObject->getVal( 'poll_alternative_3' ) : "";
				$alternative_3 = preg_replace( "#\[\[#", "", $alternative_3 );
				$alternative_3 = preg_replace( "#\]\]#", "", $alternative_3 );
				$alternative_4 = ( $requestObject->getVal( 'poll_alternative_4' ) != "" ) ? $requestObject->getVal( 'poll_alternative_4' ) : "";
				$alternative_4 = preg_replace( "#\[\[#", "", $alternative_4 );
				$alternative_4 = preg_replace( "#\]\]#", "", $alternative_4 );
				$alternative_5 = ( $requestObject->getVal( 'poll_alternative_5' ) != "" ) ? $requestObject->getVal( 'poll_alternative_5' ) : "";
				$alternative_5 = preg_replace( "#\[\[#", "", $alternative_5 );
				$alternative_5 = preg_replace( "#\]\]#", "", $alternative_5 );
				$alternative_6 = ( $requestObject->getVal( 'poll_alternative_6' ) != "" ) ? $requestObject->getVal( 'poll_alternative_6' ) : "";
				$alternative_6 = preg_replace( "#\[\[#", "", $alternative_6 );
				$alternative_6 = preg_replace( "#\]\]#", "", $alternative_6 );
				$dis = ( $requestObject->getVal( 'dis' ) != "" ) ? $requestObject->getVal( 'dis' ) : wfMsg( 'poll-no-dis' );
				$user = $userObject->getName();

				$dbw->update( 'poll', array( 'question' => $question, 'alternative_1' => $alternative_1, 'alternative_2' => $alternative_2,
					'alternative_3' => $alternative_3, 'alternative_4' => $alternative_4, 'alternative_5' => $alternative_5,
					'alternative_6' => $alternative_6, 'creater' => $user, 'dis' => $dis ), array( 'id' => $pid ) );

				$log = new LogPage( "poll" );
				$title = $this->getPageTitle();
				$log->addEntry( "change", $title, "", array( htmlentities( $question, ENT_QUOTES, 'UTF-8' ) ), $userObject );

				$output->addWikiMsg( 'poll-change-pass' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
			}
		}

		if ( $type == 'delete' ) {
			$dbr = wfGetDB( DB_SLAVE );
			$query = $dbr->select( 'poll', 'creater, question', array( 'id' => $pid ) );

			while ( $row = $dbr->fetchObject( $query ) ) {
				$creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8' );
				$question = $row->question;
			}

			if ( ( $creater != $userObject->getName() ) && !$userObject->isAllowed( 'poll-admin' ) ) {
				$output->addWikiMsg( 'poll-delete-right-error' );
				$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
					array(), array( 'action' => 'list' ) ) );
				return;
			}
			if ( ( $creater == $userObject->getName() ) || $userObject->isAllowed( 'poll-admin' ) ) {
				if ( $requestObject->getCheck( 'controll_delete' ) && $requestObject->getVal( 'controll_delete' ) == 1 ) {
					$dbw = wfGetDB( DB_MASTER );

					$dbw->delete( 'poll', array( 'id' => $pid ) );
					$dbw->delete( 'poll_answer', array( 'uid' => $pid ) );

					$log = new LogPage( "poll" );
					$title = $this->getPageTitle();
					$log->addEntry( "delete", $title, "", array( htmlentities( $question, ENT_QUOTES, 'UTF-8' ) ), $userObject );

					$output->addWikiMsg( 'poll-delete-pass' );

					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
				}
				else {
					$output->addWikiMsg( 'poll-delete-cancel' );
					$output->addHtml( Linker::linkKnown( $this->getPageTitle(), wfMessage( 'poll-back' )->escaped(),
						array(), array( 'action' => 'list' ) ) );
				}
			}
		}
	}

	// Copy of Xml::buildTable but without escaping the values
	public static function buildTable( $rows, $attribs = array(), $headers = null ) {
		$s = Xml::openElement( 'table', $attribs );

		if ( is_array( $headers ) ) {
			$s .= Xml::openElement( 'thead', $attribs );

			foreach ( $headers as $id => $header ) {
				$attribs = array();

				if ( is_string( $id ) ) {
					$attribs['id'] = $id;
				}

				$s .= Xml::openElement( 'th', $attribs ) . $header . Xml::closeElement( 'th' );
			}
			$s .= Xml::closeElement( 'thead' );
		}

		foreach ( $rows as $id => $row ) {
			$attribs = array();

			if ( is_string( $id ) ) {
				$attribs['id'] = $id;
			}

			$s .= self::buildTableRow( $attribs, $row );
		}

		$s .= Xml::closeElement( 'table' );

		return $s;
	}

	// Copy of Xml::buildTableRow but without escaping the values
	public static function buildTableRow( $attribs, $cells ) {
		$s = Xml::openElement( 'tr', $attribs );

		foreach ( $cells as $id => $cell ) {

			$attribs = array();

			if ( is_string( $id ) ) {
				$attribs['id'] = $id;
			}

			$s .= Xml::openElement( 'td', $attribs ) . $cell . Xml::closeElement( 'td' );
		}

		$s .= Xml::closeElement( 'tr' );

		return $s;
	}

	protected function getGroupName() {
		return 'other';
	}
}
