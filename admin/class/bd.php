<?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'off'){
    define("HOST", "localhost");
    define("BD", "cert");
    define("USUARIO", "root");
    define("PASSWORD", "fabricandomarcas");
}else{
    define("HOST", "localhost");
    define("BD", "cert");
    define("USUARIO", "root");
    define("PASSWORD", "");
}
