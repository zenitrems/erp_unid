<?php

require "../../../vendor/autoload.php";

// Using Medoo namespace
use Medoo\Medoo;

// Initialize
$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'sonicbea_erp',
    'server' => 'servidor1242.il.controladordns.com',
    'username' => 'sonicbea_tram',
    'password' => 'VfQnYRVhg39RCgq'
]);
