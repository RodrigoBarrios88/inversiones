<?php
require_once ("ClsConex.php");

class ClsUmedida extends ClsConex{
   
    function get_unidad($calse = '',$cod = ''){
	    $sql ="SELECT * ";
	    $sql.=" FROM inv_unidad_medida";
	    $sql.=" WHERE 1 = 1";
	    if(strlen($calse)>0) { 
			$sql.=" AND u_clase = '$calse'";
	    }
		if(strlen($cod)>0) { 
			$sql.=" AND u_codigo = '$cod'";
	    }
		$sql.=" ORDER BY u_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
		
	
}	
?>
