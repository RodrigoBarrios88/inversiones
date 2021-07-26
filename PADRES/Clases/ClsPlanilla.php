<?php
require_once ("ClsConex.php");

class ClsPlanilla extends ClsConex{
	
/* TIPO DE NOMINA */
//////////////////////////////////////////////////////////////////
   
    function get_tipo_nomina($codigo,$desc = '',$sit = ''){
		$desc = trim($desc);
		$obs = trim($obs);
		
        $sql= "SELECT * ";
		$sql.= " FROM sal_tipo_nomina";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND tip_codigo = $codigo"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tip_descripcion like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND tip_situacion = $sit"; 
		}
		$sql.= " ORDER BY tip_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_tipo_nomina($codigo,$desc = '',$sit = ''){
		$desc = trim($desc);
		$obs = trim($obs);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM sal_tipo_nomina";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND tip_codigo = $codigo"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND tip_descripcion like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND tip_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_tipo_nomina($codigo,$desc,$obs){
		$desc = trim($desc);
		$obs = trim($obs);
		
		$sql = "INSERT INTO sal_tipo_nomina VALUES ($codigo,'$desc','$obs',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_tipo_nomina($codigo,$desc,$obs){
		$desc = trim($desc);
		$obs = trim($obs);
		
		$sql = "UPDATE sal_tipo_nomina SET "; 
		$sql.= " tip_descripcion = '$desc',";
		$sql.= " tip_observaciones = '$obs' ";
		
		$sql.= " WHERE tip_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_tipo_nomina($codigo,$sit){
		
		$sql = "UPDATE sal_tipo_nomina SET tip_situacion = $sit"; 
		$sql.= " WHERE tip_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function max_tipo_nomina() {
		
        $sql = "SELECT max(tip_codigo) as max ";
		$sql.= " FROM sal_tipo_nomina";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/* NOMINA */
//////////////////////////////////////////////////////////////////

	function get_nomina($codigo,$tipo,$clase,$periodo = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM sal_tipo_nomina, sal_nomina";
		$sql.= " WHERE tip_codigo = nom_tipo";
		if(strlen($codigo)>0) { 
			  $sql.= " AND nom_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND nom_tipo = $tipo"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND nom_clase = '$clase'"; 
		}
		if(strlen($periodo)>0) { 
			  $sql.= " AND nom_tipo_periodo = '$periodo'"; 
		}
		
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			  $fini = $this->regresa_fecha($fini);
			  $ffin = $this->regresa_fecha($ffin);
			  $sql.= " AND nom_desde BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND nom_situacion = $sit"; 
		}
		$sql.= " ORDER BY nom_desde ASC, nom_hasta ASC, nom_clase ASC, nom_tipo ASC, nom_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_nomina($codigo,$tipo,$clase,$periodo = '',$fini = '',$ffin = '',$sit = ''){
		$desc = trim($desc);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM sal_tipo_nomina, sal_nomina";
		$sql.= " WHERE tip_codigo = nom_tipo";
		if(strlen($codigo)>0) { 
			  $sql.= " AND nom_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND nom_tipo = $tipo"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND nom_clase = '$clase'"; 
		}
		if(strlen($periodo)>0) { 
			  $sql.= " AND nom_tipo_periodo = '$periodo'"; 
		}
		
		if((strlen($fini)>0) && (strlen($ffin)>0)) {
			  $fini = $this->regresa_fecha($fini);
			  $ffin = $this->regresa_fecha($ffin);
			  $sql.= " AND nom_desde BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND nom_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_nomina($codigo,$tipo,$clase,$titulo,$desde,$hasta,$periodo,$obs){
		$titulo = trim($titulo);
		$obs = trim($obs);
		$desde = $this->regresa_fecha($desde);
		$hasta = $this->regresa_fecha($hasta);
		$usu = $_SESSION['codigo'];
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO sal_nomina VALUES ($codigo,'$tipo','$clase','$titulo','$desde','$hasta','$periodo','$obs','$freg','$freg','$usu',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_nomina($codigo,$tipo,$clase,$titulo,$desde,$hasta,$periodo,$obs){
		$titulo = trim($titulo);
		$desde = $this->regresa_fecha($desde);
		$hasta = $this->regresa_fecha($hasta);
		
		$sql = "UPDATE sal_nomina SET "; 
		$sql.= " nom_titulo = '$titulo',";
		$sql.= " nom_tipo = '$tipo',";
		$sql.= " nom_clase = '$clase',";
		$sql.= " nom_desde = '$desde',";
		$sql.= " nom_hasta = '$hasta',";
		$sql.= " nom_tipo_periodo = '$periodo',";
		$sql.= " nom_observaciones = '$obs'";
		
		$sql.= " WHERE nom_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_nomina($codigo,$sit){
		$usu = $_SESSION['codigo'];
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE sal_nomina SET nom_situacion = '$sit',";
		$sql.= " nom_usuario = '$usu',";
		$sql.= " nom_fecha_modificacion = '$freg'";
		
		$sql.= " WHERE nom_codigo = $codigo; "; 	
		
		return $sql;
	}
	
	
	function max_nomina() {
		
        $sql = "SELECT max(nom_codigo) as max ";
		$sql.= " FROM sal_nomina";
		$sql.= " WHERE 1 = 1 ";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
//////////////////// Personal - Tipo de Nomina //////////////////////////
	function asignacion_personal_tipo_nomina($personal,$tipo){
		///--
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO sal_personal_tipo_nomina";
		$sql.= " VALUES ('$personal','$tipo','$fecha');";
		//echo $sql;
		return $sql;
	}

	function desasignacion_personal_tipo_nomina($personal,$tipo){
	    $sql = "DELETE FROM sal_personal_tipo_nomina";
		$sql.= " WHERE  ptn_personal = '$personal'";
		$sql.= " AND ptn_tipo_nomina = '$tipo';";  	
		//echo $sql;
		return $sql;
	}
	
	function desasignacion_tipo_nomina_general($tipo){
	    $sql = "DELETE FROM sal_personal_tipo_nomina";
		$sql.= " WHERE ptn_tipo_nomina = '$tipo';";  	
		//echo $sql;
		return $sql;
	}
	
	function get_personal_tipo_nomina($personal,$tipo) {
		
	    $sql= "SELECT *, CONCAT(per_nombres,' ',per_apellidos) as nombre_completo ";
		$sql.= " FROM sal_personal_tipo_nomina,rrhh_personal,sal_tipo_nomina";
		$sql.= " WHERE ptn_personal = per_dpi";
		$sql.= " AND ptn_tipo_nomina = tip_codigo";
		if(strlen($personal)>0) { 
			  $sql.= " AND ptn_personal = '$personal'";
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ptn_tipo_nomina = '$tipo'";
		}
		$sql.= " ORDER BY per_nombres ASC, per_apellidos ASC, per_dpi ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	 
	function get_not_personal_tipo_nomina($personal) {
		
	    $sql= "SELECT *, CONCAT(per_nombres,' ',per_apellidos) as nombre_completo";
		$sql.= " FROM rrhh_personal";
		$sql.= " WHERE 1 = 1";
		if(strlen($personal)>0) { 
		    $sql.= " AND per_dpi NOT IN($personal)";
		}
		$sql.= " ORDER BY per_nombres ASC, per_apellidos ASC, per_dpi ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}


/* DETALLE DE NOMINA */
//////////////////////////////////////////////////////////////////

	function get_personal_pre_planilla($tipo,$nomina){
		$sql= "SELECT *, CONCAT(per_nombres,' ',per_apellidos) as nombre_completo, ";
		///////--- SUBCONSULTAS DE MONTOS DE PLANILLA ----////////////
		////- Horas Laboradas
		$sql.="(SELECT SUM(hor_cantidad_regulares) FROM sal_horas_laboradas WHERE hor_nomina = '$nomina' AND hor_personal = per_dpi) as cantidad_horas_laboradas,";
		$sql.="(SELECT SUM((hor_monto_regulares * hor_cambio) * hor_cantidad_regulares) FROM sal_horas_laboradas WHERE hor_nomina = '$nomina' AND hor_personal = per_dpi) as montol_horas_laboradas,";
		////- Horas Extras
		$sql.="(SELECT SUM(hor_cantidad_extras) FROM sal_horas_laboradas WHERE hor_nomina = '$nomina' AND hor_personal = per_dpi) as cantidad_horas_extras,";
		$sql.="(SELECT SUM((hor_monto_extras * hor_cambio) * hor_cantidad_extras) FROM sal_horas_laboradas WHERE hor_nomina = '$nomina' AND hor_personal = per_dpi) as montol_horas_extras,";
		////- Bonificaciones Generales
		$sql.="(SELECT SUM(bon_monto * bon_tipo_cambio) FROM sal_bonificaciones_generales WHERE bon_nomina = '$nomina' AND bon_personal = per_dpi) as bonificaciones_generales,";
		////- Bonificaciones Emergentes
		$sql.="(SELECT SUM(bon_monto * bon_tipo_cambio) FROM sal_bonificaciones_emeregentes WHERE bon_nomina = '$nomina' AND bon_personal = per_dpi) as bonificaciones_emergentes,";
		////- Comisiones
		$sql.="(SELECT SUM(com_monto * com_tipo_cambio) FROM  sal_comisiones WHERE com_nomina = '$nomina' AND com_personal = per_dpi) as comisiones,";
		////- Descuentos
		$sql.="(SELECT SUM(des_monto * des_tipo_cambio) FROM sal_descuentos WHERE des_nomina = '$nomina' AND des_personal = per_dpi) as descuentos";
		///////--- SUBCONSULTAS DE MONTOS DE PLANILLA ----////////////
		$sql.= " FROM sal_personal_tipo_nomina,rrhh_personal,sal_tipo_nomina";
		$sql.= " WHERE ptn_personal = per_dpi";
		$sql.= " AND ptn_tipo_nomina = tip_codigo";
		if(strlen($personal)>0) { 
			  $sql.= " AND ptn_personal = '$personal'";
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ptn_tipo_nomina = '$tipo'";
		}
		$sql.= " ORDER BY per_nombres ASC, per_apellidos ASC, per_dpi ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
}	
?>
