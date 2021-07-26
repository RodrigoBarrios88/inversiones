<?php
require_once ("ClsConex.php");

class ClsMoneda extends ClsConex{
   
    function get_moneda($id = '') {
				
        $sql= "SELECT * ";
		$sql.= " FROM fin_moneda";
		$sql.= " WHERE mon_situacion = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND mon_id = $id"; 
		}
		$sql.= " ORDER BY mon_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_tipo_cambio($id = '') {
				
        $sql= "SELECT mon_cambio as tcambio ";
		$sql.= " FROM fin_moneda";
		$sql.= " WHERE mon_situacion = 1";
		$sql.= " AND mon_id = $id"; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$tcambio = $row["tcambio"];
			}
		}else{
			$tcambio = 0;
		}
		
		return $tcambio;
	}
		
	function insert_moneda($id,$desc,$simbolo,$pais,$camb){
		$desc = strtoupper($desc);
		$simbolo = strtoupper($simbolo);
		$pais = strtoupper($pais);
				
		$sql = "INSERT INTO fin_moneda ";
		$sql.= " VALUES ($id,'$desc','$simbolo','$pais',$camb,1);";
		//echo $sql;
		return $sql;
	}
	
	function update_moneda($id,$desc,$simbolo,$pais){
		$desc = strtoupper($desc);
		$pais = strtoupper($pais);
		
		$sql = "UPDATE fin_moneda SET "; 
		$sql.= " mon_desc = '$desc',"; 	
		$sql.= " mon_simbolo = '$simbolo',"; 	
		$sql.= " mon_pais = '$pais'"; 	
		
		$sql.= " WHERE mon_id = $id;"; 	
		
		return $sql;
	}
	
	function update_cambio_moneda($id,$camb){
		
		$sql = "UPDATE fin_moneda SET mon_cambio = $camb"; 
		$sql.= " WHERE mon_id = $id;"; 	
		
		return $sql;
	}
		
	function cambia_sit_moneda($id,$sit){
		
		$sql = "UPDATE fin_moneda SET mon_situacion = $sit"; 
		$sql.= " WHERE mon_id = $id;"; 	
		
		return $sql;
	}
	
	function max_moneda() {
		
        $sql = "SELECT max(mon_id) as max ";
		$sql.= " FROM fin_moneda";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function insert_his_cambio($mon,$camb){
		$fec = date("Y-m-d H:i:s");		
		$sql = "INSERT INTO fin_his_cambio (hcam_moneda,hcam_cambio,hcam_fecha)";
		$sql.= " VALUES ($mon,$camb,'$fec');";
		//echo $sql;
		return $sql;
	}
	
	function get_his_cambio($mon = '',$fec = '') {
				
        $sql= "SELECT * ";
		$sql.= " FROM fin_his_cambio,fin_moneda";
		$sql.= " WHERE hcam_moneda = mon_id";
		if(strlen($id)>0) { 
			  $sql.= " AND hcam_moneda = $mon"; 
		}
		if(strlen($fec)>0) { 
			$fec = $this->regresa_fecha($fec);
			  $sql.= " AND hcam_fecha = '$fec'"; 
		}
		$sql.= " ORDER BY hcam_fecha ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
				
	
}	
?>
