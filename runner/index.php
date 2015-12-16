<?php

require_once 'config.php';

use PHPPDO\DB;

$data = DB::i()
            ->setFetchMode(PDO::FETCH_OBJ)
            ->fetchRows('SELECT * FROM projects LIMIT 3');

dd(
    DB::i()->getRowCount(),
    $data
);