<?php
require_once "../../config/config.php";
require_once ROOT_PATH . "/libs/database.php";
session_start();
error_reporting(0);
$id_usr = $_SESSION["id"];
// $id_usr = $_SESSION["id"];
if (isset($id_usr)) {
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Historial de Cursos</title>
    <link rel="stylesheet" href="styles.css" />
  </head>

  <body>
    <div class="container">
      <section class="banner-wrapper">
        <div class="banner">
          <div class="text">
            <?php
            $empleado = $db->get("empleados_rh", ["name", "lastname"], ["id" => 4]);
            $empleadoFullName = $empleado['name'] . ' ' . $empleado['lastname'];
            ?>
            <h2>Bienvenido <?php echo $empleadoFullName; ?> a Vista Cursos</h2>
            <p>
              Aqui podras ver todos tus cursos en los cuales estas registrado
            </p>
          </div>
        </div>
        <span>=</span>
      </section>

      <?php
      $consultaEmpleadoCursos = $db->query("SELECT cursos.nombre_curso AS curso, cursos.fecha_inicio AS inicio, cursos.fecha_final AS final, cursos.horario_curso AS horario, cursos_empleados.status_curso AS statu, grupos.nombre_grupo AS grupo
        FROM cursos
        INNER JOIN
        grupos_empleados ON cursos.id_curso = grupos_empleados.id_curso
        INNER JOIN
        grupos ON grupos.id_grupo = grupos_empleados.id_grupo
        INNER JOIN
        cursos_empleados ON grupos_empleados.id_curso = cursos_empleados.id_curso AND grupos_empleados.id_grupo = cursos_empleados.id_grupo
        WHERE grupos_empleados.id_empleado = 4;
        ")->fetchAll();
      // var_dump($consultaEmpleadoCursos);
      if ($consultaEmpleadoCursos[0] == '') {
      ?>
        <section class="cursos">
          <h3 style="color: #fff; font-style: italic; font-weight: lighter;">Estas registrado en 0 cursos</h3>
        </section>
      <?php
      } else {
      ?>
        <section class="cursos">
          <?php
          foreach ($consultaEmpleadoCursos as $consulta) {
          ?>

            <div class="boxContent">
              <div class="texto">
                <h2>Grupo:</h2>
                <p><?php echo $consulta['grupo']; ?></p>
                <h2>Curso:</h2>
                <p><?php echo $consulta['curso']; ?></p>
                <h2>Horario:</h2>
                <p><?php echo $consulta['horario']; ?></p>
                <h2>Fecha Inicio:</h2>
                <p><?php echo $consulta['inicio']; ?></p>
                <h2>Fecha Fin:</h2>
                <p><?php echo $consulta['final']; ?></p>
                <h2>Status:</h2>
                <?php if ($consulta['statu'] == 'Nuevo') {
                ?>
                  <span class="nuevo">Nuevo</span>
                <?php } elseif ($consulta['statu'] == 'En proceso') {
                ?>
                  <span class="enproceso">En Proceso</span>
                <?php } elseif ($consulta['statu'] == 'Pendiente') {
                ?>
                  <span class="pendiente">Pendiente</span>
                <?php } elseif ($consulta['statu'] == 'Terminado') {
                ?>
                  <form action="certificado.php" method="POST">
                    <span class="terminado">Terminado</span>
                    <input type="submit" value="Diploma" class="btnDiploma" id="btnDiploma"></input>
                    <input type="hidden" name="empleado" value="<?php echo $empleadoFullName; ?>">
                    <input type="hidden" name="curso" value="<?php echo $consulta['curso']; ?>">
                  </form>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </section>
      <?php } ?>

      <footer class="footer">
        <div class="textoo">
          <p>mucho texto</p>
          <img src="images/yoda.png" alt="yoda" />
        </div>
      </footer>
    </div>
  </body>

  </html>
<?php

} else {
  header("Location:" . URL . "/erp_modulos/login/index.php");
}
?>