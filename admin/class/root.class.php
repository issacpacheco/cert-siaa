<?php
namespace nsroot;
use conexionbd\mysqlconsultas;

class root extends mysqlconsultas{
    public function obtener_solicitudes($id_area){
        $qry = "SELECT s.id, s.fecha, s.hora, s.clave_solicitud, u.nombre
                FROM inv_salida_producto s
                LEFT JOIN inv_usuario u ON u.id = s.id_solicitante
                WHERE s.estatus = 1 AND s.id_campus = {$_SESSION['campus']} AND u.id_area = '$id_area'
                GROUP BY s.clave_solicitud";
        $res = $this->consulta($qry);
        return $res;

    }

    public function obtener_materiales_por_agotarse($id_area){
        $qry = "SELECT p.id, p.nombre, c.cantidad FROM inv_productos p
                LEFT JOIN inv_campus_producto c ON c.id_producto = p.id
                WHERE c.cantidad <= 10 and c.id_campus = {$_SESSION['campus']} AND p.id_area = '$id_area'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales_prestados($id_area){
        $qry = "SELECT s.id, s.cantidad_prestada, s.clave_solicitud, s.fecha, s.hora, p.nombre, u.nombre AS usuario
                FROM inv_salida_producto s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                LEFT JOIN inv_usuario u ON u.id = s.id_solicitante
                WHERE s.estatus = 3 AND p.id_area = '$id_area'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_transferencias_en_curso($id_area){
        $qry = "SELECT s.id, s.codigo_transfer, c.nombre AS campus_origen, a.nombre AS campus_destino
                FROM inv_salida_transferencia s
                LEFT JOIN campus c ON c.id = s.id_campus
                LEFT JOIN campus a ON a.id = s.id_campus_destino
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                WHERE s.estatus < 3 AND p.id_area = '$id_area' GROUP BY s.codigo_transfer";
        $res = $this->consulta($qry);
        return $res;
    }

    public function top6_mas_solicitados($id_area){
        $qry = "SELECT COUNT(s.id_producto) as total, s.id_producto, p.nombre FROM inv_salida_producto s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                WHERE p.id_area = '$id_area' GROUP BY s.id_producto ORDER BY total desc LIMIT 6";
        $res = $this->consulta($qry);
        return $res;
    }

    public function productos_activos($id_area){
        $qry = "SELECT COUNT(estatus) as disponibles FROM inv_productos WHERE estatus = 1 AND id_area = '$id_area'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function gastos_del_mes($id_area){
        $qry = "SELECT f.id, f.fecha, f.hora, f.comentarios, f.factura, 
                SUM(f.total) as subtotal,
                SUM(CASE 
                        WHEN f.iva = 1 THEN ((f.total * 0.16) + f.total) 
                        WHEN f.iva = 0 or f.iva = null THEN f.total END) AS total, 
                u.nombre AS usuario
                FROM inv_entrada_producto f
                LEFT JOIN usuarios u ON u.id = f.id_usuario
                WHERE (f.factura is not null and f.factura != '') AND u.id_area = '$id_area' AND month(f.fecha) = month(CURDATE()) GROUP BY f.factura";
        $res = $this->consulta($qry);
        return $res;
    }

    public function grafica_gasto_año($id_area){
        $qry = "SELECT f.id, f.fecha, f.hora, f.comentarios, f.factura, MONTHNAME(f.fecha) Mes,
                SUM(f.total) as subtotal,
                SUM(CASE 
                        WHEN f.iva = 1 THEN ((f.total * 0.16) + f.total) 
                        WHEN f.iva = 0 or f.iva = null THEN f.total END) AS total, 
                u.nombre AS usuario
                FROM inv_entrada_producto f
                LEFT JOIN usuarios u ON u.id = f.id_usuario
                WHERE (f.factura is not null and f.factura != '') AND u.id_area = '$id_area' GROUP BY MONTH(f.fecha) ORDER BY f.fecha";
        $res = $this->consulta($qry);
        return $res;
    }
}


?>