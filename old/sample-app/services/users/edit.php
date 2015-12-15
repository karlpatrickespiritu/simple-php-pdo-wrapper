<?php

$base = '../../';
require_once $base . 'config.php';
require_once $base . 'libs/simple-php-pdo-class/DB.php';

$id	 		= $_POST['id'];
$name 		= $_POST['name'];
$address 	= $_POST['address'];
$email 		= $_POST['email'];
$response 	= [
    'success' => false,
    'data' 	  => null,
];

// simply create a new instance of DB class
$db = new DB();

$aUpdateValues = [
    'name'      => $name,
    'address'   => $address,
    'email'     => $email
];
$iAffectedRows = $db->update('users')->set($aUpdateValues)->where('id = :id', [':id' => $id]);

if($iAffectedRows > 0) {
    $user = $db->fetchRow("SELECT * FROM users WHERE id = :id", [':id' => $id]);
    $response['success'] 		= true;
    $response['data']['user']   = $user;
}

// generate response
echo json_encode($response); exit;