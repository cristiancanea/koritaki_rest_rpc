<?php
namespace koritaki\Database\Connectors;

interface ConnectorInterface {
    public function connect($config);
}
