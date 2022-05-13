<?php
namespace nsalmacen;
use conexionbd\mysqlconsultas;

class almacen extends mysqlconsultas{
    
    public function obtener_categorias(){
        $qry = "SELECT * FROM inv_categoria WHERE id_area = {$_SESSION['area']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_categoria($id){
        $qry = "SELECT * FROM inv_categoria WHERE id = '$id'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales(){
        $qry = "SELECT m.* FROM inv_productos m 
                LEFT JOIN inv_campus_producto cp ON cp.id_producto = m.id 
                LEFT JOIN campus c ON c.id = cp.id_campus  
                WHERE c.id = {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales_salida(){
        $qry = "SELECT m.id, m.nombre, cp.cantidad FROM inv_productos m 
                LEFT JOIN inv_campus_producto cp ON cp.id_producto = m.id 
                LEFT JOIN campus c ON c.id = cp.id_campus   
                WHERE cp.cantidad > 0 AND c.id = {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales_entrada(){
        $qry = "SELECT * FROM inv_productos";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales_categorias(){
        $qry = "SELECT m.id, m.nombre, m.numero_serie, m.descripcion, cp.cantidad, c.nombre AS categoria, u.nombre AS unidad FROM inv_productos m 
                LEFT JOIN inv_categoria c ON c.id = m.id_categoria
                LEFT JOIN inv_campus_producto cp ON cp.id_producto = m.id
                LEFT JOIN campus cam ON cam.id = cp.id_campus
                LEFT JOIN inv_unidades u ON u.id = m.id_unidad 
                WHERE cam.id = {$_SESSION['campus']} AND m.id_area = {$_SESSION['area']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_material($id){
        $qry = "SELECT p.*, c.nombre AS categoria, i.cantidad FROM inv_productos p 
                LEFT JOIN inv_categoria c ON c.id = p.id_categoria 
                LEFT JOIN inv_campus_producto i ON i.id_producto = p.id
                WHERE p.id = '$id'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_fotos_materiales($id){
        $qry = "SELECT f.*, concat_ws('/','../upload/materiales',f.foto) AS imgweb
                FROM inv_producto_foto f
                WHERE f.id_producto = '$id'
                ORDER BY f.id";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_lista_materiales_foto(){
        $qry = "SELECT p.id, p.nombre, f.favorito, IF(f.favorito = '1',concat_ws('/','../admin/upload/materiales',f.foto),concat_ws('/','../admin/upload/generales','not-found-img.png')) AS imgweb
                FROM inv_productos p
                LEFT JOIN inv_producto_foto f ON f.id_producto = p.id
                WHERE f.favorito = 1
                GROUP BY p.id";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_entradas(){
        $qry = "SELECT e.*, p.nombre AS producto, u.nombre AS nombre
                FROM inv_entrada_producto e
                LEFT JOIN inv_productos p ON p.id = e.id_producto
                LEFT JOIN usuarios u ON u.id = e.id_usuario
                WHERE e.id_campus = {$_SESSION['campus']}
                ORDER BY e.fecha DESC, e.hora DESC";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_salidas(){
        $qry = "SELECT e.*, p.nombre AS producto, u.nombre AS nombre, s.nombre AS solicitante
                FROM inv_salida_producto e
                LEFT JOIN inv_productos p ON p.id = e.id_producto
                LEFT JOIN usuarios u ON u.id = e.id_usuario
                LEFT JOIN usuarios s ON s.id = e.id_solicitante
                WHERE e.id_campus = {$_SESSION['campus']}
                AND e.estatus = 0 OR e.estatus >= 3
                ORDER BY e.fecha DESC, e.hora DESC";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_entradas_transferencia(){
        $qry = "SELECT e.*, p.nombre AS producto, u.nombre AS nombre
                FROM inv_entrada_transferencia e
                LEFT JOIN inv_productos p ON p.id = e.id_producto
                LEFT JOIN usuarios u ON u.id = e.id_usuario
                WHERE e.id_campus = {$_SESSION['campus']}
                ORDER BY e.fecha DESC, e.hora DESC";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_salidas_transferencia(){
        $qry = "SELECT e.*, p.nombre AS producto, u.nombre AS nombre
                FROM inv_salida_transferencia e
                LEFT JOIN inv_productos p ON p.id = e.id_producto
                LEFT JOIN usuarios u ON u.id = e.id_usuario
                WHERE e.id_campus = {$_SESSION['campus']}
                ORDER BY e.fecha DESC, e.hora DESC";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_cantidad_material($id){
        $qry = "SELECT cantidad FROM inv_campus_producto WHERE id_producto = '$id' AND id_campus = {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_prestamos($folio){
        $qry = "SELECT s.*, p.nombre AS producto FROM inv_salida_producto s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                WHERE clave_solicitud = '$folio' AND s.estatus != 5";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_cantidad_prestada($id,$clave){
        $qry = "SELECT cantidad, cantidad_prestada FROM inv_salida_producto WHERE id_producto = '$id' AND clave_solicitud = '$clave'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_cantidad_enviada($id,$clave){
        $qry = "SELECT cantidad, cantidad_enviada FROM inv_salida_transferencia WHERE id_producto = '$id' AND codigo_transfer = '$clave'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_almacenes(){
        $qry = "SELECT * FROM campus WHERE id != {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_todos_almacenes(){
        $qry = "SELECT * FROM campus";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_transferencia($folio){
        $qry = "SELECT s.*, p.nombre AS producto FROM inv_salida_transferencia s
        LEFT JOIN inv_productos p ON p.id = s.id_producto
        WHERE s.codigo_transfer = '$folio' AND s.estatus != 3 AND s.id_campus_destino = {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_transferencia_eliminar($folio,$destino){
        $qry = "SELECT s.*, p.nombre AS producto FROM inv_salida_transferencia s
        LEFT JOIN inv_productos p ON p.id = s.id_producto
        WHERE s.codigo_transfer = '$folio' AND s.estatus != 3 AND s.id_campus_destino = $destino";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_mis_solicitudes(){
        $qry = "SELECT * FROM inv_salida_producto WHERE id_solicitante = {$_SESSION['id_admin']} GROUP BY clave_solicitud";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_lista_materiales($id){
        $qry = "SELECT s.*, p.nombre AS nombre FROM inv_salida_producto s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                WHERE s.clave_solicitud = '$id'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_solicitudes(){
        $qry = "SELECT s.id, s.fecha, s.hora, s.clave_solicitud, u.nombre
                FROM inv_salida_producto s
                LEFT JOIN usuarios u ON u.id = s.id_solicitante
                WHERE s.estatus = 1 AND s.id_campus = {$_SESSION['campus']}
                GROUP BY s.clave_solicitud";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales_por_agotarse(){
        $qry = "SELECT p.id, p.nombre, c.cantidad FROM inv_productos p
                LEFT JOIN inv_campus_producto c ON c.id_producto = p.id
                WHERE c.cantidad <= 10 and c.id_campus = {$_SESSION['campus']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_materiales_prestados(){
        $qry = "SELECT s.id, s.cantidad_prestada, s.clave_solicitud, s.fecha, s.hora, p.nombre, u.nombre AS usuario
                FROM inv_salida_producto s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                LEFT JOIN usuarios u ON u.id = s.id_solicitante
                WHERE s.estatus = 3";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_mis_envios(){
        $qry = "SELECT s.id, s.codigo_transfer, c.nombre AS campus_origen, a.nombre AS campus_destino
                FROM inv_salida_transferencia s
                LEFT JOIN campus c ON c.id = s.id_campus
                LEFT JOIN campus a ON a.id = s.id_campus_destino
                WHERE s.id_responsable = {$_SESSION['id_admin']} AND s.estatus < 3";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_mis_envios_finalizados(){
        $qry = "SELECT s.id, s.codigo_transfer, c.nombre AS campus_origen, a.nombre AS campus_destino
                FROM inv_salida_transferencia s
                LEFT JOIN campus c ON c.id = s.id_campus
                LEFT JOIN campus a ON a.id = s.id_campus_destino
                WHERE s.id_responsable = {$_SESSION['id_admin']} AND s.estatus > 2";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_lista_transferencia($clave){
        $qry = "SELECT s.id, p.nombre AS producto, s.cantidad, c.nombre AS campus_origen, a.nombre AS campus_destino, u.nombre AS nombre
                FROM inv_salida_transferencia s
                LEFT JOIN inv_productos p ON p.id = s.id_producto
                LEFT JOIN usuarios u ON u.id = s.id_responsable
                LEFT JOIN campus c ON c.id = s.id_campus
                LEFT JOIN campus a ON a.id = s.id_campus_destino
                WHERE s.codigo_transfer = '$clave'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_transferencias_en_curso(){
        $qry = "SELECT s.id, s.codigo_transfer, c.nombre AS campus_origen, a.nombre AS campus_destino
                FROM inv_salida_transferencia s
                LEFT JOIN campus c ON c.id = s.id_campus
                LEFT JOIN campus a ON a.id = s.id_campus_destino
                WHERE s.estatus < 3";
        $res = $this->consulta($qry);
        return $res;
    }

    public function subareas(){
        $qry = "SELECT * FROM inv_subareas WHERE id_area = {$_SESSION['area']}";
        $res = $this->consulta($qry);
        return $res;
    }
    
    public function unidades(){
        $qry = "SELECT * FROM inv_unidades";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_unidad($valor){
        $qry = "SELECT * FROM inv_unidades WHERE abreviacion LIKE '".$valor."'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function mis_bodeguitas(){
        $qry = "SELECT * FROM inv_bodeguitas WHERE id_area = {$_SESSION['area']}";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_bodega($id){
        $qry = "SELECT * FROM inv_bodeguitas WHERE id = '$id'";
        $res = $this->consulta($qry);
        return $res;
    }

    public function historial_material_entrada($id){
        $qry = "SELECT e.id, m.nombre, e.cantidad, e.fecha, e.hora, e.total, e.devolucion, u.nombre AS usuario 
                FROM inv_entrada_producto e 
                LEFT JOIN inv_productos m ON m.id = e.id_producto
                LEFT JOIN usuarios u ON u.id = e.id_usuario
                WHERE  e.id_producto = $id ORDER BY e.id DESC";
        $res = $this->consulta($qry);
        return $res;
    }

    public function historial_material_salida($id){
        $qry = "SELECT e.id, m.nombre, e.cantidad, e.fecha, e.hora, e.prestamo, u.nombre AS usuario 
                FROM inv_salida_producto e 
                LEFT JOIN inv_productos m ON m.id = e.id_producto
                LEFT JOIN usuarios u ON u.id = e.id_usuario
                WHERE  e.id_producto = $id ORDER BY e.id DESC";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_facturas(){
        $qry = "SELECT f.id, f.fecha, f.hora, f.comentarios, f.factura, u.nombre AS usuario
                FROM inv_entrada_producto f
                LEFT JOIN usuarios u ON u.id = f.id_usuario
                WHERE f.factura is not null GROUP BY f.factura";
        $res = $this->consulta($qry);
        return $res;
    }

}


?>