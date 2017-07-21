<?php
namespace client\Model;

use koritaki\Database\ConnectionManager;
use \koritaki\Database\Orm\Model as Model;

abstract class DbModel extends Model {
    public function __construct() {
        $this->setConnection( ConnectionManager::getDataSource() );
    }
}