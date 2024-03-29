<?php

function d( $var = false )
{
    echo "<pre style=\"max-height:35vh;z-index:9999;position:relative;overflow-y:scroll;white-space:pre-wrap;word-wrap:break-word;padding:10px 15px;border:1px solid #fff;background-color:#161616;text-align:left;line-height:1.5;font-family:Courier;font-size:16px;color:#fff;\">";
    print_r( $var );
    echo "</pre>";
}

function dd( $var = false )
{
    d( $var );
    exit;
}

function remove_undesired_entries( $items )
{
    $items = array_diff(
        $items,
        [
            '.',
            '..',
            basename( dirname( dirname( __FILE__ ) ) ),
        ]
    );

    $items = array_diff( $items, APP_IGNORE_PROJECTS );

    return array_filter( $items, function ( $item ) {
        return is_dir( APP_PROJECTS_PATH.$item );
    });
}

function analyse_directory_type( $item )
{
    if ( is_file( APP_PROJECTS_PATH.$item.'/public_html/wp-config.php' ) )
        return 'wordpress';
    if ( is_file( APP_PROJECTS_PATH.$item.'/artisan' ) )
        return 'laravel';

    return false;
}

function analyse_directory_git( $item )
{
    if ( !is_dir( APP_PROJECTS_PATH.$item.'/.git' ) )
        return false;

    $git_config_path = APP_PROJECTS_PATH.$item.'/.git/config';

    if ( !is_file( $git_config_path ) )
        return true;

    $git_config = file_get_contents( $git_config_path );

    // https://user@bitbucket.org/owner/project.git
    preg_match( '/(bitbucket\.org\/.+).git/', $git_config, $bitbucket_url );
    if ( isset( $bitbucket_url[1] ) )
        return 'https://'.$bitbucket_url[1];

    // git@bitbucket.org:owner/project.git
    preg_match( '/(bitbucket\.org:.+).git/', $git_config, $bitbucket_url );
    if ( isset( $bitbucket_url[1] ) )
        return 'https://'.str_replace( ':', '/', $bitbucket_url[1] );

    // https://github.com/owner/project.git
    preg_match( '/(github\.com.+).git/', $git_config, $github_url );
    if ( isset( $github_url[1] ) )
        return 'https://'.$github_url[1];

    return true;
}

function analyse_directories( $items )
{
    return array_map( function ( $item ) {
        return [
            'dir'  => $item,
            'type' => analyse_directory_type( $item ),
            'git'  => analyse_directory_git( $item ),
        ];
    }, $items );
}

function scheme()
{
    if ( defined('APP_SSL') && APP_SSL )
        return 'https://';

    return 'http://';
}

function build_frontend_url( $item, $type = false )
{
    return scheme().$item.'.'.APP_TLD;
}

function build_backend_url( $item, $type = false )
{
    if ( $type == 'wordpress' )
        return scheme().$item.'.'.APP_TLD.'/wp-admin/';

    return false;
}

function append_project_urls( $items )
{
    return array_map( function ( $item ) {
        $item['frontend_url'] = build_frontend_url( $item['dir'], $item['type'] );
        $item['backend_url'] = build_backend_url( $item['dir'], $item['type'] );
        return $item;
    }, $items );
}

function get_projects()
{
    $projects = scandir( APP_PROJECTS_PATH, SCANDIR_SORT_NONE );
    $projects = remove_undesired_entries( $projects );
    $projects = analyse_directories( $projects );
    $projects = append_project_urls( $projects );

    return $projects;
}

function get_projects_basic()
{
    $projects = scandir( APP_PROJECTS_PATH, SCANDIR_SORT_NONE );
    $projects = remove_undesired_entries( $projects );

    return $projects;
}

function display_icon( $icon )
{
    $path = '../public_html/assets/images/'.$icon.'.svg';

    if ( file_exists( $path ) )
        include $path;
}

function display_project_type_icon( $type )
{
    switch ( $type )
    {
        case 'wordpress':
            display_icon( 'wordpress-simple-brands' );
            break;
        case 'laravel':
            display_icon( 'laravel-brands' );
            break;
        default:
            display_icon( 'code-light' );
            break;
    }
}

function display_git_icon( $git_link )
{
    if ( strpos( $git_link, 'github.com' ) !== false )
    {
        display_icon( 'github-brands' );
    }
    elseif ( strpos( $git_link, 'bitbucket.org' ) !== false )
    {
        display_icon( 'bitbucket-brands' );
    }
    else
    {
        display_icon( 'git-alt-brands' );
    }
}

