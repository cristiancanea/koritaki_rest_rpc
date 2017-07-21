<?php

require_once '_init.php';

$server->getProcedureHandler()
    ->withCallback('country', function ($code) use( $connection ) {

        $connection->query('SELECT `name`, `prefix` FROM locations_countries WHERE code = ?;', [ $code ]);
        $data = $connection->fetch();

        return $data;
    })
;

echo $server->execute();