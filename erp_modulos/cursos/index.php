<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModuloCursos = $db->select("modulos", "id_modulo", ["nombre_modulo" => "cursos"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModuloCursos[0], $_SESSION["consultar"])) {
        header("Location:" . URL . "/403.html");
    } else {
?>
        <!DOCTYPE html>
        <html lang="mx">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.13.10/jquery.timepicker.css">
            <link rel=" stylesheet" href="<?php echo constant("URL") ?>/main.css" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <title>Cursos</title>
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
                                            $iconoCursos = $db->get("modulos", "icono_modulo", ["nombre_modulo" => "cursos"]);
                                            ?>
                                            <i class="<?php echo $iconoCursos; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Consultar cursos
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModuloCursos[0], $_SESSION["insertar"])) :
                                        ?>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalCourses" id="newCourse">
                                                Nuevo curso
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
                                            <table class="mb-0 table table-bordered text-center">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Fin</th>
                                                        <th>Duracion</th>
                                                        <th>Dias</th>
                                                        <th>Horario</th>
                                                        <?php
                                                        //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                        if (in_array($idModuloCursos[0], $_SESSION["editar"]) || in_array($idModuloCursos[0], $_SESSION["eliminar"])) :
                                                        ?>
                                                            <th>Acciones</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $courses = $db->select("cursos", "*");
                                                    $number = 1;
                                                    foreach ($courses as $course) {
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $number; ?></th>
                                                            <td><?php echo utf8_encode(ucfirst($course['nombre_curso'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($course['fecha_inicio'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($course['fecha_final'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($course['duracion_curso'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($course['dias_curso'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($course['horario_curso'])) ?></td>
                                                            <?php
                                                            //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                            if (in_array($idModuloCursos[0], $_SESSION["editar"]) || in_array($idModuloCursos[0], $_SESSION["eliminar"])) :
                                                            ?>
                                                                <td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                    if (in_array($idModuloCursos[0], $_SESSION["editar"])) :
                                                                    ?>
                                                                        <button class="btnEdit mr-2 btn btn-outline-primary" data="<?php echo $course['id_curso'] ?>" data-toggle="modal" data-target="#modalCourses">
                                                                            Editar
                                                                        </button>
                                                                    <?php
                                                                    endif;

                                                                    //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                    if (in_array($idModuloCursos[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <button class="btnDelete mr-2 btn btn-outline-danger" data="<?php echo $course['id_curso'] ?>">
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
            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/timepicker@1.13.10/jquery.timepicker.min.js"></script>
            <script src="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.jquery.min.js"></script>
            <script src="<?php echo constant("URL") ?>/erp_modulos/cursos/main.js"></script>
        </body>

        </html>

        <!-- Modal Cuourses -->
        <div class="modal fade" id="modalCourses" tabindex="-1" role="dialog" aria-labelledby="modalCourses" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Insertar nuevo curso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formCourses">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombre_curso">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_curso" name="nombre_curso" placeholder="ej. Inducción">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_inicio">Fecha de inicio</label>
                                    <input type="text" placeholder="aaaa/mm/dd" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_final">Fecha final</label>
                                    <input type="text" placeholder="aaaa/mm/dd" class="form-control" id="fecha_final" name="fecha_final">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="dias_curso">Duracion del curso en horas</label>
                                    <select class="form-control" name="duracion_curso" id="duracion_curso">
                                        <option value="0">Seleccionar</option>
                                        <option value="1 hr">1 hrs</option>
                                        <option value="2 hrs">2 hrs</option>
                                        <option value="3 hrs">3 hrs</option>
                                        <option value="4 hrs">4 hrs</option>
                                        <option value="5 hrs">5 hrs</option>
                                        <option value="6 hrs">6 hrs</option>
                                        <option value="7 hrs">7 hrs</option>
                                        <option value="8 hrs">8 hrs</option>
                                        <option value="9 hrs">9 hrs</option>
                                        <option value="10 hrs">10 hrs</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="horario_curso">Horario del curso</label>
                                    <input type="text" class="form-control" id="horario_curso" name="horario_curso">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="dias_curso">Seleccione los días en que el curso estará disponible</label>
                                    <select class="form-control" name="dias_curso[]" id="dias_curso" data-placeholder="Seleccionar" multiple>
                                        <option value="Lun">Lun</option>
                                        <option value="Mar">Mar</option>
                                        <option value="Mie">Mie</option>
                                        <option value="Jue">Jue</option>
                                        <option value="Vie">Vie</option>
                                        <option value="Sab">Sab</option>
                                        <option value="Dom">Dom</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-outline-success" id="btnInsertCourse" type="button">Insertar</button>
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