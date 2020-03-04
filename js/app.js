(function($) {

    /**
     * Functions.
     */

    var filter_project_list = function () {
        var query = $( this ).val().toLowerCase();
        if ( query != '' ) {
            $('.project').filter( function () {
                $( this ).toggle(
                    $( this ).find('.name').text().toLowerCase().indexOf( query ) > -1
                );
            });
        } else {
            $('.project').show();
        };
    }

    /**
     * On load: Fade in.
     */

    $('#app').fadeIn();

    /**
     * On load: Focus search.
     */

    $('#q').focus().select();

    /**
     * On query change: Search query.
     */

    $('#q').on( 'keyup change', filter_project_list );

    /**
     * On link click: Focus search.
     */

    $('a').on( 'click mouseup', function ( event ) {
        $('#q').focus();
    });

})( jQuery );