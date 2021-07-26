<?php
require_once ("ClsConex.php");
date_default_timezone_set('America/Guatemala');

class ClsBitacora extends ClsConex{

/* Situacion 1 = ACTIVO, 0 = INACTIVO*/
   
    function get_bitacora($id,$suc = '',$usu = '',$mod = '',$acc = '',$fini = '',$ffin = '') {
		$usu = trim($usu);
		$mod = trim($mod);
		$acc = trim($acc);
		
        $sql= "SELECT * ";
		$sql.= " FROM seg_bitacora,seg_usuarios,mast_sucursal";
		$sql.= " WHERE bit_usuario = usu_id";
		$sql.= " AND usu_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND bit_id = $id"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND usu_sucursal = $suc"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND usu_id = '$usu'"; 
		}
		if(strlen($mod)>0) { 
			  $sql.= " AND bit_modulo = '$mod'"; 
		}
		if(strlen($acc)>0) { 
			  $sql.= " AND bit_accion = '$acc'"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			  $sql.= " AND bit_fec_hor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		$sql.= " ORDER BY bit_id DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
				
	function insert_bitacora($mod,$acc,$obs){
		$mod = trim($mod);
		$acc = trim($acc);
		$obs = trim($obs);
		
		$usu = $_SESSION["codigo"];
		$fec = date("Y-m-d H:i:s");
		$sql = "INSERT INTO seg_bitacora (bit_usuario,bit_fec_hor,bit_modulo,bit_accion,bit_obs)";
		$sql.= " VALUES ($usu,'$fec','$mod','$acc','$obs'); ";
		//echo $sql;
		return $sql;
	}
	
}	
?>
