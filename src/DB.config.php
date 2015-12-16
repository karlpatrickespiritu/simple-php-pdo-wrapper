<?php

return [
    /**
     * Your database configuration. Modify accordingly.
     *
     * @see http://php.net/manual/en/pdo.construct.php
     */
    'DB_CONFIG' => [
        'host' => 'localhost',
        'port' => '',
        'dbname' => 'mobileco2',
        'username' => 'root',
        'password' => ''
    ],

    /**
     * Default PDO attributes. Modify accordingly.
     *
     * @see http://php.net/manual/en/pdo.setattribute.php
     */
    'PDO_ATTRIBUTES' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];