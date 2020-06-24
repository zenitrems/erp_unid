<?php
require '../../config/config.php';
require_once ROOT_PATH . '/libs/database.php';

if ($_POST) {
    switch ($_POST["action"]) {
        case 'insertVendedor':
            insertVendedor();
            break;

        case 'getVendedor':
            getVendedor($_POST["id"]);
            break;

        case 'updateVendedor':
            updateVendedor($_POST["id"]);
            break;

        case 'deleteVendedor':
            deleteVendedor($_POST["id"]);
            break;

        default:
            # code...
            break;
    }
}
function validateVendedor($empleado_id)
{
    global $db;
    $vendedores = $db->select("vendedores", "*", ["empleado_id" => $empleado_id]);
    foreach ($vendedores as $vendedor) {
        if ($vendedor["empleado_id"] == $empleado_id) {
            return true;
        }
    }
}

function insertVendedor()
{
    global $db;
    $duplicate = false;
    if ($_POST["empleado_id"] == "0") {
        $res["status"] = 0;
    } else {
        $duplicate = validateVendedor($_POST["empleado_id"]);
        if (!$duplicate) {
            $db->insert("vendedores", [
                "empleado_id" => $_POST["empleado_id"]
            ]);
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
    }

    echo json_encode($res);
}

function getVendedor($id)
{
    global $db;
    $vendedor = $db->get("vendedores", "*", ["id_vendedor" => $id]);
    echo json_encode($vendedor);
}

function updateVendedor($id)
{
    global $db;
    $duplicate = false;
    if ($_POST["empleado_id"] == "0") {
        $res["status"] = 0;
    } else {
        $duplicate = validateVendedor($_POST["empleado_id"]);
        if (!$duplicate) {
            $db->update(
                "vendedores",
                [
                    "empleado_id" => $_POST["empleado_id"]
                ],
                ["id_vendedor" => $id]
            );
            $res["status"] = 1;
        } else {
            $res["status"] = 2;
        }
    }
    echo json_encode($res);
}

function deleteVendedor($id_vendedor)
{
    global $db;
    $db->delete("vendedores", ["id_vendedor" => $id_vendedor]);
    $respuesta["status"] = 1;
    echo json_encode($respuesta);
}
