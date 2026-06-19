window.addEventListener( 'load', function () {

    /**
     * Functions.
     */

    var is_subsequence = function ( query, text ) {
        var i = 0;
        var j = 0;

        while ( i < query.length && j < text.length ) {
            if ( query[i] === text[j] ) {
                i++;
            }
            j++;
        }

        return i === query.length;
    };

    var filter_project_list = function () {
        var query = this.value.toLowerCase().replace( /\s+/g, '' );
        var projects = document.querySelectorAll('.project');

        projects.forEach( function ( project ) {
            var name = project.querySelector('.name').textContent.toLowerCase();
            var matches = query === '' || name.indexOf( query ) > -1 || is_subsequence( query, name );

            project.style.display = matches ? 'grid' : 'none';
        });
    };

    var open_top_visible_project = function () {
        var top_project = document.querySelector('.project:not([style*="display: none"])');

        if ( !top_project )
            return;

        var link = top_project.querySelector('.icon.frontend a');

        if ( link && link.href )
            window.location.href = link.href;
    };

    /**
     * On load: Focus search.
     */

    document.getElementById('q').focus();
    document.getElementById('q').select();

    /**
     * On query change: Search query.
     */

    document.getElementById('q').addEventListener( 'change', filter_project_list );
    document.getElementById('q').addEventListener( 'keyup', filter_project_list );
    document.getElementById('q').addEventListener( 'keydown', function ( event ) {
        if ( event.key === 'Enter' )
            open_top_visible_project();
    });

    /**
     * On link click: Focus search.
     */

    var links = document.querySelectorAll('a');
    links.forEach( function ( link ) {
        link.addEventListener( 'click', function ( event ) {
            document.getElementById('q').focus();
        });
        link.addEventListener( 'mouseup', function ( event ) {
            document.getElementById('q').focus();
        });
    });

    /**
     * Detect changes in the project dir.
     */

    var projects_old = false;

    setInterval( function () {
        fetch( '/json/project-list.php' )
            .then( res => res.json() )
            .then( projects_new => {
                if ( projects_old ) {
                    let removed = projects_old.filter( project => !projects_new.includes( project ) );
                    let added = projects_new.filter( project => !projects_old.includes( project ) );
                    if ( added.length != 0 || removed.length != 0 ) {
                        location.reload();
                    }
                }
                projects_old = projects_new;
            })
    }, 5000 );

    /**
     * Filter by URL (/?q=example).
     */

    let searchParams = new URLSearchParams( window.location.search );

    if ( searchParams.has('q') ) {
        document.getElementById('q').value = searchParams.get('q');
        filter_project_list.call( document.getElementById('q') );
    }

});