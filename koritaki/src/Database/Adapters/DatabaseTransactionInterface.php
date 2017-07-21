<?php
namespace koritaki\Database\Adapters;

interface DatabaseTransactionInterface {
    public function begin();
    public function commit();
    public function rollback();
}