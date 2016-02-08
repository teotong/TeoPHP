<?php

namespace configs;

return array(
    'test' => array(
//            'class' => 'Db_Adapter',
        'username' => array('username', 'username', 'username', 'username'),
        'password' => array('password', 'password', 'password', 'password'),
        'timeout' => 10,
        'charset' => 'utf8',
        'dsn' => array(
            'mysql:host=127.0.0.1;port=3306;dbname=test',
            'mysql:host=127.0.0.1;port=3306;dbname=test',
            'mysql:host=127.0.0.1;port=3306;dbname=test',
            'mysql:host=127.0.0.1;port=3306;dbname=test',
        )
    ),
    'logpath' => array('path' => 'log/' . date('Y-m-d') . '.log'),
);