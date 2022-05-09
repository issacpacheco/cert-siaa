<?php
namespace nsusuarios;
use conexionbd\mysqlconsultas;

class usuarios extends mysqlconsultas{
    public function obtener_grupos(){
        $qry = "SELECT * FROM area WHERE sistema = 2";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_usuarios(){
        $qry = "SELECT * FROM usuarios WHERE id_campus = {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_almacenistas(){
        $qry = "SELECT * FROM usuarios WHERE id_area = 1";
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
                WHERE a.sistema = 2";
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

}


?>