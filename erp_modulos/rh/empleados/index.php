<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../libs/database.php';
session_cache_limiter('private');
session_cache_expire(0);
session_start();
error_reporting(0);
$id_usr = $_SESSION['id'];
if (isset($id_usr)) {
    ?>
    <!DOCTYPE html>
    <html lang="mx">

    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
        user-scalable=no, shrink-to-fit=no"/>

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
        <link rel="stylesheet" href="/main.css" />
        <link rel="stylesheet" href="employees.css" />

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script type="text/javascript" src=" ../common/factory.js"></script>
        <script type="text/javascript" src="employees.js"></script>

        <title>Módulos</title>
    </head>

    <body>
    <!-- Full Container -->
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <?php include(ROOT_PATH . "/includes/navbar.php"); ?>
        <!-- Container app main -->
        <div class="app-main">
            <?php include(ROOT_PATH . "/includes/sidenav.php"); ?>
            <!-- App Content -->
            <div class="app-main__outer">
                <!-- Content -->
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <!-- Img title -->
                                <div class="page-title-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <!-- Title & subtitle -->
                                <div>
                                    Consultar empleados
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <a class="btn btn-outline-success" href="form.php" role="button">
                                    Nuevo empleado
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="container main-container col-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="container">
                                </div>
                                <table class="mb-0 table table-bordered text-center" id="table-emp">
                                    <thead>
                                    <tr class="d-flex" style="text-align: justify">
                                        <th scope="col">#</th>
                                        <th class="col-2" scope="col">Estado</th>
                                        <th class="col" scope="col">Puesto</th>
                                        <th class="col-2" scope="col">Apellido paterno</th>
                                        <th class="col-2" scope="col">Apellido materno</th>
                                        <th class="col-2" scope="col">Nombre</th>
                                        <th class="col-2" scope="col">Acciones</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 1
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="app-footer-right">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="javascript:void(0);" class="nav-link">
                                            Footer Link 2
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /App Content -->
            </div>
            <!-- /Container app main -->
        </div>
        <div class="modal fade" id="modal-delete" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-label">Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
                        <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Full Container -->
    </body>
    </html>
    <?php
} else {
    header('Location:' . URL . '/erp_modulos/login/index.php');
}
?>