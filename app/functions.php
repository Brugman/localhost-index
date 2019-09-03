<?php

function remove_files( $items )
{
    $items = array_diff( $items, [ '.', '..', 'localhost-index' ] );

    return array_filter( $items, function( $item ) {
        global $index_root_dir;
        return is_dir( $index_root_dir.$item );
    });
}

function find_type( $item )
{
    global $index_root_dir;

    if ( is_file( $index_root_dir.$item.'/public_html/wp-config.php' ) )
        return 'wordpress';
    if ( is_file( $index_root_dir.$item.'/wp-config.php' ) )
        return 'wordpress';
    if ( is_file( $index_root_dir.$item.'/artisan' ) )
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

function type_icon( $type )
{
    if ( $type == 'wordpress' )
        return include 'assets/images/test/wordpress-simple-brands.svg';
    if ( $type == 'laravel' )
        return include 'assets/images/test/laravel-brands.svg';

    // return include 'assets/images/test/browser-light.svg';
    return include 'assets/images/test/code-light.svg';
}

// $index_root_dir = '.';
$index_root_dir = './../../';
$items = scandir( $index_root_dir, SCANDIR_SORT_NONE );
$items = remove_files( $items );
$items = analyse_dirs( $items );
$items = add_urls( $items );

// echo "<pre style=\"max-height: 800px; z-index: 9999; position: relative; overflow-y: scroll; white-space: pre-wrap; word-wrap: break-word; padding: 10px 15px; border: 1px solid #fff; background-color: #161616; text-align: left; line-height: 1.5; font-family: Courier; font-size: 16px; color: #fff; \">";
// print_r( $items );
// echo "</pre>";
// exit;