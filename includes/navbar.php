<!-- Header navbar -->
<div class="app-header header-shadow">
    <!-- Header logo -->
    <div class="app-header__logo">
        <a href="<?php echo constant("URL") ?>">HOME</a>
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
                    <i class="fas fa-ellipsis-v"></i>
                </span>
            </button>
        </span>
    </div>
    <!-- Header content -->
    <div class="app-header__content">
        <div class="app-header-right center">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group nav-item pr-2">
                                <span class="bold">Sesión actual: <?php echo $_SESSION["nombre_usr"] ?></span>
                            </div>
                            <div class="btn-group">
                                <a href="<?php echo constant("URL") ?>/includes/close_session.php" class="btn btn-danger">Cerrar sesión <i class="fa fa-fw" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Header navbar -->