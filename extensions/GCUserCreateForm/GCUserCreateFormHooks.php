<?php

use MediaWiki\Auth\AuthManager;

class GCUserCreateForm {

    public static function onAuthChangeFormFields($requests, $fieldInfo, &$formDescriptor, $action) {
        if ( $action === AuthManager::ACTION_CREATE ) 
            GCUserCreateForm::customizeCreateForm( $formDescriptor );
        else if ( $action === AuthManager::ACTION_LOGIN )
            GCUserCreateForm::customizeLoginForm( $formDescriptor );

        return;
    }


    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        if ( $out->getPageTitle() == $skin->msg("createaccount") ){
            $out->addModuleStyles( [ 'ext.gcusercreateform.create.styles' ] );
            $out->addModules( [ 'ext.gcusercreateform.create.scripts' ] );
        }
        else if ( $out->getPageTitle() == $skin->msg("login") ){
            $out->addModules( [ 'ext.gcusercreateform.styles', 'ext.gcusercreateform.scripts' ] );
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

        // re-order and add custom field
        $formDescriptor = [
            'statusarea' => $formDescriptor['statusarea'],
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
            'createaccount' => $formDescriptor['createaccount']
        ];
        $formDescriptor['username']['readonly'] = true;
        $formDescriptor['username']['label-message'] = 'accountname';
        $formDescriptor['email']['required'] = true;
        $formDescriptor['email']['type'] = 'hidden';
    }
    
    private static function customizeLoginForm( &$formDescriptor ){
    }
}