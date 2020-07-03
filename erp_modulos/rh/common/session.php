<?php

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../libs/database.php';

//session_cache_limiter('private');
//session_cache_expire(0);
session_start(['read_and_close' => true]);
error_reporting(0);

$id_usr = $_SESSION['id'];

if (!isset($id_usr)) {
    header('Location:' . URL . '/erp_modulos/login/index.php');
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$key = array_search('rh', $uri);
$route = isset($uri[$key + 1]) ? $uri[$key + 1] : null;

$_SESSION['id_empleado'] = $db->get('usuarios', 'id_empleado', ['id_usr' => $id_usr]);

if ($route) {

    switch ($route) {

        case 'departamentos':
            $_SESSION['module'] = $db->get("modulos", "id_modulo", ["nombre_modulo" => "rh/departamentos"]);
            if (!in_array($_SESSION['module'], $_SESSION["consultar"])) {
                header("Location:" . URL . "/403.html");
            }
            break;

        case 'empleados':
            $_SESSION['module'] = $db->get("modulos", "id_modulo", ["nombre_modulo" => "rh/empleados"]);
            if (!in_array($_SESSION['module'], $_SESSION["consultar"])) {
                header("Location:" . URL . "/403.html");
            }
            break;

        case 'puestos':
            $_SESSION['module'] = $db->get("modulos", "id_modulo", ["nombre_modulo" => "rh/puestos"]);
            if (!in_array($_SESSION['module'], $_SESSION["consultar"])) {
                header("Location:" . URL . "/403.html");
            }
            break;

        case 'vacaciones':
            $_SESSION['module'] = $db->get("modulos", "id_modulo", ["nombre_modulo" => "rh/vacaciones"]);
            if (!in_array($_SESSION['module'], $_SESSION["consultar"])) {
                header("Location:" . URL . "/403.html");
            }
            break;

        default:
            header("HTTP/1.1 404 Not Found");
            exit();
    }

} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}