<?php

use MediaWiki\Auth\AuthManager;
use MediaWiki\MediaWikiServices;


class GCUserCreateForm {

    public static function onAuthChangeFormFields($requests, $fieldInfo, &$formDescriptor, $action) {
		$user = RequestContext::getMain()->getUser();
        if ($user->getId() > 0){
            $formDescriptor = [ 'info' => [ 'type' => 'info', 'default' => wfMessage('gcusercreate-loggedin') ] ];
            return;
        }

        if ( $action === AuthManager::ACTION_CREATE ) 
            GCUserCreateForm::customizeCreateForm( $formDescriptor );

        return;
    }


    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        if ( $out->getPageTitle() == $skin->msg("createaccount") ){
            $out->addModuleStyles( [ 'ext.gcusercreateform.create.styles' ] );
            $out->addModules( [ 'ext.gcusercreateform.create.scripts' ] );
        }
        else if ( $out->getPageTitle() == $skin->msg("login") ){
            $out->addModules( [ 'ext.gcusercreateform.login.scripts' ] );
            $out->addHTML( GCUserCreateForm::customLoginFindUsernameHTML($skin) );
        }

        return;
    }



    private static function customizeCreateForm( &$formDescriptor ){

        include("src/domains/DomainList.php");
        $domain_options = [];


        foreach($domainList as $emailDomain) {
            # check for first option in dropdown
            if($emailDomain == 'institution.gc.ca') {
                # example domain
                $domain_options[$emailDomain] = 'example';
                $domain_options[ wfMessage('htmlform-selectorother-other') . '..'] = "other";
            } else {
                # valid domains
                $domain_options[$emailDomain] = $emailDomain;
            }
        }

        $email_name = [
            'type' => 'text',
            'required' => false,
            'section' => 'validgcemail'
        ];
        $email_symbol = [
            'type' => 'info',
            'default' => '@',
            'raw' => true,
            'section' => 'validgcemail',
            'cssclass' => 'mw-input-email-symbol'
        ];
        
        $email_domain_note = [
            'type' => 'info',
            'default' => wfMessage('validgcemailnote'),
            'section' => 'validgcemail'
        ];
        $email_domain = [
            'type' => 'select',
            'required' => false,
            'section' => 'validgcemail',
            'options' => $domain_options
        ];
        $email_domain_text = [
            'type' => 'text',
            'hide-if'  => ['!==', 'emaildomain', 'other'],
            'required' => false,
            'section' => 'validgcemail'
        ];

        $terms_message = [
            'type' => 'info',
            'default' => wfMessage('terms-conditions-message'),
            'raw' => true
        ];
        $terms_checkbox = [
            'type' => 'check',
            'label-message' => 'terms-conditions-check',
            'required' => true
        ];

        $heading = wfMessage('registration-help-section-head');
        $link1 = wfMessage('registration-help-section-link1');
        $link2 = wfMessage('registration-help-section-link2');
        $link3 = wfMessage('registration-help-section-link3');
        $link4 = wfMessage('registration-help-section-link4');
        $contactus = wfMessage('registration-help-section-contactus');
        $registration_help_section = [
            'type' => 'info',
            'default' => "<br /> <h2 id='registration-faq-head'> $heading </h2>
    <ul>
		<li>$link1</li>
		<li>$link2</li>
		<li>$link3</li>
		<li>$link4</li>
	</ul>
	<br />
	$contactus.
            ",
            'raw' => true
        ];

        // re-order and add custom field
        $formDescriptor = [
            'statusarea' => $formDescriptor['statusarea'],
            'email_domain_note' => $email_domain_note,
            'email' => $formDescriptor['email'],
            'emailname' => $email_name,
            'email_symbol' => $email_symbol,
            'emaildomain' => $email_domain,
            'emaildomaintext' => $email_domain_text,
            'username' => $formDescriptor['username'],
            'password' => $formDescriptor['password'],
            'retype' => $formDescriptor['retype'],
            'realname' => $formDescriptor['realname'],
            'terms_message' => $terms_message,
            'terms_checkbox' => $terms_checkbox,
            'createaccount' => $formDescriptor['createaccount'],
            'registration_help_section' => $registration_help_section
        ];
        $formDescriptor['username']['readonly'] = true;
        $formDescriptor['username']['label-message'] = 'accountname';
        $formDescriptor['username']['placeholder-message'] = null;
        $formDescriptor['email']['required'] = true;
        $formDescriptor['email']['type'] = 'hidden';
    }

    private static function customLoginFindUsernameHTML( $skin ){
        return "<br /><br />
            <b>" . wfMessage('forgotusername-text1'). "</b>" . wfMessage('forgotusername-text1-2') . " <br /> " .
            wfMessage('forgotusername-text2') . " <br />
            <label for='byEmail'>" . wfMessage('enteremail') . "</label>
            <input type='text' name='byEmail' id='byEmail'>
            <input type='button' value=\"" . wfMessage('findusername') . "\"name='findUser' id='findUser'> <br /><br />" . 
            wfMessage('registration-help-section-contactus');
    }
}