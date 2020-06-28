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
    // print_r($_POST);
    //Si no existe empleado o curso == 0 regresar status 0
    if (!isset($_POST['id_empleado']) || $_POST["id_curso"] == "0") {
        $res["status"] = 0;
    } else {
        //Sacar tamaño de array empleados
        $tamanoEmpleados = sizeof($_POST['id_empleado']);
        //Si es un solo empleado, hacer insercion o mostrar msj de que esta repetido
        if ($tamanoEmpleados == 1) {
            $duplicate = validateCourseEmployee($_POST["id_empleado"], $_POST["id_curso"]);
            if (!$duplicate) {
                $db->insert("cursos_empleados", [
                    "id_empleado" => $_POST["id_empleado"][0],
                    "id_curso" => $_POST["id_curso"],
                    "status_curso" => "Nuevo"
                ]);
                $res["status"] = 1;
            } else {
                $res["status"] = 2;
            }
        } else{
        //Si hay mas de un empleado en el array insertar demas empleados y no mostrar msj de repetido en los repetidos

            //Recorrer empleados individualmente
            for ($i = 0; $i < $tamanoEmpleados; $i++) {
                // var_dump($_POST['id_empleado'][$i]);
                $duplicate = validateCourseEmployee($_POST["id_empleado"][$i], $_POST["id_curso"]);
                if (!$duplicate) {
                    $db->insert("cursos_empleados", [
                        "id_empleado" => $_POST["id_empleado"][$i],
                        "id_curso" => $_POST["id_curso"],
                        "status_curso" => "Nuevo"
                    ]);
                    $res["status"] = 1;
                } else {
                    $res["status"] = 1;
                }
            }
        }
    }
    echo json_encode($res);
}

function validateCourseEmployee($id_empleado, $id_curso)
{
    global $db;
    $coursesEmployees = $db->select("cursos_empleados", "*", ["id_empleado" => $id_empleado]);
    foreach ($coursesEmployees as $courseEmployee) {
        if ($courseEmployee["id_curso"] == $id_curso) {
            return true;
        }
    }
}

function validateCourseEmployee2($id_empleado, $id_curso, $status_curso)
{
    global $db;
    $coursesEmployees = $db->select("cursos_empleados", "*", ["id_empleado" => $id_empleado]);
    foreach ($coursesEmployees as $courseEmployee) {
        if ($courseEmployee["id_curso"] == $id_curso && $courseEmployee['status_curso'] == $status_curso) {
            return true;
        }
    }
}

function getCourseEmployee($id)
{
    global $db;
    $courseEmployee = $db->get("cursos_empleados", "*", ["id" => $id]);
    // var_dump($courseEmployee);
    echo json_encode($courseEmployee);
}

function updateCourseEmployee($id)
{
    global $db;
    $duplicate = false;
    // print_r($_POST);
    if ($_POST["id_empleado2"] == "0" || $_POST["id_curso"] == "0" || $_POST['status_curso'] == '0') {
        $res["status"] = 0;
    } else {
        $duplicate = validateCourseEmployee2($_POST["id_empleado2"], $_POST["id_curso"], $_POST['status_curso']);
        if (!$duplicate) {
            $db->update(
                "cursos_empleados",
                [
                    "id_empleado" => $_POST["id_empleado2"],
                    "id_curso" => $_POST["id_curso"],
                    "status_curso" => $_POST["status_curso"]
                ],
                ["id" => $id]
            );
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
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
