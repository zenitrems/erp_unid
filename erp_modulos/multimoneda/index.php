<?php
require_once '../../config/config.php';
require_once ROOT_PATH . '/libs/database.php';
session_start();
error_reporting(0);
$id_usr = $_SESSION['id'];
if (isset($id_usr)) {
    //Traer id del modulo actual
    $idModulo = $db->select("modulos", "id_modulo", ["nombre_modulo" => "multimoneda"]);
?>
    <!DOCTYPE html>
    <html lang="mx">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, 
        user-scalable=no, shrink-to-fit=no" />
        <link rel="stylesheet" href="<?php echo constant('URL') ?>/main.css" />
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="<?php echo constant('URL') ?>/vendor/components/jquery/jquery.min.js"></script>
        <title>Multimoneda</title>
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
                                        $iconoModulo = $db->get('modulos', 'icono_modulo', ['nombre_modulo' => 'multimoneda']);
                                        ?>
                                        <i class="<?php echo $iconoModulo; ?>"></i>
                                    </div>
                                    <!-- Title & subtitle -->
                                    <div>
                                        Multimoneda
                                    </div>
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
                                                    <th>Fuente</th>
                                                    <th>Destino</th>
                                                    <th>Factor</th>
                                                    <th>Actualizado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $multimoneda = $db->select("multimoneda", "*");
                                                if ($multimoneda) {
                                                    foreach ($multimoneda as $row) {
                                                        # code...
                                                ?>
                                                        <tr>
                                                            <td><?php echo $row['source']; ?></td>
                                                            <td><?php echo $row['target']; ?></td>
                                                            <td><?php echo $row['value']; ?></td>
                                                            <td><?php echo $row['updated']; ?></td>
                                                        </tr>
                                                <?php
                                                    }
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
        <script type="text/javascript" src="<?php echo constant('URL') ?>/assets/scripts/main.js"></script>
    </body>

    </html>
<?php
} else {
    header('Location:' . URL . '/erp_modulos/login/index.php');
}

?>