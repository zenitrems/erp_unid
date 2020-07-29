<?php include __DIR__ . "/../common/session.php";
if (!isset($_GET["id"])){
    header('Location:' . URL . '/erp_modulos/rh/vacaciones/');
}
?>
<!DOCTYPE html>
<html lang="mx">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,
    user-scalable=no, shrink-to-fit=no"/>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="/main.css"/>
    <link rel="stylesheet" href="format.css"/>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2020.2.617/js/kendo.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
    <script type="text/javascript" src=" ../common/factory.js"></script>
    <script type="text/javascript" src="format.js"></script>

    <title>Módulos</title>
</head>

<body>
<?php if (isset($_SESSION['id_empleado'])) { ?>
    <input type="hidden" id="employee" name="employee" value="<?=$_SESSION['id_empleado']?>"/>
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
                            <!-- Title & subtitle -->
                            <div>
                                Consultar Solicitudes de Vacaciones
                            </div>
                        </div>
                        <div class="page-title-actions">
                            <a class="btn btn-outline-danger" href="#" role="button" id="back">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                            <a class="btn btn-outline-success" href="#" role="button" id="print">
                                <i class="fas fa-print"></i> Imprimir
                            </a>
                            <a class="btn btn-outline-info" href="#" role="button" id="download">
                                <i class="fas fa-file-download"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="container main-container col-12" style="align-content: center" id="main-container">
                    <div class="card" id="format">
                        <div class="card-body" id="format-body">
                            <p></p>
                            <p id="date" class="text-right">Fecha</p>
                            <p><strong>&nbsp;</strong></p>
                            <h3 class="text-center text-right"><b>Asunto:</b> Solicitud de vacaciones</h3>
                            <p><strong>&nbsp;</strong></p>
                            <div>
                                <p id="supervisorName">Nombre</p>
                                <p id="supervisorPosition">Puesto</p>
                                <p style="font-weight:bold">PRESENTE</p>
                            </div>
                            <p><strong>&nbsp;</strong></p>
                            <div style="text-align: justify">
                                <p>
                                    Por medio de la presente y conforme a lo establecido en el Artículo 76° de la Ley
                                    Federal del Trabajo, me permito informarle que para este año laboral me corresponden
                                    <span id="days">x</span> días hábiles de vacaciones. Me gustaría hacer efectivos mis días de vacaciones a
                                    partir del <span id="from"></span> al <span id="to"></span>
                                </p>
                                <p>
                                    Espero no incomodar o afectar las actividades laborales con mi petición. Sin más
                                    por el momento me despido de usted y quedo a la espera de su respuesta y autorización.
                                    Saludos cordiales
                                </p>
                            </div>
                            <p><strong>&nbsp;</strong></p>
                            <div class="text-center">
                                <p style="font-weight:bold">Atentamente</p>
                                <p id="name">Nombre </p>
                                <p id="position">Puesto</p>
                            </div>
                            <p><strong>&nbsp;</strong></p>
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
</body>
</html>