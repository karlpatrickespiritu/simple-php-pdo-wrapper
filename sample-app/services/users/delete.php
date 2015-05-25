<?php

$base = '../../';
require_once $base . 'config.php';
require_once $base . 'libs/simple-php-pdo-class/DB.php';

// you might need to clean POST requests.
// but for the sake of the testing, just assign them directly.
$id 		= $_POST['id'];
$response 	= [
    'success' => false,
    'data' 	  => null,
    'html' 	  => ''
];

// simply create a new instance of DB class
$db = new DB();

// execute delete via query method. delete|insert|update queries returns number of affected rows
$affectedRows = $db->query("DELETE FROM users WHERE id = :id", ['id' => $id]);

$response['success'] = $affectedRows > 0;

// generate response
echo json_encode($response); exit;