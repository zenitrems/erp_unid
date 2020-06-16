<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModuloUsuarios = $db->select("modulos", "id_modulo", ["nombre_modulo" => "usuarios"]);
    //Si no puede consultar este modulo mostrar pagina de error
    if (!in_array($idModuloUsuarios[0], $_SESSION["consultar"])) {
        header("Location:" . URL . "/403.html");
    } else {
?>
        <!DOCTYPE html>
        <html lang="mx">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
            <link rel="stylesheet" href="<?php echo constant("URL") ?>/main.css" />
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
            <title>Usuarios</title>
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
                                            $iconoUsuarios = $db->get("modulos", "icono_modulo", ["nombre_modulo" => "usuarios"]);
                                            ?>
                                            <i class="<?php echo $iconoUsuarios; ?>"></i>
                                        </div>
                                        <!-- Title & subtitle -->
                                        <div>
                                            Consultar usuarios
                                        </div>
                                    </div>
                                    <div class="page-title-actions">
                                        <?php
                                        //Si el id del modulo está en el array de permisos insertar muestra el boton
                                        if (in_array($idModuloUsuarios[0], $_SESSION["insertar"])) :
                                        ?>
                                            <button class="btn btn-outline-success" data-toggle="modal" data-target="#modalUsers" id="newUser">
                                                Nuevo usuario
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
                                            <table class="mb-0 table table-bordered text-center" id="tableUsers">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nombre</th>
                                                        <th>Correo electronico</th>
                                                        <th>Telefono</th>
                                                        <th>Dirección</th>
                                                        <th>Perfil</th>
                                                        <?php
                                                        //Si el id del modulo se encuentra en el array de permisos editar o eliminar muestra el th
                                                        if (in_array($idModuloUsuarios[0], $_SESSION["editar"]) || in_array($idModuloUsuarios[0], $_SESSION["eliminar"])) :
                                                        ?>
                                                            <th>Acciones</th>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $users = $db->select(
                                                        "usuarios(usr)",
                                                        [
                                                            "[><]perfiles(p)" => ["usr.id_perfil" => "id_perfil"]
                                                        ],
                                                        ["usr.id_usr", "usr.nombre_usr", "usr.correo_usr", "usr.telefono_usr", "usr.direccion_usr", "p.nombre_perfil"]
                                                    );
                                                    $number = 1;
                                                    foreach ($users as $user) {
                                                    ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $number; ?></th>
                                                            <td><?php echo $user['nombre_usr']; ?></td>
                                                            <td><?php echo $user['correo_usr']; ?></td>
                                                            <td><?php echo $user['telefono_usr']; ?></td>
                                                            <td><?php echo $user['direccion_usr']; ?></td>
                                                            <td><?php echo ucfirst(strtolower($user["nombre_perfil"])); ?></td>
                                                            <?php
                                                            //Si el id del modulo está en el array de permisos editar y eliminar muestra el td
                                                            if (in_array($idModuloUsuarios[0], $_SESSION["editar"]) || in_array($idModuloUsuarios[0], $_SESSION["eliminar"])) :
                                                            ?>
                                                                <td>
                                                                    <?php
                                                                    //Si el id del modulo está en el array de permisos editar muestra el boton
                                                                    if (in_array($idModuloUsuarios[0], $_SESSION["editar"])) :
                                                                    ?>
                                                                        <button class="btnEdit mr-2 btn btn-outline-primary" data="<?php echo $user['id_usr'] ?>" data-toggle="modal" data-target="#modalUsers">
                                                                            Editar
                                                                        </button>
                                                                    <?php
                                                                    endif;

                                                                    //Si el id del modulo está en el array de permisos eliminar muestra el boton
                                                                    if (in_array($idModuloUsuarios[0], $_SESSION["eliminar"])) :
                                                                    ?>
                                                                        <button class="btnDelete mr-2 btn btn-outline-danger" data="<?php echo $user['id_usr'] ?>">
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
            <script src="<?php echo constant("URL") ?>/erp_modulos/usuarios/main.js"></script>
        </body>

        </html>

        <!-- Modal -->
        <div class="modal fade" id="modalUsers" tabindex="-1" role="dialog" aria-labelledby="modalUsers" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Insertar nuevo usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUsers">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombre_usr">Nombre</label>
                                    <input type="text" class="form-control" id="nombre_usr" name="nombre_usr" placeholder="ej. Alan" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="correo_usr">Correo electronico</label>
                                    <input type="text" class="form-control" id="correo_usr" name="correo_usr" placeholder="ej. alan2020@gmail.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_usr">Password</label>
                                    <input type="password" class="form-control" id="password_usr" name="password_usr" placeholder="*****" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono_usr">Telefono</label>
                                    <input type="text" class="form-control" id="telefono_usr" name="telefono_usr" placeholder="ej. 9981284316" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="direccion_usr">Dirección</label>
                                    <input type="text" class="form-control" id="direccion_usr" name="direccion_usr" placeholder="ej. Calle ceibo 37" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="id_perfil">Perfil</label>
                                    <select name="id_perfil" id="id_perfil" class="form-control">
                                        <option value="0">Seleccione un perfil</option>
                                        <?php
                                        $perfiles = $db->select('perfiles', '*');
                                        foreach ($perfiles as $perfil) {
                                        ?>
                                            <option value="<?php echo $perfil['id_perfil']; ?>">
                                                <?php echo ucfirst(strtolower($perfil["nombre_perfil"])); ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-outline-success" id="btnInsertUser" type="button">Insertar</button>
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