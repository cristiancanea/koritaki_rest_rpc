<?php
namespace koritaki\Database\Connectors;

use koritaki\Database\Exceptions\DbException;
use mysqli;

class MysqlConnector implements ConnectorInterface {
    /**
     * @param $config
     * @return Mysqli
     */
    public function connect($config) {
        $connection = new mysqli($config->host, $config->user, $config->password, $config->database, $config->port, $config->socket);

        if ($connection->connect_errno > 0){
            throw new DbException('Unable to connect to database [' . $connection->connect_errno . ']');
        }

        return $connection;
    }
}