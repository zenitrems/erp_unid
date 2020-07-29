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
                $i = -1;
                $idModulosPrincipales = $db->select("submodulos", "id_modulo_principal");
                foreach ($idModulosPrincipales as $key => $item) {
                    $result = array_unique($idModulosPrincipales);
                }
                foreach ($result as $key => $item2) {
                    $nombrePrincipal = $db->query("SELECT modulos_principales.nombre_modulo_principal as principal  
                    FROM submodulos
                    INNER JOIN modulos_principales ON submodulos.id_modulo_principal = modulos_principales.id_modulo_principal
                    WHERE modulos_principales.id_modulo_principal = $item2 LIMIT 1")->fetchAll();
                    $nombrePrincipal = array_unique($nombrePrincipal[0]);
                    $i++;
                ?>

                    <li class="app-sidebar__heading" id="<?php echo "head-" . $i ?>"><?php echo $nombrePrincipal["principal"] ?></li>
                    <?php
                    foreach ($modulosConsultar as $modulo) {
                        $nombre = $db->query("SELECT modulos.nombre_modulo as modulo, modulos.icono_modulo AS icono
                        FROM modulos
                        INNER JOIN submodulos ON submodulos.id_submodulo = modulos.id_modulo
                        INNER JOIN modulos_principales ON submodulos.id_modulo_principal = modulos_principales.id_modulo_principal
                        WHERE modulos.id_modulo = $modulo AND modulos_principales.id_modulo_principal = $item2")->fetchAll();
                        foreach ($nombre as $modulo) {
                    ?>
                            <li class="links">
                                <a href="<?php echo constant('URL') ?>/erp_modulos/<?php echo $modulo['modulo']; ?>/">
                                    <i class="metismenu-icon <?php echo $modulo['icono']; ?>"></i>
                                    <?php echo $modulo['modulo']; ?>
                                </a>
                            </li>

                <?php
                        }
                    }
                }
                ?>
            </ul>
            <script>
                const heads = document.querySelectorAll(".app-sidebar__heading")
                let arraySelectors = []
                heads.forEach((item, i) => {
                    arraySelectors.push(`#head-${i}`)
                })
                arraySelectors.forEach((item) => {
                    let head = document.querySelector(item)
                    if (head.nextElementSibling === null) {
                        head.remove()
                    }
                    if (head.nextElementSibling.classList[0] === "app-sidebar__heading") {
                        head.remove()
                    } else {
                        head.style.display = "block";
                    }
                })
            </script>
        </div>
    </div>
    <!-- /Sidebar content -->
</div>
<!-- /Sidebar -->