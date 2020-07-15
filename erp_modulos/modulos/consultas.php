<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

// require_once 'local-database.php';

if ($_POST) {

    switch ($_POST["accion"]) {
            //Functions Modulos
        case "getModulo":
            getModulo($_POST["modulo"]);
            break;

        case "insertModulo":
            insertModulo();
            break;

        case "updateModulo":
            updateModulo($_POST["modulo"]);
            break;

        case "deleteModulo":
            deleteModulo($_POST["modulo"]);
            break;

            //Functions ModulosPrincipales
        case "getModuloP":
            getModuloP($_POST["id_modulo_principal"]);
            break;

        case "insertModuloP":
            insertModuloP();
            break;

        case "updateModuloP":
            updateModuloP($_POST["id_modulo_principal"]);
            break;

        case "deleteModuloP":
            deleteModuloP($_POST["id_modulo_principal"]);
            break;

            //Functions Submodulos
        case "getSubmodulo":
            getSubmodulo($_POST["id"]);
            break;

        case "insertSubmodulo":
            insertSubmodulo();
            break;

        case "updateSubmodulo":
            updateSubmodulo($_POST["id"]);
            break;

        case "deleteSubmodulo":
            deleteSubmodulo($_POST["id"]);
            break;
    }
}

//Functions Modulos
function getModulo($id_modulo)
{
    global $db;
    $modulos = $db->get("modulos", "*", ["id_modulo" => $id_modulo]);

    $respuesta["nombre_modulo"] = $modulos["nombre_modulo"];
    $respuesta["icono_modulo"] = $modulos["icono_modulo"];
    echo json_encode($respuesta);
}

function insertModulo()
{
    global $db;
    $respuesta = [];
    $nombre_modulo = strtolower($_POST["nombre_modulo"]);
    $icono_modulo = $_POST["icono_modulo"];

    if (empty(trim($nombre_modulo)) || $icono_modulo == "0") {
        $respuesta["status"] = 0;
    } else if (!empty($nombre_modulo) || $icono_modulo != "0") {
        $db->insert("modulos", [
            "nombre_modulo" => $nombre_modulo,
            "icono_modulo" => $icono_modulo
        ]);
        $respuesta["status"] = 1;
    }

    echo json_encode($respuesta);
}

function updateModulo($id_modulo)
{
    global $db;
    $nombre_modulo = strtolower($_POST["nombre_modulo"]);
    $icono_modulo = $_POST["icono_modulo"];

    if (empty(trim($nombre_modulo)) || $icono_modulo == "0") {
        $respuesta["status"] = 0;
    } else if (!empty($nombre_modulo) || $icono_modulo != "0") {
        $db->update("modulos", [
            "nombre_modulo" => $nombre_modulo,
            "icono_modulo" => $icono_modulo
        ], [
            "id_modulo" => $id_modulo
        ]);

        $respuesta["status"] = 1;
    }

    echo json_encode($respuesta);
}

function deleteModulo($id_modulo)
{
    global $db;

    $db->delete("modulos", ["id_modulo" => $id_modulo]);
    $respuesta["status"] = 1;
    echo json_encode($respuesta);
}

//Functions Modulos Principales
function validateModuloP($moduloP)
{
    global $db;
    $groups = $db->select("modulos_principales", "*");
    foreach ($groups as $group) {
        if ($group["nombre_modulo_principal"] == $moduloP) {
            return true;
        }
    }
}

function insertModuloP()
{
    global $db;
    $respuesta = [];
    $moduloP = strtolower($_POST['nombre_modulo_principal']);
    $duplicateModuloP = false;

    if (empty(trim($moduloP))) {
        $respuesta["status"] = 0;
    } else {
        $duplicateModuloP = validateModuloP($moduloP);
        if (!$duplicateModuloP) {
            $db->insert('modulos_principales', [
                'nombre_modulo_principal' => $moduloP
            ]);
            $respuesta["status"] = 1;
        } else {
            $respuesta["status"] = 2;
        }
    }
    echo json_encode($respuesta);
}

