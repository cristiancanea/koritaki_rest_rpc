<?php
namespace koritaki\Database\Orm;
use koritaki\Database\Adapters\DatabaseAdapterInterface;

/**
 * Class Model
 * @package koritaki\Model
 */
abstract class Model
{
    protected $table = null;
    protected $connection;

    public function __construct()
    {

    }

    /**
     * @param DatabaseAdapterInterface $connection
     */
    public function setConnection(DatabaseAdapterInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Execute row query
     */
    public function query($sql, array $binds, array $extra = null)
    {
        $this->connection->query($sql, $binds, $extra);
        $data = $this->connection->fetch();
        return $data;
    }

    /**
     * @param array $paramsWhere
     * @param $binds
     * @return string
     */
    //TODO: improve this
    private function prepareWhere($whereParam, &$binds)
    {
        $where = '';

        list($column, $operator, $value) = $whereParam;
        $where .= sprintf(' `%s` %s ? ', $column, $operator);
        $binds[] = $value;

        return $where;
    }

    /**
     * Read model
     * @param array $params = [
     *
     *              ]
     */
    public function read(array $params = [])
    {
        //default params
        $params = $params + [
                'columns' => '*',
                'where' => '1',
            ];

        $binds = [];

        $where = '';
        if (is_array($params['where'])) {
            $where = $this->prepareWhere($params['where'], $binds);
        }

        if (is_array($params['columns'])) {
            $params['columns'] = implode(',', $params['columns']);
        }

        if (!empty($params['limit'])) {
            $limit = 'LIMIT ?';
            $binds[] = $params['limit'];
        }

        $sql = sprintf(
            'SELECT %s FROM `%s` WHERE %s %s',
            $params['columns'],
            $this->table,
            !empty($where) ? $where : $params['where'],
            $limit
        );

        $this->connection->query($sql, $binds);

        $data = $this->connection->fetch();

        return $data;
    }

    /**
     * @param $column
     * @param $value
     */
    public function findBy($column, $value)
    {
        return $this->read([
            'where' => [$column, '=', $value],
        ]);
    }

    /**
     * Create
     * @param array $data
     */
    public function create(array $data)
    {
        $columns = implode(',', array_keys($data));
        $binds = array_values($data);
        $valuesPrepared = rtrim(str_repeat('?,', count($binds)), ',');

        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s);', $this->table, $columns, $valuesPrepared);

        $this->connection->query($sql, $binds);

        $id = $this->connection->lastInsertId();

        return $id;
    }

    /**
     * Update
     * @param array $condition
     * @param array $data
     * @return array
     */
    public function update(array $condition, array $data)
    {
        $binds = array_values($data);
        $columnsPrepared = implode(' = ? , ', array_keys($data)) . ' = ?';

        $where = '';
        if (is_array($condition)) {
            $where = $this->prepareWhere($condition, $binds);
        }

        $sql = sprintf('UPDATE %s SET %s WHERE %s', $this->table , $columnsPrepared, $where);

        $this->connection->query($sql, $binds);
        $data = $this->connection->affectedRows();

        return $data;
    }

    /**
     * Delete
     * @param array $params
     * @return
     */
    public function delete(array $params){
        $binds = [];
        $where = '';
        if (is_array($params['where'])) {
            $where = $this->prepareWhere($params['where'], $binds);
        }

        $sql = sprintf('DELETE FROM %s WHERE %s', $this->table, $where);
        $this->connection->query($sql, $binds);
        $data = $this->connection->affectedRows();

        return $data;
    }

    /**
     * Transaction begin
     * @return mixed
     */
    public function transactionBegin()
    {
        if (method_exists($this->connection, 'begin')) {
            return $this->connection->begin();
        }
        return true;
    }

    /**
     * Transaction commit
     * @return mixed
     */
    public function transactionCommit()
    {
        if (method_exists($this->connection, 'commit')) {
            return $this->connection->commit();
        }
        return true;
    }

    /**
     * Transaction rollback
     * @return mixed
     */
    public function transactionRollback()
    {
        if (method_exists($this->connection, 'rollback')) {
            return $this->connection->rollback();
        }
    }
}