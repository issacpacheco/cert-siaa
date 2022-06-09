<?php
namespace nsreportes;
use conexionbd\mysqlconsultas;

class reportes extends mysqlconsultas{
    public function obtener_reporte_alumnos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT a.*, o.nombre as oferta, c.nombre as campus FROM alumnos a 
                LEFT JOIN oferta_educativa o ON o.id = a.id_oferta 
                LEFT JOIN campus c ON c.id = a.id_campus
                WHERE a.id_campus = '".$campus."' AND a.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY a.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_reporte_prospectos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT p.*, o.nombre AS oferta, u.nombre AS asesor, c.nombre AS campus FROM prospectos p 
                LEFT JOIN oferta_educativa o ON o.id = p.id_oferta 
                LEFT JOIN usuarios u ON u.id = p.id_asesor
                LEFT JOIN campus c ON c.id = p.id_campus
                WHERE p.id_campus = '".$campus."' AND p.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY p.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_reporte_aspirantes($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT a.*, o.nombre AS oferta, c.nombre AS campus, m.nombre AS medio_llegada FROM aspirantes a 
                LEFT JOIN oferta_educativa o ON o.id = a.id_oferta 
                LEFT JOIN campus c ON c.id = a.id_campus
                LEFT JOIN medios m ON m.id = a.medio
                WHERE a.id_campus = '".$campus."' AND a.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY a.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_reporte_completos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT a.*, o.nombre AS oferta, c.nombre AS campus, m.nombre AS medio_llegada FROM aspirantes_validacion v
                LEFT JOIN aspirantes a ON a.id = v.id_aspirante 
                LEFT JOIN oferta_educativa o ON o.id = a.id_oferta 
                LEFT JOIN campus c ON c.id = a.id_campus
                LEFT JOIN medios m ON m.id = a.medio
                WHERE a.id_campus = '".$campus."' AND v.fecha BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' AND v.presentado_p = 1 AND v.presentado_d = 1 AND v.resultado = 1 ORDER BY v.fecha";
        $res = $this->consulta($qry);
        return $res;
    }


