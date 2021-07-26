<?php
require_once ("ClsConex.php");

class ClsDivision extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
    
    /////////////////////// GRUPO //////////////////////////////////////////
    function get_grupo($codigo,$nombre = '',$situacion = '',$habiles = '') {
		$nombre = trim($nombre);
		
        $sql= "SELECT * ";
		$sql.= " FROM boletas_division_grupo";
		$sql.= " WHERE 1 = 1";
        if(strlen($codigo)>0) { 
			$sql.= " AND gru_codigo = $codigo"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND gru_nombre like '%$nombre%'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND gru_situacion = $situacion"; 
		}
        if(strlen($habiles)>0) { 
			$sql.= " AND gru_codigo != 0"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, gru_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_grupo($codigo,$nombre = '',$situacion = '',$habiles = '') {
        $nombre = trim($nombre);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM boletas_division_grupo";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND gru_codigo = $codigo"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND gru_nombre like '%$nombre%'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND gru_situacion = $situacion"; 
		}
        if(strlen($habiles)>0) { 
			$sql.= " AND gru_codigo != 0"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_grupo($codigo,$nombre){
		$nombre = trim($nombre);
		
		$sql = "INSERT INTO boletas_division_grupo";
		$sql.= " VALUES ($codigo,'$nombre',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_grupo($codigo,$nombre){
		$nombre = trim($nombre);
		
		$sql = "UPDATE boletas_division_grupo SET ";
		$sql.= "gru_nombre = '$nombre'"; 
		
		$sql.= " WHERE gru_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_situacion_grupo($codigo,$situacion){
		
		$sql = "UPDATE boletas_division_grupo SET ";
		$sql.= "gru_situacion = $situacion"; 
				
		$sql.= " WHERE gru_codigo = $codigo"; 	
		
		return $sql;
	}
	
	
	function max_grupo() {
		
        $sql = "SELECT max(gru_codigo) as max ";
		$sql.= " FROM boletas_division_grupo";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$max = $row["max"];
			}
		}
		//echo $sql;
		return $max;
	}
    
    /////////////////////// DIVISION GRUPO //////////////////////////////////////////
    function get_division($codigo,$grupo,$nombre = '',$situacion = '',$habiles = '') {
		$nombre = trim($nombre);
		
        $sql= "SELECT * ";
		$sql.= " FROM boletas_division, boletas_division_grupo, fin_moneda, mast_sucursal";
		$sql.= " WHERE div_grupo = gru_codigo";
        $sql.= " AND div_empresa = suc_id";
		$sql.= " AND div_moneda = mon_id";
        if(strlen($codigo)>0) { 
			$sql.= " AND div_codigo = $codigo"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND div_grupo = $grupo"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND div_nombre like '%$nombre%'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND div_situacion = $situacion"; 
		}
        if(strlen($habiles)>0) { 
			$sql.= " AND div_situacion != 0"; 
		}
		$sql.= " ORDER BY div_codigo ASC, div_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	function count_division($codigo,$grupo,$nombre = '',$situacion = '',$habiles = '') {
        $nombre = trim($nombre);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM boletas_division, boletas_division_grupo, fin_moneda, mast_sucursal";
		$sql.= " WHERE div_grupo = gru_codigo";
        $sql.= " AND div_empresa = suc_id";
		$sql.= " AND div_moneda = mon_id";
		if(strlen($codigo)>0) { 
			$sql.= " AND div_codigo = $codigo"; 
		}
        if(strlen($grupo)>0) { 
			$sql.= " AND div_grupo = $grupo"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND div_nombre like '%$nombre%'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND div_situacion = $situacion"; 
		}
        if(strlen($habiles)>0) { 
			$sql.= " AND div_situacion != 0"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
    
    function comprueba_situacion_divisiones($grupo) {
		
		$sql = "SELECT COUNT(div_codigo) as total";
		$sql.= " FROM boletas_division";
		$sql.= " WHERE div_grupo = $grupo"; 	
		$sql.= " AND div_situacion = 1; "; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cant = $row["total"];
				if($cant > 0){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
    
		
	function insert_division($codigo,$grupo,$nombre,$empresa,$moneda){
		$nombre = trim($nombre);
		
		$sql = "INSERT INTO boletas_division";
		$sql.= " VALUES ($codigo,$grupo,'$nombre',$empresa,$moneda,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_division($codigo,$grupo,$nombre,$empresa,$moneda){
		$nombre = trim($nombre);
		
		$sql = "UPDATE boletas_division SET ";
		$sql.= "div_nombre = '$nombre',"; 
		$sql.= "div_empresa = '$empresa',"; 
		$sql.= "div_moneda = '$moneda'"; 
		
		$sql.= " WHERE div_codigo = $codigo "; 	
		$sql.= " AND div_grupo = $grupo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_situacion_division($codigo,$grupo,$situacion){
		
		$sql = "UPDATE boletas_division SET ";
		$sql.= "div_situacion = $situacion"; 
				
		$sql.= " WHERE div_codigo = $codigo "; 	
		$sql.= " AND div_grupo = $grupo; ";
		
		return $sql;
	}
	
	
	function max_division($grupo) {
		
        $sql = "SELECT max(div_codigo) as max ";
		$sql.= " FROM boletas_division";
        $sql.= " WHERE div_grupo = $grupo;"; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$max = $row["max"];
			}
		}
		//echo $sql;
		return $max;
	}		

}	
?>