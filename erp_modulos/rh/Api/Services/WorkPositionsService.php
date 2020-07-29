<?php

namespace Api\Services;

use Api\Validators\SchemaValidator;
use Api\DataAccess\WorkPositionDataAccess;

class WorkPositionsService
{

    public function getPosition($id)
    {
        $dataAccess = new WorkPositionDataAccess();
        $result = $dataAccess->select($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getPositionByDepartment($department)
    {
        $dataAccess = new WorkPositionDataAccess();
        $result = $dataAccess->selectByDepartment($department);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getPositionSupervisorsByDepartment($supervisors, $department)
    {
        if($supervisors){
            $dataAccess = new WorkPositionDataAccess();
            $result = $dataAccess->selectSupervisorsByDepartment($department);
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result);
        } else {
            $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        }
        return $response;
    }

    public function getAllPositions()
    {
        $dataAccess = new WorkPositionDataAccess();
        $result = $dataAccess->selectAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function createPosition($data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'positions');

        if ($validationResult === true) {
            $dataAccess = new WorkPositionDataAccess();
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

    public function updatePosition($id, $data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'positions');

        if ($validationResult === true) {
            $dataAccess = new WorkPositionDataAccess();
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

    public function deletePosition($id)
    {
        $dataAccess = new WorkPositionDataAccess();
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