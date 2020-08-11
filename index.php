<?php
require_once "./config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
if (isset($id_usr)) {
?>
    <!DOCTYPE html>
    <html lang="mx">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, 
        user-scalable=no, shrink-to-fit=no" />
        <link rel="stylesheet" href="<?php echo constant("URL") ?>/main.css" />
        <script src="<?php echo constant("URL") ?>/vendor/components/jquery/jquery.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css">
        <style>
            .wrapper {
                grid-column-start: 1;
                grid-column-end: 4;
                grid-row-start: 1;
                grid-row-end: 3;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }
        </style>
        <title>Dashboard</title>
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
                        <h1>Dashboard</h1>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">

                                        <div class="wrapper">

                                            <div class="alert">
                                                <h5>Estatus tareas</h5>
                                                <hr />
                                                <div class="col">
                                                    <table class="mb-0 table table-bordered text-center" id="tableDash">
                                                        <thead>
                                                            <tr>
                                                                <th>Descripción</th>
                                                                <th>Estatus</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tareas = $db /*->debug()*/->select(
                                                                "tareas(t)",
                                                                [
                                                                    "t.id_tar",
                                                                    "t.desc_tar",
                                                                    "fechaentrega_tar",
                                                                    "t.usr2_tar",
                                                                    "t.status_tar"
                                                                ],
                                                                [
                                                                    "OR" => [
                                                                        "t.usr2_tar" => $id_usr
                                                                    ]
                                                                ]
                                                            );
                                                            foreach ($tareas as $tarea) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $tarea["desc_tar"]; ?></td>
                                                                    <td><?php echo $tarea["status_tar"]; ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="alert">
                                                <h5>Fecha de entrega</h5>
                                                <hr />
                                                <div class="col">
                                                    <table class="mb-0 table table-bordered text-center" id="tableDash1">
                                                        <thead>
                                                            <tr>
                                                                <th>Descripción</th>
                                                                <th>Fecha</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tareas = $db /*->debug() */->select(
                                                                "tareas(t)",
                                                                [
                                                                    "t.id_tar",
                                                                    "t.desc_tar",
                                                                    "fechaentrega_tar",
                                                                    "t.usr2_tar",
                                                                    "t.status_tar"
                                                                ],
                                                                [
                                                                    "OR" => [
                                                                        "t.usr2_tar" => $id_usr
                                                                    ]
                                                                ]
                                                            );
                                                            
                                                            foreach ($tareas as $tarea) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $tarea["desc_tar"]; ?></td>
                                                                    <td><?php echo $tarea["fechaentrega_tar"]; ?></td>
                                                                </tr>
                                                            <?php
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
        <script src="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.js"></script>
        <script>
            $('#tableDash').bootstrapTable({})
            $('#tableDash1').bootstrapTable({})
        </script>
    </body>

    </html>
<?php
} else {
    header("Location:" . URL . "/erp_modulos/login/index.php");
}
?>