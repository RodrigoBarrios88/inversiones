<?php
require_once ("ClsConex.php");

class ClsRecibo extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
 
/////////// SERIE ////////////////////////////////// 
    function get_serie_recibo($cod,$num = '',$desc = '') {
		$num = trim($num);
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_serie_recibo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND ser_codigo = $cod"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND ser_numero = $num"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND ser_descripcion like '%$desc%'"; 
		}
		$sql.= " ORDER BY ser_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_serie_recibo($cod,$num = '',$desc = '') {
		$num = trim($num);
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_serie_recibo";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND ser_codigo = $cod"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND ser_numero = $num"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND ser_descripcion like '%$desc%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_serie_recibo($cod,$num,$desc){
		$num = trim($num);
		$desc = trim($desc);
		
		$sql = "INSERT INTO vnt_serie_recibo ";
		$sql.= " VALUES ($cod,'$num','$desc');";
		//echo $sql;
		return $sql;
	}
	
	function modifica_serie_recibo($cod,$num,$desc){
		$num = trim($num);
		$desc = trim($desc);
		
		$sql = "UPDATE vnt_serie_recibo SET ";
		$sql.= "ser_numero = '$num',"; 
		$sql.= "ser_descripcion = '$desc'"; 
		
		$sql.= " WHERE ser_codigo = $cod"; 	
		//echo $sql;
		return $sql;
	}
		
	function max_serie_recibo() {
		
        $sql = "SELECT max(ser_codigo) as max ";
		$sql.= " FROM vnt_serie_recibo";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////// BASE DE NUMERO DE RECIBO ////////////////////////////////// 
    function get_rec_base($pv,$suc,$ser = '',$num = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_recibo_base,vnt_serie_recibo,vnt_punto_venta,mast_sucursal";
		$sql.= " WHERE ser_codigo = rbase_serie";
		$sql.= " AND pv_codigo = rbase_punto_venta";
		$sql.= " AND pv_sucursal = rbase_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		if(strlen($pv)>0) { 
			  $sql.= " AND rbase_punto_venta = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND rbase_sucursal = $suc";
		}
		if(strlen($ser)>0) { 
			  $sql.= " AND rbase_serie = $ser"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND rbase_numero = $num"; 
		}
		$sql.= " ORDER BY rbase_sucursal ASC, rbase_punto_venta ASC, rbase_serie ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_rec_base($pv,$suc,$ser = '',$num = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_recibo_base,vnt_serie_recibo,vnt_punto_venta,mast_sucursal";
		$sql.= " WHERE ser_codigo = rbase_serie";
		$sql.= " AND pv_codigo = rbase_punto_venta";
		$sql.= " AND pv_sucursal = rbase_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		if(strlen($pv)>0) { 
			  $sql.= " AND rbase_punto_venta = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND rbase_sucursal = $suc";
		}
		if(strlen($ser)>0) { 
			  $sql.= " AND rbase_serie = $ser"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND rbase_numero = $num"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_rec_base($pv,$suc,$ser,$num){
		
		$sql = "INSERT INTO vnt_recibo_base ";
		$sql.= " VALUES ($pv,$suc,$ser,$num);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_rec_base($pv,$suc,$ser,$num){
		
		$sql = "UPDATE vnt_recibo_base SET ";
		$sql.= "rbase_numero = $num"; 
		
		$sql.= " WHERE rbase_punto_venta = $pv"; 
		$sql.= " AND rbase_sucursal = $suc";
		$sql.= " AND rbase_serie = $ser;";  
		//echo $sql;
		return $sql;
	}
	
	function max_recibo_base($suc,$pv,$ser) {
		
        $sql = "SELECT max(rbase_numero) as max ";
		$sql.= " FROM vnt_recibo_base";
		//$sql.= " WHERE rbase_punto_venta = $pv"; 
		//$sql.= " AND rbase_sucursal = $suc";
		$sql.= " WHERE rbase_serie = $ser";  
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
			$max++;
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
