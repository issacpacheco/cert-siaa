<?php
namespace nsusuarios;
use conexionbd\mysqlconsultas;

class usuarios extends mysqlconsultas{
    public function obtener_grupos(){
        if($_SESSION['nivel'] == 99){
            $qry = "SELECT * FROM area WHERE sistema = 2";
        }else if($_SESSION['nivel'] == 1){
            $qry = "SELECT * FROM inv_subareas WHERE id_area = {$_SESSION['area']}";
        }
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_usuarios(){
        $qry = "SELECT * FROM usuarios WHERE id_campus = {$_SESSION['campus']}";
        if($_SESSION['area'] == 6){
            $qry .= " AND id_area = {$_SESSION['area']}";
        }
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_almacenistas(){
        $qry = "SELECT * FROM usuarios WHERE id_area = {$_SESSION['area']}";
        $res = $this-> consulta($qry);
        return $res;
    }

    public function obtener_grupo($id){
        $qry = "SELECT * FROM area WHERE id = '$id'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_usuarios_sistema(){
        $qry = "SELECT u.*, a.nombre as area FROM usuarios u
                LEFT JOIN area a ON a.id = u.id_area
                WHERE u.id_area = {$_SESSION['area']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_usuario($id){
        $qry = "SELECT u.*, a.nombre AS area
                FROM usuarios u 
                LEFT JOIN area a ON a.id = u.id_area
                WHERE u.id = '$id'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function nivelesusuarios(){
        $qry = "SELECT * FROM inv_niveles";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_subareas(){
        $qry = "SELECT * FROM inv_subareas WHERE id_area = {$_SESSION['area']}";
        $res = $this->consulta($qry);
        return $res;
    }

}


?>