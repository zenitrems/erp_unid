<?php

namespace Api\Controllers;

use Api\Services\DepartmentsService;

class DepartmentsController
{

    public function process($requestMethod, $id, $data)
    {
        $services = new DepartmentsService();

        switch ($requestMethod) {

            case 'GET':
                if ($id) {
                    $response = $services->getDepartment($id);
                } else {
                    $response = $services->getAllDepartments();
                }
                break;

            case 'POST':
                if ($data) {
                    $response = $services->createDepartment($data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            case 'PUT':
                if ($data) {
                    $response = $services->updateDepartment($id, $data);
                } else {
                    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                    exit();
                }
                break;

            case 'DELETE':
                if ($id) {
                    $response = $services->deleteDepartment($id);
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