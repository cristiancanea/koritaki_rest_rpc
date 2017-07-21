<?php

return [
    'default'   => 'mysql_local',
    'connections'   => [
        'mysql_local' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'port'      => null,
            'socket'    => null,
            'user'      => 'root',
            'password'  => '',
            'database'  => 'test',
            'fetch'     => MYSQLI_ASSOC,
        ],
        'mysql_local_clone' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'port'      => null,
            'socket'    => null,
            'user'      => 'root',
            'password'  => '',
            'database'  => 'test',
            'fetch'     => MYSQLI_ASSOC,
        ],
    ]
];