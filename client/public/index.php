<?php
namespace client;

define( 'APP_PATH' ,  __DIR__. DIRECTORY_SEPARATOR. '..');
const APP_PATH = APP_PATH;
define( 'BASE_PATH', '/test_nph/client/public/');
const BASE_PATH = BASE_PATH;

$app    = include( APP_PATH . '\..\koritaki\src\main.php' );

$app->config(include(APP_PATH . '\Config\config.php'));
include(APP_PATH . '\Config\routes.php');

require __DIR__.'/../../vendor/autoload.php';

$app->run();
