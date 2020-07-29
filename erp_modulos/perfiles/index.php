<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModuloPerfiles = $db->select("modulos", "id_modulo", ["nombre_modulo" => "perfiles"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModuloPerfiles[0], $_SESSION["consultar"])) {
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
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/main.css" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <title>Perfiles</title>
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
                                            $iconoPerfiles = $db->get("modulos", "icono_modulo", ["nombre_modulo" => "perfiles"]);
                                            ?>
                                            <i class="<?php echo $iconoPerfiles; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Consultar perfiles
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModuloPerfiles[0], $_SESSION["insertar"])) :
                                        ?>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalProfiles" id="newProfile">
                                                Nuevo perfil
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
                                            <table class="mb-0 table table-bordered text-center" id="tableProfiles">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nombre</th>
                                                        <th>Consultar</th>
                                                        <th>Insertar</th>
                                                        <th>Editar</th>
                                                        <th>Eliminar</th>
                                                        <?php
                                                        //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                        if (in_array($idModuloPerfiles[0], $_SESSION["editar"]) || in_array($idModuloPerfiles[0], $_SESSION["eliminar"])) :
                                                        ?>
                                                            <th>Acciones</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $profiles = $db->select("perfiles", "*");
                                                    $number = 1;
                                                    // $i = 0;
                                                    foreach ($profiles as $profile) {
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $number; ?></th>
                                                            <td><?php echo ucfirst(strtolower($profile["nombre_perfil"])); ?></td>
                                                            <td>
                                                                <?php
                                                                $consultarPerfiles = explode(' ', $profile['consultar']);
                                                                foreach ($consultarPerfiles as $perfil) {
                                                                    $consultasNomModulo = $db->select('modulos', 'nombre_modulo', ['id_modulo' => $perfil]);
                                                                    foreach ($consultasNomModulo as $nombreMod) {
                                                                        echo $nombreMod;
                                                                        echo "<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $insertarPerfiles = explode(' ', $profile['insertar']);
                                                                foreach ($insertarPerfiles as $perfil) {
                                                                    $insertarNomModulo = $db->select('modulos', 'nombre_modulo', ['id_modulo' => $perfil]);
                                                                    foreach ($insertarNomModulo as $nombreMod) {
                                                                        echo $nombreMod;
                                                                        echo "<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $editarPerfiles = explode(' ', $profile['editar']);
                                                                foreach ($editarPerfiles as $perfil) {
                                                                    $editarNomModulo = $db->select('modulos', 'nombre_modulo', ['id_modulo' => $perfil]);
                                                                    foreach ($editarNomModulo as $nombreMod) {
                                                                        echo $nombreMod;
                                                                        echo "<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $deletePerfiles = explode(' ', $profile['eliminar']);
                                                                foreach ($deletePerfiles as $perfil) {
                                                                    $deleteNomModulo = $db->select('modulos', 'nombre_modulo', ['id_modulo' => $perfil]);
                                                                    foreach ($deleteNomModulo as $nombreMod) {
                                                                        echo $nombreMod;
                                                                        echo "<br>";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php
                                                            //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el td
                                                            if (in_array($idModuloPerfiles[0], $_SESSION["editar"]) || in_array($idModuloPerfiles[0], $_SESSION["eliminar"])) :
                                                            ?>
                                                                <td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                    if (in_array($idModuloPerfiles[0], $_SESSION["editar"])) :
                                                                    ?>
                                                                        <button class="btnEdit mr-2 btn btn-outline-primary" data-toggle="modal" data-target="#modalProfiles" data="<?php echo $profile["id_perfil"]; ?>">
                                                                            Editar
                                                                        </button>
                                                                    <?php
                                                                    endif;

                                                                    //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                    if (in_array($idModuloPerfiles[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <button class="btnDelete mr-2 btn btn-outline-danger" data="<?php echo $profile["id_perfil"]; ?>">
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
            <script type="text/javascript" src="<?php echo constant("URL") ?>/assets/scripts/main.js"></script>
            <script type="text/javascript" src="<?php echo constant("URL") ?>/vendor/components/jquery/jquery.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
            <script type="text/javascript" src="<?php echo constant("URL") ?>/erp_modulos/perfiles/main.js"></script>
        </body>

        </html>

        <!-- Modal -->
        <div class="modal fade" id="modalProfiles" tabindex="-1" role="dialog" aria-labelledby="modalProfiles" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formProfiles">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombre_perfil">Nombre</label>
                                    <input type="text" class="form-control" id="nombrePerfil" name="nombre_perfil" placeholder="ej. Empleado RH">
                                </div>
                            </div>
                            <div class="form-row" id="consultar">
                                <div class="col-md-12 mb-3">
                                    <div class="main-card card">
                                        <div class="card-body">
                                            <h5 class="card-title">Seleccione modulos a consultar</h5>
                                            <div class="position-relative form-group" style="display:grid; grid-template-columns: 1fr 1fr;">
                                                <?php
                                                $modules = $db->select("modulos", "*", ["ORDER" => ["nombre_modulo" => "ASC"],]);
                                                foreach ($modules as $module) {
                                                ?>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" id="consultar-<?php echo $module["id_modulo"] ?>" class="custom-control-input" name="consultar-<?php echo $module["id_modulo"] ?>" value="<?php echo $module["id_modulo"] ?>">
                                                        <label class="custom-control-label" for="consultar-<?php echo $module["id_modulo"] ?>">
                                                            <?php echo $module["nombre_modulo"] ?>
                                                        </label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="insertar">
                                <div class="col-md-12 mb-3">
                                    <div class="main-card card">
                                        <div class="card-body">
                                            <h5 class="card-title">Seleccione modulos para insertar datos</h5>
                                            <div class="position-relative form-group" style="display:grid; grid-template-columns: 1fr 1fr;">
                                                <?php
                                                $modules = $db->select("modulos", "*", ["ORDER" => ["nombre_modulo" => "ASC"],]);
                                                foreach ($modules as $module) {
                                                ?>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" id="insertar-<?php echo $module["id_modulo"] ?>" class="custom-control-input" name="insertar-<?php echo $module["id_modulo"] ?>" value="<?php echo $module["id_modulo"] ?>">
                                                        <label class="custom-control-label" for="insertar-<?php echo $module["id_modulo"] ?>">
                                                            <?php echo $module["nombre_modulo"] ?>
                                                        </label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="editar">
                                <div class="col-md-12 mb-3">
                                    <div class="main-card card">
                                        <div class="card-body">
                                            <h5 class="card-title">Seleccione modulos para editar datos</h5>
                                            <div class="position-relative form-group" style="display:grid; grid-template-columns: 1fr 1fr;">
                                                <?php
                                                $modules = $db->select("modulos", "*", ["ORDER" => ["nombre_modulo" => "ASC"],]);
                                                foreach ($modules as $module) {
                                                ?>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" id="editar-<?php echo $module["id_modulo"] ?>" class="custom-control-input" name="editar-<?php echo $module["id_modulo"] ?>" value="<?php echo $module["id_modulo"] ?>">
                                                        <label class="custom-control-label" for="editar-<?php echo $module["id_modulo"] ?>">
                                                            <?php echo $module["nombre_modulo"] ?>
                                                        </label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="eliminar">
                                <div class="col-md-12 mb-3">
                                    <div class="main-card card">
                                        <div class="card-body">
                                            <h5 class="card-title">Seleccione modulos para eliminar datos</h5>
                                            <div class="position-relative form-group" style="display:grid; grid-template-columns: 1fr 1fr;">
                                                <?php
                                                $modules = $db->select("modulos", "*", ["ORDER" => ["nombre_modulo" => "ASC"],]);
                                                foreach ($modules as $module) {
                                                ?>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" id="eliminar-<?php echo $module["id_modulo"] ?>" class="custom-control-input" name="editar-<?php echo $module["id_modulo"] ?>" value="<?php echo $module["id_modulo"] ?>">
                                                        <label class="custom-control-label" for="eliminar-<?php echo $module["id_modulo"] ?>">
                                                            <?php echo $module["nombre_modulo"] ?>
                                                        </label>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-success" id="btnInsertProfile" type="button">Insertar</button>
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