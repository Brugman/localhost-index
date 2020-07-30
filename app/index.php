<?php

if ( !file_exists( dirname(__FILE__).'/config.php') )
    copy( dirname(__FILE__).'/config-example.php', dirname(__FILE__).'/config.php' );

include 'config.php';
include 'functions.php';
include 'core-head.php';
include 'view.php';
include 'core-foot.php';

