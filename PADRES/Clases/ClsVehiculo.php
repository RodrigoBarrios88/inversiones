<?php
require_once ("ClsConex.php");

class ClsVehiculo extends ClsConex{
   
//---------- vehiculos ---------//
	function get_vehiculos($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_vehiculos, mast_paises";
		$sql.= " WHERE veh_pais_reg = pai_id"; 
		$sql.= " AND veh_personal = $personal"; 
		$sql.= " ORDER BY veh_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_vehiculos($personal) {
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_vehiculos";
		$sql.= " WHERE veh_personal = $personal"; 
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
			
	function insert_vehiculos($veh_codigo,$veh_personal,$veh_tipo,$veh_marca,$veh_linea,$veh_modelo,$veh_tarjeta,$veh_color,$veh_chasis,$veh_motor,$veh_placas,$veh_pais_reg) {
	     //-- UPPERCASE|
			$veh_tipo = trim($veh_tipo);
			$veh_marca = trim($veh_marca);
			$veh_linea = trim($veh_linea);
			$veh_modelo = trim($veh_modelo);
			$veh_tarjeta = trim($veh_tarjeta);
			$veh_color = trim($veh_color);
			$veh_chasis = trim($veh_chasis);
			$veh_motor = trim($veh_motor);
			$veh_placas = trim($veh_placas);
			$veh_pais_reg = trim($veh_pais_reg);
		//--
		$sql = "INSERT INTO rrhh_vehiculos ";
		$sql.= "VALUES ('$veh_codigo','$veh_personal','$veh_tipo','$veh_marca','$veh_linea','$veh_modelo','$veh_tarjeta','$veh_color','$veh_chasis','$veh_motor','$veh_placas','$veh_pais_reg'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_vehiculos($personal){
		$sql = "DELETE FROM rrhh_vehiculos  ";
		$sql.= " WHERE veh_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
