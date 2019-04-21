<?php

define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASS', "");
define('DB_NAME', "tmcaa");

define('SITE_URL', "http://localhost/projects/tmcaa");
define('SITE_TITLE', "TMCAA");
define('APP_PATH', dirname(dirname(__FILE__)));

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/functions.php';

// require_once __DIR__.'/../classes/User.php';

if (isset($_POST['logout'])) {
    Auth::logout();
    header('Location:' . SITE_URL);
}
