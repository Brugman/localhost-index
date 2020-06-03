<?php

include 'config.php';
include 'functions.php';

$projects = get_projects_basic();

$projects = array_filter( $projects, function ( $item ) {
    if ( strpos( $item, 'New folder' ) === 0 )
        return false;

    return true;
});

// d( $projects );

header('HTTP/1.1 200 OK');
header( 'Content-Type: application/json' );
echo json_encode( array_values( $projects ) );
exit;

