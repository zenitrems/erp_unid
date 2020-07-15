<?php
require_once '../../config/config.php';
require_once ROOT_PATH . '/libs/database.php';
session_start();
error_reporting(0);
$id_usr = $_SESSION['id'];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModuloVendedores = $db->select("modulos", "id_modulo", ["nombre_modulo" => "vendedores"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModuloVendedores[0], $_SESSION["consultar"])) {
        header("Location:" . URL . "/403.html");
    } else {
?>

        <!DOCTYPE html>
        <html lang="mx">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
            <link rel="stylesheet" href="<?php echo constant('URL') ?>/main.css" />
            <link rel="stylesheet" href="<?php echo constant('URL') ?>/style.css" />
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.css">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css">
            <title>Vendedores</title>
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
                                            $iconoVendedores = $db->get('modulos', 'icono_modulo', ['nombre_modulo' => 'vendedores']);
                                            ?>
                                            <i class="<?php echo $iconoVendedores; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Vendedores
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModuloVendedores[0], $_SESSION["insertar"])) :
                                        ?>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modal" id="newVendedor">
                                                Nuevo Vendedor
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
                                            <table class="mb-0 table table-bordered text-center" id="tableVendedores">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido</th>
                                                        <?php
                                                        //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                        if (in_array($idModuloVendedores[0], $_SESSION["editar"]) || in_array($idModuloVendedores[0], $_SESSION["eliminar"])) :
                                                        ?>
                                                            <th>Acciones</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $vendedores = $db/* ->debug() */->select("vendedores", [
                                                        "[>]empleados_rh" => ["empleado_id" => "id"],
                                                    ], [
                                                        "vendedores.id_vendedor",
                                                        "vendedores.empleado_id",
                                                        "empleados_rh.id",
                                                        "empleados_rh.name",
                                                        "empleados_rh.lastname",
                                                        "empleados_rh.mothersLastname"

                                                    ], [
                                                        "ORDER" => ["vendedores.id_vendedor" => "DESC"],
                                                    ]);
                                                    $number = 1;
                                                    foreach ($vendedores as $vendedor) {
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $number; ?></th>
                                                            <td><?php echo utf8_encode(ucfirst($vendedor['name'])) ?></td>
                                                            <td><?php echo utf8_encode(ucfirst($vendedor['lastname'])) ?></td>

                                                            <?php
                                                            //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                            if (in_array($idModuloVendedores[0], $_SESSION["editar"]) || in_array($idModuloVendedores[0], $_SESSION["eliminar"])) :
                                                            ?>
                                                                <td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                    if (in_array($idModuloVendedores[0], $_SESSION["editar"])) :
                                                                    ?>
                                                                        <button class="btnEdit mr-2 btn btn-outline-primary" data="<?php echo $vendedor['id_vendedor'] ?>" data-toggle="modal" data-target="#modal">
                                                                            Editar
                                                                        </button>
                                                                    <?php
                                                                    endif;

                                                                    //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                    if (in_array($idModuloVendedores[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <button class="btnDelete mr-2 btn btn-outline-danger" data="<?php echo $vendedor['id_vendedor'] ?>">
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
            <script src="<?php echo constant('URL') ?>/assets/scripts/main.js"></script>
            <script src="<?php echo constant('URL') ?>/vendor/components/jquery/jquery.min.js"></script>
            <script src="<?php echo constant('URL') ?>/erp_modulos/vendedores/main.js"></script>
            <script src="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.jquery.min.js"></script>
            <script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.js"></script>
            <script>
                $('#tableVendedores').bootstrapTable({
                    pagination: true,
                    search: true
                })
            </script>
        </body>

        </html>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar vendedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <select name="empleado_id" id="empleado_id" class="chosen-select form-control">
                                <option value="0">Selecciona un empleado</option>
                                <?php
                                $empleados = $db->query("SELECT CONCAT(empleados_rh.name,' ',empleados_rh.lastname) AS empleado, id FROM empleados_rh")->fetchAll();
                                foreach ($empleados as $empleado) {
                                ?>
                                    <option value="<?php echo $empleado['id'] ?>">
                                        <?php echo utf8_encode(ucfirst($empleado["empleado"])) ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-outline-success" id="btnInsertVendedor" type="button">Agregar</button>
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