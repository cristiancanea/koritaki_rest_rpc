<?php
namespace client\config;

return [
    'APP_PATH'              => \client\APP_PATH,
    'BASE_PATH'             => \client\BASE_PATH,
    'NAMESPACE_CONTROLLERS' => '\client\Controller',
    'NAMESPACE_MIDDLEWARE'  => '\client\Middleware',
    'NAMESPACE_VIEW'        => '\client\View',
    'DATABASE'              => include_once('database.php'),
];