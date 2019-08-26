<?php

function remove_files( $items )
{
    $items = array_diff( $items, [ '.', '..', 'localhost-index' ] );

    return array_filter( $items, function( $item ) {
        return is_dir( $item );
    });
}

function find_type( $item )
{
    if ( is_file( $item.'/public_html/wp-config.php' ) )
        return 'wordpress';
    if ( is_file( $item.'/wp-config.php' ) )
        return 'wordpress';
    if ( is_file( $item.'/artisan' ) )
        return 'laravel';

    return false;
}

function get_frontend_url( $item, $type = false )
{
    $ip = getHostByName( getHostName() );

    $ext = 'dev';
    if ( $type == 'laravel' )
        $ext = 'lar';

    return 'http://'.$item.'.'.$ext.'.'.$ip.'.nip.io';
}

function get_backend_url( $item, $type = false )
{
    $ip = getHostByName( getHostName() );

    if ( $type == 'wordpress' )
        return 'http://'.$item.'.dev.'.$ip.'.nip.io/wp-login.php';

    return false;
}

function analyse_dirs( $items )
{
    return array_map( function( $item ) {
        return [
            'dir'  => $item,
            'type' => find_type( $item ),
        ];
    }, $items );
}

function add_urls( $items )
{
    return array_map( function( $item ) {
        $item['frontend_url'] = get_frontend_url( $item['dir'], $item['type'] );
        $item['backend_url']  = get_backend_url( $item['dir'], $item['type'] );
        return $item;
    }, $items );
}

$items = scandir('.');
$items = remove_files( $items );
$items = analyse_dirs( $items );
$items = add_urls( $items );




echo "<pre style=\"max-height: 800px; z-index: 9999; position: relative; overflow-y: scroll; white-space: pre-wrap; word-wrap: break-word; padding: 10px 15px; border: 1px solid #fff; background-color: #161616; text-align: left; line-height: 1.5; font-family: Courier; font-size: 16px; color: #fff; \">";
print_r( $items );
echo "</pre>";