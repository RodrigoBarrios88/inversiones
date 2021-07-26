<?php
require_once ("ClsConex.php");

class ClsArea extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  AREA //////////////////////////////////////
  
      function get_area($cod,$nom = '',$periodo = '',$anio = '',$sit = '') {
		$nom = trim($nom);
		
	      $sql= "SELECT * ";
		$sql.= " FROM app_area";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
		    $sql.= " AND are_codigo = $cod"; 
		}
		if(strlen($nom)>0) { 
		    $sql.= " AND are_nombre like '%$nom%'"; 
		}
		if(strlen($periodo)>0) { 
		    $sql.= " AND are_periodo like '%$periodo%'"; 
		}
		if(strlen($anio)>0) { 
		    $sql.= " AND are_anio = $anio"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND are_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY are_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_area($cod,$nom = '',$periodo = '',$anio = '',$sit = '') {
		$nom = trim($nom);
		
	        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_area";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
		    $sql.= " AND are_codigo = $cod"; 
		}
		if(strlen($nom)>0) { 
		    $sql.= " AND are_nombre like '%$nom%'"; 
		}
		if(strlen($periodo)>0) { 
		    $sql.= " AND are_periodo like '%$periodo%'"; 
		}
		if(strlen($anio)>0) { 
		    $sql.= " AND are_anio = $anio"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND are_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_area($cod,$nom,$periodo,$anio){
		$nom = trim($nom);
		$periodo = trim($periodo);
		$anio = strtolower($anio);
		
		$sql = "INSERT INTO app_area";
		$sql.= " VALUES ($cod,'$nom','$periodo','$anio',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_area($cod,$nom,$periodo,$anio){
		$nom = trim($nom);
		$periodo = trim($periodo);
		$anio = strtolower($anio);
		
		$sql = "UPDATE app_area SET ";
		$sql.= "are_nombre = '$nom',"; 
		$sql.= "are_periodo = '$periodo',"; 		
		$sql.= "are_anio = '$anio'";
		
		$sql.= " WHERE are_codigo = $cod"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_area($cod,$sit){
		
		$sql = "UPDATE app_area SET ";
		$sql.= "are_situacion = $sit"; 
				
		$sql.= " WHERE are_codigo = $cod"; 	
		
		return $sql;
	}
	
	function max_area(){
	        $sql = "SELECT max(are_codigo) as max ";
		$sql.= " FROM app_area";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
 /////////////////////////////  SEGMENTO //////////////////////////////////////
   
      function get_segmento($cod,$area,$nom = '',$sit = '') {
		$nom = trim($nom);
		
	        $sql= "SELECT * ";
		$sql.= " FROM app_segmento,app_area";
		$sql.= " WHERE seg_area = are_codigo";
		if(strlen($cod)>0) { 
		    	  $sql.= " AND seg_codigo = $cod"; 
		}
		if(strlen($area)>0) { 
		    $sql.= " AND seg_area = $area"; 
		}
		if(strlen($nom)>0) { 
		    $sql.= " AND seg_nombre like '%$nom%'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND seg_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY are_codigo ASC, seg_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_segmento($cod,$area,$nom = '',$sit = '') {
		$nom = trim($nom);
		
	        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_segmento,app_area";
		$sql.= " WHERE seg_area = are_codigo";
		if(strlen($cod)>0) { 
		    	  $sql.= " AND seg_codigo = $cod"; 
		}
		if(strlen($area)>0) { 
		    $sql.= " AND seg_area = $area"; 
		}
		if(strlen($nom)>0) { 
		    $sql.= " AND seg_nombre like '%$nom%'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND seg_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_segmento($cod,$area,$nom){
		$nom = trim($nom);
		
		$sql = "INSERT INTO app_segmento";
		$sql.= " VALUES ($cod,$area,'$nom',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_segmento($cod,$area,$nom){
		$nom = trim($nom);
		
		$sql = "UPDATE app_segmento SET ";
		$sql.= "seg_nombre = '$nom'"; 
	  
		$sql.= " WHERE seg_codigo = $cod"; 	
		$sql.= " AND seg_area = $area"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_segmento($cod,$area,$sit){
		
		$sql = "UPDATE app_segmento SET ";
		$sql.= "seg_situacion = $sit"; 
				
		$sql.= " WHERE seg_codigo = $cod"; 	
		$sql.= " AND seg_area = $area"; 	
		
		return $sql;
	}
	
	function max_segmento($area){
	        $sql = "SELECT max(seg_codigo) as max ";
		$sql.= " FROM app_segmento";
		$sql.= " WHERE seg_area = $area"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
	
}	
?>
