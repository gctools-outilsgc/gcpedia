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
                $domain_options['htmlform-selectorother-other'] = "other";
            } else {
                # valid domains
                $domain_options[$emailDomain] = $emailDomain;
            }
        }

        $email_domain = [
            'type' => 'select',
            'options' => $domain_options
        ];
        $email_name = [
            'type' => 'text'
        ];

        $formDescriptor = [
            'statusarea' => $formDescriptor['statusarea'],
            'email' => $formDescriptor['email'],
            'emailname' => $email_name,
            'emaildomain' => $email_domain,
            'username' => $formDescriptor['username'],
            'password' => $formDescriptor['password'],
            'retype' => $formDescriptor['retype'],
            'realname' => $formDescriptor['realname'],
            'createaccount' => $formDescriptor['createaccount']
        ];
        $formDescriptor['username']['readonly'] = true;
        $formDescriptor['email']['required'] = true;
        $formDescriptor['email']['type'] = 'hidden';
    }
    
    private static function customizeLoginForm( &$formDescriptor ){
    }
}