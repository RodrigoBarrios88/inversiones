<?php
require_once ("ClsConex.php");

class ClsConta extends ClsConex{

//////////// POLIZAS ////////////////////
    function get_poliza($cod,$suc = '',$doc = '',$desc = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_poliza, mast_sucursal";
		$sql.= " WHERE suc_id = pol_sucursal";
		if(strlen($cod)>0) { 
			$sql.= " AND pol_codigo = $cod"; 
		}
		if(strlen($suc)>0) { 
			$sql.= " AND pol_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			$sql.= " AND pol_documento = '$doc'"; 
		}
		if(strlen($desc)>0) { 
			$sql.= " AND pol_descripcion like '%$desc%'"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pol_fecha_contable BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND pol_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY pol_sucursal ASC, pol_fecha_contable DESC, pol_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_poliza($cod,$suc = '',$doc = '',$desc = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_poliza, mast_sucursal";
		$sql.= " WHERE suc_id = pol_sucursal";
		if(strlen($cod)>0) { 
			$sql.= " AND pol_codigo = $cod"; 
		}
		if(strlen($suc)>0) { 
			$sql.= " AND pol_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			$sql.= " AND pol_documento = '$doc'"; 
		}
		if(strlen($desc)>0) { 
			$sql.= " AND pol_descripcion like '%$desc%'"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pol_fecha_contable BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND pol_situacion IN($sit)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}
	
	function insert_poliza($cod,$doc,$suc,$desc,$fecha) {
		//--
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO fin_poliza ";
		$sql.= "VALUES ($cod,'$doc',$suc,'$desc','$fecha','$fsis',$usu,1); ";
		//echo $sql;
		return $sql;
	}
	
	function update_poliza($cod,$doc,$suc,$desc,$fecha){
		$doc = trim($doc);
		$desc = trim($desc);
		$fecha = $this->regresa_fecha($fecha);
		
		$sql = "UPDATE fin_poliza SET ";
		$sql.= "pol_documento = '$doc',"; 
		$sql.= "pol_sucursal = '$suc',"; 
		$sql.= "pol_descripcion = '$desc',"; 
		$sql.= "pol_fecha_contable = '$fecha'"; 
				
		$sql.= " WHERE pol_codigo = $cod; "; 	
		
		return $sql;
	}
		
	function cambia_sit_poliza($cod,$sit){
		
		$sql = "UPDATE fin_poliza SET ";
		$sql.= "pol_situacion = $sit"; 
				
		$sql.= " WHERE pol_codigo = $cod; "; 	
		
		return $sql;
	}
		
	function max_poliza() {
		
        $sql = "SELECT max(pol_codigo) as max ";
		$sql.= " FROM fin_poliza";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

	
//////////// DETALLE DE POLIZAS ////////////////////

	function get_det_poliza($cod,$poliza = '',$suc = '',$doc = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_poliza,fin_poliza_detalle,fin_subreglon,fin_moneda";
		$sql.= " WHERE pol_codigo = dpol_poliza";
		$sql.= " AND dpol_partida = sub_partida";
		$sql.= " AND dpol_reglon = sub_reglon";
		$sql.= " AND dpol_subreglon = sub_codigo";
		$sql.= " AND dpol_moneda = mon_id";
		if(strlen($cod)>0) { 
			$sql.= " AND dpol_codigo = $cod"; 
		}
		if(strlen($poliza)>0) { 
			$sql.= " AND dpol_poliza = $poliza"; 
		}
		if(strlen($suc)>0) { 
			$sql.= " AND pol_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			$sql.= " AND pol_documento = '$doc'"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pol_fecha_contable BETWEEN '$fini 00:00:00' AND '$ffin 23:59:59'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND pol_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY pol_sucursal ASC, pol_fecha_contable DESC, pol_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function insert_det_poliza($cod,$poliza,$tipo,$clase,$partida,$reglon,$subreglon,$motivo,$mov,$monto,$moneda,$tcambio) {
		//--
		$sql = "INSERT INTO fin_poliza_detalle ";
		$sql.= "VALUES ($cod,$poliza,'$tipo','$clase',$partida,$reglon,$subreglon,'$motivo','$mov','$monto','$moneda','$tcambio'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_det_poliza($cod,$poliza,$tipo,$clase,$partida,$reglon,$subreglon,$motivo,$mov,$monto,$moneda,$tcambio){
		$doc = trim($doc);
		$desc = trim($desc);
		
		$sql = "UPDATE fin_poliza_detalle SET ";
		$sql.= "dpol_tipo = '$tipo',"; 
		$sql.= "dpol_clase = '$clase',"; 
		$sql.= "dpol_partida = '$partida',"; 
		$sql.= "dpol_reglon = '$reglon',"; 
		$sql.= "dpol_subreglon = '$subreglon',"; 
		$sql.= "dpol_motivo = '$motivo',"; 
		$sql.= "dpol_movimiento = '$mov',"; 
		$sql.= "dpol_monto = '$monto',"; 
		$sql.= "dpol_moneda = '$moneda',"; 
		$sql.= "dpol_tcambio = '$tcambio'"; 
				
		$sql.= " WHERE dpol_codigo = $cod"; 	
		$sql.= " AND dpol_poliza = $poliza; "; 	
		
		return $sql;
	}
		
	function delete_det_poliza($cod,$poliza){
		
		$sql = "DELETE FROM fin_poliza_detalle ";
		$sql.= " WHERE dpol_codigo = $cod"; 	
		$sql.= " AND dpol_poliza = $poliza; "; 	
		
		return $sql;
	}
		
	function max_det_poliza($poliza) {
		
        $sql = "SELECT max(dpol_codigo) as max ";
		$sql.= " FROM fin_poliza_detalle";
		$sql.= " WHERE dpol_poliza = $poliza "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
