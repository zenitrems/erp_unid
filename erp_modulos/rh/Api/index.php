<?php

require (__DIR__ . '/../../../vendor/autoload.php');

use Api\Controllers\DepartmentsController;
use Api\Controllers\EmployeesController;
use Api\Controllers\DefinedOptionsController;
use Api\Controllers\WorkPositionsController;
use Api\Controllers\VacationsController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
isset($_SERVER['QUERY_STRING']) ? parse_str($_SERVER['QUERY_STRING'], $params) : $params = null;
$uri = explode('/', $uri);
$key = array_search('Api', $uri);
$route = isset($uri[$key + 1]) ? $uri[$key + 1] : null;
$requestMethod = $_SERVER["REQUEST_METHOD"];
$id = isset($uri[$key + 2]) ? $uri[$key + 2] : null;
$data = file_get_contents('php://input') ? file_get_contents('php://input') : null;

$departments = new DepartmentsController();
$employees = new EmployeesController();
$definedOptions= new DefinedOptionsController();
$workPositions = new WorkPositionsController();
$vacations = new VacationsController();

if ($route) {

    switch ($route) {

        case 'departments':
            $departments->process($requestMethod, $id, $data);
            break;

        case 'employees':
            $employees->process($requestMethod, $id, $params, $data);
            break;

        case 'definedOptions':
            $definedOptions->process($requestMethod);
            break;

        case 'positions':
            $workPositions->process($requestMethod, $id, $params, $data);
            break;

        case 'vacations':
            $vacations->process($requestMethod, $id, $params, $data);
            break;

        default:
            header("HTTP/1.1 404 Not Found");
            exit();
    }

} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

