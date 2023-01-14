window.addEventListener('load', function () {

    /**
     * Functions.
     */

    var filter_project_list = function () {
        var query = this.value.toLowerCase();
        var projects = document.querySelectorAll('.project');
        projects.forEach( function ( project ) {
            if ( query != '' ) {
                project.style.display = project.querySelector('.name').textContent.toLowerCase().indexOf( query ) > -1 ? 'grid' : 'none';
            } else {
                project.style.display = 'grid';
            };
        });
    }

    /**
     * On load: Focus search.
     */

    document.getElementById('q').focus();
    document.getElementById('q').select();

    /**
     * On query change: Search query.
     */

    document.getElementById('q').addEventListener( 'keyup', filter_project_list );
    document.getElementById('q').addEventListener( 'change', filter_project_list );

    /**
     * On link click: Focus search.
     */

    var links = document.querySelectorAll('a');
    links.forEach( function ( link ) {
        link.addEventListener('click', function ( event ) {
            document.getElementById('q').focus();
        });
        link.addEventListener('mouseup', function ( event ) {
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