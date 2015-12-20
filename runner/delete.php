<?php

require_once 'config.php';

use PDO\DB;

DB::i()->exec("DELETE FROM `users` WHERE id = :id", [':id' => 99]);
DB::i()->exec("DELETE FROM `users` WHERE id = ?", [100]);