<?php

namespace Api\Services;

use Api\Validators\SchemaValidator;
use Api\DataAccess\VacationsDataAccess;

class VacationsService
{

    public function getVacation($id)
    {
        $dataAccess = new VacationsDataAccess();
        $result = $dataAccess->select($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getVacationByUser($user)
    {
        $dataAccess = new VacationsDataAccess();
        $result = $dataAccess->selectByUser($user);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getVacationByEmployee($employee)
    {
        $dataAccess = new VacationsDataAccess();
        $result = $dataAccess->selectByEmployee($employee);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }


    public function getVacationBySupervisor($supervisor)
    {
        $dataAccess = new VacationsDataAccess();
        $result = $dataAccess->selectBySupervisor($supervisor);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getAllVacations()
    {
        $dataAccess = new VacationsDataAccess();
        $result = $dataAccess->selectAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function createVacation($data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'vacations');

        if ($validationResult === true) {
            $dataAccess = new VacationsDataAccess();
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

    public function updateVacation($id, $data)
    {
        $validation = new SchemaValidator();
        $validationResult = $validation->validateSchema($data, 'vacations');

        if ($validationResult === true) {
            $dataAccess = new VacationsDataAccess();
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

    public function deleteVacation($id)
    {
        $dataAccess = new VacationsDataAccess();
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