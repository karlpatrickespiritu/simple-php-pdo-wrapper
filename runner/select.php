<?php

require_once 'config.php';

use PDO\DB;

DB::i()->setFetchMode(PDO::FETCH_OBJ);
// $data = DB::i()->fetchRows('SELECT * FROM projects LIMIT 3');
$data = DB::i()->fetch('SELECT * FROM projects WHERE id = :id', [':id' => 1]);

dd(
    DB::i()->getLastQuery(),
    DB::i()->getRowCount(),
    $data
);