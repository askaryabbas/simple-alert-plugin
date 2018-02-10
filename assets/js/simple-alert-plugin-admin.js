( function ( $ ) {
    $( function () {
//        $( '' )
    } );

} )( jQuery );
function sab_cpt_toggle( el, post_type ) {

    if ( el.checked ) {
        jQuery( '#sab-cpt-' + post_type ).show();
    } else {
        jQuery( '#sab-cpt-' + post_type ).hide();
    }
//    alert( post_type );
}