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

    function notify_new_projects( projects ) {

        if ( projects.length == 0 )
            return;

        projects.forEach( function ( project ) {
            $('.notifications .list').append('<li>'+project+'</li>');
        });

        $('.notifications').fadeIn();
    }

    function remove_projects( removeList ) {

        if ( removeList.length == 0 )
            return;

        $('.project').each( function () {
            if ( $.inArray( $( this ).find('.name').text(), removeList ) != -1 ) {
                $( this ).find('.name').css('color','#c0392b');
                $( this ).delay(2500).slideUp();
            }
        });
    }

    var projects_old = false;

    setInterval( function () {
        $.getJSON(
            '/json/project-list.php',
            function ( projects_new ) {
                if ( projects_old ) {
                    let removed = $( projects_old ).not( projects_new ).get();
                    let added = $( projects_new ).not( projects_old ).get();

                    notify_new_projects( added );
                    remove_projects( removed );
                }
                projects_old = projects_new;
            }
        );
    }, 5000 );

})( jQuery );