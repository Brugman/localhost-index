(function($) {

    var filter_list = function () {

        var q = $( this ).val().toLowerCase();
        if ( q != '' ) {
            $( '.project' ).filter( function() {
                $( this ).toggle(
                    $( this ).find( '.name' ).text().toLowerCase().indexOf( q ) > -1
                );
            });
        } else {
            $( '.project' ).show();
        };

        update_count();
    }

    $( '#q' ).on( 'keyup change', filter_list );
    $( '#q' ).focus().select();

})( jQuery );