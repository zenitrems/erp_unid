<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModuloCursosGrupos = $db->select("modulos", "id_modulo", ["nombre_modulo" => "cursos_grupos"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModuloCursosGrupos[0], $_SESSION["consultar"])) {
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
            <title>Cursos de Empleados</title>
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
                                            $iconoCursosGrupo = $db->get("modulos", "icono_modulo", ["nombre_modulo" => "cursos_grupos"]);
                                            ?>
                                            <i class="<?php echo $iconoCursosGrupo; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Consultar cursos de grupos
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModuloCursosGrupos[0], $_SESSION["insertar"])) :
                                        ?>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modal" id="newCourseEmployee">
                                                Añadir curso a grupo
                                            </button>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <table class="mb-0 table table-bordered text-center" id="tableCoursesGroups">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Grupo</th>
                                                        <th>Curso</th>
                                                        <th>Status</th>
                                                        <?php
                                                        //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                        if (in_array($idModuloCursosGrupos[0], $_SESSION["editar"]) || in_array($idModuloCursosGrupos[0], $_SESSION["eliminar"])) :
                                                        ?>
                                                            <th>Acciones</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $coursesEmployee = $db->query("SELECT cursos.nombre_curso AS curso, cursos_empleados.id AS id, cursos_empleados.status_curso AS status, grupos.nombre_grupo AS grupo
                                                                                    FROM cursos
                                                                                    INNER JOIN
                                                                                    cursos_empleados
                                                                                    ON 
                                                                                    cursos.id_curso = cursos_empleados.id_curso
                                                                                    INNER JOIN
                                                                                    grupos
                                                                                    ON 
                                                                                    grupos.id_grupo = cursos_empleados.id_grupo
                                                                                    ORDER BY
                                                                                    grupo ASC")->fetchAll();
                                                    $number = 1;
                                                    foreach ($coursesEmployee as $courseEmployee) {
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $number; ?></th>
                                                            <td><?php echo utf8_encode(ucfirst($courseEmployee['grupo'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($courseEmployee['curso'])) ?></td>
                                                            <td><?php echo $courseEmployee['status']; ?> </td>
                                                            <?php
                                                            //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                            if (in_array($idModuloCursosGrupos[0], $_SESSION["editar"]) || in_array($idModuloCursosGrupos[0], $_SESSION["eliminar"])) :
                                                            ?>
                                                                <td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                    if (in_array($idModuloCursosGrupos[0], $_SESSION["editar"])) :
                                                                    ?>
                                                                        <button class="btnEdit mr-2 btn btn-outline-primary" data="<?php echo $courseEmployee['id'] ?>" data-toggle="modal" data-target="#modal">
                                                                            Editar
                                                                        </button>
                                                                    <?php
                                                                    endif;

                                                                    //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                    if (in_array($idModuloCursosGrupos[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <button class="btnDelete mr-2 btn btn-outline-danger" data="<?php echo $courseEmployee['id'] ?>">
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
            <script src="<?php echo constant("URL") ?>/erp_modulos/cursos_grupos/main.js"></script>
        </body>

        </html>

        <!-- Modal CoursesEmployee -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir nuevo curso a grupo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formCoursesEmployee">
                            <div class="form-row" id="grupo_many">
                                <div class="col-md-12 mb-3">
                                    <label for="id_grupo_many">Grupo(s)</label>
                                    <select name="id_grupo_many" id="id_grupo_many" multiple class="chosen-select form-control" data-placeholder="Selecciona Grupo(s)">
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
                            <div class="form-row" id="grupo_one">
                                <div class="col-md-12 mb-3">
                                    <label for="id_grupo_one">Grupo</label>
                                    <select name="id_grupo_one" id="id_grupo_one" class="chosen-select form-control">
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
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="id_curso">Curso</label>
                                    <select name="id_curso" id="id_curso" class="chosen-select form-control">
                                        <option value="0">Seleccionar</option>
                                        <?php
                                        $courses = $db->select("cursos", "*");
                                        foreach ($courses as $course) {
                                        ?>
                                            <option value="<?php echo $course['id_curso'] ?>">
                                                <?php echo utf8_encode(ucfirst($course["nombre_curso"])) ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Select Status -->
                            <div class="form-row" id="select-status">
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
                            <button class="btn btn-outline-success" id="btnInsertCourseEmployee" type="button">Añadir</button>
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