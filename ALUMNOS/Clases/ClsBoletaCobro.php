<?php
require_once("ClsConex.php");

class ClsBoletaCobro extends ClsConex{
    var $pensum;
	var $periodo;

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


    //---------- Configuracion de Boletas de Cobro ---------//
    public function get_configuracion_boleta_cobro($codigo, $division = '', $grupo = '', $tipo = '', $periodo = '', $pensum = '', $nivel = '', $grado = ''){
        $sql= "SELECT *, ";
        $sql.= " (SELECT per_anio FROM fin_periodo_fiscal WHERE cbol_periodo_fiscal = per_codigo ORDER BY per_codigo DESC LIMIT 0,1) ,";
        $sql.= " (SELECT per_descripcion FROM fin_periodo_fiscal WHERE cbol_periodo_fiscal = per_codigo ORDER BY per_codigo DESC LIMIT 0,1) as cbol_periodo_descripcion";
        $sql.= " FROM  boletas_configuracion_boleta_cobro, boletas_division, boletas_division_grupo, fin_moneda";
        $sql.= " WHERE cbol_division = div_codigo";
        $sql.= " AND cbol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        if (strlen($codigo)>0) {
            $sql.= " AND cbol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND cbol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND cbol_grupo = $grupo";
        }
        if (strlen($tipo)>0) {
            $sql.= " AND cbol_tipo = '$tipo'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND cbol_periodo_fiscal = $periodo";
        }
        if (strlen($pensum)>0) {
            $sql.= " AND cbol_pensum = $pensum";
        }
        if (strlen($nivel)>0) {
            $sql.= " AND cbol_nivel = $nivel";
        }
        if (strlen($grado)>0) {
            $sql.= " AND cbol_grado = $grado";
        }
        $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, cbol_tipo ASC, cbol_periodo_fiscal ASC, cbol_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql."<br>";
        return $result;
    }

    public function count_configuracion_boleta_cobro($codigo, $division = '', $grupo = '', $tipo = '', $periodo = '', $pensum = '', $nivel = '', $grado = ''){
        $sql= "SELECT COUNT(*) as total";
        $sql.= " FROM  boletas_configuracion_boleta_cobro, boletas_division, boletas_division_grupo, fin_moneda";
        $sql.= " WHERE cbol_division = div_codigo";
        $sql.= " AND cbol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        if (strlen($codigo)>0) {
            $sql.= " AND cbol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND cbol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND cbol_grupo = $grupo";
        }
        if (strlen($tipo)>0) {
            $sql.= " AND cbol_tipo = '$tipo'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND cbol_periodo_fiscal = $periodo";
        }
        if (strlen($pensum)>0) {
            $sql.= " AND cbol_pensum = $pensum";
        }
        if (strlen($nivel)>0) {
            $sql.= " AND cbol_nivel = $nivel";
        }
        if (strlen($grado)>0) {
            $sql.= " AND cbol_grado = $grado";
        }
        //echo $sql;
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $total = $row['total'];
        }
        return $total;
    }


    public function insert_configuracion_boleta_cobro($codigo, $periodo, $division, $grupo, $tipo, $pensum, $nivel, $grado, $monto, $motivo, $mes, $dia,$anio){
        //--
        $motivo = trim($motivo);
        $fecha = $this->regresa_fecha($fecha);
        $freg = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boletas_configuracion_boleta_cobro";
        $sql.= " VALUES ($codigo,$periodo,$division,$grupo,'$tipo',$pensum,$nivel,$grado,$monto,'$motivo',$mes,$dia,$anio); ";
        //echo $sql;
        return $sql;
    }


    public function update_configuracion_boleta_cobro($codigo, $division, $grupo, $tipo, $pensum, $nivel, $grado, $monto, $motivo, $periodo, $mes, $dia){
        //--
        $motivo = trim($motivo);
        //--
        $sql = "UPDATE boletas_configuracion_boleta_cobro SET ";
        $sql.= "cbol_tipo = '$tipo',";
        $sql.= "cbol_pensum = $pensum,";
        $sql.= "cbol_nivel = $nivel,";
        $sql.= "cbol_grado = $grado,";
        $sql.= "cbol_monto = '$monto',";
        $sql.= "cbol_motivo = '$motivo',";
        $sql.= "cbol_periodo_fiscal = '$periodo',";
        $sql.= "cbol_mes = '$mes',";
        $sql.= "cbol_dia = '$dia' ";

        $sql.= " WHERE cbol_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function delete_configuracion_boleta_cobro($codigo){
        //--
        $sql = "DELETE FROM boletas_configuracion_boleta_cobro";
        $sql.= " WHERE cbol_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function max_configuracion_boleta_cobro(){
        $sql = "SELECT max(cbol_codigo) as max ";
        $sql.= " FROM boletas_configuracion_boleta_cobro";
        $sql.= " WHERE 1 = 1 ";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
    }


    //---------- Boleta de Cobro ---------//
    public function get_boleta_cobro_independiente($codigo, $division = '', $grupo = '', $alumno = '', $referencia = '', $periodo = '', $empresa = '', $fini = '', $ffin = '', $sit = '', $pagado = ''){
        $pensum = $this->pensum;

        $sql= "SELECT *, bol_codigo as bol_corretalivo,";
        //-- subquery de periodo fiscal
        $sql.= " (SELECT per_anio FROM fin_periodo_fiscal WHERE bol_periodo_fiscal = per_codigo ORDER BY per_codigo DESC LIMIT 0,1) as bol_anio,";
        $sql.= " (SELECT per_descripcion FROM fin_periodo_fiscal WHERE bol_periodo_fiscal = per_codigo ORDER BY per_codigo DESC LIMIT 0,1) as bol_periodo_descripcion,";
        //-- subquery alumno
        $sql.= " (SELECT CONCAT(alu_nombre, ' ', alu_apellido) FROM app_alumnos";
        $sql.= " WHERE alu_cui = bol_alumno ORDER BY alu_cui DESC LIMIT 0 , 1) AS alu_nombre_completo,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = bol_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion";
        //--
        $sql.= " FROM  boletas_boleta_cobro, boletas_division, boletas_division_grupo, fin_moneda";
        $sql.= " WHERE bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        if (strlen($codigo)>0) {
            $sql.= " AND bol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND bol_referencia = '$referencia'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion = $sit";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }


    public function get_boleta_cobro($codigo, $division = '', $grupo = '', $alumno = '', $referencia = '', $periodo = '', $empresa = '', $fini = '', $ffin = '', $sit = '', $orderby = '', $pagado = '', $tipo = ''){
        $pensum = $this->pensum;

        $sql= "SELECT *, bol_codigo as bol_corretalivo,";
        //-- subquery de periodo fiscal
        $sql.= " (SELECT per_anio FROM fin_periodo_fiscal WHERE bol_periodo_fiscal = per_codigo ORDER BY per_codigo DESC LIMIT 0,1) as bol_anio,";
        $sql.= " (SELECT per_descripcion FROM fin_periodo_fiscal WHERE bol_periodo_fiscal = per_codigo ORDER BY per_codigo DESC LIMIT 0,1) as bol_periodo_descripcion,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = bol_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = bol_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion";
        //--
        $sql.= " FROM  boletas_boleta_cobro, boletas_division, boletas_division_grupo, fin_moneda, app_alumnos";
        $sql.= " WHERE bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        $sql.= " AND bol_alumno = alu_cui";
        if (strlen($codigo)>0) {
            $sql.= " AND bol_codigo IN($codigo)";
        }
        if (strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND bol_referencia = '$referencia'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion = $sit";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
        }
        if (strlen($orderby)>0) {
            switch ($orderby) {
                case 1: $sql.= " ORDER BY gru_codigo ASC,  div_codigo ASC, bol_alumno ASC, bol_codigo ASC"; break;
                case 2: $sql.= " ORDER BY bol_fecha_pago ASC, gru_codigo ASC,  div_codigo ASC, bol_alumno ASC, bol_codigo ASC"; break;
                case 3: $sql.= " ORDER BY bol_tipo ASC, div_codigo ASC, bol_alumno ASC, bol_fecha_pago ASC, bol_codigo ASC"; break;
                default: $sql.= " ORDER BY gru_codigo ASC,  div_codigo ASC, bol_alumno ASC, bol_codigo ASC"; break;
            }
        } else {
            $sql.= " ORDER BY gru_codigo ASC,  div_codigo ASC, bol_alumno ASC, bol_codigo ASC";
        }

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }

    public function count_boleta_cobro($codigo, $division = '', $grupo = '', $alumno = '', $referencia = '', $periodo = '', $empresa = '', $fini = '', $ffin = '', $sit = '', $pagado = '') {
        $sql= "SELECT COUNT(*) as total";
        $sql.= " FROM  boletas_boleta_cobro, boletas_division, boletas_division_grupo, fin_moneda, app_alumnos";
        $sql.= " WHERE bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        $sql.= " AND bol_alumno = alu_cui";
        if (strlen($codigo)>0) {
            $sql.= " AND bol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND bol_referencia = '$referencia'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion = $sit";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        //echo $sql;
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $total = $row['total'];
        }
        return $total;
    }


    public function get_boleta_vs_pago($codigo, $division = '', $grupo = '', $alumno = '', $referencia = '', $periodo = '', $empresa = '', $fini = '', $ffin = '', $sit = '', $orderby = '', $pagado = ''){
        $pensum = $this->pensum;

        $sql = " SELECT *, bol_codigo as bol_corretalivo";
        $sql.= " FROM vista_boleta_cobro";
        $sql.= " LEFT JOIN vista_alumnos_cliente ON bol_alumno = alu_cui";
        $sql.= " LEFT JOIN vista_alumnos_inscripciones ON bol_alumno = alu_inscripciones_cui";
        $sql.= " LEFT JOIN vista_pago_boletas ON pag_programado = bol_codigo";
        $sql.= " LEFT JOIN vista_factura_boleta ON pag_codigo = fac_pago";
        $sql.= " LEFT JOIN vista_recibo_boleta ON pag_codigo = rec_pago";
        $sql.= " WHERE 1 = 1";
        if (strlen($codigo)>0) {
            $sql.= " AND bol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND bol_referencia = '$referencia'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion = $sit";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($orderby)>0) {
            switch ($orderby) {
                case 1: $sql.= " ORDER BY bol_grupo ASC, bol_division ASC, bol_alumno ASC, bol_codigo ASC"; break;
                case 2: $sql.= " ORDER BY bol_fecha_pago ASC, bol_grupo ASC, bol_division ASC, bol_alumno ASC, bol_codigo ASC"; break;
                case 3: $sql.= " ORDER BY bol_tipo ASC, bol_division ASC, bol_alumno ASC, bol_fecha_pago ASC, bol_codigo ASC"; break;
                default: $sql.= " ORDER BY bol_grupo ASC, bol_division ASC, bol_alumno ASC, bol_codigo ASC"; break;
            }
        } else {
            $sql.= " ORDER BY bol_grupo ASC, bol_tipo_cuenta ASC, bol_division ASC, bol_alumno ASC, bol_codigo ASC";
        }
        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }


    //////// OJO CAMBIOS ///////////
    public function get_cartera($division, $grupo, $tipo, $anio, $periodo, $mes, $pensum, $nivel = '', $grado = '', $seccion = ''){
        $sql= "SELECT *,";
        ///---cargos----//
        if($mes == 1 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-01-01' AND '$anio-01-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 1";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_enero,";
        }
        if($mes == 2 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-02-01' AND '$anio-02-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 2";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_febrero,";
        }
        if($mes == 3 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-03-01' AND '$anio-03-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 3";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_marzo,";
        }
        if($mes == 4 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-04-01' AND '$anio-04-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 4";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_abril,";
        }
        if($mes == 5 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-05-01' AND '$anio-05-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 5";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_mayo,";
        }
        if($mes == 6 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-06-01' AND '$anio-06-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 6";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_junio,";
        }
        if($mes == 7 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-07-01' AND '$anio-07-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 7";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_julio,";
        }
        if($mes == 8 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-08-01' AND '$anio-08-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 8";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_agosto,";
        }
        if($mes == 9 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-09-01' AND '$anio-09-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 9";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_septiembre,";
        }
        if($mes == 10 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-10-01' AND '$anio-10-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 10";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_octubre,";
        }
        if($mes == 11 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-11-01' AND '$anio-11-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 11";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_noviembre,";
        }
        if($mes == 12 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-12-01' AND '$anio-12-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 12";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as cargos_diciembre,";
        }
        ///---descuentos---///
        if($mes == 1 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-01-01' AND '$anio-01-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 1";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_enero,";
        }
        if($mes == 2 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-02-01' AND '$anio-02-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 2";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_febrero,";
        }
        if($mes == 3 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-03-01' AND '$anio-03-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 3";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_marzo,";
        }
        if($mes == 4 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-04-01' AND '$anio-04-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 4";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_abril,";
        }
        if($mes == 5 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-05-01' AND '$anio-05-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 5";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_mayo,";
        }
        if($mes == 6 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-06-01' AND '$anio-06-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 6";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_junio,";
        }
        if($mes == 7 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-07-01' AND '$anio-07-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 7";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_julio,";
        }
        if($mes == 8 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-08-01' AND '$anio-08-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 8";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_agosto,";
        }
        if($mes == 9 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-09-01' AND '$anio-09-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 9";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_septiembre,";
        }
        if($mes == 10 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-10-01' AND '$anio-10-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 10";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_octubre,";
        }
        if($mes == 11 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-11-01' AND '$anio-11-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 11";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_noviembre,";
        }
        if($mes == 12 || $mes == 13) {
            $sql.= " (SELECT SUM(bol_descuento) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND bol_fecha_pago BETWEEN '$anio-12-01' AND '$anio-12-31'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo AND MONTH(bol_fecha_pago) = 12";
            }
            if(strlen($tipo)>0) {
            $sql.= " AND bol_tipo = '$tipo'";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as descuentos_diciembre,";
        }
        ///---pagos---///
        if($mes == 1 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-01-01 00:00:00' AND '$anio-01-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 1";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_enero,";
        }
        if($mes == 2 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-02-01 00:00:00' AND '$anio-02-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 2";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_febrero,";
        }
        if($mes == 3 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-03-01 00:00:00' AND '$anio-03-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 3";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_marzo,";
        }
        if($mes == 4 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-04-01 00:00:00' AND '$anio-04-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 4";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_abril,";
        }
        if($mes == 5 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-05-01 00:00:00' AND '$anio-05-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 5";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_mayo,";
        }
        if($mes == 6 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-06-01 00:00:00' AND '$anio-06-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 6";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_junio,";
        }
        if($mes == 7 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-07-01 00:00:00' AND '$anio-07-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 7";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_julio,";
        }
        if($mes == 8 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-08-01 00:00:00' AND '$anio-08-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 8";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_agosto,";
        }
        if($mes == 9 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-09-01 00:00:00' AND '$anio-09-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 9";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_septiembre,";
        }
        if($mes == 10 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-10-01 00:00:00' AND '$anio-10-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 10";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_octubre,";
        }
        if($mes == 11 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-11-01 00:00:00' AND '$anio-11-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 11";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_noviembre,";
        }
        if($mes == 12 || $mes == 13) {
            $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta,boletas_boleta_cobro";
            $sql.= " WHERE bol_codigo = pag_programado AND pag_alumno = alu_cui";
            if(strlen($anio)>0) {
            $sql.= " AND pag_fechor BETWEEN '$anio-12-01 00:00:00' AND '$anio-12-31 23:59:00'";
            }
            if(strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo AND MONTH(pag_fechor) = 12";
            }
            $sql.= " AND bol_division = $division AND bol_grupo = $grupo AND bol_situacion = 1) as pagos_diciembre,";
        }
        //--
        $sql = substr($sql, 0, -1); //limpia la ultima coma de los subquerys
        //--
        $sql.= " FROM academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos";
        $sql.= " WHERE sec_pensum = gra_pensum";
        $sql.= " AND sec_nivel = gra_nivel";
        $sql.= " AND sec_grado = gra_codigo";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = alu_cui";
        $sql.= " AND alu_situacion != 0";
        if(strlen($pensum)>0) {
            $sql.= " AND seca_pensum = $pensum";
        }
        if(strlen($nivel)>0) {
            $sql.= " AND seca_nivel = $nivel";
        }
        if(strlen($grado)>0) {
            $sql.= " AND seca_grado = $grado";
        }
        if(strlen($seccion)>0) {
            $sql.= " AND seca_seccion = $seccion";
        }
        $sql.= " ORDER BY seca_nivel ASC, seca_grado ASC, sec_codigo ASC, alu_apellido ASC, alu_nombre ASC";

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }

    public function comprueba_periodo_boleta_cobro($codigo){
        $sql = "SELECT bol_periodo_fiscal as periodo";
        $sql.= " FROM boletas_boleta_cobro";
        $sql.= " WHERE bol_codigo = '$codigo'";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $periodo = $row["periodo"];
            }
        } else {
            $periodo = '';
        }
        //echo $sql;
        return $periodo;
    }


    public function insert_boleta_cobro($codigo, $periodo, $division, $grupo, $alumno, $codalumno, $referencia, $tipo, $monto, $motivo, $descuento, $motdescuento, $fecha){
        //--
        $motivo = trim($motivo);
        $motdescuento = trim($motdescuento);
        $fecha = $this->regresa_fecha($fecha);
        $freg = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boletas_boleta_cobro";
        $sql.= " VALUES ($codigo,$periodo,$division,$grupo,'$alumno','$codalumno','$referencia', '$tipo', '$monto','$motivo','$descuento','$motdescuento','$freg','$fecha',$usu,0,1); ";
        //echo $sql;
        return $sql;
    }


    public function update_boleta_cobro($codigo, $division, $grupo, $alumno, $codalumno, $referencia, $tipo, $monto, $motivo, $descuento, $motdescuento, $fecha){
        //--
        $motivo = trim($motivo);
        $motdescuento = trim($motdescuento);
        $fecha = $this->regresa_fecha($fecha);
        $freg = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boletas_boleta_cobro SET ";
        $sql.= "bol_grupo = $grupo, ";
        $sql.= "bol_division = $division, ";
        $sql.= "bol_alumno = '$alumno',";
        $sql.= "bol_codigo_interno = '$codalumno',";
        $sql.= "bol_referencia = '$referencia',";
        $sql.= "bol_tipo = '$tipo',";
        $sql.= "bol_monto = '$monto',";
        $sql.= "bol_motivo = '$motivo',";  /// motivo de la boleta
        $sql.= "bol_descuento = '$descuento',";
        $sql.= "bol_motivo_descuento = '$motdescuento',";  // motivo por el cual se justifica el descuento
        $sql.= "bol_fecha_pago = '$fecha',";
        $sql.= "bol_fecha_registro = '$freg',";
        $sql.= "bol_usuario = '$usu'";

        $sql.= " WHERE bol_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function cambia_sit_boleta_cobro($codigo, $motivo_anula, $situacion){
        //--
        $motivo_anula = trim($motivo_anula);
        $freg = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boletas_boleta_cobro SET ";
        $sql.= "bol_motivo = CONCAT(bol_motivo, '/Anulada por: $motivo_anula'),";
        $sql.= "bol_situacion = '$situacion',";
        $sql.= "bol_fecha_registro = '$freg',";
        $sql.= "bol_usuario = '$usu'";

        $sql.= " WHERE bol_codigo IN($codigo); ";
        //echo $sql;
        return $sql;
    }

    public function cambia_documento_boleta_cobro($codigo, $referencia){
        //--
        $sql = "UPDATE boletas_boleta_cobro SET ";
        $sql.= "bol_referencia = '$referencia'";

        $sql.= " WHERE bol_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function cambia_pagado_boleta_cobro($codigo, $pagado){
        //--
        $sql = "UPDATE boletas_boleta_cobro SET ";
        $sql.= "bol_pagado = '$pagado'";

        $sql.= " WHERE bol_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function cambia_pagado_boleta_cobro_carga($division, $grupo, $referencia, $pagado){
        //--
        $sql = "UPDATE boletas_boleta_cobro SET ";
        $sql.= "bol_pagado = '$pagado'";

        $sql.= " WHERE bol_referencia = '$referencia' ";
        $sql.= " AND bol_grupo = $grupo ";
        $sql.= " AND bol_division = $division; ";
        //echo $sql;
        return $sql;
    }



    public function max_boleta_cobro(){
        $sql = "SELECT max(bol_codigo) as max ";
        $sql.= " FROM boletas_boleta_cobro";
        $sql.= " WHERE 1 = 1 ";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
    }


    public function max_numero_boleta_cobro($division, $grupo, $periodo){
        $sql = "SELECT max(CAST(bol_referencia AS SIGNED)) as max ";
        $sql.= " FROM boletas_boleta_cobro";
        $sql.= " WHERE bol_grupo = $grupo ";
        $sql.= " AND bol_division = $division ";
        $sql.= " AND bol_periodo_fiscal = ".$periodo;
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
    }


    //---------- Detalle de Ventas con Boletas de Cobro ---------//

    public function insert_detalle_desde_temporal($referencia, $division, $grupo, $pv, $suc){
        $sql.= "INSERT INTO boletas_det_venta (dven_codigo, dven_boleta, dven_division, dven_grupo_division, dven_tipo, dven_detalle, dven_articulo, dven_grupo, dven_cantidad, dven_precio, dven_moneda, dven_tcambio, dven_subtotal, dven_descuento, dven_total, dven_descarga)";
        $sql.= " SELECT dventemp_codigo, $referencia, $division, $grupo, dventemp_tipo, dventemp_detalle, dventemp_articulo, dventemp_grupo, dventemp_cantidad, dventemp_precio, dventemp_moneda, dventemp_tcambio, dventemp_subtotal, dventemp_descuento, dventemp_total, 0";
        $sql.= " FROM vnt_detalle_temporal";
        $sql.= " WHERE dventemp_pventa = '$pv'";
        $sql.= " AND dventemp_sucursal = '$suc';";
        //echo $sql;
        return $sql;
    }

    public function descargar_det_venta($referencia, $division, $grupo, $desc, $art, $grup){
        $sql = "UPDATE boletas_det_venta SET ";
        $sql.= "dven_descarga = $desc";

        $sql.= " WHERE dven_boleta = $referencia";
        $sql.= " AND dven_division = $division";
        $sql.= " AND dven_grupo_division = $grupo";
        $sql.= " AND dven_articulo = $art ";
        $sql.= " AND dven_grupo = $grup; ";

        return $sql;
    }

    public function get_det_venta($codigo = '', $referencia = '', $division = '', $grupo = '', $tipo = '', $alumno = '', $fregini = '', $fregfin = '', $fpagini = '', $fpagfin = '', $pagado = '', $sit = '', $empresa = ''){

        $pensum = $this->pensum;

        $sql= "SELECT *, ";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = bol_alumno) as alu_nombre_completo";
        $sql.= " (SELECT alu_nit FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_cliente_nombre,";
        //--subqueryes de facturas y recibos
        $sql.= " (SELECT CONCAT(ser_numero,' ',fac_numero) FROM boletas_factura_boleta,vnt_serie WHERE fac_serie = ser_codigo AND fac_referencia = bol_referencia AND fac_sucursal = div_empresa AND fac_situacion = 1 ORDER BY ser_numero LIMIT 0 , 1) as fac_serie_numero,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = bol_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = bol_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion";
        //--
        $sql.= " FROM boletas_boleta_cobro,boletas_det_venta,boletas_division,fin_moneda";
        $sql.= " WHERE bol_codigo = dven_boleta ";
        $sql.= " AND bol_grupo = dven_grupo_division ";
        $sql.= " AND bol_division = dven_division ";
        $sql.= " AND bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND dven_moneda = mon_id";

        if (strlen($codigo)>0) {
            $sql.= " AND dven_codigo = $codigo";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND dven_boleta = $referencia";
        }
        if (strlen($division)>0) {
            $sql.= " AND dven_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND dven_grupo_division = $grupo";
        }
        if (strlen($tipo)>0) {
            $sql.= " AND dven_tipo = '$tipo'";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if ($fregini != "" && $fregfin != "") {
            $fregini = $this->regresa_fecha($fregini);
            $fregfin = $this->regresa_fecha($fregfin);
            $sql.= " AND bol_fecha_registro BETWEEN '$fregini 00:00:00' AND '$fregfin 23:59:59'";
        }
        if ($fpagini != "" && $fpagfin != "") {
            $fpagini = $this->regresa_fecha($fpagini);
            $fpagfin = $this->regresa_fecha($fpagfin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fpagini' AND '$fpagfin'";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion IN($sit)";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        $sql.= " ORDER BY bol_grupo ASC, bol_division ASC, bol_fecha_registro ASC, dven_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }


    public function get_det_venta_producto($codigo = '', $referencia = '', $division = '', $grupo = '', $tipo = '', $alumno = '', $fregini = '', $fregfin = '', $fpagini = '', $fpagfin = '', $pagado = '', $sit = '', $empresa = ''){
        $pensum = $this->pensum;

        $sql= "SELECT *, ";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = bol_alumno) as alu_nombre_completo,";
        $sql.= " (SELECT alu_nit FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_cliente_nombre,";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = bol_alumno) as alu_nombre_completo,";
        $sql.= " (SELECT alu_nit FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_cliente_nombre,";
        //--subqueryes de facturas y recibos
        $sql.= " (SELECT CONCAT(ser_numero,' ',fac_numero) FROM boletas_factura_boleta,vnt_serie WHERE fac_serie = ser_codigo AND fac_referencia = bol_referencia AND fac_sucursal = div_empresa AND fac_situacion = 1 ORDER BY ser_numero LIMIT 0 , 1) as fac_serie_numero,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = bol_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = bol_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion,";
        //--subqueryes de facturas y recibos
        $sql.= " (SELECT fac_numero FROM boletas_factura_boleta WHERE fac_referencia = bol_referencia AND fac_sucursal = div_empresa AND fac_situacion = 1 ORDER BY fac_numero LIMIT 0 , 1) as fac_numero,";
        $sql.= " (SELECT fac_serie FROM boletas_factura_boleta WHERE fac_referencia = bol_referencia AND fac_sucursal = div_empresa AND fac_situacion = 1 ORDER BY fac_serie LIMIT 0 , 1) as fac_serie,";
        $sql.= " (SELECT ser_numero FROM boletas_factura_boleta,vnt_serie WHERE fac_serie = ser_codigo AND fac_referencia = bol_referencia AND fac_sucursal = div_empresa AND fac_situacion = 1 ORDER BY ser_numero LIMIT 0 , 1) as fac_serie_numero";
        //--
        $sql.= " FROM boletas_boleta_cobro,boletas_det_venta,boletas_division,boletas_division_grupo,inv_articulo";
        $sql.= " WHERE bol_codigo = dven_boleta ";
        $sql.= " AND bol_grupo = dven_grupo_division ";
        $sql.= " AND bol_division = dven_division ";
        $sql.= " AND bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND dven_grupo = art_grupo";
        $sql.= " AND dven_articulo = art_codigo";

        if (strlen($codigo)>0) {
            $sql.= " AND dven_codigo = $codigo";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND dven_boleta = $referencia";
        }
        if (strlen($division)>0) {
            $sql.= " AND dven_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND dven_grupo_division = $grupo";
        }
        if (strlen($tipo)>0) {
            $sql.= " AND dven_tipo = '$tipo'";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if ($fregini != "" && $fregfin != "") {
            $fregini = $this->regresa_fecha($fregini);
            $fregfin = $this->regresa_fecha($fregfin);
            $sql.= " AND bol_fecha_registro BETWEEN '$fregini 00:00:00' AND '$fregfin 23:59:59'";
        }
        if ($fpagini != "" && $fpagfin != "") {
            $fpagini = $this->regresa_fecha($fpagini);
            $fpagfin = $this->regresa_fecha($fpagfin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fpagini' AND '$fpagfin'";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion IN($sit)";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        $sql.= " ORDER BY bol_grupo ASC, bol_division ASC, bol_fecha_registro ASC, dven_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }

    public function get_det_venta_servicios($codigo = '', $referencia = '', $division = '', $grupo = '', $tipo = '', $alumno = '', $fregini = '', $fregfin = '', $fpagini = '', $fpagfin = '', $pagado = '', $sit = '', $empresa = ''){

        $pensum = $this->pensum;

        $sql= "SELECT *, ";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = bol_alumno) as alu_nombre_completo,";
        $sql.= " (SELECT alu_nit FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM app_alumnos WHERE alu_cui = bol_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_cliente_nombre,";
        //--subqueryes de facturas y recibos
        $sql.= " (SELECT CONCAT(ser_numero,' ',fac_numero) FROM boletas_factura_boleta,vnt_serie WHERE fac_serie = ser_codigo AND fac_referencia = bol_referencia AND fac_sucursal = div_empresa AND fac_situacion = 1 ORDER BY ser_numero LIMIT 0 , 1) as fac_serie_numero,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = bol_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = bol_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion";
        //--
        $sql.= " FROM boletas_boleta_cobro,boletas_det_venta,boletas_division,inv_servicio";
        $sql.= " WHERE bol_codigo = dven_boleta ";
        $sql.= " AND bol_grupo = dven_grupo_division ";
        $sql.= " AND bol_division = dven_division ";
        $sql.= " AND bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND dven_articulo = ser_codigo";
        $sql.= " AND dven_grupo = ser_grupo";

        if (strlen($codigo)>0) {
            $sql.= " AND dven_codigo = $codigo";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND dven_boleta = $referencia";
        }
        if (strlen($division)>0) {
            $sql.= " AND dven_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND dven_grupo_division = $grupo";
        }
        if (strlen($tipo)>0) {
            $sql.= " AND dven_tipo = '$tipo'";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if ($fregini != "" && $fregfin != "") {
            $fregini = $this->regresa_fecha($fregini);
            $fregfin = $this->regresa_fecha($fregfin);
            $sql.= " AND bol_fecha_registro BETWEEN '$fregini 00:00:00' AND '$fregfin 23:59:59'";
        }
        if ($fpagini != "" && $fpagfin != "") {
            $fpagini = $this->regresa_fecha($fpagini);
            $fpagfin = $this->regresa_fecha($fpagfin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fpagini' AND '$fpagfin'";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion IN($sit)";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        $sql.= " ORDER BY bol_grupo ASC, bol_division ASC, bol_fecha_registro ASC, dven_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }


    //---------- Pago de Boleta de Cobro ---------//
    public function get_pago_boleta_cobro($codigo, $cuenta = '', $banco = '', $alumno = '', $referencia = '', $periodo = '', $carga = '', $programado = '', $empresa = '', $fini = '', $ffin = '', $orderby = '', $facturado = ''){
        $pensum = $this->pensum;

        $sql= "SELECT *, ";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = pag_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nombre_completo,";
        $sql.= " (SELECT alu_nit FROM app_alumnos WHERE alu_cui = pag_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM app_alumnos WHERE alu_cui = pag_alumno ORDER BY alu_cui LIMIT 0 , 1) as alu_cliente_nombre,";
        $sql.= " (SELECT bol_motivo FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado AND pag_alumno = pag_alumno ORDER BY pag_referencia LIMIT 0 , 1) as bol_motivo,";
        $sql.= " (SELECT bol_fecha_pago FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY pag_referencia LIMIT 0 , 1) as bol_fecha_pago,";
        $sql.= " (SELECT bol_monto FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY pag_referencia LIMIT 0 , 1) as bol_monto,";
        $sql.= " (SELECT bol_descuento FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY pag_referencia LIMIT 0 , 1) as bol_descuento,";
        $sql.= " (SELECT bol_tipo FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY bol_tipo LIMIT 0 , 1) as bol_tipo,";
        ///-- INSCRIPCION
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM inscripcion_alumnos WHERE alu_cui_new = pag_alumno ORDER BY alu_cui_new LIMIT 0 , 1) as inscripcion_nombre_completo,";
        $sql.= " (SELECT alu_nit FROM inscripcion_alumnos WHERE alu_cui_new = pag_alumno ORDER BY alu_cui_new LIMIT 0 , 1) as inscripcion_nit,";
        $sql.= " (SELECT alu_cliente_nombre FROM inscripcion_alumnos WHERE alu_cui_new = pag_alumno ORDER BY alu_cui_new LIMIT 0 , 1) as inscripcion_cliente_nombre,";
        //--subqueryes de facturas y recibos
        $sql.= " (SELECT fac_numero FROM boletas_factura_boleta WHERE fac_pago = pag_codigo AND fac_sucursal = cueb_sucursal AND fac_situacion = 1 ORDER BY fac_numero LIMIT 0 , 1) as fac_numero,";
        $sql.= " (SELECT fac_serie FROM boletas_factura_boleta WHERE fac_pago = pag_codigo AND fac_sucursal = cueb_sucursal AND fac_situacion = 1 ORDER BY fac_serie LIMIT 0 , 1) as fac_serie,";
        $sql.= " (SELECT ser_numero FROM boletas_factura_boleta,vnt_serie WHERE fac_serie = ser_codigo AND fac_pago = pag_codigo AND fac_sucursal = cueb_sucursal AND fac_situacion = 1 ORDER BY ser_numero LIMIT 0 , 1) as fac_serie_numero,";
        $sql.= " (SELECT rec_numero FROM boletas_recibo_boleta WHERE rec_pago = pag_codigo AND rec_situacion = 1 ORDER BY rec_numero LIMIT 0 , 1) as rec_numero,";
        $sql.= " (SELECT rec_serie FROM boletas_recibo_boleta WHERE rec_pago = pag_codigo AND rec_situacion = 1 ORDER BY rec_serie LIMIT 0 , 1) as rec_serie,";
        $sql.= " (SELECT ser_numero FROM boletas_recibo_boleta,vnt_serie_recibo WHERE rec_serie = ser_codigo AND rec_pago = pag_codigo AND rec_situacion = 1 ORDER BY ser_numero LIMIT 0 , 1) as rec_serie_numero,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = pag_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = pag_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion";
        //--
        $sql.= " FROM  boletas_pago_boleta, fin_cuenta_banco, fin_banco, fin_moneda, fin_tipo_cuenta";
        $sql.= " WHERE pag_cuenta = cueb_codigo";
        $sql.= " AND pag_banco = cueb_banco";
        $sql.= " AND cueb_banco = ban_codigo";
        $sql.= " AND cueb_tipo_cuenta = tcue_codigo";
        $sql.= " AND cueb_moneda = mon_id";
        //$sql.= " AND pag_situacion != 1";
        if (strlen($codigo)>0) {
            $sql.= " AND pag_codigo = $codigo";
        }
        if (strlen($cuenta)>0) {
            $sql.= " AND pag_cuenta = $cuenta";
        }
        if (strlen($banco)>0) {
            $sql.= " AND pag_banco = $banco";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND pag_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND pag_referencia = '$referencia'";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo";
        }
        if (strlen($carga)>0) {
            $sql.= " AND pag_carga = '$carga'";
        }
        if (strlen($programado)>0) {
            $sql.= " AND pag_programado = '$programado'";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND cueb_sucursal = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND pag_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'";
        }
        if (strlen($facturado)>0) {
            $sql.= " AND pag_facturado = $facturado";
        }
        if (strlen($orderby)>0) {
            switch ($orderby) {
                case 1: $sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, pag_alumno ASC, pag_referencia ASC"; break;
                case 2: $sql.= " ORDER BY pag_fechor ASC, ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, pag_alumno ASC"; break;
                case 3: $sql.= " ORDER BY pag_alumno ASC, pag_referencia ASC, pag_fechor ASC"; break;
                case 4: $sql.= " ORDER BY bol_tipo ASC, cueb_codigo ASC, pag_alumno ASC, pag_fechor ASC, pag_referencia ASC"; break;
                default: $sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, pag_alumno ASC, bol_referencia ASC"; break;
            }
        } else {
            $sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, pag_alumno ASC, pag_referencia ASC";
        }

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }


    public function get_pago_boleta_cobro_error($codigo, $cuenta = '', $banco = '', $alumno = '', $referencia = '', $periodo = '', $carga = '', $programado = '', $empresa = '', $fini = '', $ffin = '', $facturado = ''){
        $sql= "SELECT * ";
        $sql.= " FROM  boletas_pago_boleta, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta, boletas_boleta_cobro";
        $sql.= " WHERE ban_pais = pai_id";
        $sql.= " AND pag_cuenta = cueb_codigo";
        $sql.= " AND pag_banco = cueb_banco";
        $sql.= " AND cueb_banco = ban_codigo";
        $sql.= " AND cueb_tipo_cuenta = tcue_codigo";
        $sql.= " AND cueb_moneda = mon_id";
        $sql.= " AND pag_referencia = bol_referencia";
        if (strlen($codigo)>0) {
            $sql.= " AND pag_codigo = $codigo";
        }
        if (strlen($cuenta)>0) {
            $sql.= " AND pag_cuenta = $cuenta";
        }
        if (strlen($banco)>0) {
            $sql.= " AND pag_banco = $banco";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND pag_referencia = $referencia";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo";
        }
        if (strlen($carga)>0) {
            $sql.= " AND pag_carga = '$carga'";
        }
        if (strlen($programado)>0) {
            $sql.= " AND pag_programado = '$programado'";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND cueb_sucursal = $empresa";
        }
        if (strlen($facturado)>0) {
            $sql.= " AND pag_facturado = $facturado";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND pag_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'";
        }
        $sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, pag_alumno ASC, pag_referencia ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }


    public function get_pago_aislado($codigo, $cuenta = '', $banco = '', $alumno = '', $referencia = '', $periodo = '', $carga = '', $programado = '', $empresa = '', $fini = '', $ffin = '', $facturado = ''){
        $sql= "SELECT * ";
        $sql.= " FROM  boletas_pago_boleta, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda";
        $sql.= " WHERE ban_pais = pai_id";
        $sql.= " AND pag_cuenta = cueb_codigo";
        $sql.= " AND pag_banco = cueb_banco";
        $sql.= " AND cueb_banco = ban_codigo";
        $sql.= " AND cueb_moneda = mon_id";
        if (strlen($codigo)>0) {
            $sql.= " AND pag_codigo = $codigo";
        }
        if (strlen($cuenta)>0) {
            $sql.= " AND pag_cuenta = $cuenta";
        }
        if (strlen($banco)>0) {
            $sql.= " AND pag_banco = $banco";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND pag_alumno = '$alumno'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND pag_referencia = $referencia";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND pag_periodo_fiscal = $periodo";
        }
        if (strlen($carga)>0) {
            $sql.= " AND pag_carga = '$carga'";
        }
        if (strlen($programado)>0) {
            $sql.= " AND pag_programado = '$programado'";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND cueb_sucursal = $empresa";
        }
        if (strlen($facturado)>0) {
            $sql.= " AND pag_facturado = $facturado";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND pag_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'";
        }
        $sql.= " ORDER BY ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC, pag_alumno ASC, pag_referencia ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }

    public function get_pagos_de_carga2($carga){
        $sql= "SELECT *,";
        $sql.= " (SELECT bol_motivo FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY pag_referencia LIMIT 0 , 1) as bol_motivo,";
        $sql.= " (SELECT bol_fecha_pago FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY pag_referencia LIMIT 0 , 1) as bol_fecha_pago,";
        $sql.= " (SELECT bol_monto FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado AND bol_situacion = 1 ORDER BY pag_referencia LIMIT 0 , 1) as comprueba_monto,";
        $sql.= " (SELECT bol_descuento FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado AND bol_situacion = 1 ORDER BY pag_referencia LIMIT 0 , 1) as bol_descuento,";
        $sql.= " (SELECT bol_tipo FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado ORDER BY bol_tipo LIMIT 0 , 1) as bol_tipo,";
        $sql.= " (SELECT bol_referencia FROM boletas_boleta_cobro WHERE bol_codigo = pag_programado AND bol_situacion = 1 ORDER BY bol_codigo ASC LIMIT 0 , 1) comprueba_boleta,";
        $sql.= " (SELECT alu_cui FROM app_alumnos WHERE alu_cui = pag_alumno ORDER BY alu_cui LIMIT 0 , 1) as comprueba_alumno";
        $sql.= " FROM  boletas_pago_boleta, fin_cuenta_banco, fin_moneda";
        $sql.= " WHERE pag_cuenta = cueb_codigo";
        $sql.= " AND pag_banco = cueb_banco";
        $sql.= " AND cueb_moneda = mon_id";
        $sql.= " AND pag_carga = '$carga'";
        $sql.= " ORDER BY pag_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }

    function get_pagos_de_carga($carga){

        $sql = " SELECT *, bol_codigo as bol_corretalivo";
        $sql.= " FROM vista_pago_boletas";
        $sql.= " LEFT JOIN vista_alumnos_cliente ON pag_alumno = alu_cui";
        $sql.= " LEFT JOIN vista_alumnos_inscripciones ON pag_alumno = alu_inscripciones_cui";
        $sql.= " LEFT JOIN vista_factura_boleta ON pag_codigo = fac_pago";
        $sql.= " LEFT JOIN vista_boleta_cobro ON pag_programado = bol_codigo";
        $sql.= " WHERE pag_carga = '$carga'";
        $sql.= " ORDER BY pag_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql."<br><br>";
        return $result;
    }


    public function insert_pago_boleta_cobro($periodo, $alumno, $codint, $referencia, $cuenta, $banco, $carga, $programado, $efect, $cheprop, $otrosban, $online, $fechor){
        //--
        $programado = trim($programado);
        $fechor = $this->regresa_fechaHora($fechor);
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boletas_pago_boleta (pag_periodo_fiscal, pag_alumno, pag_codigo_interno, pag_referencia, pag_cuenta, pag_banco, pag_carga, pag_programado, pag_efectivo, pag_cheques_propios, pag_otros_bancos, pag_online, pag_fechor, pag_usuario, pag_facturado)";
        $sql.= " VALUES ($periodo, '$alumno','$codint','$referencia','$cuenta','$banco','$carga','$programado','$efect','$cheprop','$otrosban',$online,'$fechor',$usu,0); ";
        //echo $sql;
        return $sql;
    }


    public function update_pago_boleta_cobro($codigo, $alumno, $codint, $referencia, $cuenta, $banco, $freg, $efect, $cheprop, $otrosban, $online){
        //--
        $programado = trim($programado);
        $freg = regresa_fechaHora($freg);
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boletas_pago_boleta SET ";
        $sql.= "pag_alumno = '$alumno',";
        $sql.= "pag_codigo_interno = '$codint',";
        $sql.= "pag_referencia = $referencia,";
        $sql.= "pag_cuenta = $cuenta,";
        $sql.= "pag_banco = $banco,";
        $sql.= "pag_efectivo = '$efect',";
        $sql.= "pag_cheques_propios = '$cheprop',";
        $sql.= "pag_otros_bancos = '$otrosban',";
        $sql.= "pag_online = '$online',";
        $sql.= "pag_fechor = '$freg',";
        $sql.= "pag_usuario = '$usu'";

        $sql.= " WHERE pag_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function update_pago_boleta_cobro_carga($codigo, $alumno, $codint, $referencia, $monto, $freg){
         $freg = regresa_fechaHora($freg);
        //--
        $sql = "UPDATE boletas_pago_boleta SET ";
        $sql.= "pag_alumno = '$alumno',";
        $sql.= "pag_codigo_interno = '$codint',";
        $sql.= "pag_referencia = '$referencia',";
        $sql.= "pag_efectivo = '$monto',";
        $sql.= "pag_fechor = '$freg'";

        $sql.= " WHERE pag_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }

    public function update_pago_boleta($codigo, $programado, $periodo, $referencia){

        $sql = "UPDATE boletas_pago_boleta SET ";
        $sql.= "pag_programado = '$programado',";
        $sql.= "pag_periodo_fiscal = '$periodo',";
        $sql.= "pag_referencia = '$referencia'";

        $sql.= " WHERE pag_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function cambia_pago_alumno($codigo, $alumno){
        //--
        $sql = "UPDATE boletas_pago_boleta SET ";
        $sql.= "pag_alumno = '$alumno'";

        $sql.= " WHERE pag_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function update_facturado_pago($codigo, $facturado){
        $sql = "UPDATE boletas_pago_boleta SET ";
        $sql.= "pag_facturado = '$facturado'";

        $sql.= " WHERE pag_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function delete_pago($codigo){
        $sql = "DELETE FROM boletas_pago_boleta ";
        $sql.= " WHERE pag_codigo = $codigo; ";
        //echo $sql;
        return $sql;
    }


    public function max_pago_boleta_cobro(){
        $sql = "SELECT max(pag_codigo) as max ";
        $sql.= " FROM boletas_pago_boleta";
        $sql.= " WHERE 1 = 1";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
    }


    /////////////////////// CARGAS ////////////////////////////////////

    public function get_carga_electronica($codigo, $cuenta = '', $banco = '', $fini = '', $ffin = ''){
        $sql= "SELECT *, ";
        $sql.= " (SELECT fac_carga FROM boletas_factura_boleta WHERE fac_carga = car_codigo AND fac_situacion = 1 ORDER BY fac_carga ASC LIMIT 0 , 1) carga_con_factura,";
        $sql.= " (SELECT rec_carga FROM boletas_recibo_boleta WHERE rec_carga = car_codigo AND rec_situacion = 1 ORDER BY rec_carga ASC LIMIT 0 , 1) carga_con_recibo";
        $sql.= " FROM  boletas_carga_electronica, fin_cuenta_banco, fin_banco, mast_paises, fin_moneda, fin_tipo_cuenta";
        $sql.= " WHERE ban_pais = pai_id";
        $sql.= " AND car_cuenta = cueb_codigo";
        $sql.= " AND car_banco = cueb_banco";
        $sql.= " AND cueb_banco = ban_codigo";
        $sql.= " AND cueb_tipo_cuenta = tcue_codigo";
        $sql.= " AND cueb_moneda = mon_id";
        if (strlen($codigo)>0) {
            $sql.= " AND car_codigo = $codigo";
        }
        if (strlen($cuenta)>0) {
            $sql.= " AND car_cuenta = $cuenta";
        }
        if (strlen($banco)>0) {
            $sql.= " AND car_banco = $banco";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND car_fecha_registro BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'";
        }
        $sql.= " ORDER BY car_fecha_registro DESC, car_codigo DESC, ban_codigo ASC, cueb_tipo_cuenta ASC, cueb_codigo ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }


    public function insert_carga_electronica($codigo, $cuenta, $banco, $desc, $archivo){
        //--
        $fechor = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boletas_carga_electronica ";
        $sql.= " VALUES ($codigo,$cuenta,$banco,'$desc','$archivo','$fechor',$usu); ";
        //echo $sql;
        return $sql;
    }


    public function comprueba_boleta_cobro($boleta){
        $sql = "SELECT bol_codigo, bol_situacion, bol_pagado, bol_monto, bol_periodo_fiscal, bol_tipo";
        $sql.= " FROM boletas_boleta_cobro";
        $sql.= " WHERE bol_codigo = $boleta";
        $result = $this->exec_query($sql);
        $respuesta = array();
        if (is_array($result)) {
            foreach ($result as $row) {
                $respuesta["valida"] = true;
                $respuesta["bol_codigo"] = $row["bol_codigo"];
                $respuesta["bol_monto"] = $row["bol_monto"];
                $respuesta["bol_periodo_fiscal"] = $row["bol_periodo_fiscal"];
                $respuesta["bol_pagado"] = $row["bol_pagado"];
                $respuesta["bol_tipo"] = $row["bol_tipo"];
                $respuesta["bol_situacion"] = $row["bol_situacion"];
            }
        } else {
            $respuesta["valida"] = false;
            $respuesta["bol_codigo"] = "";
            $respuesta["bol_monto"] = "";
            $respuesta["bol_pagado"] = "";
            $respuesta["bol_tipo"] = "";
            $respuesta["bol_situacion"] = "";
        }
        //echo $sql."<br><br>";
        return $respuesta;
    }


    public function comprueba_boleta_referencia($referencia, $cuenta, $banco, $alumno){
        $sql = "SELECT bol_codigo as boleta";
        $sql.= " FROM boletas_boleta_cobro";
        $sql.= " WHERE bol_referencia = '$referencia' ";
        $sql.= " AND bol_division = $cuenta ";
        $sql.= " AND bol_grupo = $banco ";
        $sql.= " AND bol_alumno = '$alumno'";
        $sql.= " AND bol_situacion = 1";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $boleta = $row["boleta"];
            }
        } else {
            $boleta = 0;
        }
        //echo $sql."<br><br>";
        return $boleta;
    }


    public function comprueba_boleta_monto($referencia, $cuenta, $banco, $periodo){
        $sql = "SELECT bol_monto as monto";
        $sql.= " FROM boletas_boleta_cobro";
        $sql.= " WHERE bol_referencia = '$referencia' ";
        $sql.= " AND bol_division = $cuenta ";
        $sql.= " AND bol_grupo = $banco ";
        $sql.= " AND bol_periodo_fiscal = $periodo";
        $sql.= " AND bol_situacion = 1";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $monto = $row["monto"];
            }
        } else {
            $monto = 0;
        }
        //echo $sql;
        return $monto;
    }


    public function comprueba_alumno($cui){
        $sql = "SELECT alu_cui as valida";
        $sql.= " FROM app_alumnos";
        $sql.= " WHERE alu_cui = '$cui'";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $valida = $row["valida"];
            }
        } else {
            $valida = null;
        }
        //echo $sql;
        return $valida;
    }

    public function comprueba_codigo_interno($codigo){
        $sql = "SELECT alu_codigo_interno as valida";
        $sql.= " FROM app_alumnos";
        $sql.= " WHERE REPLACE(alu_codigo_interno,'-','') = '$codigo'";
        $sql.= " OR alu_codigo_interno = '$codigo'";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $valida = $row["valida"];
            }
        } else {
            $valida = null;
        }
        //echo $sql;
        return $valida;
    }


    public function comprueba_pagado_boleta_cobro($programado){
        $sql = "SELECT pag_codigo as pagado";
        $sql.= " FROM boletas_pago_boleta";
        $sql.= " WHERE pag_programado = '$programado'";
        $result = $this->exec_query($sql);
        if (is_array($result)) {
            foreach ($result as $row) {
                $valida = $row["pagado"];
            }
        } else {
            $valida = '';
        }
        //echo $sql;
        return $valida;
    }


    public function delete_carga_electronica($carga){
        $sql = "DELETE FROM boletas_pago_boleta";
        $sql.= " WHERE pag_carga = '$carga'; ";
        $sql.= "DELETE FROM boletas_carga_electronica";
        $sql.= " WHERE car_codigo = '$carga';";
        //echo $sql;
        return $sql;
    }


    public function delete_movimiento_banco_carga_electronica($cuenta, $banco, $referencia){
        $sql = "DELETE FROM fin_mov_cuenta_banco";
        $sql.= " WHERE mcb_cuenta = '$cuenta' ";
        $sql.= " AND mcb_banco = '$banco' ";
        $sql.= " AND mcb_movimiento = 'I' ";
        $sql.= " AND mcb_tipo = 'DP' ";
        $sql.= " AND mcb_doc = '$referencia'; ";
        //echo $sql;
        return $sql;
    }


    public function max_carga_electronica(){
        $sql = "SELECT max(car_codigo) as max ";
        $sql.= " FROM boletas_carga_electronica";
        $sql.= " WHERE 1 = 1 ";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $max = $row["max"];
        }
        //echo $sql;
        return $max;
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
        $sql.= " FROM boletas_factura_boleta,vnt_serie,fin_cliente,mast_sucursal,fin_moneda";
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
            $sql.= " AND fac_referencia = '$referencia'";
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
        //echo $sql;
        return $result;
    }

    public function count_factura($num, $ser, $carga = '', $referencia = '', $cli = '', $alumno = '', $suc = '', $fecha = '', $sit = '', $fini = '', $ffin = ''){
        $sql= "SELECT COUNT(*) as total";
        $sql.= " FROM boletas_factura_boleta,vnt_serie,vnt_venta,fin_cliente,mast_sucursal,fin_moneda";
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
            $sql.= " AND fac_referencia = '$referencia'";
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

    public function insert_factura($num, $ser, $suc, $alumno, $cli, $carga, $codpago, $referencia, $desc, $monto, $moneda, $tcambio, $fecha){
        $desc = trim($desc);
        $fecha = $this->regresa_fecha($fecha);
        $fsis = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boletas_factura_boleta ";
        $sql.= "VALUES ($num,$ser,$suc,'$alumno',$cli,$carga,'$codpago','$referencia','$desc',$monto,$moneda,$tcambio,'$fecha','$fsis',$usu,1);";
        //echo $sql;
        return $sql;
    }


    public function update_factura($num, $ser, $suc, $alumno, $cli, $referencia, $desc, $monto, $moneda, $tcambio, $fecha){
        $desc = trim($desc);
        $fecha = $this->regresa_fecha($fecha);
        $fsis = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boletas_factura_boleta SET ";
        $sql.= "fac_sucursal = $suc,";
        $sql.= "fac_alumno = '$alumno',";
        $sql.= "fac_cliente = $cli,";
        $sql.= "fac_referencia = '$referencia',";
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

    public function cambia_sit_factura($num, $ser, $sit){
        $sql = "UPDATE boletas_factura_boleta SET ";
        $sql.= "fac_situacion = $sit";

        $sql.= " WHERE fac_numero = $num";
        $sql.= " AND fac_serie = $ser;";

        return $sql;
    }

    ////////////////////// Recibo de Boletas //////////////////////////////////

    public function get_recibo($num, $ser, $carga = '', $referencia = '', $cli = '', $alumno = '', $suc = '', $fecha = '', $sit = '', $fini = '', $ffin = ''){
        $pensum = $this->pensum;

        $sql= "SELECT *, ";
        $sql.= " (SELECT CONCAT(alu_nombre,' ',alu_apellido) FROM app_alumnos WHERE alu_cui = rec_alumno) as alu_nombre_completo,";
        //-- subquery grado
        $sql.= " (SELECT TRIM(gra_descripcion) FROM academ_grado, academ_grado_alumno";
        $sql.= " WHERE gra_pensum = $pensum";
        $sql.= " AND graa_pensum = gra_pensum";
        $sql.= " AND graa_nivel = gra_nivel";
        $sql.= " AND graa_grado = gra_codigo";
        $sql.= " AND graa_alumno = rec_alumno ORDER BY graa_grado DESC LIMIT 0 , 1) AS alu_grado_descripcion,";
        //-- subquery seccion
        $sql.= " (SELECT TRIM(sec_descripcion) FROM academ_secciones,academ_seccion_alumno";
        $sql.= " WHERE seca_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = rec_alumno ORDER BY seca_seccion LIMIT 0 , 1) AS alu_seccion_descripcion";
        //--
        $sql.= " FROM boletas_recibo_boleta,vnt_serie_recibo,fin_cliente,mast_sucursal,fin_moneda";
        $sql.= " WHERE rec_serie = ser_codigo";
        $sql.= " AND cli_id = rec_cliente";
        $sql.= " AND rec_sucursal = suc_id";
        $sql.= " AND mon_id = rec_moneda";
        if (strlen($num)>0) {
            $sql.= " AND rec_numero = $num";
        }
        if (strlen($ser)>0) {
            $sql.= " AND rec_serie = $ser";
        }
        if (strlen($carga)>0) {
            $sql.= " AND rec_carga = '$carga'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND rec_referencia = '$referencia'";
        }
        if (strlen($cli)>0) {
            $sql.= " AND ven_cliente = $cli";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND rec_alumno = '$alumno'";
        }
        if (strlen($suc)>0) {
            $sql.= " AND rec_sucursal = $suc";
        }
        if (strlen($fecha)>0) {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND rec_fecha BETWEEN '$fecha' AND '$fecha'";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND rec_fecha BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND rec_situacion = $sit";
        }
        $sql.= " ORDER BY rec_sucursal ASC, rec_carga ASC, rec_serie ASC, rec_numero ASC, rec_fecha ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }

    public function count_recibo($num, $ser, $carga = '', $referencia = '', $cli = '', $alumno = '', $suc = '', $fecha = '', $sit = '', $fini = '', $ffin = ''){
        $sql= "SELECT COUNT(*) as total";
        $sql.= " FROM boletas_recibo_boleta,vnt_serie_recibo,vnt_venta,fin_cliente,mast_sucursal,fin_moneda";
        $sql.= " WHERE rec_serie = ser_codigo";
        $sql.= " AND cli_id = rec_cliente";
        $sql.= " AND rec_sucursal = suc_id";
        $sql.= " AND mon_id = rec_moneda";
        if (strlen($num)>0) {
            $sql.= " AND rec_numero = $num";
        }
        if (strlen($ser)>0) {
            $sql.= " AND rec_serie = $ser";
        }
        if (strlen($carga)>0) {
            $sql.= " AND rec_carga = '$carga'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND rec_referencia = '$referencia'";
        }
        if (strlen($cli)>0) {
            $sql.= " AND ven_cliente = $cli";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND rec_alumno = '$alumno'";
        }
        if (strlen($suc)>0) {
            $sql.= " AND rec_sucursal = $suc";
        }
        if (strlen($fecha)>0) {
            $fecha = $this->regresa_fecha($fecha);
            $sql.= " AND rec_fecha BETWEEN '$fecha' AND '$fecha'";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND rec_fecha BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND rec_situacion = $sit";
        }
        //echo $sql;
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $total = $row['total'];
        }
        return $total;
    }

    public function insert_recibo($num, $ser, $suc, $alumno, $cli, $carga, $codpago, $referencia, $desc, $monto, $moneda, $tcambio, $fecha){
        $desc = trim($desc);
        $fecha = $this->regresa_fecha($fecha);
        $fsis = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "INSERT INTO boletas_recibo_boleta ";
        $sql.= "VALUES ($num,$ser,$suc,'$alumno',$cli,$carga,'$codpago','$referencia','$desc',$monto,$moneda,$tcambio,'$fecha','$fsis',$usu,1);";
        //echo $sql;
        return $sql;
    }


    public function update_recibo($num, $ser, $suc, $alumno, $cli, $referencia, $desc, $monto, $moneda, $tcambio, $fecha){
        $desc = trim($desc);
        $fecha = $this->regresa_fecha($fecha);
        $fsis = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
        //--
        $sql = "UPDATE boletas_recibo_boleta SET ";
        $sql.= "rec_sucursal = $suc,";
        $sql.= "rec_alumno = '$alumno',";
        $sql.= "rec_cliente = $cli,";
        $sql.= "rec_referencia = '$referencia',";
        $sql.= "rec_descripcion = '$desc',";
        $sql.= "rec_monto = $monto,";
        $sql.= "rec_moneda = $moneda,";
        $sql.= "rec_tcambio = $tcambio,";
        $sql.= "rec_fecha = '$fecha',";
        $sql.= "rec_fecha_registro = '$fsis',";
        $sql.= "rec_usuario = '$usu'";

        $sql.= " WHERE rec_numero = $num";
        $sql.= " AND rec_serie = $ser; ";
        //echo $sql;
        return $sql;
    }

    public function cambia_sit_recibo($num, $ser, $sit){
        $sql = "UPDATE boletas_recibo_boleta SET ";
        $sql.= "rec_situacion = $sit";

        $sql.= " WHERE rec_numero = $num";
        $sql.= " AND rec_serie = $ser;";

        return $sql;
    }


    //---------- Moras sobre Boleta de Cobro ---------//
    public function get_morosos($fini, $ffin, $pensum, $division = '', $grupo = '', $periodo = '', $periodo_activo = '', $nivel = '', $grado = '', $seccion = ''){
        $tipo = trim($tipo);
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $bol_fechas = " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
            $pag_fechas = " AND pag_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00'";
        }else{
            if($periodo == $periodo_activo){
                $anio = date("Y");
                $hoy = date("Y-m-d");
                $bol_fechas = " AND bol_fecha_pago BETWEEN '2000-01-00' AND '$hoy'";
                $pag_fechas = " AND pag_fechor BETWEEN '2000-01-00 00:00:00' AND '$hoy 23:59:00'";
            }else{
                $bol_fechas = "";
                $pag_fechas = "";
            }
        }

        if (strlen($division)>0) {
            $bol_division = " AND bol_division = $division";
            $pag_cuenta = " AND pag_cuenta = $division";
        }
        if (strlen($grupo)>0) {
            $bol_grupo = " AND bol_grupo = $grupo";
            $pag_banco = " AND pag_banco = $grupo";
        }
        if (strlen($periodo)>0) {
            $bol_periodo = " AND bol_periodo_fiscal = '$periodo'";
            $pag_periodo = " AND pag_periodo_fiscal = '$periodo'";
        }

        $sql= "SELECT *,";
        $sql.= " (SELECT SUM(bol_monto) FROM vista_boleta_cobro WHERE bol_alumno = alu_cui $bol_fechas $bol_division $bol_grupo $bol_periodo AND bol_situacion = 1) as pagos_programados,";
        $sql.= " (SELECT SUM(pag_total) FROM vista_pago_boletas,boletas_boleta_cobro WHERE pag_programado = bol_codigo AND pag_alumno = alu_cui $bol_division $bol_grupo $pag_periodo $pag_fechas) as pagos_ejecutados";
        $sql.= " FROM academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos";
        $sql.= " WHERE sec_pensum = gra_pensum";
        $sql.= " AND sec_nivel = gra_nivel";
        $sql.= " AND sec_grado = gra_codigo";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND seca_alumno = alu_cui";
        $sql.= " AND alu_situacion != 0";
        if (strlen($pensum)>0) {
            $sql.= " AND seca_pensum = $pensum";
        }
        if (strlen($nivel)>0) {
            $sql.= " AND seca_nivel = $nivel";
        }
        if (strlen($grado)>0) {
            $sql.= " AND seca_grado = $grado";
        }
        if (strlen($seccion)>0) {
            $sql.= " AND seca_seccion = $seccion";
        }

        $sql.= " ORDER BY seca_nivel ASC, seca_grado ASC, sec_codigo ASC, alu_apellido ASC, alu_nombre ASC";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }


    public function calcula_mora($periodo, $fini, $ffin){
        $fini = $this->regresa_fecha($fini);
        $ffin = $this->regresa_fecha($ffin);

        $sql = " SELECT alu_cui, alu_codigo_interno,";
        $sql.= " (SELECT SUM(bol_monto) FROM boletas_boleta_cobro WHERE bol_alumno = alu_cui AND bol_periodo_fiscal = $periodo AND bol_fecha_pago BETWEEN '$fini' AND '$ffin' AND bol_situacion = 1) as pagos_programados,";
        $sql.= " (SELECT SUM(pag_efectivo)+SUM(pag_cheques_propios)+SUM(pag_otros_bancos)+SUM(pag_online) FROM boletas_pago_boleta WHERE pag_alumno = alu_cui AND pag_fechor BETWEEN '$fini 00:00:00' AND '$ffin 23:59:00') as pagos_ejecutados";
        $sql.= " FROM app_alumnos";
        $sql.= " WHERE alu_situacion = 1";

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }

    public function get_mora($codigo,$division='',$grupo='',$alumno='',$nivel='',$grado='',$seccion='',$referencia='',$periodo='',$empresa='',$fini='',$ffin='',$sit='',$orderby='',$pagado='',$bloque = ''){
        $pensum = $this->pensum;

        $sql = "SELECT * ";
        $sql.= " FROM  boletas_boleta_cobro, boleta_mora, boletas_division, boletas_division_grupo, fin_moneda, app_alumnos, academ_seccion_alumno, academ_grado, academ_secciones";
        $sql.= " WHERE bol_codigo = mor_codigo";
        $sql.= " AND bol_division = mor_division";
        $sql.= " AND bol_grupo = mor_grupo_division";
        //--
        $sql.= " AND bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        $sql.= " AND bol_alumno = alu_cui";
        //--
        $sql.= " AND seca_alumno = bol_alumno";
        $sql.= " AND sec_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND sec_pensum = gra_pensum";
        $sql.= " AND sec_nivel = gra_nivel";
        $sql.= " AND sec_grado = gra_codigo";
        $sql.= " AND bol_tipo = 'M'";
        //--
        if (strlen($codigo)>0) {
            $sql.= " AND bol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno IN($alumno)";
        }
        if (strlen($nivel)>0) {
            $sql.= " AND seca_nivel = '$nivel'";
        }
        if (strlen($grado)>0) {
            $sql.= " AND seca_grado = '$grado'";
        }
        if (strlen($seccion)>0) {
            $sql.= " AND seca_seccion = '$seccion'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND bol_referencia = $referencia";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion = $sit";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($bloque)>0) {
            $sql.= " AND mor_bloque = $bloque";
        }
        if (strlen($orderby)>0) {
            switch ($orderby) {
              case 1: $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_referencia ASC, bol_alumno ASC"; break;
              case 2: $sql.= " ORDER BY bol_fecha_pago ASC, gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC"; break;
              default: $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC"; break;
          }
        } else {
            $sql.= " ORDER BY gru_codigo ASC, div_codigo ASC, bol_alumno ASC, bol_referencia ASC";
        }

        $result = $this->exec_query($sql);
        //echo $sql;
        return $result;
    }

    public function count_mora($codigo,$division='',$grupo='',$alumno='',$nivel='',$grado='',$seccion='',$referencia='',$periodo='',$empresa='',$fini='',$ffin='',$sit='',$orderby='',$pagado='',$bloque = ''){
        $pensum = $this->pensum;

        $sql= "SELECT COUNT(*) as total";
        $sql.= " FROM  boletas_boleta_cobro, boleta_mora, boletas_division, boletas_division_grupo, fin_moneda, app_alumnos, academ_seccion_alumno, academ_grado, academ_secciones";
        $sql.= " WHERE bol_codigo = mor_codigo";
        $sql.= " AND bol_division = mor_division";
        $sql.= " AND bol_grupo = mor_grupo_division";
        //--
        $sql.= " AND bol_division = div_codigo";
        $sql.= " AND bol_grupo = div_grupo";
        $sql.= " AND div_grupo = gru_codigo";
        $sql.= " AND div_moneda = mon_id";
        $sql.= " AND bol_alumno = alu_cui";
        //--
        $sql.= " AND seca_alumno = bol_alumno";
        $sql.= " AND sec_pensum = $pensum";
        $sql.= " AND seca_pensum = sec_pensum";
        $sql.= " AND seca_nivel = sec_nivel";
        $sql.= " AND seca_grado = sec_grado";
        $sql.= " AND seca_seccion = sec_codigo";
        $sql.= " AND sec_pensum = gra_pensum";
        $sql.= " AND sec_nivel = gra_nivel";
        $sql.= " AND sec_grado = gra_codigo";
        $sql.= " AND bol_tipo = 'M'";
        //--
        if (strlen($codigo)>0) {
            $sql.= " AND bol_codigo = $codigo";
        }
        if (strlen($division)>0) {
            $sql.= " AND bol_division = $division";
        }
        if (strlen($grupo)>0) {
            $sql.= " AND bol_grupo = $grupo";
        }
        if (strlen($alumno)>0) {
            $sql.= " AND bol_alumno IN($alumno)";
        }
        if (strlen($nivel)>0) {
            $sql.= " AND seca_nivel = '$nivel'";
        }
        if (strlen($grado)>0) {
            $sql.= " AND seca_grado = '$grado'";
        }
        if (strlen($seccion)>0) {
            $sql.= " AND seca_seccion = '$seccion'";
        }
        if (strlen($referencia)>0) {
            $sql.= " AND bol_referencia = $referencia";
        }
        if (strlen($periodo)>0) {
            $sql.= " AND bol_periodo_fiscal = $periodo";
        }
        if (strlen($empresa)>0) {
            $sql.= " AND div_empresa = $empresa";
        }
        if ($fini != "" && $ffin != "") {
            $fini = $this->regresa_fecha($fini);
            $ffin = $this->regresa_fecha($ffin);
            $sql.= " AND bol_fecha_pago BETWEEN '$fini' AND '$ffin'";
        }
        if (strlen($sit)>0) {
            $sql.= " AND bol_situacion = $sit";
        }
        if (strlen($pagado)>0) {
            $sql.= " AND bol_pagado = $pagado";
        }
        if (strlen($bloque)>0) {
            $sql.= " AND mor_bloque = $bloque";
        }
        //echo $sql."<br><br>";
        $result = $this->exec_query($sql);
        foreach ($result as $row) {
            $total = $row['total'];
        }
        return $total;
    }
}
