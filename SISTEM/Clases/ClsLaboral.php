<?php
require_once ("ClsConex.php");

class ClsLaboral extends ClsConex{
   
//---------- Laboral Anterior ---------//
    function get_laboral_anterior($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_laboral_anterior";
		$sql.= " WHERE lab_personal = $personal"; 
		$sql.= " ORDER BY lab_personal ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
			
	function insert_laboral_anterior($lab_personal,$lab_empleo,$lab_telefono,$lab_direccion,$lab_puesto,$lab_empresa,$lab_sueldo,$lab_fecha) {
	     //-- UPPERCASE
			$lab_empleo = trim($lab_empleo);
			$lab_direccion = trim($lab_direccion);
			$lab_puesto = trim($lab_puesto);
			$lab_empresa = trim($lab_empresa);
			$lab_fecha = trim($lab_fecha);
		//--
		$sql = "INSERT INTO rrhh_laboral_anterior ";
		$sql.= "VALUES ('$lab_personal','$lab_empleo','$lab_telefono','$lab_direccion','$lab_puesto','$lab_empresa','$lab_sueldo','$lab_fecha'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_laboral_anterior($lab_personal,$lab_empleo,$lab_telefono,$lab_direccion,$lab_puesto,$lab_empresa,$lab_sueldo,$lab_fecha) {
	     //-- UPPERCASE
			$lab_empleo = trim($lab_empleo);
			$lab_direccion = trim($lab_direccion);
			$lab_puesto = trim($lab_puesto);
			$lab_empresa = trim($lab_empresa);
			$lab_fecha = trim($lab_fecha);
		//--
		$sql = "UPDATE rrhh_laboral_anterior SET";
		$sql.= " lab_empleo = '$lab_empleo',";
		$sql.= " lab_telefono = '$lab_telefono',";
		$sql.= " lab_direccion = '$lab_direccion',";
		$sql.= " lab_puesto = '$lab_puesto',";
		$sql.= " lab_empresa = '$lab_empresa',";
		$sql.= " lab_sueldo = '$lab_sueldo',";
		$sql.= " lab_fecha = '$lab_fecha' ";
		
		$sql.= "WHERE lab_personal = '$lab_personal'; ";
		//echo $sql;
		return $sql;
	}
	
	function delete_laboral_anterior($personal){
		$sql = "DELETE FROM rrhh_laboral_anterior  ";
		$sql.= " WHERE lab_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
