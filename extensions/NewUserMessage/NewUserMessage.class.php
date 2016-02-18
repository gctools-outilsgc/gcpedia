<?php
/** Extension:NewUserMessage
 *
 * @file
 * @ingroup Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license GNU General Public Licence 2.0 or later
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright 2009 Siebrand Mazeland
 */

class NewUserMessage {
	/**
	 * Produce the editor for new user messages.
	 * @return User
	 */
	static function fetchEditor() {
		// Create a user object for the editing user and add it to the
		// database if it is not there already
		$editor = User::newFromName( self::getMsg( 'newusermessage-editor' )->text() );

		if ( !$editor ) {
			return false; # Invalid user name
		}

		if ( !$editor->isLoggedIn() ) {
			$editor->addToDatabase();
		}

		return $editor;
	}

	/**
	 * Produce a (possibly random) signature.
	 * @return String
	 */
	static function fetchSignature() {
		$signatures = self::getMsg( 'newusermessage-signatures' )->text();
		$signature = '';

		if ( !self::getMsg( 'newusermessage-signatures' )->isDisabled() ) {
			$pattern = '/^\* ?(.*?)$/m';
			$signatureList = array();
			preg_match_all( $pattern, $signatures, $signatureList, PREG_SET_ORDER );
			if ( count( $signatureList ) > 0 ) {
				$rand = rand( 0, count( $signatureList ) - 1 );
				$signature = $signatureList[$rand][1];
			}
		}

		return $signature;
	}

	/**
	 * Return the template name if it exists, or '' otherwise.
	 * @param $template string with page name of user message template
	 * @return string
	 */
	static function fetchTemplateIfExists( $template ) {
		$text = Title::newFromText( $template );

		if ( !$text ) {
			wfDebug( __METHOD__ . ": '$template' is not a valid title.\n" );
			return '';
		} elseif ( $text->getNamespace() !== NS_TEMPLATE ) {
			wfDebug( __METHOD__ . ": '$template' is not a valid Template.\n" );
			return '';
		} elseif ( !$text->exists() ) {
			return '';
		}

		return $text->getText();
	}

	/**
	 * Produce a subject for the message.
	 * @return String
	 */
	static function fetchSubject() {
		return self::fetchTemplateIfExists( self::getMsg( 'newusermessage-template-subject' )->text() );
	}

	/**
	 * Produce the template that contains the text of the message.
	 * @return String
	 */
	static function fetchText() {
		$template = self::getMsg( 'newusermessage-template-body' )->text();

		$title = Title::newFromText( $template );
		if ( $title && $title->exists() && $title->getLength() ) {
			return $template;
		}

		// Fall back if necessary to the old template
		return self::getMsg( 'newusermessage-template' )->text();
	}

	/**
	 * Produce the flags to set on Article::doEdit
	 * @return Int
	 */
	static function fetchFlags() {
		global $wgNewUserMinorEdit, $wgNewUserSuppressRC;

		$flags = EDIT_NEW;
		if ( $wgNewUserMinorEdit ) $flags = $flags | EDIT_MINOR;
		if ( $wgNewUserSuppressRC ) $flags = $flags | EDIT_SUPPRESS_RC;

		return $flags;
	}

	/**
	 * Take care of substition on the string in a uniform manner
	 * @param $str string
	 * @param $user User
	 * @param $editor User
	 * @param $talk Title
	 * @param $preparse bool If provided, then preparse the string using a Parser
	 * @return string
	 */
	static private function substString( $str, $user, $editor, $talk, $preparse = null ) {
		$realName = $user->getRealName();
		$name = $user->getName();

		// Add (any) content to [[MediaWiki:Newusermessage-substitute]] to substitute the
		// welcome template.
		$substDisabled = self::getMsg( 'newusermessage-substitute' )->isDisabled();

		if ( $substDisabled ) {
			$str = '{{' . "$str|realName=$realName|name=$name}}";
		} else {
			$str = '{{subst:' . "$str|realName=$realName|name=$name}}";
		}

		if ( $preparse ) {
			global $wgParser;

			$str = $wgParser->preSaveTransform( $str, $talk, $editor, new ParserOptions );
		}

		return $str;
	}

	/**
	 * Add the message if the users talk page does not already exist
	 * @param $user User object
	 * @return bool
	 */
	static function createNewUserMessage( $user ) {
		$talk = $user->getTalkPage();

		// Only leave message if user doesn't have a talk page yet
		if ( !$talk->exists() ) {
			$wikiPage = WikiPage::factory( $talk );
			$subject = self::fetchSubject();
			$text = self::fetchText();
			$signature = self::fetchSignature();
			$editSummary = self::getMsg( 'newuseredit-summary' )->text();
			$editor = self::fetchEditor();
			$flags = self::fetchFlags();

			# Do not add a message if the username is invalid or if the account that adds it, is blocked
			if ( !$editor || $editor->isBlocked() ) {
				return true;
			}

			if ( $subject ) {
				$subject = self::substString( $subject, $user, $editor, $talk, "preparse" );
			}
			if ( $text ) {
				$text = self::substString( $text, $user, $editor, $talk );
			}

			self::leaveUserMessage( $user, $wikiPage, $subject, $text,
				$signature, $editSummary, $editor, $flags );
		}
		return true;
	}

	/**
	 * Hook function to create a message on an auto-created user
	 * @param $user User object of the user
	 * @return bool
	 */
	static function createNewUserMessageAutoCreated( $user ) {
		global $wgNewUserMessageOnAutoCreate;

		if ( $wgNewUserMessageOnAutoCreate ) {
			NewUserMessage::createNewUserMessage( $user );
		}

		return true;
	}

	/**
	 * Hook function to provide a reserved name
	 * @param $names Array
	 * @return bool
	 */
	static function onUserGetReservedNames( &$names ) {
		$names[] = 'msg:newusermessage-editor';
		return true;
	}

	/**
	 * Leave a user a message
	 * @param $user User to message
	 * @param $wikiPage WikiPage user talk page
	 * @param $subject string with the subject of the message
	 * @param $text string with the message to leave
	 * @param $signature string to leave in the signature
	 * @param $summary string with the summary for this change, defaults to
	 *                        "Leave system message."
	 * @param $editor User leaving the message, defaults to
	 *                        "{{MediaWiki:usermessage-editor}}"
	 * @param $flags int default edit flags
	 *
	 * @return boolean true if it was successful
	 */
	public static function leaveUserMessage( $user, $wikiPage, $subject, $text, $signature,
			$summary, $editor, $flags ) {
		$text = self::formatUserMessage( $subject, $text, $signature );
		$flags = $wikiPage->checkFlags( $flags );

		if ( $flags & EDIT_UPDATE ) {
			$text = $wikiPage->getRawText() . "\n" . $text;
		}
		$status = $wikiPage->doEdit( $text, $summary, $flags, false, $editor );
		return $status->isGood();
	}

	/**
	 * Format the user message using a hook, a template, or, failing these, a static format.
	 * @param $subject   string the subject of the message
	 * @param $text      string the content of the message
	 * @param $signature string the signature, if provided.
	 * @return string in wiki text with complete user message
	 */
	static protected function formatUserMessage( $subject, $text, $signature ) {
		$contents = "";
		$signature = empty( $signature ) ? "~~~~" : "{$signature} ~~~~~";

		if ( $subject ) {
			$contents .= "== $subject ==\n\n";
		}
		$contents .= "$text\n\n-- $signature\n";

		return $contents;
	}

	static protected function getMsg( $name ) {
		return wfMessage( $name )->inContentLanguage();
	}
}
