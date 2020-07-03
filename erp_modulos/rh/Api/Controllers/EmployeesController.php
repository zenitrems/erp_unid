<?php

namespace Api\Controllers;

use Api\Services\EmployeesService;

class EmployeesController
{

    public function process($requestMethod, $id, $params, $data)
    {
        $services = new EmployeesService();

        switch ($requestMethod) {

            case 'GET':
                if($id){
                    $response = $services->getEmployee($id);
                } elseif ($params && isset($params['supervisors']) && isset($params['department'])) {
                    $response = $services->getAllEmployeesSupervisorsByDepartment($params['supervisors'], $params['department']);
                } else {
                    $response = $services->getAllEmployees();
                }
                break;

            case 'POST':
                if ($data) {
                    $response = $services->createEmployee($data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
            break;

            case 'DELETE':
                if ($id) {
                    $response = $services->disableEmployee($id);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            default:
                $response['status_code_header'] = 'HTTP/1.1 405 Method Not Allowed';
                break;
        }

        header($response['status_code_header']);
        if (isset($response['body'])) {
            echo $response['body'];
        }
    }
}