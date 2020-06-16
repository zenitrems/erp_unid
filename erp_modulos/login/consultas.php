<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

if ($_POST) {
    switch ($_POST["accion"]) {
        case "login":
            login();
            break;

        default:
            break;
    }
}

function login()
{
    global $db;

    if ($_POST["correo"] != "") {
        $usuario = $db->get("usuarios", "*", ["correo_usr" => $_POST["correo"]]);
        $respuesta["s"] = $usuario;
        if ($usuario) {

            if ($usuario = $db->get("usuarios", "*", ["AND" => ["correo_usr" => $_POST['correo'], "password_usr" => $_POST['password']]])) {
                //Correo & Password correctos
                //Iniciar sesión
                session_start();
                error_reporting(0);

                //Traer consultar, insertar, editar y eliminar de perfiles
                $permisos = $db->select(
                    "usuarios(usr)",
                    [
                        "[><]perfiles(p)" => ["usr.id_perfil" => "id_perfil"]
                    ],
                    ["p.consultar", "p.insertar", "p.editar", "p.eliminar"],
                    ["usr.id_usr" => $usuario["id_usr"]]
                );

                //Declarar variables de session
                $_SESSION["id"] = $usuario["id_usr"];
                $_SESSION["nombre_usr"] = $usuario["nombre_usr"];
                $_SESSION["consultar"] = explode(" ", $permisos[0]["consultar"]);
                $_SESSION["insertar"] = explode(" ", $permisos[0]["insertar"]);
                $_SESSION["editar"] = explode(" ", $permisos[0]["editar"]);
                $_SESSION["eliminar"] = explode(" ", $permisos[0]["eliminar"]);
                //Correcto->iniciar sesión
                $respuesta["status"] = 2;
            } else {
                //Password Incorrecto
                $respuesta["status"] = 3;
            }
        } else {
            //Correo no registrado
            $respuesta["status"] = 1;
        }
    } else {
        //Campos vacios
        $respuesta["status"] = 0;
    }

    echo json_encode($respuesta);
}
