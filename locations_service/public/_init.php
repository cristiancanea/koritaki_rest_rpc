<?php

define('BASE_PATH_KORITAKI', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..' );
define('DIR_PATH_KORITAKI', 'koritaki'.DIRECTORY_SEPARATOR.'src' );
define('VENDOR_NAMESPACE_KORITAKI', 'koritaki' );
require_once __DIR__.'/../../'.'koritaki/src/Helpers/Autoload.php';
require_once __DIR__.'/../../'.'koritaki/src/Helpers/Utils.php';
use \koritaki\Helpers\Autoload;
Autoload::register();

require __DIR__ . '/../../vendor/autoload.php';

use JsonRPC\Server;
use koritaki\Database\ConnectionManager;

//set database config
ConnectionManager::setConfig( include_once(__DIR__.'/../Config/database.php') );
$connection = ConnectionManager::getDataSource('default');

//server
$server = new Server();