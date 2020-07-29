<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModuloGrupos = $db->select("modulos", "id_modulo", ["nombre_modulo" => "grupos"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModuloGrupos[0], $_SESSION["consultar"])) {
        header("Location:" . URL . "/403.html");
    } else {
?>
        <!DOCTYPE html>
        <html lang="mx">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.css">
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/main.css" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <title>Grupos</title>
        </head>

        <body>
            <!-- Full Container -->
            <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
                <!-- Navbar -->
                <?php include(ROOT_PATH . "/includes/navbar.php"); ?>
                <!-- Container app main -->
                <div class="app-main">
                    <!-- Sidenav -->
                    <?php include(ROOT_PATH . "/includes/sidenav.php"); ?>
                    <!-- App Content -->
                    <div class="app-main__outer">
                        <!-- Content -->
                        <div class="app-main__inner">
                            <!-- Page title -->
                            <div class="app-page-title">
                                <div class="page-title-wrapper">
                                    <div class="page-title-heading">
                                        <!-- Img title -->
                                        <div class="page-title-icon">
                                            <?php
                                            $iconoGrupos = $db->get("modulos", "icono_modulo", ["nombre_modulo" => "grupos"]);
                                            ?>
                                            <i class="<?php echo $iconoGrupos; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Consultar grupos
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModuloGrupos[0], $_SESSION["insertar"])) :
                                        ?>
                                            <!-- <a href="../../erp_vistas/cursosVista/index.php" target="_blank" style="margin-right: 10px;"> Ir a CursosVista</a> -->
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modal" id="newGroup">
                                                Añadir nuevo grupo
                                            </button>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalGroupEmployee" id="newGroupEmployee">
                                                Asignar grupo a empleado(s)
                                            </button>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div role="group" class="btn-group-sm nav btn-group">
                                    <a data-toggle="tab" href="#groups" id="table-1" class="btn-shadow active btn btn-focus">Grupos</a>
                                    <a data-toggle="tab" href="#groupsEmployee" id="table-2" class="btn-shadow btn btn-focus">Grupos con empleados</a>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="groups" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <table class="mb-0 table table-bordered text-center" id="tableGroups">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nombre</th>
                                                                <?php
                                                                //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                                if (in_array($idModuloGrupos[0], $_SESSION["editar"]) || in_array($idModuloGrupos[0], $_SESSION["eliminar"])) :
                                                                ?>
                                                                    <th>Acciones</th>
                                                                <?php
                                                                endif;

                                                                ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $groups = $db->select("grupos", "*");
                                                            $number = 1;
                                                            foreach ($groups as $group) {
                                                            ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $number; ?></th>
                                                                    <td><?php echo utf8_encode(ucfirst($group['nombre_grupo'])) ?></td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                                    if (in_array($idModuloGrupos[0], $_SESSION["editar"]) || in_array($idModuloGrupos[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <td>
                                                                            <?php
                                                                            //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                            if (in_array($idModuloGrupos[0], $_SESSION["editar"])) :
                                                                            ?>
                                                                                <button class="btnEdit mr-2 btn btn-outline-primary" data="<?php echo $group['id_grupo'] ?>" data-toggle="modal" data-target="#modal">
                                                                                    Editar
                                                                                </button>
                                                                            <?php
                                                                            endif;

                                                                            //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                            if (in_array($idModuloGrupos[0], $_SESSION["eliminar"])) :
                                                                            ?>
                                                                                <button class="btnDelete mr-2 btn btn-outline-danger" data="<?php echo $group['id_grupo'] ?>">
                                                                                    Eliminar
                                                                                </button>
                                                                            <?php
                                                                            endif;
                                                                            ?>
                                                                        </td>
                                                                    <?php
                                                                    endif;
                                                                    ?>
                                                                </tr>
                                                            <?php
                                                                $number++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="groupsEmployee" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <table class="mb-0 table table-bordered text-center" id="tableGroupsEmployees">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nombre</th>
                                                                <th>Empleado</th>
                                                                <th>Curso</th>
                                                                <th>Status</th>
                                                                <?php
                                                                //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                                if (in_array($idModuloGrupos[0], $_SESSION["editar"]) || in_array($idModuloGrupos[0], $_SESSION["eliminar"])) :
                                                                ?>
                                                                    <th>Acciones</th>
                                                                <?php
                                                                endif;

                                                                ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $groupsEmployee = $db->query("SELECT grupos_empleados.id AS id, grupos.nombre_grupo AS nombre, CONCAT(empleados_rh.name,' ', empleados_rh.lastname) AS empleado, cursos.nombre_curso AS curso, grupos_empleados.status_empleadoCurso AS statu
                                                                            FROM grupos_empleados
                                                                            INNER JOIN grupos ON grupos_empleados.id_grupo = grupos.id_grupo
                                                                            INNER JOIN empleados_rh ON grupos_empleados.id_empleado = empleados_rh.id
                                                                            INNER JOIN cursos ON grupos_empleados.id_curso = cursos.id_curso
                                                                            ORDER BY nombre ASC")->fetchAll();
                                                            $number = 1;
                                                            foreach ($groupsEmployee as $groupEmployee) {
                                                            ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $number; ?></th>
                                                                    <td><?php echo utf8_encode(ucfirst($groupEmployee['nombre'])) ?></td>
                                                                    <td><?php echo utf8_encode(ucfirst($groupEmployee['empleado'])) ?></td>
                                                                    <td><?php echo utf8_encode(ucfirst($groupEmployee['curso'])) ?></td>
                                                                    <td><?php echo utf8_encode(ucfirst($groupEmployee['statu'])) ?></td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                                    if (in_array($idModuloGrupos[0], $_SESSION["editar"]) || in_array($idModuloGrupos[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <td>
                                                                            <?php
                                                                            //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                            if (in_array($idModuloGrupos[0], $_SESSION["editar"])) :
                                                                            ?>
                                                                                <button class="btnEditGroupEmployee mr-2 btn btn-outline-primary" data="<?php echo $groupEmployee['id'] ?>" data-toggle="modal" data-target="#modalGroupEmployee">
                                                                                    Editar
                                                                                </button>
                                                                            <?php
                                                                            endif;

                                                                            //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                            if (in_array($idModuloGrupos[0], $_SESSION["eliminar"])) :
                                                                            ?>
                                                                                <button class="btnDeleteGroupEmployee mr-2 btn btn-outline-danger" data="<?php echo $groupEmployee['id'] ?>">
                                                                                    Eliminar
                                                                                </button>
                                                                            <?php
                                                                            endif;
                                                                            ?>
                                                                        </td>
                                                                    <?php
                                                                    endif;
                                                                    ?>
                                                                </tr>
                                                            <?php
                                                                $number++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer -->
                        <?php include(ROOT_PATH . "/includes/footer.php"); ?>
                    </div>
                    <!-- /App Content -->
                </div>
                <!-- /Container app main -->
            </div>
            <!-- /Full Container -->
            <script src="<?php echo constant("URL") ?>/assets/scripts/main.js"></script>
            <script src="<?php echo constant("URL") ?>/vendor/components/jquery/jquery.min.js"></script>
            <script src="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.jquery.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
            <script src="<?php echo constant("URL") ?>/erp_modulos/grupos/groups.js"></script>
            <script src="<?php echo constant("URL") ?>/erp_modulos/grupos/groupsEmployee.js"></script>
        </body>

        </html>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir nuevo grupo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formGroups">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombre_grupo">Nombre</label>
                                    <input type="text" class="form-control" name="nombre_grupo" id="nombre_grupo" placeholder="Ej. Seguridad">
                                </div>
                            </div>
                            <button class="btn btn-outline-success" id="btnInsertGroup" type="button">Añadir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalGroupEmployee" tabindex="-1" role="dialog" aria-labelledby="modalGroupEmployee" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir nuevo grupo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formGroupsEmployee">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="id_grupo">Grupo</label>
                                    <select name="id_grupo" id="id_grupo" class="chosen-select form-control" data-placeholder="Selecciona un grupo">
                                        <option value="0">Seleccionar</option>
                                        <?php
                                        $groups = $db->select("grupos", "*");
                                        foreach ($groups as $group) {
                                        ?>
                                            <option value="<?php echo $group['id_grupo'] ?>">
                                                <?php echo utf8_encode(ucfirst($group["nombre_grupo"])) ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" id="select-many-cursos">
                                <div class="col-md-12 mb-3">
                                    <label for="id_curso">Curso(s)</label>
                                    <select name="id_curso_many" id="id_curso_many" multiple class="chosen-select form-control" data-placeholder="Selecciona Curso(s)">
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" id="select-one-curso">
                                <div class="col-md-12 mb-3">
                                    <label for="id_curso">Curso</label>
                                    <select data-placeholder="Seleccionar curso" name="id_curso_one" id="id_curso_one" class="chosen-select form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" id="select-many-id">
                                <div class="col-md-12 mb-3">
                                    <label for="id_empleado">Empleado(s)</label>
                                    <select name="id_empleado" id="id_empleado" multiple class="chosen-select form-control" data-placeholder="Selecciona Empleado(s)">
                                        <?php
                                        $employees = $db->query("SELECT CONCAT(empleados_rh.name,' ',empleados_rh.lastname) AS empleado, id FROM empleados_rh")->fetchAll();
                                        foreach ($employees as $employee) {
                                        ?>
                                            <option value="<?php echo $employee['id'] ?>">
                                                <?php echo utf8_encode(ucfirst($employee["empleado"])) ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" id="select-one-id">
                                <div class="col-md-12 mb-3">
                                    <label for="id_empleado">Empleado</label>
                                    <select name="id_empleado_one" id="id_empleado_one" class="chosen-select form-control">
                                        <option value="0">Seleccionar</option>
                                        <?php
                                        $employees = $db->query("SELECT CONCAT(empleados_rh.name,' ',empleados_rh.lastname) AS empleado, id FROM empleados_rh")->fetchAll();
                                        foreach ($employees as $employee) {
                                        ?>
                                            <option value="<?php echo $employee['id'] ?>">
                                                <?php echo utf8_encode(ucfirst($employee["empleado"])) ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Select Status -->
                            <div class="form-row" id="select-status" class="select-status">
                                <div class="col-md-12 mb-3">
                                    <label for="status_curso">Status</label>
                                    <select name="status_curso" id="status_curso" class="chosen-select form-control">
                                        <option value="0">
                                            Seleccionar
                                        </option>
                                        <option value="Nuevo">
                                            Nuevo
                                        </option>
                                        <option value="Pendiente">
                                            Pendiente
                                        </option>
                                        <option value="En proceso">
                                            En proceso
                                        </option>
                                        <option value="Terminado">
                                            Terminado
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-outline-success" id="btnInsertGroupEmployee" type="button">Añadir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    header("Location:" . URL . "/erp_modulos/login/index.php");
}
?>