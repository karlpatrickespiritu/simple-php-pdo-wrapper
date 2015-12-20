<?php

require_once 'config.php';

use PDO\DB;

DB::i()->exec(
    "UPDATE `users` SET name = ?, email = ? WHERE id = ?",
    ["nick", "nick@nick.com", 98]
);

DB::i()->exec("UPDATE `users` SET name = :name, email = :email WHERE id = :id", [
    ":name" => "clyde",
    ":email" => "clyde@clyde.com",
    ":id" => 97
]);