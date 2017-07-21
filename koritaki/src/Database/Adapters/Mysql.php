<?php
/**
 * Mysql Adapter using Mysqli extension
 */

namespace koritaki\Database\Adapters;

use Exception;
use koritaki\Database\Exceptions\DbException;
use mysqli;
use ReflectionClass;

class Mysql implements DatabaseAdapterInterface, DatabaseTransactionInterface {
    private $_connection;
    private $_stmt;

    public function __construct(mysqli $connection) {
        $this->_connection = $connection;
    }

    public function disconnect() {
        return $this->_connection->close();
    }

    /**
     * @param $sql
     * @param array $binds
     * @param array $extra
     */
    public function query($sql, array $binds, array $extra = null) {
        $ret = false;
        $bindParams = [];

        if ($this->_stmt = $this->_connection->prepare($sql)) {

            if ( !empty($binds) ) {
                $bindsWithTypes = $this->prepareBinds($binds);
                foreach ($bindsWithTypes as $key => $val) {
                    $bindParams[$key] = &$bindsWithTypes[$key];
                }

                $ref    = new ReflectionClass('mysqli_stmt');
                $method = $ref->getMethod("bind_param");
                $method->invokeArgs($this->_stmt, $bindParams);
            }

            /* execute query */
            $ret = $this->_stmt->execute();
        }

        return (bool)$ret;
    }

    /**
     * @return mixed
     */
    public function lastInsertId() {
        return $this->_connection->insert_id;
    }

    /**
     * @return int
     */
    public function affectedRows() {
        return $this->_connection->affected_rows;
    }

    /**
     * @return array
     */
    public function fetch() {
        $data = [];

        try {
            $result = $this->_stmt->get_result();

            while ( $row  = $result->fetch_array(MYSQLI_ASSOC) ) {
                $data[] = $row;
            }

            $this->_stmt->close();
        } catch (Exception $e) {
            throw new DbException('fetch error');
        }

        return $data;
    }

    /**
     * @param array $params
     * @return array
     */
    private function prepareBinds($params = []) {
        $params = !empty($params) ? array_values($params) : [];
        $types = '';

        array_walk ($params, function ($item, $key) use (&$params, &$types) {
            if (is_float($item))   {
                $types .= 'd';
            } elseif (is_integer($item)) {
                $types .= 'i';
            } elseif (is_string($item)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
        });
        array_unshift($params, $types);

        return $params;
    }

    /**
     * Transaction becgin
     * @return bool
     */
    public function begin()
    {
        return $this->_connection->begin_transaction();
    }

    /**
     * Transaction commit
     * @return bool
     */
    public function commit()
    {
        return $this->_connection->commit();
    }

    /**
     * Transaction rollback
     * @return bool
     */
    public function rollback()
    {
        return $this->_connection->rollback();
    }
}

