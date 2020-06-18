<?php

namespace Api\DataAccess;

use Api\Connectors\DatabaseConnector;
use PDO;
use PDOException;

class DepartmentsDataAccess
{

    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = (new DatabaseConnector())->connection();
    }

    public function selectAll()
    {
        $stmt = $this->dbConnection->query('SELECT * from departamentos_rh');
        try {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function select($id)
    {
        $stmt = $this->dbConnection->prepare('SELECT * FROM departamentos_rh WHERE id = ?');
        try {
            $stmt->execute(array($id));
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($data)
    {
        $values = json_decode($data, true);
        $stmt = $this->dbConnection->prepare('INSERT INTO departamentos_rh (name) VALUES (:name)');
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
        $stmt = $this->dbConnection->prepare('UPDATE departamentos_rh SET name = :name WHERE id = :id');
        try {
            $stmt->execute(array_map('trim', $values));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $stmt = $this->dbConnection->prepare('DELETE FROM departamentos_rh WHERE id = ?');
        try {
            $stmt->execute(array($id));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
