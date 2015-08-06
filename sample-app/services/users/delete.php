<?php

$base = '../../';
require_once $base . 'config.php';
require_once $base . 'libs/simple-php-pdo-class/DB.php';

$id 		= $_POST['id'];
$response 	= [
    'success' => false,
    'data' 	  => null,
    'html' 	  => ''
];

// simply create a new instance of DB class
$db = new DB();

$affectedRows 		 = $db->delete('users')->where('id = :id', [':id' => $id]);
$response['success'] = $affectedRows > 0;

// generate response
echo json_encode($response); exit;