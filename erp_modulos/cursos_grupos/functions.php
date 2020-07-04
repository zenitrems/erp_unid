<?php
require "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

if ($_POST) {
    switch ($_POST["action"]) {
        case "insertCourseEmployee":
            insertCourseEmployee();
            break;

        case "getCourseEmployee":
            getCourseEmployee($_POST["id"]);
            break;

        case "updateCourseEmployee":
            updateCourseEmployee($_POST["id"]);
            break;

        case "deleteCourseEmployee":
            deleteCourseEmployee($_POST["id"]);
            break;
        default:
            # code...
            break;
    }
}

function insertCourseEmployee()
{
    global $db;
    $duplicate = false;
    $idGrupoMany = $_POST["id_grupo_many"];
    $idCurso = $_POST["id_curso"];
    if ($idGrupoMany == "0" || $idCurso == "0") {
        $res["status"] = 0;
    } else {
        if (sizeof($idGrupoMany) == 1) {
            $duplicate = validateCourseEmployee($idGrupoMany, $idCurso);
            if (!$duplicate) {
                $db->insert("cursos_empleados", [
                    "id_grupo" => $idGrupoMany[0],
                    "id_curso" => $idCurso,
                    "status_curso" => "Nuevo"
                ]);
                $res["status"] = 1;
            } else {
                $res["status"] = 2;
            }
        } else {
            foreach ($idGrupoMany as $id) {
                $duplicate = validateCourseEmployee($id, $idCurso);
                if (!$duplicate) {
                    $db->insert("cursos_empleados", [
                        "id_grupo" => $id,
                        "id_curso" => $idCurso,
                        "status_curso" => "Nuevo"
                    ]);
                    $res["status"] = 1;
                } else {
                    $res["status"] = 2;
                }
            }
        }
    }
    echo json_encode($res);
}

function validateCourseEmployee($idGrupo, $idCurso)
{
    global $db;
    $coursesEmployees = $db->select("cursos_empleados", "*", ["id_grupo" => $idGrupo]);
    foreach ($coursesEmployees as $courseEmployee) {
        if ($courseEmployee["id_curso"] == $idCurso) {
            return true;
        }
    }
}

function getCourseEmployee($id)
{
    global $db;
    $courseEmployee = $db->get("cursos_empleados", "*", ["id" => $id]);
    echo json_encode($courseEmployee);
}

function updateCourseEmployee($id)
{
    global $db;
    $idGrupo = $_POST["id_grupo_one"];
    $idCurso = $_POST["id_curso"];
    $statusCurso = $_POST["status_curso"];

    if ($idGrupo == "0" || $idCurso == "0" || $statusCurso == "0") {
        $res["status"] = 0;
    } else {
        $db->update(
            "cursos_empleados",
            [
                "id_grupo" => $idGrupo,
                "id_curso" => $idCurso,
                "status_curso" => $statusCurso
            ],
            ["id" => $id]
        );
        $res["status"] = 1;
    }
    echo json_encode($res);
}

function deleteCourseEmployee($id)
{
    global $db;
    $db->delete("cursos_empleados", ["id" => $id]);
    $res["status"] = 1;
    echo json_encode($res);
}
