<?php
namespace koritaki;

define('BASE_PATH_KORITAKI', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..' );
define('DIR_PATH_KORITAKI', 'koritaki'.DIRECTORY_SEPARATOR.'src' );
define('VENDOR_NAMESPACE_KORITAKI', 'koritaki' );

require_once __DIR__ . DIRECTORY_SEPARATOR.'Helpers'.DIRECTORY_SEPARATOR.'Utils.php';

require_once __DIR__.DIRECTORY_SEPARATOR.'Helpers'.DIRECTORY_SEPARATOR.'Autoload.php';
use \koritaki\Helpers\Autoload;
Autoload::register();

$app = new Kernel();

return $app;