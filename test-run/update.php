<?php

require_once 'config.php';

use PDO\DB;

// not recommened use
/**
DB::i()->exec(
    "UPDATE `users` SET name = ?, email = ? WHERE id = ?",
    ["nick", "nick@nick.com", 98]
);
**/

// recommended use, more readable

$params = [
    ":name" => "John Mayer",
    ":email" => "mayer@somesite.com",
    ":id" => 3
];

$affectedRows = DB::i()->exec("UPDATE `users` SET name = :name, email = :email WHERE id = :id", $params);


dd($affectedRows);