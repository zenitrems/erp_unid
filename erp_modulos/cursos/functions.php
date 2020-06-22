<?php
require "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";

if ($_POST) {
    switch ($_POST["action"]) {
        case "insertCourse":
            insertCourse();
            break;

        case "getCourse":
            getCourse($_POST["id_curso"]);
            break;

        case "updateCourse":
            updateCourse($_POST["id_curso"]);
            break;

        case "deleteCourse":
            deleteCourse($_POST["id_curso"]);
            break;

        default:
            # code...
            break;
    }
}

function insertCourse()
{
    global $db;
    $duplicateCourse = false;
    $nombre_curso = strtolower($_POST["nombre_curso"]);
    if (empty(trim($nombre_curso))) {
        $res["status"] = 0;
    } else {
        $duplicateCourse = validateCourse("cursos", "nombre_curso", $nombre_curso);
        if (!$duplicateCourse) {
            $db->insert("cursos", [
                "nombre_curso" => $nombre_curso
            ]);
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
    }
    echo json_encode($res);
}

function validateCourse($table, $field, $param)
{
    global $db;
    $courses = $db->select($table, $field);
    foreach ($courses as $course) {
        if ($course == $param) {
            return true;
        }
    }
}

function getCourse($id_curso)
{
    global $db;
    $course = $db->get("cursos", "*", ["id_curso" => $id_curso]);
    echo json_encode($course);
}

function updateCourse($id_curso)
{
    global $db;
    $nombre_curso = strtolower($_POST["nombre_curso"]);
    if (empty(trim($nombre_curso))) {
        $res["status"] = 0;
    } else {
        $db->update(
            "cursos",
            [
                "nombre_curso" => $nombre_curso
            ],
            ["id_curso" => $id_curso]
        );
        $res["status"] = 1;
    }
    echo json_encode($res);
}

function deleteCourse($id_curso)
{
    global $db;
    $db->delete("cursos", ["id_curso" => $id_curso]);
    $res["status"] = 1;
    echo json_encode($res);
}
