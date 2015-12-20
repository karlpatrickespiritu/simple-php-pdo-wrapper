<?php

require_once 'config.php';

use PDO\DB;

// not recommended use
/**
DB::i()->exec(
    "INSERT INTO `users`(`name`, `address`, `email`) VALUES (?, ?, ?)",
    ['brian', 'labangon', 'brian@brian.com']
);
**/

// recommended use, more readable
DB::i()->exec("INSERT IGNORE INTO `users`(`name`, `address`, `email`) VALUES (:name, :address, :email)", [
    ':address' => 'urgello',
    ':name' => 'Karl',
    ':email' => 'karl.espiritu@corp.mobile.co'
]);

// dump data
dd(DB::i()->getLastId());