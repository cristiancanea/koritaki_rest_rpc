<?php
namespace koritaki\Database\Adapters;

interface DatabaseAdapterInterface {
    public function query($sql, array $binds, array $extra = null);
    public function fetch();
    public function lastInsertId();
    public function affectedRows();
    public function begin();
    public function commit();
    public function rollback();
}