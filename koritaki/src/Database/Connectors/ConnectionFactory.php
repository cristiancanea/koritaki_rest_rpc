<?php
namespace koritaki\Database\Connectors;

class ConnectionFactory {

    /**
     * This is a general connection factory
     * @param $config
     * @return null
     * @throws DbException
     */
    public function make($config) {
        $db = null;

        if ( empty($config) || empty($config->driver)) {
            throw new DbException('No DataBase Driver was defined!');
        }

        $className = sprintf("\\koritaki\\Database\\Connectors\\%s", ucfirst($config->driver).'Connector');
        $db = new $className();

        $connection = $db->connect($config);

        return $connection;
    }

}