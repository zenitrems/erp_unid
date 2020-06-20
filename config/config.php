<?php

//Constantes
if ($_SERVER["HTTP_HOST"] == "localhost") {
    define("URL", "/erp_unid");
    define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/erp_unid");
    define("SERVER", "servidor1242.il.controladordns.com");
    define("DB", "sonicbea_erp");
    define("USER", "sonicbea_tram");
    define("PASSWORD", "VfQnYRVhg39RCgq");
} else {
    define("URL", "http://" . $_SERVER["HTTP_HOST"]);
    define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
    define("SERVER", "servidor1242.il.controladordns.com");
    define("DB", "sonicbea_erp");
    define("USER", "sonicbea_tram");
    define("PASSWORD", "VfQnYRVhg39RCgq");
}
