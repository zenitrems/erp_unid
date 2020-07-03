<?php

namespace Api\DataAccess;

use Api\Connectors\DatabaseConnector;
use PDO;
use PDOException;

class WorkPositionDataAccess
{

    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new DatabaseConnector())->connection();
    }

    public function selectAll()
    {
        try {
            $stmt = $this->dbConnection->query('SELECT pus.id AS id, positionName, positionDepartment, dep.name AS departmentName, positionIsSupervisor FROM puestos_empleados_rh pus JOIN departamentos_rh dep ON pus.positionDepartment = dep.id');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function select($id)
    {
        $stmt = $this->dbConnection->prepare('SELECT pus.id AS id, positionName, positionDepartment, dep.name AS departmentName, positionIsSupervisor FROM puestos_empleados_rh pus JOIN departamentos_rh dep ON pus.positionDepartment = dep.id WHERE pus.id = ?');
        try {
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function selectByDepartment($department)
    {
        $stmt = $this->dbConnection->prepare('SELECT pus.id AS id, positionName, positionDepartment, dep.name AS departmentName, positionIsSupervisor FROM puestos_empleados_rh pus JOIN departamentos_rh dep ON pus.positionDepartment = dep.id WHERE dep.id = ?');
        try {
            $stmt->execute(array($department));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function selectSupervisorsByDepartment($department)
    {
        $stmt = $this->dbConnection->prepare('SELECT pus.id AS id, positionName, positionDepartment, dep.name AS departmentName, positionIsSupervisor FROM puestos_empleados_rh pus JOIN departamentos_rh dep ON pus.positionDepartment = dep.id WHERE dep.id = ? AND positionIsSupervisor = 1');
        try {
            $stmt->execute(array($department));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($data)
    {
        $values = json_decode($data, true);
        $stmt = $this->dbConnection->prepare('INSERT INTO puestos_empleados_rh (positionName, positionDepartment, positionIsSupervisor) VALUES (:positionName, :positionDepartment, :positionIsSupervisor)');
        try {
            $stmt->execute(array_map('trim', $values));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, $data)
    {
        $values = json_decode($data, true);
        $values['id'] = $id;
        $stmt = $this->dbConnection->prepare('UPDATE puestos_empleados_rh SET positionName = :positionName, positionDepartment = :positionDepartment, positionIsSupervisor = :positionIsSupervisor WHERE id = :id');
        try {
            $stmt->execute(array_map('trim', $values));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $stmt = $this->dbConnection->prepare('DELETE FROM puestos_empleados_rh WHERE id = ?');
        try {
            $stmt->execute(array($id));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

}
