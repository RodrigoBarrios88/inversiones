<?php
require_once ("ClsConex.php");

class ClsFamilia extends ClsConex{
   
//---------- Familia ---------//
	function get_familia($personal,$parent="") {
		
		$sql= "SELECT * ";
		$sql.= " FROM rrhh_familia, rrhh_parentesco, mast_paises";
		$sql.= " WHERE fam_parentesco = par_codigo";
		$sql.= " AND pai_id = fam_pais";
		$sql.= " AND fam_personal = $personal"; 
		if(strlen($parent)>0) { 
			$sql.= " AND fam_parentesco = '$parent'"; 
		}
		$sql.= " ORDER BY fam_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_familia($personal,$parent=""){
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_familia, rrhh_parentesco, mast_paises";
		$sql.= " WHERE fam_parentesco = par_codigo";
		$sql.= " AND pai_id = fam_pais";
		$sql.= " AND fam_personal = $personal"; 
		if(strlen($parent)>0) { 
			$sql.= " AND fam_parentesco = '$parent'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
			
	function insert_familia($fam_codigo,$fam_personal,$fam_nombres,$fam_apellidos,$fam_direccion,$fam_telefono,$fam_celular,$fam_profesion,
										  $fam_religion,$fam_pais,$fam_fecnac,$fam_parentesco) {
		//-- UPPERCASE
			$fam_nombres = trim($fam_nombres);
			$fam_apellidos = trim($fam_apellidos);
			$fam_direccion = trim($fam_direccion);
			$fam_profesion = trim($fam_profesion);
			$fam_religion = trim($fam_religion);
		//--	cambio de formatos de fecha
		$fam_fecnac = $this->regresa_fecha($fam_fecnac);
		//--
		$sql = "INSERT INTO rrhh_familia ";
		$sql.= "VALUES ('$fam_codigo','$fam_personal','$fam_nombres','$fam_apellidos','$fam_direccion','$fam_telefono','$fam_celular','$fam_profesion','$fam_religion','$fam_pais','$fam_fecnac','$fam_parentesco'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_familia($personal){
		$sql = "DELETE FROM rrhh_familia  ";
		$sql.= " WHERE fam_personal = $personal; "; 	
		return $sql;
	}
	
	
//---------- Familia Militar ---------//
	function get_familia_institucion($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_familia_institucion";
		$sql.= " WHERE fainst_personal = $personal"; 
		$sql.= " ORDER BY fainst_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_familia_institucion($personal) {
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_familia_institucion";
		$sql.= " WHERE fainst_personal = $personal"; 
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_familia_institucion($fainst_codigo,$fainst_personal,$fainst_nombre,$fainst_parentesco,$fainst_puesto,$fainst_anio) {
	     //-- UPPERCASE
			$fainst_grado = trim($fainst_grado);
			$fainst_nombre = trim($fainst_nombre);
			$fainst_parentesco = trim($fainst_parentesco);
			$fainst_puesto = trim($fainst_puesto);
		//--
		$sql = "INSERT INTO rrhh_familia_institucion ";
		$sql.= "VALUES ('$fainst_codigo','$fainst_personal','$fainst_nombre','$fainst_parentesco','$fainst_puesto','$fainst_anio'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_familia_institucion($personal){
		$sql = "DELETE FROM rrhh_familia_institucion  ";
		$sql.= " WHERE fainst_personal = $personal; "; 	
		return $sql;
	}
	
	
}	
?>
