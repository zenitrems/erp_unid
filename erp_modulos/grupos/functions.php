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

        case "getCursosByGrupo":
            getCursosByGrupo($_POST["id_grupo"]);
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
    $idCurso = $_POST["id_curso_many"];
    $duplicateCourseEmployee = false;

    if ($idGrupo == "0" || $idEmpleado == "0" || $idCurso == "0") {
        $res["status"] = 0;
    } else {
        if (sizeof($idEmpleado) == 1 && sizeof($idCurso) == 1) {
            $duplicateCourseEmployee = validateCourseEmployee($idEmpleado[0], $idCurso[0]);
            if (!$duplicateCourseEmployee) {
                $db->insert("grupos_empleados", ["id_grupo" => $idGrupo, "id_empleado" => $idEmpleado[0], "id_curso" => $idCurso[0]]);
                $res["status"] = 1;
            } else {
                $res["status"] = 2;
            }
        } else {
            foreach ($idEmpleado as $idEmp) {
                foreach ($idCurso as $idCur) {
                    $duplicateCourseEmployee = validateCourseEmployee($idEmp, $idCur);
                    if (!$duplicateCourseEmployee) {
                        $db->insert("grupos_empleados", ["id_grupo" => $idGrupo, "id_empleado" => $idEmp, "id_curso" => $idCur]);
                        $res["status"] = 1;
                    } else {
                        $res["status"] = 2;
                    }
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
    $idCurso = $_POST["id_curso_one"];
    $idEmpleado = $_POST["id_empleado_one"];

    if ($idGrupo == "0" || $idCurso == null || $idEmpleado == "0") {
        $res["status"] = 0;
    } else {
        $duplicateCourseEmployee = validateCourseEmployee($idEmpleado, $idCurso);
        if (!$duplicateCourseEmployee) {
            $db->update(
                "grupos_empleados",
                ["id_grupo" => $idGrupo, "id_empleado" => $idEmpleado, "id_curso" => $idCurso],
                ["id" => $id]
            );
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
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

function validateCourseEmployee($idEmpleado, $idCurso)
{
    global $db;
    $groupEmployees = $db->select("grupos_empleados", "*", ["id_empleado" => $idEmpleado]);
    foreach ($groupEmployees as $groupEmployee) {
        if ($groupEmployee["id_curso"] == $idCurso) {
            return true;
        }
    }
}

function getCursosByGrupo($idGrupo)
{
    global $db;
    $courses = $db->query("SELECT cursos.id_curso AS id_curso, cursos.nombre_curso AS nombre_curso
    FROM cursos_empleados
    INNER JOIN cursos ON cursos_empleados.id_curso = cursos.id_curso
    WHERE cursos_empleados.id_grupo = $idGrupo")->fetchAll();
    echo json_encode($courses);
}