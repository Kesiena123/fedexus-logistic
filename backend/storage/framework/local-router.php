<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$root = dirname(__DIR__, 3);
$file = $root . '/public' . $path;

if ($path !== '/' && is_file($file)) {
    return false;
}

$_SERVER['SCRIPT_FILENAME'] = $root . '/public/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

require $root . '/public/index.php';
