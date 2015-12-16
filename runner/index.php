<?php

require_once 'config.php';

use PHPPDO\DB;

$type = 'update';

if ($type === 'insert') {
	DB::i()->exec(
		"INSERT INTO `users`(`name`, `address`, `email`) VALUES (?, ?, ?)",
		['brian', 'labangon', 'brian@brian.com']
	);

	DB::i()->exec("INSERT INTO `users`(`name`, `address`, `email`) VALUES (:name, :address, :email)", [
		':address' => 'urgello',
		':name' => 'Karl',
		':email' => 'karl.espiritu@corp.mobile.co'
	]);

	dd(DB::i()->lastId());
}

if ($type === 'delete') {
	DB::i()->exec("DELETE FROM `users` WHERE id = :id", [':id' => 99]);
	DB::i()->exec("DELETE FROM `users` WHERE id = ?", [100]);
} 

if ($type === 'update') {
	DB::i()->exec(
		"UPDATE `users` SET name = ?, email = ? WHERE id = ?", 
		["nick", "nick@nick.com", 98]
	);

	DB::i()->exec("UPDATE `users` SET name = :name, email = :email WHERE id = :id", [
		":name" => "clyde", 
		":email" => "clyde@clyde.com",
		":id" => 97
	]);
}

if ($type === 'select') {
	DB::i()->setFetchMode(PDO::FETCH_OBJ);
	// $data = DB::i()->fetchRows('SELECT * FROM projects LIMIT 3');
	$data = DB::i()->fetch('SELECT * FROM projects WHERE id = :id', [':id' => 1], PDO::FETCH_ASSOC);

	dd(DB::i()->getRowCount(), $data);
}