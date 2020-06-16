<?php
session_start();
error_reporting(0);
session_destroy();
header("location: ../erp_modulos/login/index.php");