<?php
require_once ("ClsConex.php");

class ClsTipoCuenta extends ClsConex{
   
    function get_tipo_cuenta($cod = '') {
				
        $sql= "SELECT * ";
		$sql.= " FROM fin_tipo_cuenta";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			$sql.= " AND tcue_codigo = $cod"; 
		}
		$sql.= " ORDER BY tcue_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
				
	function insert_tipo_cuenta($cod,$dct,$dlg){
		$dct = trim($dct);
		$dlg = trim($dlg);
				
		$sql = "INSERT INTO fin_tipo_cuenta";
		$sql.= " VALUES ($cod,'$dct','$dlg')";
		//echo $sql;
		$result = $this->exec_sql($sql);
		return $result;
	}
				
}	
?>
