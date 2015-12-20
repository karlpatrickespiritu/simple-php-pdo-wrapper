<?php

require_once 'config.php';

use PDO\DB;

// not recommened use
// affectedRows = DB::i()->exec("DELETE FROM `users` WHERE id = ?", [2]);

// recommended use, more
$affectedRows = DB::i()->exec("DELETE FROM `users` WHERE id = :id", [':id' => 1]);

dd($affectedRows);