<?php
require "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

if ($_POST) {
    switch ($_POST["action"]) {
        case "insertProfile":
            insertProfile();
            break;

        case "getProfile":
            getProfile($_POST["id_perfil"]);
            break;

        case "updateProfile":
            updateProfile();
            break;

        case "deleteProfile":
            deleteProfile($_POST["id_perfil"]);
            break;

        default:
            # code...
            break;
    }
}

function insertProfile()
{
    global $db;
    //get obj from js
    $obj = $_POST["obj"];
    $duplicate = false;
    //Decode the JSON string and convert it into a PHP associative array.
    $decoded = json_decode($obj, true);
    $nombre_perfil =  strtoupper($decoded["nombre_perfil"]);
    $consultar = $decoded["consultar"];
    $insertar = $decoded["insertar"];
    $editar = $decoded["editar"];
    $eliminar = $decoded["eliminar"];

    //ValidateFields
    if (empty(trim($nombre_perfil))) {
        $res["status"] = 0;
    } else if (count($consultar) == 0 && count($insertar) == 0 && count($editar) == 0 && count($eliminar) == 0) {
        $res["status"] = 2;
        // echo "No puedes insertar un perfil sin permisos";
    } else if (count($consultar) == 0 && count($insertar) > 0) {
        $res["status"] = 3;
        // echo "Selecciona un modulo a consultar para poder insertar datos en el";
    } else if (count($consultar) == 0 && count($editar) > 0) {
        $res["status"] = 4;
        // echo "Selecciona un modulo a consultar para poder editar datos en el";
    } else if (count($consultar) == 0 && count($eliminar) > 0) {
        $res["status"] = 5;
        // echo "Selecciona un modulo a consultar para poder eliminar datos en el";
    } else if (validateInsertarConsultar($consultar, $insertar)) {
        $res["status"] = 6;
        // echo "No puedes insertar en un modulo donde no puedas consultarlo";
    } else if (validateEditarConsultar($consultar, $editar)) {
        $res["status"] = 7;
        // echo "No puedes editar en un modulo donde no puedas consultarlo";
    } else if (validateEliminarConsultar($consultar, $eliminar)) {
        $res["status"] = 8;
        // echo "No puedes eliminar en un modulo donde no puedas consultarlo";
    } else {
        $duplicate = validateProfile("nombre_perfil", $nombre_perfil);
        if (!$duplicate) {
            $db->insert("perfiles", [
                "nombre_perfil" =>  $nombre_perfil,
                "consultar" =>  implode(" ", $consultar),
                "insertar" => implode(" ", $insertar),
                "editar" => implode(" ", $editar),
                "eliminar" => implode(" ", $eliminar)
            ]);
            $res["status"] = 1;
        } else {
            $res["status"] = 9;
        }
    }
    echo json_encode($res);
}

function validateProfile($field, $param)
{
    global $db;
    $profiles = $db->select("perfiles", $field);
    foreach ($profiles as $profile) {
        if ($profile == $param) {
            return true;
        }
    }
}

function validateInsertarConsultar($consultar, $insertar)
{
    $result = array_diff($insertar, $consultar);
    if (count($result) > 0) {
        return true;
    }
}

function validateEditarConsultar($consultar, $editar)
{
    $result = array_diff($editar, $consultar);
    if (count($result) > 0) {
        return true;
    }
}

function validateEliminarConsultar($consultar, $eliminar)
{
    $result = array_diff($eliminar, $consultar);
    if (count($result) > 0) {
        return true;
    }
}

function getProfile($id_perfil)
{
    global $db;

    $profile = $db->select("perfiles", "*", ["id_perfil" => $id_perfil]);

    $consultar = [explode(" ", $profile[0]["consultar"])];
    $insertar = [explode(" ", $profile[0]["insertar"])];
    $editar = [explode(" ", $profile[0]["editar"])];
    $eliminar = [explode(" ", $profile[0]["eliminar"])];
    $res["nombre_perfil"] = $profile[0]["nombre_perfil"];
    $res["consultar"] = $consultar[0];
    $res["insertar"] = $insertar[0];
    $res["editar"] = $editar[0];
    $res["eliminar"] = $eliminar[0];
    echo json_encode($res);
}

function updateProfile()
{
    global $db;
    //get obj from js
    $obj = $_POST["obj"];
    //Decode the JSON string and convert it into a PHP associative array.
    $decoded = json_decode($obj, true);
    $nombre_perfil =  strtoupper($decoded["nombre_perfil"]);
    $consultar = $decoded["consultar"];
    $insertar = $decoded["insertar"];
    $editar = $decoded["editar"];
    $eliminar = $decoded["eliminar"];
    $id_perfil = $decoded["id_perfil"];

    //ValidateFields
    if (empty(trim($nombre_perfil))) {
        $res["status"] = 0;
    } else if (count($consultar) == 0 && count($insertar) == 0 && count($editar) == 0 && count($eliminar) == 0) {
        $res["status"] = 2;
        // echo "No puedes insertar un perfil sin permisos";
    } else if (count($consultar) == 0 && count($insertar) > 0) {
        $res["status"] = 3;
        // echo "Selecciona un modulo a consultar para poder insertar datos en el";
    } else if (count($consultar) == 0 && count($editar) > 0) {
        $res["status"] = 4;
        // echo "Selecciona un modulo a consultar para poder editar datos en el";
    } else if (count($consultar) == 0 && count($eliminar) > 0) {
        $res["status"] = 5;
        // echo "Selecciona un modulo a consultar para poder eliminar datos en el";
    } else if (validateInsertarConsultar($consultar, $insertar)) {
        $res["status"] = 6;
        // echo "No puedes insertar en un modulo donde no puedas consultarlo";
    } else if (validateEditarConsultar($consultar, $editar)) {
        $res["status"] = 7;
        // echo "No puedes editar en un modulo donde no puedas consultarlo";
    } else if (validateEliminarConsultar($consultar, $eliminar)) {
        $res["status"] = 8;
        // echo "No puedes eliminar en un modulo donde no puedas consultarlo";
    } else {
        $db->update(
            "perfiles",
            [
                "nombre_perfil" =>  $nombre_perfil,
                "consultar" =>  implode(" ", $consultar),
                "insertar" => implode(" ", $insertar),
                "editar" => implode(" ", $editar),
                "eliminar" => implode(" ", $eliminar)
            ],
            ["id_perfil" => $id_perfil]
        );
        $res["status"] = 1;
    }
    echo json_encode($res);
}

function deleteProfile($id_perfil)
{
    global $db;
    $db->delete("perfiles", ["id_perfil" => $id_perfil]);
    $res["status"] = 1;
    echo json_encode($res);
}
