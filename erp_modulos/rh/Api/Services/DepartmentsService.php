<?php

namespace Api\Services;

use Api\Validators\SchemaValidator;
use Api\DataAccess\DepartmentsDataAccess;

class DepartmentsService
{

    public function getAllDepartments()
    {
        $dataAccess = new DepartmentsDataAccess();
        $result = $dataAccess->selectAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function createDepartment($data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'departments');

        if ($validationResult === true) {
            $dataAccess = new DepartmentsDataAccess();
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

    public function getDepartment($id)
    {
        $dataAccess = new DepartmentsDataAccess();
        $result = $dataAccess->select($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function updateDepartment($id, $data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'departments');

        if ($validationResult === true) {
            $dataAccess = new DepartmentsDataAccess();
            $result = $dataAccess->update($id, $data);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode($result);
            return $response;

        } else {
            $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
            $response['body'] = json_encode($validationResult);
            return $response;
        }
    }

    public function deleteDepartment($id)
    {
        $dataAccess = new DepartmentsDataAccess();
        $result = $dataAccess->delete($id);
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