    public function obtener_reporte_psicometricos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT a.*, o.nombre AS oferta, c.nombre AS campus, m.nombre AS medio_llegada FROM aspirantes_validacion v
                LEFT JOIN aspirantes a ON a.id = v.id_aspirante 
                LEFT JOIN oferta_educativa o ON o.id = a.id_oferta 
                LEFT JOIN campus c ON c.id = a.id_campus
                LEFT JOIN medios m ON m.id = a.medio
                WHERE a.id_campus = '".$campus."' AND v.fecha BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' AND v.presentado_p = 1 AND v.presentado_d = 0 AND v.resultado = 0 ORDER BY v.fecha";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_reporte_diagnostico($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT a.*, o.nombre AS oferta, c.nombre AS campus, m.nombre AS medio_llegada FROM aspirantes_validacion v
                LEFT JOIN aspirantes a ON a.id = v.id_aspirante 
                LEFT JOIN oferta_educativa o ON o.id = a.id_oferta 
                LEFT JOIN campus c ON c.id = a.id_campus
                LEFT JOIN medios m ON m.id = a.medio
                WHERE a.id_campus = '".$campus."' AND v.fecha BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' AND v.presentado_p = 1 AND v.presentado_d = 1 AND v.resultado = 0 ORDER BY v.fecha";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_graficas_alumnos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT 
                COUNT(CASE WHEN p.id_oferta = 1 OR p.id_oferta = 17 THEN 1 END) administracion_mercadotecnia,
                COUNT(CASE WHEN p.id_oferta = 2 OR p.id_oferta = 18 THEN 1 END) derecho,
                COUNT(CASE WHEN p.id_oferta = 3 OR p.id_oferta = 19 THEN 1 END) educacion_preescolar,
                COUNT(CASE WHEN p.id_oferta = 4 THEN 1 END) educacion_primaria,
                COUNT(CASE WHEN p.id_oferta = 5 OR p.id_oferta = 20 THEN 1 END) enfermeria,
                COUNT(CASE WHEN p.id_oferta = 6 OR p.id_oferta = 21 THEN 1 END) fisioterapia,
                COUNT(CASE WHEN p.id_oferta = 7 OR p.id_oferta = 23 THEN 1 END) nutricion,
                COUNT(CASE WHEN p.id_oferta = 8 OR p.id_oferta = 24 THEN 1 END) psicologia,
                COUNT(CASE WHEN p.id_oferta = 9 THEN 1 END) enfermeria_cuidados_intensivos,
                COUNT(CASE WHEN p.id_oferta = 10 THEN 1 END) enfermeria_pediatrica,
                COUNT(CASE WHEN p.id_oferta = 11 THEN 1 END) enfermeria_quirurgica,
                COUNT(CASE WHEN p.id_oferta = 12 THEN 1 END) gestion_docencia_servicios_enfermeria,
                COUNT(CASE WHEN p.id_oferta = 13 THEN 1 END) derecho_procesal_penal,
                COUNT(CASE WHEN p.id_oferta = 14 THEN 1 END) innovacion_desarrollo_educativos,
                COUNT(CASE WHEN p.id_oferta = 15 THEN 1 END) salud_publica,
                COUNT(CASE WHEN p.id_oferta = 16 THEN 1 END) doctorado_educacion,
                COUNT(CASE WHEN p.id_oferta = 22 THEN 1 END) medico_cirujano,
                COUNT(CASE WHEN p.id_oferta = 25 THEN 1 END) turismo
                FROM alumnos p WHERE p.id_campus = '".$campus."' AND p.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY p.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_graficas_medios_prospectos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT 
                COUNT(CASE WHEN p.medio = 1 THEN 1 END) facebook,
                COUNT(CASE WHEN p.medio = 2 THEN 1 END) google,
                COUNT(CASE WHEN p.medio = 3 THEN 1 END) instagram,
                COUNT(CASE WHEN p.medio = 4 THEN 1 END) whatsapp,
                COUNT(CASE WHEN p.medio = 5 THEN 1 END) periodico,
                COUNT(CASE WHEN p.medio = 6 THEN 1 END) ferias_vocacionales,
                COUNT(CASE WHEN p.medio = 7 THEN 1 END) espectaculares,
                COUNT(CASE WHEN p.medio = 8 THEN 1 END) visita_plantel,
                COUNT(CASE WHEN p.medio = 9 THEN 1 END) publicidad_transporte_publico,
                COUNT(CASE WHEN p.medio = 10 THEN 1 END) television,
                COUNT(CASE WHEN p.medio = 11 THEN 1 END) recomendacion,
                COUNT(CASE WHEN p.medio = 12 THEN 1 END) otros
                FROM prospectos p WHERE p.id_campus = '$campus' AND p.fecha_registro BETWEEN '$fecha_ini' AND '$fecha_fin' ORDER BY p.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_graficas_carreras_prospectos($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT 
                COUNT(CASE WHEN p.id_oferta = 1 OR p.id_oferta = 17 THEN 1 END) administracion_mercadotecnia,
                COUNT(CASE WHEN p.id_oferta = 2 OR p.id_oferta = 18 THEN 1 END) derecho,
                COUNT(CASE WHEN p.id_oferta = 3 OR p.id_oferta = 19 THEN 1 END) educacion_preescolar,
                COUNT(CASE WHEN p.id_oferta = 4 THEN 1 END) educacion_primaria,
                COUNT(CASE WHEN p.id_oferta = 5 OR p.id_oferta = 20 THEN 1 END) enfermeria,
                COUNT(CASE WHEN p.id_oferta = 6 OR p.id_oferta = 21 THEN 1 END) fisioterapia,
                COUNT(CASE WHEN p.id_oferta = 7 OR p.id_oferta = 23 THEN 1 END) nutricion,
                COUNT(CASE WHEN p.id_oferta = 8 OR p.id_oferta = 24 THEN 1 END) psicologia,
                COUNT(CASE WHEN p.id_oferta = 9 THEN 1 END) enfermeria_cuidados_intensivos,
                COUNT(CASE WHEN p.id_oferta = 10 THEN 1 END) enfermeria_pediatrica,
                COUNT(CASE WHEN p.id_oferta = 11 THEN 1 END) enfermeria_quirurgica,
                COUNT(CASE WHEN p.id_oferta = 12 THEN 1 END) gestion_docencia_servicios_enfermeria,
                COUNT(CASE WHEN p.id_oferta = 13 THEN 1 END) derecho_procesal_penal,
                COUNT(CASE WHEN p.id_oferta = 14 THEN 1 END) innovacion_desarrollo_educativos,
                COUNT(CASE WHEN p.id_oferta = 15 THEN 1 END) salud_publica,
                COUNT(CASE WHEN p.id_oferta = 16 THEN 1 END) doctorado_educacion,
                COUNT(CASE WHEN p.id_oferta = 22 THEN 1 END) medico_cirujano,
                COUNT(CASE WHEN p.id_oferta = 25 THEN 1 END) turismo
                FROM prospectos p WHERE p.id_campus = '".$campus."' AND p.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY p.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_graficas_medios_aspirantes($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT 
                COUNT(CASE WHEN a.medio = 1 THEN 1 END) facebook,
                COUNT(CASE WHEN a.medio = 2 THEN 1 END) google,
                COUNT(CASE WHEN a.medio = 3 THEN 1 END) instagram,
                COUNT(CASE WHEN a.medio = 4 THEN 1 END) whatsapp,
                COUNT(CASE WHEN a.medio = 5 THEN 1 END) periodico,
                COUNT(CASE WHEN a.medio = 6 THEN 1 END) ferias_vocacionales,
                COUNT(CASE WHEN a.medio = 7 THEN 1 END) espectaculares,
                COUNT(CASE WHEN a.medio = 8 THEN 1 END) visita_plantel,
                COUNT(CASE WHEN a.medio = 9 THEN 1 END) publicidad_transporte_publico,
                COUNT(CASE WHEN a.medio = 10 THEN 1 END) television,
                COUNT(CASE WHEN a.medio = 11 THEN 1 END) recomendacion,
                COUNT(CASE WHEN a.medio = 12 THEN 1 END) otros
                FROM aspirantes a WHERE a.id_campus = '".$campus."' AND a.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY a.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_graficas_carreras_aspirantes($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT 
                COUNT(CASE WHEN a.id_oferta = 1 OR a.id_oferta = 17 THEN 1 END) administracion_mercadotecnia,
                COUNT(CASE WHEN a.id_oferta = 2 OR a.id_oferta = 18 THEN 1 END) derecho,
                COUNT(CASE WHEN a.id_oferta = 3 OR a.id_oferta = 19 THEN 1 END) educacion_preescolar,
                COUNT(CASE WHEN a.id_oferta = 4 THEN 1 END) educacion_primaria,
                COUNT(CASE WHEN a.id_oferta = 5 OR a.id_oferta = 20 THEN 1 END) enfermeria,
                COUNT(CASE WHEN a.id_oferta = 6 OR a.id_oferta = 21 THEN 1 END) fisioterapia,
                COUNT(CASE WHEN a.id_oferta = 7 OR a.id_oferta = 23 THEN 1 END) nutricion,
                COUNT(CASE WHEN a.id_oferta = 8 OR a.id_oferta = 24 THEN 1 END) psicologia,
                COUNT(CASE WHEN a.id_oferta = 9 THEN 1 END) enfermeria_cuidados_intensivos,
                COUNT(CASE WHEN a.id_oferta = 10 THEN 1 END) enfermeria_pediatrica,
                COUNT(CASE WHEN a.id_oferta = 11 THEN 1 END) enfermeria_quirurgica,
                COUNT(CASE WHEN a.id_oferta = 12 THEN 1 END) gestion_docencia_servicios_enfermeria,
                COUNT(CASE WHEN a.id_oferta = 13 THEN 1 END) derecho_procesal_penal,
                COUNT(CASE WHEN a.id_oferta = 14 THEN 1 END) innovacion_desarrollo_educativos,
                COUNT(CASE WHEN a.id_oferta = 15 THEN 1 END) salud_publica,
                COUNT(CASE WHEN a.id_oferta = 16 THEN 1 END) doctorado_educacion,
                COUNT(CASE WHEN a.id_oferta = 22 THEN 1 END) medico_cirujano,
                COUNT(CASE WHEN a.id_oferta = 25 THEN 1 END) turismo
                FROM aspirantes a WHERE a.id_campus = '".$campus."' AND a.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' ORDER BY a.fecha_registro";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_graficas_instituciones($campus, $fecha_ini, $fecha_fin){
        $qry ="SELECT id, COUNT(case when institucion = institucion THEN 1 end) as total, institucion 
                FROM prospectos 
                WHERE id_campus = '".$campus."'  AND fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'  GROUP BY institucion ORDER BY total DESC LIMIT 10";
        $res = $this->consulta($qry);
        return $res;
    }

    public function obtener_horario_preferencia($campus, $fecha_ini, $fecha_fin){
        $qry = "SELECT 
                COUNT(CASE WHEN p.horario = 'Mañana' THEN 1 END) Matutino,
                COUNT(CASE WHEN p.horario = 'Tarde' THEN 1 END) Vespertino,
                COUNT(CASE WHEN p.horario = 'Indistinto' THEN 1 END) Indistinto
                FROM prospectos p WHERE p.id_campus = '".$campus."' AND p.fecha_registro BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'";
        $res = $this->consulta($qry);
        return $res;
    }
    
}

?>