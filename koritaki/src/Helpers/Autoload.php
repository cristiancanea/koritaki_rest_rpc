<?php
namespace koritaki\Helpers;

class Autoload {

    /**
     * Register Autoload method
     */
    static function register() {
        spl_autoload_register([__CLASS__, 'loader']);
    }

    /**
     * Autoload files for using the classes PSR4
     * @param $className
     */
    static function loader($className) {
        //TODO: this should be improved!

        $className = ltrim($className, '\\');
        $fileName  = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            if ( preg_match('/^'.VENDOR_NAMESPACE_KORITAKI.'(.*)/i', $fileName) ) {
                $fileName = preg_replace('/^'.VENDOR_NAMESPACE_KORITAKI.'/i', DIR_PATH_KORITAKI, $fileName);
            }
        }

        $fileName = BASE_PATH_KORITAKI.DIRECTORY_SEPARATOR.$fileName. str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;
    }
}