<?php
/**
 * @addtogroup Templates
 */
if( !defined( 'MEDIAWIKI' ) ) die( -1 );


require_once( 'includes/skins/SkinTemplate.php' );


class customUsercreateTemplate extends QuickTemplate {
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
<div id="userlogin">
<script type="text/javascript">
	window.onload = function() {
		document.getElementById("EmailName").focus();
		document.getElementById("EmailName").select();
	}
</script>
<form name="userlogin2" id="userlogin2" method="post" action="<?php $this->text('action') ?>" 
onmousemove = "
/*if ( accept.value != 1 && accept.value != -1 )
	accept.value = -1;*/
"
>
	
	<?php $this->html('header'); /* pre-table point for form plugins... */ ?>
	<?php if( @$this->haveData( 'languages' ) ) { ?><div id="languagelinks"><p><?php $this->html( 'languages' ); ?></p></div><?php } ?>
		
		<?php $this->msg('mandatory') ?>
	<br/>
	<p>
		
		<?php 
		include( 'domains/DomainList.php' );
		
		//if( $this->data['useemail'] ) { ?>
<!-- Email -->			
		<label for='EmailName'> <?php $this->msg('validgcemail')?> <br /> <small><?php $this->msg('validgcemailnote')?></small>  </label>
		<br/>
		
		<input type='text' class='loginText' name="EmailName" id="EmailName"
			style="width:17em; position:relative;"
			size='20'
			value='<?php $this->msg('email-example') ?>'
			tabindex='1'
			onblur="
				var emailName = EmailName.value.replace(/ /g, '');
				if ( emailName != '' && EmailDomain.value != 'example' && EmailDomain.value != ''){
				
						var email = emailName + '@' + EmailDomain.value;
						mw.loader.using( 'mediawiki.api', function () {
							( new mw.Api() ).get( {
								action: 'characterfilterajax',
								emailinput: email,
							} ).done( function ( data ) {
								document.getElementById('wpEmail').value = data.characterfilterajax;
							} );
						} );
						
						mw.loader.using( 'mediawiki.api', function () {
							( new mw.Api() ).get( {
								action: 'generateusernameajax',
								emailinput: email,
							} ).done( function ( data ) {
								document.getElementById('wpName2').value = data.generateusernameajax;
							
								if ( acceptv.value == 1  && wpPassword.value != '' && wpPassword.value == wpRetype.value ){
									wpCreateaccount.disabled=0;
								}
								else{
									wpCreateaccount.disabled=1;
								}
							} );
						} );
						
					} else {
						wpName.value = '';
						wpEmail.value = '';
						wpCreateaccount.disabled=1;
					}
			"
		/>
		@
<!-- Domain -->	
		<span id="domainWrapper">
			<select action="" name="EmailDomain" id="EmailDomain" tabindex="2" onchange=" 
					if(this.value == 'other') {
						mw.loader.using( 'mediawiki.api', function () {
							( new mw.Api() ).get( {
								action: 'insertdomainselector',
							} ).done( function ( data ) {
								document.getElementById('domainWrapper').innerHTML = data.insertdomainselector;
							} );
						} );
						
					} else if (this.value == 'example') {
						wpName.value = '';
						wpEmail.value = '';
						wpCreateaccount.disabled=1;
					
					} else {
						var emailName = EmailName.value.replace(/ /g, '');
						if ( emailName != '' ){
							var email = emailName + '@' + EmailDomain.value;
							mw.loader.using( 'mediawiki.api', function () {
								( new mw.Api() ).get( {
									action: 'characterfilterajax',
									emailinput: email,
								} ).done( function ( data ) {
									document.getElementById('wpEmail').value = data.characterfilterajax;
								} );
							} );
							
							mw.loader.using( 'mediawiki.api', function () {
								( new mw.Api() ).get( {
									action: 'generateusernameajax',
									emailinput: email,
								} ).done( function ( data ) {
									document.getElementById('wpName2').value = data.generateusernameajax.replace(/^\s+|\s+$/g,'');
								
									if ( acceptv.value == 1  && wpPassword.value != '' && wpPassword.value == wpRetype.value ){
										wpCreateaccount.disabled=0;
									}else{
										wpCreateaccount.disabled=1;
									}
								} );
							} );
						} else {
							wpCreateaccount.disabled=1;
						}
					}
					"
				>
															
