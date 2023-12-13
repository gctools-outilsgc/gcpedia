
$( '#findUser' )[0].addEventListener( "click", (event) => {
    mw.loader.using( 'mediawiki.api', function () {
        ( new mw.Api() ).get( {
            action: 'findusernameajax',
            emailinput: document.getElementById('byEmail').value,
        } ).done( function ( data ) {
            document.getElementById('wpName1').value = data.findusernameajax;
        } );
    } );
    },
    true,
);