<?php

$server = "67.227.206.154";
$db = "sonicbea_erp";
$user = "sonicbea_tram";
$password = "VfQnYRVhg39RCgq";
$mysqli = new mysqli($server, $user, $password, $db);
if ($mysqli === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
