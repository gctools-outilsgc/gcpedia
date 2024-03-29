
$( '#mw-input-wpemailname' )[0].addEventListener( "blur", (event) => {
    const EmailName = document.getElementById('mw-input-wpemailname');
    const EmailDomain = document.getElementById('mw-input-wpemaildomain');

    var emailNameText = EmailName.value.replace(/ /g, '');
    if ( emailNameText != '' && EmailDomain.value != 'example' && EmailDomain.value != ''){

            var email = emailNameText + '@' + EmailDomain.value;
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
                
                } );
            } );

        } else {
            document.getElementById('wpName2').value = '';
            document.getElementById('wpEmail').value = '';
        }
    },
    true,
);



$( '#mw-input-wpemaildomain' )[0].addEventListener( "change", (event) => {
    const EmailName = document.getElementById('mw-input-wpemailname');
    const EmailDomain = document.getElementById('mw-input-wpemaildomain');
    const EmailDomainText = document.getElementById('mw-input-wpemaildomaintext');

    if(EmailDomain.value == 'other') {
        EmailDomain.parentElement.parentElement.style = "display: none;";
        EmailDomainText.style = "display: block;";
    } else if (EmailDomain.value == 'example') {
        document.getElementById('wpName2').value = '';
        document.getElementById('wpEmail').value = '';

    } else 
        customCreateDomainUpdate( EmailName, EmailDomain );
},
true,
);

$( '#mw-input-wpemaildomaintext' )[0].addEventListener( "blur", (event) => {
    const EmailName = document.getElementById('mw-input-wpemailname');
    const EmailDomainText = document.getElementById('mw-input-wpemaildomaintext');
    customCreateDomainUpdate( EmailName, EmailDomainText );
},
true,
);

function customCreateDomainUpdate( EmailName, EmailDomain ){
    const emailNameText = EmailName.value.replace(/ /g, '');

    if ( emailNameText != '' ){
        var email = emailNameText + '@' + EmailDomain.value;
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
            } );
        } );
    }
}