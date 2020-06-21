<?php
//Traer los id de todos los modulos
$modulos = $db->select("modulos", "id_modulo");
//Asignar los modulos que coincidan a modulosConsultar
$modulosConsultar = array_intersect($modulos, $_SESSION["consultar"]);
?>

<!-- Sidebar -->
<div class="app-sidebar sidebar-shadow" style="overflow-y: scroll;">
    <!-- Logo -->
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile -->
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <!-- Menu -->
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <!-- Sidebar content -->
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <?php
                //Recorrer modulosConsultar y mostrar modulo
                foreach ($modulosConsultar  as $modulo) {
                    $nombreModulos = $db->select("modulos", "nombre_modulo", ["id_modulo" => $modulo]);
                    $iconoModulos = $db->select("modulos", "icono_modulo", ["id_modulo" => $modulo]);
                    //Recorrer nombreModulos y mostrarlos
                    foreach ($nombreModulos as $nombre) {
                        foreach ($iconoModulos as $icono) {
                ?>
                            <li class="app-sidebar__heading"><?php echo $nombre ?></li>
                            <li>
                                <a href="<?php echo constant('URL') ?>/erp_modulos/<?php echo $nombre; ?>/">
                                    <i class="metismenu-icon <?php echo $icono; ?>"></i>
                                    <?php echo "Consultar $nombre"; ?>
                                </a>
                            </li>
                <?php
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <!-- /Sidebar content -->
</div>
<!-- /Sidebar -->