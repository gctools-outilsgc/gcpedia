<?php
/**
 * @addtogroup Templates
 */
if( !defined( 'MEDIAWIKI' ) ) die( -1 );


require_once( 'includes/skins/SkinTemplate.php' );


class customUserloginTemplate extends QuickTemplate {
	function execute() {
		if( $this->data['message'] ) {
?>
	<div class="<?php $this->text('messagetype') ?>box">
		<?php if ( $this->data['messagetype'] == 'error' ) { ?>
			<h2><?php $this->msg('loginerror') ?>:</h2>
		<?php } ?>
		<?php $this->html('message') ?>
	</div>
	<div class="visualClear"></div>
<?php } ?>

<div id="userloginForm">
<style>
.button-link {
text-decoration: none;
    padding: 10px 15px;
    margin-top: 100px;
    margin-bottom: 100px;
    background: #4479BA;
    color: #FFF !important;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    border: solid 1px #20538D;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    -webkit-transition-duration: 0.2s;
    -moz-transition-duration: 0.2s;
    transition-duration: 0.2s;
    -webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;
}
.button-link:visited {
    text-decoration: none !important;
}
.button-link:hover {
    background: #356094;
    border: solid 1px #2A4E77;
    text-decoration: none;
}
.button-link:active {
    -webkit-box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.6);
    -moz-box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.6);
    box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.6);
    background: #2E5481;
    border: solid 1px #203E5F;
}
</style>
	
<form name="userlogin" method="post" action="<?php $this->text('action') ?>">
	<?php $this->msg( 'userlogin-noaccount' ); ?><a href="<?php $this->text( 'createOrLoginHref' ); ?>" id="mw-createaccount-join" tabindex="7" class="mw-ui-button mw-ui-progressive"><?php $this->msg( 'userlogin-joinproject' ); ?></a>
	<?php $this->html('header'); /* pre-table point for form plugins... */ ?>
	<div id="userloginprompt"><?php  $this->msgWiki('loginprompt') ?></div>
	<br />
	<?php if( @$this->haveData( 'languages' ) ) { ?><div id="languagelinks"><p><?php $this->html( 'languages' ); ?></p></div><?php } ?>
	
		
			<label for='wpName1'><?php $this->msg('username') ?></label>
								<!-- Troy: I added into the following line onfocus=" if(this.value == 'Firstname.Lastname') 
								{ this.value = '';this.style.color='#000';} " onblur="if(this.value == '') {
								this.value='Firstname.Lastname'; this.style.color='#666';this.style.fontStyle='italic';}" -->

				<input type='text' class='loginText' name="wpName" id="wpName1"
					value="<?php $this->text('name')?>" size='20' placeholder="<?php $this->msg('placeholder:firstlastname') ?>" /> <br />
		
		
		<p style="margin-top: 5px;">
			<label for='wpPassword1' style="<?php if ( $this->translator->translate( 'search' ) == 'Search' ) echo "padding-left:2px;"; else echo "padding-left:16px;"; ?>"><?php $this->msg('yourpassword') ?></label>
			
				<input type='password' class='loginPassword' name="wpPassword" id="wpPassword1"
					
					value="" size='20' /></p>
			
		
	<?php if( $this->data['usedomain'] ) {
		$doms = "";
		foreach( $this->data['domainnames'] as $dom ) {
			$doms .= "<option>" . htmlspecialchars( $dom ) . "</option>";
		}
	?>
		
			<?php $this->msg( 'yourdomainname' ) ?>
			
				<select name="wpDomain" value="<?php $this->text( 'domain' ) ?>"
					>
					<?php echo $doms ?>
				</select>
			
		
	<?php } ?>
		
			
			<p style="<?php if ( $this->translator->translate( 'search' ) == 'Search' ) echo "padding-left:68px;"; else echo "padding-left:108px;"; ?>">
				<input type='checkbox' name="wpRemember" checked="checked"<?php // GCChange - added so checked by default ?>
					
					value="1" id="wpRemember"
					<?php if( $this->data['remember'] ) { ?>checked="checked"<?php } ?>
					/> <label for="wpRemember"><?php $this->msg('remembermypassword') ?></label><br />
			
		
		
			
			<!--<td align='left' style="white-space:nowrap">-->
				<input type='submit' name="wpLoginattempt" id="wpLoginattempt" value="<?php $this->msg('login') ?>" />&nbsp;<?php if( $this->data['useemail'] && $this->data['canreset']) { ?>
				
				
<!--					<br /><br />

					<hr>
					<br />
					
					<strong><?php //$this->msg('forgotpassword'); ?></strong>
					<br />
					
					<input type='submit' name="wpMailmypassword" id="wpMailmypassword" value="<?php //$this->msg('mailmypassword'); ?>" /></p>
-->
				
				<?php } ?>
				
				<br /><br />

				<hr>
				<br />
		<!-- 		<strong><?php $this->msg('ssotitle'); ?></strong><br /><br />
				<?php $this->msg('ssobody'); ?>-->

				<strong><?php $this->msg('ssotitle'); ?></strong><br /><br />
				<?php $this->msg('sso_decom_head'); ?>
				<ol>
					<li> <?php $this->msg('sso_decom_list1'); ?> </li>
					<li> <?php
						echo Linker::link(
						SpecialPage::getTitleFor( 'PasswordReset' ),
						wfMessage( 'sso_decom_list2' )); ?> </li>
					<li> <?php $this->msg('sso_decom_list3'); ?> </li>
				</ol>
				<a href="<?php $this->msg('sso_decom_foot_link'); ?>"><?php $this->msg('sso_decom_foot'); ?></a>
				<br /><br />
				<?php
					if ( $this->haveData( 'extrafields' ) ) {
						echo $this->data['extrafields'];
					}
				?><br /><br />
<!--  -->
				<hr><br />
				<strong><?php $this->msg('forgotusername'); ?></strong>
				<br /><br />

				<?php 
					echo Linker::link(
					SpecialPage::getTitleFor( 'PasswordReset' ),
					wfMessage( 'userlogin-resetlink' )
				);
				?><br /><br />
				<b><?php $this->msg('forgotusername-text1'); ?></b><?php $this->msg('forgotusername-text1-2'); ?>
				<br />
				<?php $this->msg('forgotusername-text2'); ?>
				
				<br />
				<label for='byEmail'> <?php $this->msg('enteremail') ?> </label> <input type='text' name='byEmail' id='byEmail'>
				<input type='button' value="<?php $this->msg('findusername') ?>"name='findUser' id='findUser'
				onclick="mw.loader.using( 'mediawiki.api', function () {
							( new mw.Api() ).get( {
								action: 'findusernameajax',
								emailinput: byEmail.value,
							} ).done( function ( data ) {
								document.getElementById('wpName1').value = data.findusernameajax;
							} );
						} );
						"
				>
			
			<?php if ( $this->translator->translate( 'search' ) == 'Search' )  echo " <br /><br />
	For more information or assistance, please <a href='mailto:admin.GCPEDIA@tbs-sct.gc.ca'> contact us</a>.";
	else echo " <br /><br />
	Si vous d&#233sirez des pr&#233cisions ou de l'aide, veuillez <a href = 'mailto:admin.GCPEDIA@tbs-sct.gc.ca'> communiquer avec nous </a>.
	";
	?>
			
<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>
<?php if( @$this->haveData( 'token' ) ) { ?><input type="hidden" name="wpLoginToken" value="<?php $this->text( 'token' ); ?>" /><?php } ?>

</form>
</div>
<div id="loginend"><?php //$this->msgWiki( 'loginend' ); ?></div>
<?php

	}
}
