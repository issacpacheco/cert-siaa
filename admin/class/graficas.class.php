<?php
namespace nsgraficas;
use conexionbd\mysqlconsultas;

class graficas extends mysqlconsultas{
    public function top6_mas_solicitados(){
        $qry = "SELECT COUNT(s.id_producto) as total, s.id_producto, p.nombre FROM inv_salida_producto s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                WHERE p.id_area = {$_SESSION['area']} GROUP BY s.id_producto ORDER BY total desc LIMIT 6";
        $res = $this->consulta($qry);
        return $res;
    }

    public function productos_activos(){
        $qry = "SELECT COUNT(estatus) as disponibles FROM inv_productos WHERE estatus = 1";
        $res = $this->consulta($qry);
        return $res;
    }

    public function gastos_del_mes(){
        $qry = "SELECT f.id, f.fecha, f.hora, f.comentarios, f.factura, 
                SUM(f.total) as subtotal,
                SUM(CASE 
                        WHEN f.iva = 1 THEN ((f.total * 0.16) + f.total) 
                        WHEN f.iva = 0 or f.iva = null THEN f.total END) AS total, 
                u.nombre AS usuario
                FROM inv_entrada_producto f
                LEFT JOIN usuarios u ON u.id = f.id_usuario
                WHERE (f.factura is not null and f.factura != '') AND u.id_area = 5 AND month(f.fecha) = month(CURDATE()) GROUP BY f.factura";
        $res = $this->consulta($qry);
        return $res;
    }

    public function grafica_gasto_año(){
        $qry = "SELECT f.id, f.fecha, f.hora, f.comentarios, f.factura, MONTHNAME(f.fecha) Mes,
                SUM(f.total) as subtotal,
                SUM(CASE 
                                WHEN f.iva = 1 THEN ((f.total * 0.16) + f.total) 
                                WHEN f.iva = 0 or f.iva = null THEN f.total END) AS total, 
                u.nombre AS usuario
                FROM inv_entrada_producto f
                LEFT JOIN usuarios u ON u.id = f.id_usuario
                WHERE (f.factura is not null and f.factura != '') AND u.id_area = {$_SESSION['area']} GROUP BY MONTH(f.fecha) ORDER BY f.fecha";
        $res = $this->consulta($qry);
        return $res;
    }
}


?>