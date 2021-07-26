<?php
require_once ("ClsConex.php");

class ClsRefSocial extends ClsConex{
   
//---------- Laboral Anterior ---------//
	function get_referencia_social($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_referencia_social";
		$sql.= " WHERE refso_personal = $personal"; 
		$sql.= " ORDER BY refso_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_referencia_social($personal) {
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_referencia_social";
		$sql.= " WHERE refso_personal = $personal"; 
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_referencia_social($refso_codigo,$refso_personal,$refso_nombre,$refso_direccion,$refso_telefono,$refso_trabajo,$refso_cargo) {
	     //-- UPPERCASE
			$refso_nombre = trim($refso_nombre);
			$refso_direccion = trim($refso_direccion);
			$refso_trabajo = trim($refso_trabajo);
			$refso_cargo = trim($refso_cargo);
		//--
		$sql = "INSERT INTO rrhh_referencia_social ";
		$sql.= "VALUES ('$refso_codigo','$refso_personal','$refso_nombre','$refso_direccion','$refso_telefono','$refso_trabajo','$refso_cargo'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_referencia_social($personal){
		$sql = "DELETE FROM rrhh_referencia_social  ";
		$sql.= " WHERE refso_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
