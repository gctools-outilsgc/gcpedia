
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
    const EmailName = document.getElementById('mw-input-wpemailname');
    const EmailDomain = document.getElementById('mw-input-wpemaildomain');

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
                } );
            } );
        }
    }
},
true,
);