<?php

namespace Api\Controllers;

use Api\Services\WorkPositionsService;

class WorkPositionsController
{

    public function process($requestMethod, $id, $params, $data)
    {
        $services = new WorkPositionsService();

        switch ($requestMethod) {

            case 'GET':
                if ($id) {
                    $response = $services->getPosition($id);
                } elseif ($params && isset($params['supervisors']) && isset($params['department'])) {
                    $response = $services->getPositionSupervisorsByDepartment($params['supervisors'], $params['department']);
                } elseif ($params && isset($params['department'])) {
                    $response = $services->getPositionByDepartment($params['department']);
                } else{
                    $response = $services->getAllPositions();

                }
                break;

            case 'POST':
                if ($data) {
                    $response = $services->createPosition($data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            case 'PUT':
                if ($data) {
                    $response = $services->updatePosition($id, $data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            case 'DELETE':
                if ($id) {
                    $response = $services->deletePosition($id);
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