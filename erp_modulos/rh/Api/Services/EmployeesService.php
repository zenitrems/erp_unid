<?php

namespace Api\Services;

use Api\Validators\SchemaValidator;
use Api\DataAccess\EmployeesDataAccess;

class EmployeesService
{

    public function createEmployee($data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'employees');

        if ($validationResult === true) {
            $dataAccess = new EmployeesDataAccess();
            $result = $dataAccess->insert($data);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode($result);
            return $response;

        } else {
            $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
            $response['body'] = json_encode($validationResult);
            return $response;
        }
    }

    public function getAllEmployees()
    {
        $dataAccess = new EmployeesDataAccess();
        $result = $dataAccess->selectAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getAllEmployeesSupervisorsByDepartment($supervisors, $department)
    {
        if($supervisors){
            $dataAccess = new EmployeesDataAccess();
            $result = $dataAccess->selectAllSupervisorsByDepartment($department);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result);
        } else{
            $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        }
        return $response;
    }

    public function getEmployee($id)
    {
        $dataAccess = new EmployeesDataAccess();
        $result = $dataAccess->select($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function disableEmployee($id)
    {
        $dataAccess = new EmployeesDataAccess();
        $result = $dataAccess->disable($id);
        if($result === 0) {
            $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
            $response['body'] = $result;
            return $response;
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
}