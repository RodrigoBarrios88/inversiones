<?php
require_once ("ClsConex.php");

class ClsPresupuesto extends ClsConex{
   
    ///////////////// REGLON ///////////////////
	
	function get_reglon($reglon,$partida,$tipo,$clase,$empresa,$anio,$mes){
		$tipo = trim($tipo);
		$clase = trim($clase);
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT pre_alto FROM fin_presupuesto WHERE pre_partida = reg_partida AND pre_reglon = reg_codigo AND pre_sucursal = $empresa AND pre_anio = $anio AND pre_mes = $mes) as presupuesto_alto,";
		$sql.= " (SELECT pre_bajo FROM fin_presupuesto WHERE pre_partida = reg_partida AND pre_reglon = reg_codigo AND pre_sucursal = $empresa AND pre_anio = $anio AND pre_mes = $mes) as presupuesto_bajo,";
		$sql.= " (SELECT pre_situacion FROM fin_presupuesto WHERE pre_partida = reg_partida AND pre_reglon = reg_codigo AND pre_sucursal = $empresa AND pre_anio = $anio AND pre_mes = $mes) as presupuesto_situacion";
		$sql.= " FROM fin_reglon,fin_partida";
		$sql.= " WHERE reg_partida = par_codigo";
		if(strlen($reglon)>0) { 
			  $sql.= " AND reg_codigo = $reglon"; 
		}
		if(strlen($partida)>0) { 
			  $sql.= " AND reg_partida = $partida"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND par_clase = '$clase'"; 
		}
		$sql.= " ORDER BY par_tipo ASC, par_clase ASC, reg_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	 ///////////////// PRESUPUESTO ///////////////////
    
	function get_presupuesto($cod,$reglon="",$partida="",$tipo="",$clase="",$empresa="",$anio="",$mes="",$sit=""){
		$tipo = trim($tipo);
		$clase = trim($clase);
		
		$sql= "SELECT * ";
		$sql.= " FROM fin_presupuesto,fin_reglon,fin_partida";
		$sql.= " WHERE pre_partida = reg_partida";
		$sql.= " AND pre_reglon = reg_codigo";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND pre_codigo = $cod"; 
		}
		if(strlen($reglon)>0) { 
			  $sql.= " AND reg_codigo = $reglon"; 
		}
		if(strlen($partida)>0) { 
			  $sql.= " AND reg_partida = $partida"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND par_clase = '$clase'"; 
		}
		if(strlen($empresa)>0) { 
			  $sql.= " AND pre_sucursal = $empresa"; 
		}
		if(strlen($anio)>0) { 
			  $sql.= " AND pre_anio = $anio"; 
		}
		if(strlen($mes)>0) { 
			  $sql.= " AND pre_mes = $mes"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pre_situacion = $sit"; 
		}
		$sql.= " ORDER BY par_tipo ASC, par_clase ASC, reg_codigo ASC, pre_anio ASC, pre_mes ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_presupuesto($cod,$reglon="",$partida="",$tipo="",$clase="",$empresa="",$anio="",$mes="",$sit=""){
		$tipo = trim($tipo);
		$clase = trim($clase);
		
		$sql= "SELECT COUNT(*) as total ";
		$sql.= " FROM fin_presupuesto,fin_reglon,fin_partida";
		$sql.= " WHERE pre_partida = reg_partida";
		$sql.= " AND pre_reglon = reg_codigo";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND pre_codigo = $cod"; 
		}
		if(strlen($reglon)>0) { 
			  $sql.= " AND reg_codigo = $reglon"; 
		}
		if(strlen($partida)>0) { 
			  $sql.= " AND reg_partida = $partida"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND par_clase = '$clase'"; 
		}
		if(strlen($empresa)>0) { 
			  $sql.= " AND pre_sucursal = $empresa"; 
		}
		if(strlen($anio)>0) { 
			  $sql.= " AND pre_anio = $anio"; 
		}
		if(strlen($mes)>0) { 
			  $sql.= " AND pre_mes = $mes"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pre_situacion = $sit"; 
		}
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
		    foreach($result as $row){
			$total = $row["total"];
		    }
		}   
		//echo $sql;
		return $total;

	}
		
		
	function insert_presupuesto($cod,$reglon,$partida,$empresa,$anio,$mes,$alto,$bajo){
		
		$sql = "INSERT INTO fin_presupuesto ";
		$sql.= " VALUES ($cod,$reglon,$partida,$empresa,$anio,$mes,$alto,$bajo,1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_presupuesto_alto($cod,$alto){
		
		$sql = "UPDATE fin_presupuesto SET ";
		$sql.= "pre_alto = '$alto'"; 
		
		$sql.= " WHERE pre_codigo = $cod;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_presupuesto_bajo($cod,$bajo){
		
		$sql = "UPDATE fin_presupuesto SET ";
		$sql.= "pre_bajo = '$bajo'"; 
		
		$sql.= " WHERE pre_codigo = $cod;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_presupuesto($anio,$mes,$sit){
		
		$sql = "UPDATE fin_presupuesto SET ";
		$sql.= "pre_situacion = $sit"; 
				
		$sql.= " WHERE pre_anio = $anio "; 	
		$sql.= " AND pre_mes = $mes; "; 	
		
		return $sql;
	}
	
	function delete_presupuesto($cod) {
		
		$sql = "DELETE FROM fin_presupuesto";
		$sql.= " WHERE pre_codigo = $cod;"; 	
		//echo $sql;
		
		return $sql;
	}
	
	
	function max_presupuesto() {
		
		$sql = "SELECT max(pre_codigo) as max ";
		$sql.= " FROM fin_presupuesto";
		$sql.= " WHERE 1 = 1; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
}	
?>