				<?php
				$optionNum = 0;
				foreach($domainList as $emailDomain) {
					
					# check for first option in dropdown
					if($optionNum == 0) {
						# example domain
						echo( "<option value='example'> $emailDomain </option>" );
						?>
						<option value="other"><?php echo wfMsg('htmlform-selectorother-other') ?>..</option> 
						<?php
					} else {
						# valid domains
						echo( "<option value=$emailDomain> $emailDomain </option>" );
					}
					
					$optionNum++;
				}
				?>
				
			</select>
		</span>
		<input type="hidden" name="wpEmail" id="wpEmail" />
		<br />
		<?php //} ?>
	<br />
	<?php if( $this->data['usedomain'] ) {
	/*-- Domain (old) --*/
		$doms = "";
		foreach( $this->data['domainnames'] as $dom ) {
			$doms .= "<option>" . htmlspecialchars( $dom ) . "</option>";
		}
	?>
		
		<?php $this->msg( 'yourdomainname' ) ?>
		
			<select name="wpDomain" value="<?php $this->text( 'domain' ) ?>"
				
				<?php echo $doms ?>
			</select>
			
		<br />
	<?php } ?>
	
<!-- Username -->			
	<label for='wpName2'> <?php $this->msg('accountname') ?> </label>	
		<br />		
			<input type='text' class='loginText' name="wpName" id="wpName2"
				style="position:relative; width:17em;"
				value="" size='20'
				readonly='readonly'
				/><span id="AJAXtest"></span>

		<br />
		<br />
<!-- Password -->		
		<label for='wpPassword2'><?php $this->msg('yourpassword') ?></label>
		<br />
		
			<input type='password' class='loginPassword' name="wpPassword" id="wpPassword2"
				style="width:17em;"
				value=""
				size='20'
				tabindex='3'
				/>
				<?php if ( $this->translator->translate( 'search' ) == 'Search' ) echo "<a href='http://www.gcpedia.gc.ca/wiki/Help:Creating_a_strong_password' target='_blank'><b>How to create a strong password</b></a>";    else echo "<a href = 'http://www.gcpedia.gc.ca/wiki/Aide:_Cr&#233er_un_mot_de_passe_efficace' target='_blank'> Comment cr&#233er un mot de passe efficace </a>"; ?>
	<br />
	
<!-- Password Again -->		
		<label for='wpRetype'><?php $this->msg('yourpasswordagain') ?></label>
		<br />
			<input type='password' class='loginPassword' name="wpRetype" id="wpRetype"
				value=""
				size='20'
				tabindex='4'
				style="width:17em;"
				onblur="
				if (wpPassword.value != '' && wpPassword.value == wpRetype.value){
					document.getElementById('pwcheck').innerHTML='<?php $this->msg('passwordsmatch')?>';
				}
				else if ( wpPassword.value != wpRetype.value ) {
					document.getElementById('pwcheck').innerHTML='<?php $this->msg('passwordsdontmatch')?>';
				}
				
				if ( wpEmail.value != '' && EmailName.value != '' && acceptv.value == 1  && wpPassword.value != '' && wpPassword.value == wpRetype.value ) {
					wpCreateaccount.disabled=0;
				} else {
					wpCreateaccount.disabled=1;
				}
				"
				/>
				<span id="pwcheck"><strong><?php $this->msg('password-text')?></strong></span>
		
	<br /><br /><br /><br />
		
			
			<p><?php if ( $this->translator->translate( 'search' ) == 'Search' ) echo 'Please review the <a style="font-weight:bold;" href="http://www.gcpedia.gc.ca/gcwiki/index.php/GCPEDIA:Terms_and_conditions_of_use" target="_blank"><u>terms and conditions of use</u></a>'; else echo 'Veuillez SVP examiner les <a style="font-weight:bold;" href="http://www.gcpedia.gc.ca/gcwiki/index.php/GCPEDIA:Conditions_d\'utilisation" target="_blank"><u>modalit&#233;s et conditions d&#8217;utilisation</u></a>'; ?> </p>
			<input type='checkbox' name='accept' id='accept' tabindex='5' onchange="
			acceptv.value = -1 * acceptv.value;
			if ( wpEmail.value !='' && EmailName.value != '' && wpPassword.value != '' && wpPassword.value == wpRetype.value )
			//	wpCreateaccount.value = acceptv.value;
				if ( acceptv.value == '1' )
					wpCreateaccount.disabled = 0;
				else{
					wpCreateaccount.disabled = 1;
					wpName.select();
				}
			else if ( !wpCreateaccount.disabled ) wpCreateaccount.disabled = 1 " />
			<label for='accept'><?php $this->msg('terms-conditions') ?> </label>
			<input type='hidden' name='acceptv' value='-1' />
		
