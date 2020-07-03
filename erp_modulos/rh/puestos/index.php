<?php include __DIR__ . "/../common/session.php"; ?>
<!DOCTYPE html>
<html lang="mx">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
    user-scalable=no, shrink-to-fit=no"/>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="/main.css" />
    <link rel="stylesheet" href="positions.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src=" ../common/factory.js"></script>
    <script type="text/javascript" src="positions.js"></script>

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
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <!-- Title & subtitle -->
                            <div>
                                Consultar Puestos
                            </div>
                        </div>
                        <?php if (in_array($_SESSION['module'], $_SESSION['insertar'])) { ?>
                            <div class="page-title-actions">
                                <a class="btn btn-outline-success" data-toggle="modal" data-target="#modal-submit" href="#"
                                   role="button" onclick="document.querySelector('#form-pos').reset()">
                                    Nuevo puesto
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="container main-container col-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="container">
                            </div>
                            <table class="mb-0 table table-bordered text-center" id="table-pos" >
                                <thead>
                                <tr>
                                    <th scope="col" data-sortable="true">#</th>
                                    <th scope="col" data-sortable="true">Puesto</th>
                                    <th scope="col" data-sortable="true">Departamento</th>
                                    <th scope="col" data-sortable="true">Es supervisor</th>
                                    <th scope="col">Acciones</th>
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
    <!-- /Full Container -->
    <div class="modal fade" id="modal-submit"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submit-label">Insertar nueva posición de trabajo</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-pos">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"
                                   id="positionName">Puesto:</label>
                            <input type="text" class="form-control" id="positionName" name="positionName">
                        </div>
                        <div class="form-group">
                            <label for="positionDepartment">Departamento:</label>
                            <div class="input-group">
                                <select class="form-control" id="positionDepartment" name="positionDepartment">
                                    <option>Choose</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="positionIsSupervisor" name="positionIsSupervisor" value="1">
                            <label for="positionIsSupervisor" class="form-check-label">Es supervisor</label>
                        </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-label">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-pos">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"
                                   id="positionName">Puesto:</label>
                            <input type="text" class="form-control" id="edit-positionName" name="positionName">
                        </div>
                        <div class="form-group">
                            <label for="positionDepartment">Departamento:</label>
                            <div class="input-group">
                                <select class="form-control" id="edit-positionDepartment" name="positionDepartment">
                                    <option>Choose</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="edit-positionIsSupervisor" name="positionIsSupervisor" value="1">
                            <label for="positionIsSupervisor" class="form-check-label">Es supervisor</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit-edit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
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
</body>
</html>