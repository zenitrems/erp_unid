<?php
require "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

if ($_POST) {
    switch ($_POST["action"]) {
            //Groups
        case "insertGroup":
            insertGroup();
            break;

        case "getGroup":
            getGroup($_POST["id"]);
            break;

        case "updateGroup":
            updateGroup($_POST["id"]);
            break;

        case "deleteGroup":
            deleteGroup($_POST["id"]);
            break;

            //GroupsEmployee
        case "insertGroupEmployee":
            insertGroupEmployee();
            break;

        case "getGroupEmployee":
            getGroupEmployee($_POST["id"]);
            break;

        case "updateGroupEmployee":
            updateGroupEmployee($_POST["id"]);
            break;

        case "deleteGroupEmployee":
            deleteGroupEmployee($_POST["id"]);
            break;

        default:
            # code...
            break;
    }
}
//Groups
function insertGroup()
{
    global $db;
    $duplicateGroup = false;
    $nombreGrupo = strtolower($_POST["nombre_grupo"]);

    if (empty(trim($nombreGrupo))) {
        $res["status"] = 0;
    } else {
        $duplicateGroup = validateGroup($nombreGrupo);
        if (!$duplicateGroup) {
            $db->insert("grupos", ["nombre_grupo" => $nombreGrupo]);
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
    }
    echo json_encode($res);
}

function getGroup($id)
{
    global $db;
    $group = $db->get("grupos", "*", ["id_grupo" => $id]);
    echo json_encode($group);
}

function updateGroup($id)
{
    global $db;
    $duplicateGroup = false;
    $nombreGrupo = strtolower($_POST["nombre_grupo"]);

    if (empty(trim($nombreGrupo))) {
        $res["status"] = 0;
    } else {
        $duplicateGroup = validateGroup($nombreGrupo);
        if (!$duplicateGroup) {
            $db->update(
                "grupos",
                ["nombre_grupo" => $nombreGrupo],
                ["id_grupo" => $id]
            );
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
    }
    echo json_encode($res);
}

function deleteGroup($id)
{
    global $db;
    $db->delete("grupos", ["id_grupo" => $id]);
    $res["status"] = 1;
    echo json_encode($res);
}

//GroupsEmployee
function insertGroupEmployee()
{
    global $db;
    $idGrupo = $_POST["id_grupo"];
    $idEmpleado = $_POST["id_empleado"];
    $duplicateGroupEmployee = false;

    if ($idGrupo == "0" || $idEmpleado == "0") {
        $res["status"] = 0;
    } else {
        if (sizeof($idEmpleado) == 1) {
            $duplicateGroupEmployee = validateGroupEmployee($idEmpleado, $idGrupo);
            if (!$duplicateGroupEmployee) {
                $db->insert("grupos_empleados", ["id_grupo" => $idGrupo, "id_empleado" => $idEmpleado[0]]);
                $res["status"] = 1;
            } else {
                $res["status"] = 2;
            }
        } else {
            foreach ($idEmpleado as $id) {
                $duplicateGroupEmployee = validateGroupEmployee($id, $idGrupo);
                if (!$duplicateGroupEmployee) {
                    $db->insert("grupos_empleados", ["id_grupo" => $idGrupo, "id_empleado" => $id]);
                    $res["status"] = 1;
                } else {
                    $res["status"] = 2;
                }
            }
        }
    }

    echo json_encode($res);
}

function getGroupEmployee($id)
{
    global $db;
    $groupEmployee = $db->get("grupos_empleados", "*", ["id" => $id]);
    echo json_encode($groupEmployee);
}

function updateGroupEmployee($id)
{
    global $db;
    $idGrupo = $_POST["id_grupo"];
    $idEmpleado = $_POST["id_empleado_one"];

    if ($idGrupo == "0" || $idEmpleado == "0") {
        $res["status"] = 0;
    } else {
        $db->update(
            "grupos_empleados",
            ["id_grupo" => $idGrupo, "id_empleado" => $idEmpleado],
            ["id" => $id]
        );
        $res["status"] = 1;
    }

    echo json_encode($res);
}

function deleteGroupEmployee($id)
{
    global $db;
    $db->delete("grupos_empleados", ["id" => $id]);
    $res["status"] = 1;
    echo json_encode($res);
}

//Extra
function validateGroup($nombreGrupo)
{
    global $db;
    $groups = $db->select("grupos", "*");
    foreach ($groups as $group) {
        if ($group["nombre_grupo"] == $nombreGrupo) {
            return true;
        }
    }
}

function validateGroupEmployee($idEmpleado, $idGrupo)
{
    global $db;
    $groupEmployees = $db->select("grupos_empleados", "*", ["id_empleado" => $idEmpleado]);
    foreach ($groupEmployees as $groupEmployee) {
        if ($groupEmployee["id_grupo"] == $idGrupo) {
            return true;
        }
    }
}
