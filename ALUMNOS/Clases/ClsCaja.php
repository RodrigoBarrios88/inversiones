<?php
require_once ("ClsConex.php");

class ClsCaja extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- Bancos ---------//
    function get_caja($cod,$suc = '',$mon = '',$sit = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_caja, mast_sucursal, fin_moneda";
		$sql.= " WHERE caja_sucursal = suc_id";
		$sql.= " AND caja_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND caja_codigo = $cod"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND caja_sucursal = $suc"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND caja_moneda = $mon"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND caja_situacion = $sit"; 
		}
		$sql.= " ORDER BY caja_sucursal ASC, caja_codigo ASC, caja_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_caja($cod,$suc = '',$mon = '',$sit = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_caja, mast_sucursal, fin_moneda";
		$sql.= " WHERE caja_sucursal = suc_id";
		$sql.= " AND caja_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND caja_codigo = $cod"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND caja_sucursal = $suc"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND caja_moneda = $mon"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND caja_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_caja($cod,$suc,$mon,$desc){
		$desc = trim($desc);
		
		$sql = "INSERT INTO fin_caja VALUES($cod,$suc,'$desc',$mon,0,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_caja($cod,$suc,$mon,$desc){
		$desc = trim($desc);
		
		$sql = "UPDATE fin_caja SET ";
		$sql.= "caja_descripcion = '$desc',"; 
		$sql.= "caja_moneda = $mon"; 
		
		$sql.= " WHERE caja_codigo = $cod "; 	
		$sql.= " AND  caja_sucursal = $suc; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_caja($cod,$suc,$sit){
		
		$sql = "UPDATE fin_caja SET ";
		$sql.= "caja_situacion = $sit"; 
				
		$sql.= " WHERE caja_codigo = $cod "; 	
		$sql.= " AND  caja_sucursal = $suc; "; 	
		
		return $sql;
	}
			
	
	function comprueba_sit_caja($cod,$suc) {
		
		$sql = "SELECT COUNT(caja_codigo) as total";
		$sql.= " FROM fin_caja";
		$sql.= " WHERE caja_codigo = $cod"; 	
		$sql.= " AND caja_sucursal = $suc"; 	
		$sql.= " AND caja_saldo > 0; "; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cant = $row["total"];
				if($cant > 0){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
		
		
	function max_caja($suc) {
		
        $sql = "SELECT max(caja_codigo) as max ";
		$sql.= " FROM fin_caja";
		$sql.= " WHERE caja_sucursal = $suc; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	function saldo_caja($caja,$suc,$mont,$signo){
		
		$sql = "UPDATE  fin_caja SET ";
		if($signo == "+") { 
			$sql.= "caja_saldo = caja_saldo + $mont"; 
		}else if($signo == "-") { 
			$sql.= "caja_saldo = caja_saldo - $mont"; 
		}
		
		$sql.= " WHERE caja_codigo = $caja "; 	
		$sql.= " AND caja_sucursal = $suc; "; 	
		//echo $sql;
		return $sql;
	}

//---------- Movimientos de Caja ---------//
    function get_mov_caja($cod,$caja = '',$suc = '',$mov = '',$tipo = '',$doc = '',$quien = '',$fini = '',$ffin = '',$sit = '') {
		$doc = trim($doc);
		
        $sql= "SELECT * ";
		$sql.= " FROM  fin_mov_caja, fin_caja, mast_sucursal, fin_moneda";
		$sql.= " WHERE caja_sucursal = suc_id";
		$sql.= " AND caja_moneda = mon_id";
		$sql.= " AND mcj_caja = caja_codigo";
		$sql.= " AND mcj_sucursal = caja_sucursal";
		if(strlen($cod)>0) { 
			  $sql.= " AND mcj_codigo = $cod"; 
		}
		if(strlen($caja)>0) { 
			  $sql.= " AND caja_codigo = $caja"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND caja_sucursal = $suc"; 
		}
		if(strlen($mov)>0) { 
			  $sql.= " AND mcj_movimiento = '$num'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mcj_tipo = '$tipo'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND mcj_doc = '$doc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND mcj_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND mcj_fecha BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mcj_situacion = $sit"; 
		}
		$sql.= " ORDER BY caja_codigo ASC, mcj_codigo ASC, mcj_movimiento ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_mov_caja($cod,$caja = '',$suc = '',$mov = '',$tipo = '',$doc = '',$quien = '',$fini = '',$ffin = '',$sit = '') {
		$doc = trim($doc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM  fin_mov_caja, fin_caja, mast_sucursal, fin_moneda";
		$sql.= " WHERE caja_sucursal = suc_id";
		$sql.= " AND caja_moneda = mon_id";
		$sql.= " AND mcj_caja = caja_codigo";
		$sql.= " AND mcj_sucursal = caja_sucursal";
		if(strlen($cod)>0) { 
			  $sql.= " AND mcj_codigo = $cod"; 
		}
		if(strlen($caja)>0) { 
			  $sql.= " AND caja_codigo = $caja"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND caja_sucursal = $suc"; 
		}
		if(strlen($mov)>0) { 
			  $sql.= " AND mcj_movimiento = '$num'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mcj_tipo = '$tipo'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND mcj_doc = '$doc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND mcj_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND mcj_fecha BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mcj_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_saldo_anterior($caja,$suc,$fec) {
		$doc = trim($doc);
		$fec = $this->regresa_fecha($fec);
		
		$sql= "SELECT caja_codigo,";
		$sql.= " (SELECT SUM(mcj_monto) FROM fin_mov_caja WHERE mcj_caja = caja_codigo AND mcj_sucursal = caja_sucursal AND mcj_movimiento = 'I' AND mcj_fecha < '$fec 00:00') as ingresos,";
		$sql.= " (SELECT SUM(mcj_monto) FROM fin_mov_caja WHERE mcj_caja = caja_codigo AND mcj_sucursal = caja_sucursal AND mcj_movimiento = 'E' AND mcj_fecha < '$fec 00:00') as egresos";
		$sql.= " FROM  fin_caja";
		$sql.= " WHERE caja_codigo = $caja"; 
		$sql.= " AND caja_sucursal = $suc"; 
		//echo $sql;
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$ingresos = $row['ingresos'];
				$egresos = $row['egresos'];
			}
		}
		$saldo = $ingresos - $egresos;
		return $saldo;
	}
		
	function insert_mov_caja($cod,$caja,$suc,$mov,$monto,$tipo,$motivo,$doc,$fecha){
		$doc = trim($doc);
		//--
		$motivo = trim($motivo);
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO fin_mov_caja";
		$sql.= " VALUES ($cod,$caja,$suc,'$mov',$monto,'$tipo','$motivo','$doc','$fecha','$fsis',$usu,1); ";
		//echo $sql;
		return $sql;
	}
	
			
	function max_mov_caja($caja,$suc) {
		
        $sql = "SELECT max(mcj_codigo) as max ";
		$sql.= " FROM fin_mov_caja";
		$sql.= " WHERE mcj_caja = $caja "; 	
		$sql.= " AND mcj_sucursal = $suc "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
}	
?>