function getModuloP($id_modulo_principal)
{
    global $db;
    $respuesta = [];
    $moduloP = $db->get("modulos_principales", "*", ["id_modulo_principal" => $id_modulo_principal]);

    $respuesta['nombre_modulo_principal'] = $moduloP['nombre_modulo_principal'];

    echo json_encode($respuesta);
}

function updateModuloP($id_modulo_principal)
{
    global $db;
    $respuesta = [];
    $nombreMP = strtolower($_POST['nombre_modulo_principal']);
    $duplicateModuloP = false;

    if (empty(trim($nombreMP))) {
        $respuesta["status"] = 0;
    } else {
        $duplicateModuloP = validateModuloP($nombreMP);
        if (!$duplicateModuloP) {
            $db->update('modulos_principales', [
                'nombre_modulo_principal' => $nombreMP
            ], ['id_modulo_principal' => $id_modulo_principal]);
            $respuesta["status"] = 1;
        } else {
            $respuesta["status"] = 2;
        }
    }
    echo json_encode($respuesta);
}

function deleteModuloP($id_modulo_principal)
{
    global $db;
    $respuesta = [];

    $db->delete('modulos_principales', ['id_modulo_principal' => $id_modulo_principal]);
    $respuesta['status'] = 1;
    echo json_encode($respuesta);
}


//Funtions Submodulos
function validateSubmodulo($id_submodulo)
{
    global $db;
    $groups = $db->select("submodulos", "*");
    foreach ($groups as $group) {
        if ($group["id_submodulo"] == $id_submodulo) {
            return true;
        }
    }
}

function insertSubmodulo()
{
    global $db;
    $duplicate = false;
    $respuesta = [];
    $id_moduloP= $_POST["id_moduloP"];
    $id_submodulo = $_POST["id_submodulo"];

    if ( empty(trim($id_moduloP)) || $id_submodulo == "0") {
        $respuesta["status"] = 0;
    } else {
        if (sizeof($id_submodulo) == 1) {
            $duplicate = validateSubmodulo($id_submodulo[0]);
            if (!$duplicate) {
                $db->insert("submodulos", [
                    "id_modulo_principal" => $id_moduloP,
                    "id_submodulo" => $id_submodulo[0]
                ]);
                $respuesta["status"] = 1;
            } else {
                $respuesta["status"] = 2;
            }
        } else {
            foreach ($id_submodulo as $id) {
                $duplicate = validateSubmodulo($id);
                if (!$duplicate) {
                   $db->insert("submodulos", [
                    "id_modulo_principal" => $id_moduloP,
                    "id_submodulo" => $id
                ]);
                    $respuesta["status"] = 1;
                } else {
                    $respuesta["status"] = 2;
                }
            }
        }
    }
    echo json_encode($respuesta);
}

function getSubmodulo($id)
{
    global $db;
    $respuesta = $db->get("submodulos", "*", ["id" => $id]);
    echo json_encode($respuesta);
}

function updateSubmodulo($id)
{
    global $db;
    $respuesta = [];
    $id_moduloP= $_POST["id_moduloP"];
    $id_submodulo = $_POST["id_submoduloIn"];
    $duplicateSubmodulo = false;

    if ($id_moduloP == '0' || $id_submodulo == '0' ) {
        $respuesta["status"] = 0;
    } else {
        $duplicateSubmodulo = validateSubmodulo($id_submodulo);
        if (!$duplicateSubmodulo) {
            $db->update(
                "submodulos",
                [
                    "id_modulo_principal" => $id_moduloP,
                    "id_submodulo" => $id_submodulo
                ],
                ["id" => $id]
            );
            $respuesta["status"] = 1;
        } else {
            $respuesta["status"] = 2;
        }
    }

    echo json_encode($respuesta);
}

function deleteSubmodulo($id)
{
    global $db;
    $respuesta = [];

    $db->delete('submodulos', ['id' => $id]);
    $respuesta['status'] = 1;
    echo json_encode($respuesta);
}
