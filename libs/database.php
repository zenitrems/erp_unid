<?php

require ROOT_PATH . "/vendor/autoload.php";

// Using Medoo namespace
use Medoo\Medoo;

// Initialize
$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => DB,
    'server' => SERVER,
    'username' => USER,
    'password' => PASSWORD
]);
