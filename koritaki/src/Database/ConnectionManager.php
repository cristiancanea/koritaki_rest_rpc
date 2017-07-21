<?php
namespace koritaki\Database;

use koritaki\Database\Connectors\ConnectionFactory;
use koritaki\Database\Exceptions\DbException as DbException;

class ConnectionManager {
    /**
     * @var array - connections buffer
     */
    protected static $connections = [];
    /**
     * @var array - db configuration
     */
    protected static $config = [];

    public static function setConfig($config) {
        $config = json_decode(json_encode($config));
        static::$config = $config;
    }

    /**
     * Get the connection from the connections buffer
     * @param $connectionName
     * @return Database
     * @throws \Exception
     */
    public static function getDataSource($connectionName = 'default') {
        if ($connectionName == 'default') {
            if (!empty(static::$config->default)) {
                $connectionName = static::$config->default;
            } else {
                throw new DbException("Default connection not exists");
            }
        }

        if (empty(static::$config->connections->{$connectionName})) {
            throw new DbException("Connection {$connectionName} is not defined");
        }

        //use the connection stored in buffer or create a new one
        if ( !empty( static::$connections->{$connectionName} ) ) {
            $connection = static::$connections[$connectionName];
        } else {
            $config = static::$config->connections->{$connectionName};

            //create the connection
            $connectionFactory = new ConnectionFactory();
            $conn = $connectionFactory->make($config);

            //create the adapter
            $adapterClassName = sprintf("\\koritaki\\Database\\Adapters\\%s", ucfirst($config->driver));
            if (class_exists($adapterClassName)) {
                $connection = new $adapterClassName( $conn );
            }
        }
        return $connection;
    }
}