<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModulo = $db->select("modulos", "id_modulo", ["nombre_modulo" => "modulos"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModulo[0], $_SESSION["consultar"])) {
        header("Location:" . URL . "/403.html");
    } else {
?>
        <!DOCTYPE html>
        <html lang="mx">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, 
        user-scalable=no, shrink-to-fit=no" />
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/main.css" />
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
            <script src="<?php echo constant("URL") ?>/vendor/components/jquery/jquery.min.js"></script>
            <title>Módulos</title>
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
                                            $iconoModulo = $db->get("modulos", "icono_modulo", ["nombre_modulo" => "modulos"]);
                                            ?>
                                            <i class="<?php echo $iconoModulo; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Consultar módulos
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModulo[0], $_SESSION["insertar"])) :
                                        ?>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalModulos" id="btn-new">
                                                Nuevo módulo
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
                                                        <th>Icono</th>
                                                        <?php
                                                        //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                        if (in_array($idModulo[0], $_SESSION["editar"]) || in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                        ?>
                                                            <th>Acciones</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $modulos = $db->select("modulos", "*");
                                                    $num = 1;
                                                    foreach ($modulos as $modulo) {
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $num; ?></th>
                                                            <td><?php echo utf8_encode($modulo['nombre_modulo']); ?></td>
                                                            <td><i class=" <?php echo $modulo['icono_modulo']; ?>"></i></td>
                                                            <?php
                                                            //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el td
                                                            if (in_array($idModulo[0], $_SESSION["editar"]) || in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                            ?>
                                                                <td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                    if (in_array($idModulo[0], $_SESSION["editar"])) :
                                                                    ?>
                                                                        <button class="mr-2 btn btn-outline-primary btn-edit" data-toggle="modal" data-target="#modalModulos" data="<?php echo $modulo['id_modulo']; ?>" id="btn-edit">
                                                                            Editar
                                                                        </button>
                                                                    <?php
                                                                    endif;

                                                                    //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                    if (in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <button class="mr-2 btn btn-outline-danger btn-delete" data="<?php echo $modulo['id_modulo']; ?>">
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
                                                        $num++;
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
            <script type="text/javascript" src="<?php echo constant("URL") ?>/assets/scripts/main.js"></script>
            <script src="<?php echo constant("URL") ?>/erp_modulos/modulos/main.js"></script>
        </body>

        </html>

        <!-- Empieza Modal -->
        <div class="modal fade" id="modalModulos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Empieza Form -->
                        <form id="modulos-form">
                            <div class="form-row">
                                <div class="col-sm-10">
                                    <label for="validationCustom01">Nombre de Módulo</label>
                                    <input type="text" class="form-control nombre_modulo" name="nombre_modulo" placeholder="ej: Ventas">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="icono_modulo">Icono</label>
                                    <select name="icono_modulo" id="icono_modulo" class="form-control">
                                        <option value="0">
                                            Seleccione un icono
                                        </option>
                                        <option value="pe-7s-rocket">
                                            Cohete
                                        </option>
                                        <option value="pe-7s-users">
                                            Usuarios
                                        </option>
                                        <option value="pe-7s-cash">
                                            Dinero
                                        </option>
                                        <option value="pe-7s-graph2">
                                            Graficas
                                        </option>
                                        <option value="pe-7s-calculator">
                                            Calculadora
                                        </option>
                                        <option value="pe-7s-call">
                                            Telefono
                                        </option>
                                        <option value="pe-7s-notebook">
                                            Libro
                                        </option>
                                        <option value="pe-7s-user">
                                            Perfil
                                        </option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" id="btn-form"></button>
                        </form>
                    </div>
                    <!-- Termina Form -->
                </div>
            </div>
        </div>
        <!-- Termina Modal -->

<?php
    }
} else {
    header("Location:" . URL . "/erp_modulos/login/index.php");
}
?>