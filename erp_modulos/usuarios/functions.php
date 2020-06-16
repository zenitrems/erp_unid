<?php
require "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

if ($_POST) {
    switch ($_POST["action"]) {
        case "insertUser":
            insertUser();
            break;

        case "getUser":
            getUser($_POST["id_usr"]);
            break;

        case "updateUser":
            updateUser($_POST["id_usr"]);
            break;

        case "deleteUser":
            deleteUser($_POST["id_usr"]);
            break;

        default:
            # code...
            break;
    }
}

function insertUser()
{
    global $db;
    $duplicateEmail = false;
    if (empty(trim($_POST["nombre_usr"])) || empty(trim($_POST["correo_usr"])) || empty(trim($_POST["password_usr"])) || empty(trim($_POST["telefono_usr"])) || empty(trim($_POST["direccion_usr"])) || $_POST["id_perfil"] == "0") {
        $res["status"] = 0;
    } else if ($_POST["correo_usr"] != filter_var($_POST["correo_usr"], FILTER_VALIDATE_EMAIL)) {
        $res["status"] = 2;
    } else if (!validatePhone($_POST["telefono_usr"])) {
        $res["status"] = 4;
    } else {
        $duplicateEmail = validateEmail("usuarios", "correo_usr", $_POST["correo_usr"]);
        if (!$duplicateEmail) {
            $db->insert("usuarios", [
                "nombre_usr" => $_POST["nombre_usr"],
                "correo_usr" => $_POST["correo_usr"],
                "password_usr" => $_POST["password_usr"],
                "telefono_usr" => $_POST["telefono_usr"],
                "direccion_usr" => $_POST["direccion_usr"],
                "id_perfil" => $_POST["id_perfil"]
            ]);
            $res["status"] = 1;
        } else {
            $res["status"] = 3;
        }
    }
    echo json_encode($res);
}

function validatePhone($number)
{
    $pattern = "#^\(?\d{2}\)?[\s\.-]?\d{4}[\s\.-]?\d{4}$#";
    return preg_match($pattern, $number);
}

function validateEmail($table, $field, $param)
{
    global $db;
    $emails = $db->select($table, $field);
    foreach ($emails as $email) {
        if ($email == $param) {
            return true;
        }
    }
}

function getUser($id_usr)
{
    global $db;
    $user = $db->get("usuarios", "*", ["id_usr" => $id_usr]);
    echo json_encode($user);
}

function updateUser($id_usr)
{
    global $db;
    if (empty(trim($_POST["nombre_usr"])) || empty(trim($_POST["correo_usr"])) || empty(trim($_POST["password_usr"])) || empty(trim($_POST["telefono_usr"])) || empty(trim($_POST["direccion_usr"])) || $_POST["id_perfil"] == "0") {
        $res["status"] = 0;
    } else if ($_POST["correo_usr"] != filter_var($_POST["correo_usr"], FILTER_VALIDATE_EMAIL)) {
        $res["status"] = 2;
    } else if (!validatePhone($_POST["telefono_usr"])) {
        $res["status"] = 4;
    } else {
        $db->update(
            "usuarios",
            [
                "nombre_usr" => $_POST["nombre_usr"],
                "correo_usr" => $_POST["correo_usr"],
                "password_usr" => $_POST["password_usr"],
                "telefono_usr" => $_POST["telefono_usr"],
                "direccion_usr" => $_POST["direccion_usr"],
                "id_perfil" => $_POST["id_perfil"]
            ],
            ["id_usr" => $id_usr]
        );
        $res["status"] = 1;
    }
    echo json_encode($res);
}

function deleteUser($id_usr)
{
    global $db;
    $db->delete("usuarios", ["id_usr" => $id_usr]);
    $res["status"] = 1;
    echo json_encode($res);
}