		<br />
		
			<b><?php $this->msg('completeallfields')?></b><br />
			<input type='submit' name="wpCreateaccount" id="wpCreateaccount"
				tabindex='6'
				disabled="disabled"
				value="<?php $this->msg('createaccount') ?>"
				onmousemove = "//sajax_do_call( 'AJAXtest', [wpName.value] , function( strin ) { document.getElementById('wpName2').value = strin.responseText; AJAXtest.value = strin.responseText; }  );"
				/>
			<!--<?php if( $this->data['createemail'] ) { ?>
			 <input type='submit' name="wpCreateaccountMail" id="wpCreateaccountMail"
				tabindex="9"
				value="<?php //$this->msg('createaccountmail') ?>" /> 
			<?php } ?>-->
			
		
	
<?php if( @$this->haveData( 'uselang' ) ) { ?><input type="hidden" name="uselang" value="<?php $this->text( 'uselang' ); ?>" /><?php } ?>
<?php if( @$this->haveData( 'token' ) ) { ?><input type="hidden" name="wpCreateaccountToken" value="<?php $this->text( 'token' ); ?>" /><?php } ?>
<br />	
		
</form>
</div>


<div style='float:left; margin-left:3px;'>
<?php if ( $this->translator->translate( 'search' ) == 'Search' )  echo " <br />
	<strong>Frequently asked questions about creating an account</strong>
	<ul>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Help:Frequently_asked_questions_about_creating_an_account#I.E2.80.99ve_created_my_account._What_happens_next.3F'  target='_blank'>I've created my account. What happens next? </a></li>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Help:Frequently_asked_questions_about_creating_an_account#I_did_not_receive_the_email_confirming_that_my_account_has_been_created._What_should_I_do.3F'  target='_blank'>I did not receive the email confirming that my account has been created. What should I do?</a></li>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Help:Frequently_asked_questions_about_creating_an_account#_Why_do_I_have_to_provide_my_Government_of_Canada_email_account_information.3F'  target='_blank'>Why do I have to provide my Government of Canada email account information?</a></li>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Help:Frequently_asked_questions_about_creating_an_account#_Why_does_GCPEDIA_create_my_user_name_for_me.3F'  target='_blank'>Why does GCPEDIA create my user name for me?</a></li>
	</ul>
	<br />
	For more information or assistance, please <a href='mailto:admin.GCPEDIA@tbs-sct.gc.ca'> contact us</a>.
	";
	else echo " <br />
	<strong>Foire aux questions sur la cr&#233ation d'un compte</strong>
	<ul>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Aide:_Foire_aux_questions_sur_la_cr&#233ation_d&#146un_compte#J.E2.80.99ai_cr.C3.A9.C3.A9_mon_compte._Quelles_sont_les_.C3.A9tapes_suivantes.3F' target='_blank'> J'ai cr&#233&#233 mon compte. Quelles sont les &#233tapes suivantes? </a></li>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Aide:_Foire_aux_questions_sur_la_cr&#233ation_d&#146un_compte#Je_n.E2.80.99ai_pas_re.C3.A7u_le_courriel_confirmant_la_cr.C3.A9ation_de_mon_compte._Que_dois-je_faire.3F' target='_blank'> Je n'ai pas re&#231u de confirmation par courrier &#233lectronique que mon compte fut cr&#233&#233.  Que dois-je faire? </a></li>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Aide:_Foire_aux_questions_sur_la_cr&#233ation_d&#146un_compte#Pourquoi_dois-je_fournir_des_renseignements_sur_mon_compte_courriel_du_gouvernement_du_Canada.3F' target='_blank'> Pourquoi dois-je fournir des renseignements sur mon compte courriel du gouvernement du Canada? </a></li>
		<li><a href='http://www.gcpedia.gc.ca/wiki/Aide:_Foire_aux_questions_sur_la_cr&#233ation_d&#146un_compte#Pourquoi_GCPEDIA_cr.C3.A9e-t-il_lui-m.C3.AAme_mon_nom_d.E2.80.99utilisateur.3F' target='_blank'> Pourquoi GCPEDIA cr&#233e-t-il lui-m&#234me mon nom d'utilisateur? </a></li>
	</ul>
	<br />
	Si vous d&#233sirez des pr&#233cisions ou de l'aide, veuillez <a href = 'mailto:admin.GCPEDIA@tbs-sct.gc.ca'> communiquer avec nous </a>.
	";
	
	?>
</div>
<div id="signupend"><?php $this->msgWiki( 'signupend' ); ?></div>
<?php

	}
}
