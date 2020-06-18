<?php

namespace Api\DataAccess;

use Api\Connectors\DatabaseConnector;
use PDO;
use PDOException;

class DefinedOptionsDataAccess
{

    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new DatabaseConnector())->connection();
    }

    public function selectAll()
    {
        $response = (object)Array();
        $queries  = (object)Array(
            'nationality' => 'SELECT * FROM nacionalidad_empleados_rh',
            'dependOn' => 'SELECT * FROM depende_de_empleados_rh',
            'maritalStatus' => 'SELECT * FROM estado_civil_empleados_rh',
            'status' => 'SELECT * FROM estatus_empleados_rh',
            'livesWith' => 'SELECT * FROM vive_con_empleados_rh'
        );
            foreach ($queries as $prop => $query){
                $stmt = $this->dbConnection->query($query);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response->$prop = $data;
            }
        return $response;
    }
}
