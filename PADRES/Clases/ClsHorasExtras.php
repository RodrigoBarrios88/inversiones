<?php
require_once ("ClsConex.php");

class ClsHorasExtras extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  ASIGNACION SALARIAL //////////////////////////////////////
  
      function get_horas($plaza) {
		$desc = trim($desc);
		
	      $sql= "SELECT * ";
		$sql.= " FROM sal_horas";
		$sql.= " WHERE 1 = 1";
		if(strlen($plaza)>0) { 
		    $sql.= " AND hor_plaza = $plaza"; 
		}
		$sql.= " ORDER BY hor_plaza ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_horas($plaza,$desc = '') {
		$desc = trim($desc);
		
	      $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM sal_horas";
		$sql.= " WHERE 1 = 1";
		if(strlen($plaza)>0) { 
		    $sql.= " AND hor_plaza = $plaza"; 
		}
		if(strlen($desc)>0) { 
		    $sql.= " AND hor_descripcion like '%$desc%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_horas($plaza,$horas){
		$desc = trim($desc);
		$fechor = date("Y-m-d H:m:s");
		$usu = $_SESSION["codigo"];
		
		$sql = "INSERT INTO sal_horas";
		$sql.= " VALUES ($plaza,'$horas','$fechor','$usu');";
		//echo $sql;
		return $sql;
	}
	
	function modifica_horas($plaza,$horas){
		$horas = strtolower($horas);
		$fechor = date("Y-m-d H:m:s");
		$usu = $_SESSION["codigo"];
		
		$sql = "UPDATE sal_horas SET ";
		$sql.= "hor_horas = '$horas',";
		$sql.= "hor_fechor_registro = '$fechor',";
		$sql.= "hor_usuario = '$usu'";
		
		$sql.= " WHERE hor_plaza = $plaza"; 	
		//echo $sql;
		return $sql;
	}

}	
?>
