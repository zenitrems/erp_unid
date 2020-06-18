<?php

namespace Api\Controllers;

use Api\Services\DefinedOptionsService;

class DefinedOptionsController
{

    public function process($requestMethod)
    {
        $services = new DefinedOptionsService();

        switch ($requestMethod) {

            case 'GET':
                $response = $services->getAllOptions();
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