<?php

namespace nsnewsesion;
use conexionbd\mysqlconsultas;

class newsesion extends mysqlconsultas{

    public function crearsesion($id, $id_campus, $id_area, $nombre, $nivel, $calendario, $color){

        if (session_status() == PHP_SESSION_NONE) {
            ini_set("session.cookie_lifetime","86400");
            ini_set("session.gc_maxlifetime","86400");  
            session_start();            
            session_regenerate_id();
            session_write_close();
        }
        // session_start();
        $_SESSION['id_admin'] = $id;
		$_SESSION['campus'] = $id_campus;
		$_SESSION['area'] = $id_area;
		$_SESSION['nombre'] = $nombre;
		$_SESSION['nivel'] = $nivel;
        $_SESSION['color'] = $color;
        $_SESSION['calendario'] = $calendario;

    }

    public function login($usuario, $password){
        $qry = "SELECT * FROM usuarios WHERE correo = '$usuario' AND pass = '$password'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function leerDatos() {
        // session_start();

        if (!isset($_SESSION["id"])) {
            $_SESSION["id"] = session_id();
        }

        $res = $_SESSION;

        // Cerrar la sesion para permitir la escritura de variables por parte de otros archivos a la sesion
        session_write_close();

        header('Content-type: application/json');
        echo json_encode($res);
    }

    public function destruir() {
        // Inicializar la sesión.
        // Si está usando session_name("algo"), ¡no lo olvide ahora!
        // session_start();

        // Destruir todas las variables de sesión.
        $_SESSION = array();

        // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
        // Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión.
        session_destroy();
        session_write_close();
    }
}
 