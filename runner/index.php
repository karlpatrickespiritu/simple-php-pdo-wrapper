<?php

require_once 'config.php';

use PHPPDO\DB;

DB::i()->setFetchMode(PDO::FETCH_OBJ);
// $data = DB::i()->fetchRows('SELECT * FROM projects LIMIT 3');
$data = DB::i()->fetch('SELECT * FROM projects WHERE id = :id', [':id' => 1], PDO::FETCH_ASSOC);

dd(DB::i()->getRowCount(), $data);