<?php

if ( !file_exists('config.php') )
    copy('config-example.php', 'config.php');

include 'config.php';
include 'functions.php';
include 'core-head.php';
include 'view.php';
include 'core-foot.php';

