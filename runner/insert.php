<?php

require_once 'config.php';

use PHPPDO\DB;

DB::i()->exec(
    "INSERT INTO `users`(`name`, `address`, `email`) VALUES (?, ?, ?)",
    ['brian', 'labangon', 'brian@brian.com']
);

DB::i()->exec("INSERT INTO `users`(`name`, `address`, `email`) VALUES (:name, :address, :email)", [
    ':address' => 'urgello',
    ':name' => 'Karl',
    ':email' => 'karl.espiritu@corp.mobile.co'
]);

dd(DB::i()->getLastId());