<?php

require_once 'config.php';
require_once 'libs/simple-php-pdo-class/DB.php';

$db 	= new DB();
$users 	= $db->fetchRows('SELECT * FROM users ORDER BY id DESC');

// since we're not using a templating engine,
// just for the sake of testing, let's just have it this way :/
include_once 'views/partials/header.php';
    include_once 'views/pages/users/users-page.php';
include_once 'views/partials/footer.php';