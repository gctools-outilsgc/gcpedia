
$( '#mw-input-wpemailname' )[0].addEventListener( "blur", (event) => {
    const EmailName = document.getElementById('mw-input-wpemailname');
    const EmailDomain = document.getElementById('mw-input-wpemaildomain');

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
    const EmailDomain = document.getElementById('mw-input-wpemaildomain');
    const EmailDomainText = document.getElementById('mw-input-wpemaildomaintext');

    if(EmailDomain.value == 'other') {
        EmailDomain.parentElement.parentElement.style = "display: none;";
        EmailDomainText.style = "display: block;";
    } else if (EmailDomain.value == 'example') {
        document.getElementById('wpName2').value = '';
        document.getElementById('wpEmail').value = '';

    } else 
        customCreateDomainUpdate();
},
true,
);
$( '#mw-input-wpemaildomaintext' )[0].addEventListener( "blur", (event) => {
    const EmailName = document.getElementById('mw-input-wpemailname');
    const EmailDomain = document.getElementById('mw-input-wpemaildomaintext');
    customCreateDomainUpdate( EmailName, EmailDomain );
},
true,
);

function customCreateDomainUpdate( EmailName, EmailDomain ){
    const emailName = EmailName.value.replace(/ /g, '');

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
            } );
        } );
    }
}