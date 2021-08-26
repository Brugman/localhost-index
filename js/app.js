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

    /**
     * Detect changes in the project dir.
     */

    var projects_old = false;

    setInterval( function () {
        $.getJSON(
            '/json/project-list.php',
            function ( projects_new ) {
                if ( projects_old ) {
                    let removed = $( projects_old ).not( projects_new ).get();
                    let added = $( projects_new ).not( projects_old ).get();

                    if ( added.length != 0 || removed.length != 0 ) {
                        location.reload();
                    }
                }
                projects_old = projects_new;
            }
        );
    }, 5000 );

    /**
     * Filter by URL (/?q=example).
     */

    let searchParams = new URLSearchParams( window.location.search );

    if ( searchParams.has('q') ) {
        $('#q').val( searchParams.get('q') ).change();
    }

})( jQuery );