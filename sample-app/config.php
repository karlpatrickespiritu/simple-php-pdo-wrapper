<?php

// display errors
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

define('LIB_PATH', $_SERVER['REQUEST_URI']. 'libs');

// clean post variables
$_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
$_GET  = filter_var_array($_GET, FILTER_SANITIZE_STRING);