window.addEventListener( 'load', function () {

    /**
     * Functions.
     */

    const is_subsequence = function ( query, text ) {
        let i = 0;
        let j = 0;

        while ( i < query.length && j < text.length ) {
            if ( query[i] === text[j] )
                i++;

            j++;
        }

        return i === query.length;
    };

    const filter_project_list = function () {
        const query = this.value.toLowerCase().replace( /\s+/g, '' );
        const projects = document.querySelectorAll('.project');

        projects.forEach( function ( project ) {
            const name = project.querySelector('.name').textContent.toLowerCase();
            const matches = query === '' || name.indexOf( query ) > -1 || is_subsequence( query, name );

            project.style.display = matches ? 'grid' : 'none';
        });
    };

    const open_top_visible_project = function () {
        const top_project = document.querySelector('.project:not([style*="display: none"])');

        if ( !top_project )
            return;

        const link = top_project.querySelector('.icon.frontend a');

        if ( link && link.href )
            window.location.href = link.href;
    };

    /**
     * On load: Focus search.
     */

    const searchInput = document.getElementById('q');

    searchInput.focus();
    searchInput.select();

    /**
     * On query change: Search query.
     */

    searchInput.addEventListener( 'change', filter_project_list );
    searchInput.addEventListener( 'keyup', filter_project_list );
    searchInput.addEventListener( 'keydown', function ( event ) {
        if ( event.key === 'Enter' )
            open_top_visible_project();
    });

    /**
     * On link click: Focus search.
     */

    document.addEventListener( 'click', function ( event ) {
        if ( event.target.closest('a') )
            searchInput.focus();
    });

    /**
     * Detect changes in the project dir.
     */

    let projects_old = false;

    setInterval( function () {
        fetch( '/json/project-list.php' )
            .then( res => res.json() )
            .then( projects_new => {
                if ( projects_old ) {
                    const removed = projects_old.filter( project => !projects_new.includes( project ) );
                    const added = projects_new.filter( project => !projects_old.includes( project ) );
                    if ( added.length !== 0 || removed.length !== 0 )
                        location.reload();
                }
                projects_old = projects_new;
            })
    }, 5000 );

    /**
     * Filter by URL (/?q=example).
     */

    const searchParams = new URLSearchParams( window.location.search );

    if ( searchParams.has('q') ) {
        searchInput.value = searchParams.get('q');
        filter_project_list.call( searchInput );
    }

});