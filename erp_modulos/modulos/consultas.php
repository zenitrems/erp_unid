<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

// require_once 'local-database.php';

if ($_POST) {

    switch ($_POST["accion"]) {

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
    }
}

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
