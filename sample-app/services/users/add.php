<?php

$base = '../../';
require_once $base . 'config.php';
require_once $base . 'libs/simple-php-pdo-class/DB.php';

$response 	= [
    'success' => false,
    'data' 	  => null,
];

// simply create a new instance of DB class
$db = new DB();

/* OPTION 1 */
// $bindValues = [
// 	':name' 	=> $_POST['name'],
// 	':address' 	=> $_POST['address'],
// 	':email' 	=> $_POST['email']
// ];
// $affectedRows = $db->query(
// 	"INSERT INTO users (name, address, email)
// 	 VALUES (:name, :address, :email)",
// 	$bindValues
// );

/* OPTION 2 */
$insertValues = [
    'name' 		=> $_POST['name'],
    'address' 	=> $_POST['address'],
    'email' 	=> $_POST['email']
];
$affectedRows = $db->insert('users')->values($insertValues);

if($affectedRows > 0) {
    // just to show you the how to get the last inserted id.
    $user = $db->fetchRow("SELECT * FROM users WHERE id = :id", [':id' => $db->getLastInsertID()]);

    $response['success']		= true;
    $response['data']['user']   = $user;
}

// generate response
echo json_encode($response); exit;