<?php
require_once ("ClsConex.php");

class ClsArmamento extends ClsConex{
   
//---------- Armamento ---------//
	function get_armamento($personal) {
		
	    $sql= "SELECT * ";
		$sql.= " FROM rrhh_armamento";
		$sql.= " WHERE arm_personal = $personal"; 
		$sql.= " ORDER BY arm_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_armamento($personal) {
		
	    	$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM rrhh_armamento";
		$sql.= " WHERE arm_personal = $personal"; 
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
			
	function insert_armamento($arm_codigo,$arm_personal,$arm_tipo,$arm_marca,$arm_calibre,$arm_num_reg) {
	     //-- UPPERCASE
			$arm_tipo = trim($arm_tipo);
			$arm_marca = trim($arm_marca);
			$arm_calibre = trim($arm_calibre);
			$arm_num_reg = trim($arm_num_reg);
		//--
		$sql = "INSERT INTO rrhh_armamento ";
		$sql.= "VALUES ('$arm_codigo','$arm_personal','$arm_tipo','$arm_marca','$arm_calibre','$arm_num_reg'); ";
		//echo $sql;
		return $sql;
	}
	
	function delete_armamento($personal){
		$sql = "DELETE FROM rrhh_armamento  ";
		$sql.= " WHERE arm_personal = $personal; "; 	
		return $sql;
	}
	
}	
?>
