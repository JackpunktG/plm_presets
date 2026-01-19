<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/helper_functions.php';
session_start();

if (isset($_COOKIE['known_user']))
    render('login'); 
else
    render('unknow_user');
exit();

//composer dump-autoload
