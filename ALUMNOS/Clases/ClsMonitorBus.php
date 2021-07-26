<?php
require_once ("ClsConex.php");

class ClsMonitorBus extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
      function get_monitores_buses($cui,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	        $sql= "SELECT * ";
		$sql.= " FROM app_monitores_buses";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND mbus_cui = $cui"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND mbus_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND mbus_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mbus_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY mbus_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_monitores_buses($cui,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_monitores_buses";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND mbus_cui = $cui"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND mbus_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND mbus_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mbus_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_monitores_buses($cui,$nom,$ape,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$tel = trim($tel);
		$mail = strtolower($mail);
		
		$sql = "INSERT INTO app_monitores_buses";
		$sql.= " VALUES ($cui,'$nom','$ape','','$tel','$mail',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_monitores_buses($cui,$nom,$ape,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$tel = trim($tel);
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_monitores_buses SET ";
		$sql.= "mbus_nombre = '$nom',"; 
		$sql.= "mbus_apellido = '$ape',"; 
		$sql.= "mbus_telefono = '$tel',"; 		
		$sql.= "mbus_mail = '$mail'";
		
		$sql.= " WHERE mbus_cui = $cui"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_monitores_buses($cui,$sit){
		
		$sql = "UPDATE app_monitores_buses SET ";
		$sql.= "mbus_situacion = $sit"; 
				
		$sql.= " WHERE mbus_cui = $cui"; 	
		
		return $sql;
	}
	
	function max_monitores_buses(){
	        $sql = "SELECT max(mbus_cui) as max ";
		$sql.= " FROM app_monitores_buses";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
