<?php include __DIR__ . "/../common/session.php";?>
<!DOCTYPE html>
<html lang="mx">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
    user-scalable=no, shrink-to-fit=no"/>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="/main.css" />
    <link rel="stylesheet" href="vacations.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src=" ../common/factory.js"></script>
    <script type="text/javascript" src="vacations.js"></script>

    <title>Módulos</title>
</head>

<body>
<?php if (isset($_SESSION['id_empleado'])) { ?>
    <input type="hidden" id="employee" name="employee" value="<?=$_SESSION['id_empleado']?>"/>
    <input type="hidden" id="user" name="user" value="<?=$_SESSION['id']?>"/>
    <input type="hidden" id="module" name="module" value="<?=$_SESSION['module']?>"/>
    <input type="hidden" id="employeeEdit" name="employeeEdit" value="<?=json_encode($_SESSION['editar'], JSON_NUMERIC_CHECK)?>"/>
    <input type="hidden" id="employeeDelete" name="employeeDelete" value="<?=json_encode($_SESSION['eliminar'], JSON_NUMERIC_CHECK)?>"/>
<?php } ?>
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
                                <i class="fas fa-umbrella-beach"></i>
                            </div>
                            <!-- Title & subtitle -->
                            <div>
                                Consultar Solicitudes de Vacaciones
                            </div>
                        </div>
                        <?php if (in_array($_SESSION['module'], $_SESSION['insertar'])) { ?>
                        <div class="page-title-actions">
                            <a class="btn btn-outline-success" href="#" data-toggle="modal" data-target="#modal-submit"data-target="#modal-submit"
                               role="button" id="new">
                                Nueva Solicitud
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="container main-container col-12" id="main-container">
                    <div class="btn-group btn-group-toggle nav" data-toggle="buttons">
                        <label class="btn section btn-secondary" id="vacationRequested">
                            <input type="radio" name="vacationDisplay" id="vacationRequested" value="vacationRequested" checked><i class="fas fa-plus-circle"></i> Por validar
                        </label>
                        <label class="btn section btn-secondary active" id="vacationPending">
                            <input type="radio" name="vacationDisplay" id="vacationPending" value="vacationPending"><i class="fas fa-clock"></i>  Requieren validación
                        </label>
                        <label class="btn section btn-secondary" id="vacationValidated">
                            <input type="radio" name="vacationDisplay" id="vacationValidated" value="vacationValidated"><i class="fas fa-check-circle"></i> Validadas
                        </label>
                    </div>
                    <div class="collapse show" id="vacations" data-parent="#main-container">
                        <div class="main-card mb-3 card">
                            <div class="card-body" >
                                <div class="container">
                                </div>
                                <table class="mb-0 table table-bordered text-center" id="table-vac">
                                    <thead>
                                    <tr class="d-flex">
                                        <th scope="col" data-sortable="true">#</th>
                                        <th scope="col" data-sortable="true">Empleado</th>
                                        <th scope="col" data-sortable="true">De </th>
                                        <th scope="col" data-sortable="true">A </th>
                                        <th scope="col" data-sortable="true">Departamento</th>
                                        <th scope="col" >Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-vac-body">
                                    </tbody>
                                </table>
                            </div>
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
    <div class="modal fade" id="modal-submit"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submit-label">Crear solicitud de vacaciones</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-vac">
                        <div class="form-group">
                            <label for="employeeId">Empleado:</label>
                            <div class="input-group input-group-sm mb-3">
                                <input class="form-control" type="text" id="employeeId" name="employeeId" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="availableDays">Días dispobible: <span id="availableDays"></span></label>
                        </div>
                        <div class="form-group">
                            <label for="vacationSupervisor">Supervisor:</label>
                            <div class="input-group">
                                <select class="form-control selectpicker" data-live-search="true" id="vacationSupervisor" name="vacationSupervisor">
                                    <option>Selecionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-daterange" >
                                <label for="vacationDates">Fechas:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="vacationDate" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit" class="btn btn-success" data-method="submit">Guardar</button>
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
    <!-- /Full Container -->
</body>
</html>