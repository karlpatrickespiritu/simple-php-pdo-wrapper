<?php

$base = '../../';
require_once $base . 'config.php';
require_once $base . 'libs/simple-php-pdo-class/DB.php';

$id	 		= $aPOST['id'];
$name 		= $aPOST['name'];
$address 	= $aPOST['address'];
$email 		= $aPOST['email'];
$response 	= [
    'success' => false,
    'data' 	  => null,
];

// simply create a new instance of DB class
$db = new DB();

// execute update via query method. delete|insert|update queries returns number of affected rows
$affectedRows = $db->query(
    "UPDATE users SET name = :name, address = :address, email = :email WHERE id = :id",
    [':id' => $id, ':name' => $name, ':address' => $address, ':email' => $email,]
);

$response['success'] = $affectedRows > 0;

// generate response
echo json_encode($response); exit;