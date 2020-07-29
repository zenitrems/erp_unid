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
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/vendor/components/chosen/chosen.css">
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/main.css" />
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalModulosPrincipales" id="btn-newMP">
                                                Insertar Módulo Principal
                                            </button>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalSubmodulos" id="btn-newS">
                                                Asignar Submódulo
                                            </button>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div role="group" class="btn-group-sm nav btn-group">
                                    <a data-toggle="tab" href="#modulos" id="table-1" class="btn-shadow active btn btn-focus">Módulos</a>
                                    <a data-toggle="tab" href="#modulosPrincipales" id="table-2" class="btn-shadow btn btn-focus">Módulos Principales</a>
                                    <a data-toggle="tab" href="#submodulos" id="table-3" class="btn-shadow btn btn-focus">Submódulos</a>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="modulos" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <table class="mb-0 table table-bordered text-center" id="tablemodulos">
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

                                <div class="tab-pane" id="modulosPrincipales" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <table class="mb-0 table table-bordered text-center" id="tablemodulosPrincipales">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nombre</th>
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
                                                            $modulosPrincipales = $db->select('modulos_principales', '*');
                                                            $number = 1;
                                                            foreach ($modulosPrincipales as $principal) {
                                                            ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $number; ?></th>
                                                                    <td><?php echo utf8_encode(ucfirst($principal['nombre_modulo_principal'])) ?></td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                                    if (in_array($idModulo[0], $_SESSION["editar"]) || in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <td>
                                                                            <?php
                                                                            //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                            if (in_array($idModulo[0], $_SESSION["editar"])) :
                                                                            ?>
                                                                                <button class="btnEditModuloP mr-2 btn btn-outline-primary" data="<?php echo $principal['id_modulo_principal'] ?>" data-toggle="modal" data-target="#modalModulosPrincipales">
                                                                                    Editar
                                                                                </button>
                                                                            <?php
                                                                            endif;

                                                                            //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                            if (in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                                            ?>
                                                                                <button class="btnDeleteModuloP mr-2 btn btn-outline-danger" data="<?php echo $principal['id_modulo_principal']  ?>" id="btnDeleteModuloP">
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

                                <div class="tab-pane" id="submodulos" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="main-card mb-3 card">
                                                <div class="card-body">
                                                    <table class="mb-0 table table-bordered text-center" id="tablesubmodulos">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Módulo Principal</th>
                                                                <th>Submódulo</th>
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
                                                            $submodulos = $db->query("SELECT submodulos.id AS id, modulos.nombre_modulo AS submodulo, modulos_principales.nombre_modulo_principal AS moduloP
                                                                            FROM submodulos
                                                                            INNER JOIN modulos ON submodulos.id_submodulo = modulos.id_modulo
                                                                            INNER JOIN modulos_principales ON submodulos.id_modulo_principal = modulos_principales.id_modulo_principal
                                                                            ")->fetchAll();
                                                            $number = 1;
                                                            foreach ($submodulos as $submodulo) {
                                                            ?>
                                                                <tr>
                                                                    <th scope="row"><?php echo $number; ?></th>
                                                                    <td><?php echo utf8_encode(ucfirst($submodulo['moduloP'])) ?></td>
                                                                    <td><?php echo utf8_encode(ucfirst($submodulo['submodulo'])) ?></td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                                    if (in_array($idModulo[0], $_SESSION["editar"]) || in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <td>
                                                                            <?php
                                                                            //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                            if (in_array($idModulo[0], $_SESSION["editar"])) :
                                                                            ?>
                                                                                <button class="btnEditSubmodulo mr-2 btn btn-outline-primary" data="<?php echo $submodulo['id'] ?>" data-toggle="modal" data-target="#modalSubmodulos" id="btnEditSubmodulo">
                                                                                    Editar
                                                                                </button>
                                                                            <?php
                                                                            endif;

                                                                            //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                            if (in_array($idModulo[0], $_SESSION["eliminar"])) :
                                                                            ?>
                                                                                <button class="btnDeleteSubmodulo mr-2 btn btn-outline-danger" id="btnDeleteSubmodulo" data="<?php echo $submodulo['id'] ?>">
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
            <script src="<?php echo constant("URL") ?>/erp_modulos/modulos/main.js"></script>
            <script src="<?php echo constant("URL") ?>/erp_modulos/modulos/modulosPrincipales.js"></script>
            <script src="<?php echo constant("URL") ?>/erp_modulos/modulos/submodulos.js"></script>
        </body>

        </html>

        <!-- Empieza Modal Modulos -->
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
                                <div class="col-md-10 mb-3">
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
                                        <option value="pe-7s-id">
                                            ID Card
                                        </option>
                                        <option value="pe-7s-study">
                                            Birrete
                                        </option>
                                        <option value="pe-7s-share">
                                            Conexiones
                                        </option>
                                        <option value="pe-7s-ribbon">
                                            Ribbon
                                        </option>
                                        <option value="pe-7s-like2">
                                            Like
                                        </option>
                                        <option value="pe-7s-config">
                                            Config
                                        </option>
                                        <option value="pe-7s-comment">
                                            Comment
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

        <!-- Empieza Modal ModulosP -->
        <div class="modal fade" id="modalModulosPrincipales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelMP"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Empieza Form -->
                        <form id="modulosP-form">
                            <div class="form-row">
                                <div class="col-sm-10">
                                    <label for="validationCustom01">Nombre de Módulo Principal</label>
                                    <input type="text" class="form-control nombre_modulo_principal" name="nombre_modulo_principal" id="nombre_modulo_principal" placeholder="ej: RRHH">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" id="btn-formMP"></button>
                        </form>
                    </div>
                    <!-- Termina Form -->
                </div>
            </div>
        </div>
        <!-- Termina Modal ModulosP-->

        <!-- Empieza Modal Submodulos -->
        <div class="modal fade" id="modalSubmodulos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelS"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Empieza Form -->
                        <form id="submodulos-form">
                            <div class="form-row">
                                <div class="col-sm-10">
                                    <label for="id_modulo_principal">Módulo Principal </label>
                                    <select name="id_moduloP" id="id_moduloP" class="chosen-select form-control" data-placeholder="Selecciona Módulo">
                                        <!-- <option value="0">Selecciona Módulo</option> -->
                                        <?php
                                        $modP = $db->select("modulos_principales", "*");
                                        foreach ($modP as $mod) {
                                        ?>
                                            <option value="<?php echo $mod['id_modulo_principal'] ?>">
                                                <?php echo utf8_encode(ucfirst($mod["nombre_modulo_principal"])) ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div id="id_submoduloInDiv">
                                <div class="form-row">
                                    <div class="col-sm-10">
                                        <label for="id_submoduloIn">Submódulo </label>
                                        <select name="id_submoduloIn" id="id_submoduloIn" class="chosen-select form-control" data-placeholder="Selecciona un submódulo">
                                            <!-- <option value="0">Selecciona submódulo</option> -->
                                            <?php
                                            $modulosIn = $db->select("modulos", "*");
                                            foreach ($modulosIn as $modulo) {
                                            ?>
                                                <option value="<?php echo $modulo['id_modulo'] ?>">
                                                    <?php echo utf8_encode(ucfirst($modulo["nombre_modulo"])) ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="id_submoduloManyDiv">
                                <div class="form-row">
                                    <div class="col-sm-10">
                                        <label for="id_submodulo">Selecciona submódulo(s)</label>
                                        <select name="id_submodulo" id="id_submodulo" class="chosen-select form-control" multiple data-placeholder="Selecciona Submodulo">
                                            <!-- <option value="0">Selecciona Módulo</option> -->
                                            <?php
                                            $submodulos = $db->select('modulos', ['id_modulo', 'nombre_modulo']);
                                            foreach ($submodulos as $submodulo) {
                                            ?>
                                                <option value="<?php echo $submodulo['id_modulo'] ?>">
                                                    <?php echo utf8_encode(ucfirst($submodulo["nombre_modulo"])) ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" id="btn-formS"></button>
                        </form>
                    </div>
                    <!-- Termina Form -->
                </div>
            </div>
        </div>
        <!-- Termina Modal Submodulos -->

<?php
    }
} else {
    header("Location:" . URL . "/erp_modulos/login/index.php");
}
?>