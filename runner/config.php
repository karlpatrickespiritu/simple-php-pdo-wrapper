<?php

/*======== This is just a test runner file :) =======*/

ini_set('default_charset', 'utf-8');
// ERRORS
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('display_errors', 'On');

if (!function_exists('dd')) {
    /**
     * `dd()` a shortcut for `var_dump(); exit;`
     */
    function dd() {
        $aArgs = func_get_args();
        if ($aArgs) {
            foreach ($aArgs as $mArg) {
                var_dump($mArg);
                echo '<br>';
            }
        }
        exit;
    }
}

include_once '../vendor/autoload.php';

/*==================================*/