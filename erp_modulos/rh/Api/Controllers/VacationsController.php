<?php

namespace Api\Controllers;

use Api\Services\VacationsService;

class VacationsController
{

    public function process($requestMethod, $id, $params, $data)
    {
        $services = new VacationsService();

        switch ($requestMethod) {

            case 'GET':
                if ($id) {
                    $response = $services->getVacation($id);
                }elseif ($params && isset($params['user'])){
                    $response = $services->getVacationByUser($params['user']);
                }elseif ($params && isset($params['supervisor'])){
                    $response = $services->getVacationBySupervisor($params['supervisor']);
                }elseif ($params && isset($params['employee'])){
                    $response = $services->getVacationByEmployee($params['employee']);
                }else{
                    $response = $services->getAllVacations();

                }
                break;

            case 'POST':
                if ($data) {
                    $response = $services->createVacation($data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            case 'PUT':
                if ($data) {
                    $response = $services->updateVacation($id, $data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            case 'DELETE':
                if ($id) {
                    $response = $services->deleteVacation($id);
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