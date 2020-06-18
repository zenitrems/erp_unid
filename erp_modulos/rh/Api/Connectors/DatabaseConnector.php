<?php

namespace Api\Connectors;

use PDO;
use PDOException;

class DatabaseConnector
{
    private $dbConnection;

    public function __construct()
    {
        $host = 'servidor1242.il.controladordns.com';
        $database = 'sonicbea_erp';
        $username = 'sonicbea_tram';
        $password = 'VfQnYRVhg39RCgq';

        try {
            $this->dbConnection = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function connection()
    {
        return $this->dbConnection;
    }
}