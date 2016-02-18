<?php

class EditUserPreferencesForm extends PreferencesForm {
	public function getExtraSuccessRedirectParameters() {
		return array( 'username' => $this->getModifiedUser()->getName() );
	}

	function getButtons() {
		$html = HTMLForm::getButtons();

		$url = SpecialPage::getTitleFor( 'EditUser' )->getFullURL(
			array( 'reset' => 1, 'username' => $this->getModifiedUser()->getName() )
		);

		$html .= "\n" . Xml::element( 'a', array( 'href'=> $url ), wfMsgHtml( 'restoreprefs' ) );

		$html = Xml::tags( 'div', array( 'class' => 'mw-prefs-buttons' ), $html );

		return $html;
	}
}
