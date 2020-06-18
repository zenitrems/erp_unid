<?php

namespace Api\Services;

use Api\DataAccess\DefinedOptionsDataAccess;

class DefinedOptionsService
{

    public function getAllOptions()
    {
        $dataAccess = new DefinedOptionsDataAccess();
        $result = $dataAccess->selectAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
}