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

        $email_domain = [
            'type' => 'select',
            'options' => ['test1.local' => 'test1.local', 'dev.gccollab.ca' => 'dev.gccollab.ca']
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