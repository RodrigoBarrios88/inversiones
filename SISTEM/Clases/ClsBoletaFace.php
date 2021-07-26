<?php
require_once("ClsConex.php");

class ClsBoletaFace extends ClsConex{
    var $pensum;
	
	function __construct(){
		
		$this->anio = date("Y");
		
        if ($_SESSION["pensum"] == "") {
            require_once("ClsPensum.php");
            $ClsPen = new ClsPensum();
            $this->pensum = $ClsPen->get_pensum_activo();
        }else{
            $this->pensum = $_SESSION["pensum"];
        }
	}	
    
    ////////////////////// Facturas de Boletas //////////////////////////////////

    public function cliente_alumno($alumno){
        $sql = "SELECT max(alu_nit) as cliente ";
        $sql.= " FROM app_alumnos";
        $sql.= " WHERE alu_cui = '$alumno'";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $cli = $row["cliente"];
            }
        } else {
            $cli = 0;
        }
        //echo $sql;
        return $cli;
    }

    public function get_factura($num, $ser, $carga = '', $referencia = '', $cli = '', $alumno = '', $suc = '', $fecha = '', $sit = '', $fini = '', $ffin = ''){
        $pensum = $this->pensum;

        $sql= "SELECT *, ";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = fac_alumno) as alu_nombre_completo,";
        $sql.= " (SELECT alu_nit FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_cliente_nombre,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = fac_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = fac_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion";
        //--
        $sql.= " FROM boletas_face,vnt_serie,fin_cliente,mast_sucursal,fin_moneda";
        $sql.= " WHERE fac_serie = ser_codigo";
        $sql.= " AND cli_id = fac_cliente";
        $sql.= " AND fac_sucursal = suc_id";
        $sql.= " AND mon_id = fac_moneda";
        if (strlen($num)>0) {
            $sql.= " AND fac_numero = '$num'";
        }
        if (strlen($ser)>0) {
            $sql.= " AND fac_serie = $ser";
        }
        if (strlen($carga)>0) {
            $sql.= " AND fac_carga = '$carga'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND fac_boleta = '$referencia'";
        }
        if (strlen($cli)>0) {
            $sql.= " AND ven_cliente = $cli";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND fac_alumno = '$alumno'";
        }
        if (strlen($suc)>0) {
            $sql.= " AND fac_sucursal = $suc";
        }
        if (strlen($fecha)>0) {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND fac_fecha BETWEEN '$fecha' AND '$fecha'";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND fac_fecha BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND fac_situacion = $sit";
        }
        $sql.= " ORDER BY fac_sucursal ASC, fac_carga ASC, fac_serie ASC, fac_numero ASC, fac_fecha ASC";

        $result = $this->exec_query($sql);
        echo $sql;
        return $result;
    }

    public function count_factura($num, $ser, $carga = '', $referencia = '', $cli = '', $alumno = '', $suc = '', $fecha = '', $sit = '', $fini = '', $ffin = ''){
        $sql= "SELECT COUNT(*) as total";
        $sql.= " FROM boletas_face,vnt_serie,vnt_venta,fin_cliente,mast_sucursal,fin_moneda";
        $sql.= " WHERE fac_serie = ser_codigo";
        $sql.= " AND cli_id = fac_cliente";
        $sql.= " AND fac_sucursal = suc_id";
        $sql.= " AND mon_id = fac_moneda";
        if (strlen($num)>0) {
            $sql.= " AND fac_numero = '$num'";
        }
        if (strlen($ser)>0) {
            $sql.= " AND fac_serie = $ser";
        }
        if (strlen($carga)>0) {
            $sql.= " AND fac_carga = '$carga'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND fac_boleta = '$referencia'";
        }
        if (strlen($cli)>0) {
            $sql.= " AND ven_cliente = $cli";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND fac_alumno = '$alumno'";
        }
        if (strlen($suc)>0) {
            $sql.= " AND fac_sucursal = $suc";
        }
        if (strlen($fecha)>0) {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND fac_fecha BETWEEN '$fecha' AND '$fecha'";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND fac_fecha BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND fac_situacion = $sit";
        }
        //echo $sql;
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $total = $row['total'];
        }
        return $total;
    }

    
    public function insert_factura($codigo, $centro, $fecha, $tipo, $operacion, $serie, $numero, $nit, $bienes, $servicios, $iva, $total){
        $centro = trim($centro);
        $tipo = trim($tipo);
        $operacion = trim($operacion);
        $fecha = $this->regresa_fecha($fecha);
        //--
        $sql = "INSERT INTO boletas_face ";
        $sql.= "VALUES ($codigo, '$centro', '$fecha', '$tipo', '$operacion', '$serie', '$numero', '$nit', '$bienes', '$servicios', '$iva', '$total');";
        //echo $sql;
        return $sql;
    }


    public function update_factura($num, $ser, $suc, $alumno, $cli, $referencia, $desc, $monto, $moneda, $tcambio, $fecha){
        $desc = trim($desc);
        $fecha = $this->regresa_fecha($fecha);
        $fsis = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boletas_face SET ";
        $sql.= "fac_sucursal = $suc,";
        $sql.= "fac_alumno = '$alumno',";
        $sql.= "fac_cliente = $cli,";
        $sql.= "fac_boleta = '$referencia',";
        $sql.= "fac_descripcion = '$desc',";
        $sql.= "fac_monto = $monto,";
        $sql.= "fac_moneda = $moneda,";
        $sql.= "fac_tcambio = $tcambio,";
        $sql.= "fac_fecha = '$fecha',";
        $sql.= "fac_fecha_registro = '$fsis',";
        $sql.= "fac_usuario = '$usu'";

        $sql.= " WHERE fac_numero = $num";
        $sql.= " AND fac_serie = $ser; ";
        //echo $sql;
        return $sql;
    }
    
    public function max_factura(){
        $sql = "SELECT max(face_codigo) as max ";
        $sql.= " FROM boletas_face";
        $sql.= " WHERE 1 = 1";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
    }

    public function cambia_sit_factura($num, $ser, $sit){
        $sql = "UPDATE boletas_face SET ";
        $sql.= "fac_situacion = $sit";

        $sql.= " WHERE fac_numero = $num";
        $sql.= " AND fac_serie = $ser;";

        return $sql;
    }
    
}

?>