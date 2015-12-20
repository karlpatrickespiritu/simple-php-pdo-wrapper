<?php

require_once 'config.php';

use PDO\DB;

// fetch a single row in the result set
$singleRow = DB::i()->fetch('SELECT * FROM `users` WHERE `name` = :name', ['name' => 'Justin Beiber']);


// fetch a multiple rows in the result set
$multipleRows = DB::i()->fetchRows('SELECT * FROM projects');

// fetch a joined query
$joinQuery = 
	'SELECT `u`.*, `p`.* FROM `users` as `u`
		JOIN `projects` as `p`
		ON `u`.`id` = `p`.`user_id`
	 WHERE `p`.`user_id` = :john_id 
		OR `p`.`user_id` = :beiber_id';

$joinQueryParams = [':john_id' => 1, ':beiber_id' => 3];

$joinedQueryResults = DB::i()->fetchRows($joinQuery, $joinQueryParams);

// dump data
dd($singleRow, $multipleRows, $joinedQueryResults);