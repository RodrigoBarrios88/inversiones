<?php
require_once ("ClsConex.php");

class ClsPuntoVenta extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
    function get_punto_venta($id,$suc,$nom = '',$sit = '') {
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_punto_venta,mast_sucursal";
		$sql.= " WHERE pv_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND pv_codigo = $id"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pv_sucursal = $suc"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND pv_nombre like '%$nom%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pv_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY suc_id ASC, pv_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_punto_venta($id,$suc,$nom = '',$sit = '') {
		$nom = trim($nom);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_punto_venta,mast_sucursal";
		$sql.= " WHERE pv_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND pv_codigo = $id"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pv_sucursal = $suc"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND pv_nombre like '%$nom%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pv_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_punto_venta($id,$suc,$nom){
		$nom = trim($nom);
		
		$sql = "INSERT INTO vnt_punto_venta ";
		$sql.= " VALUES ($id,$suc,'$nom',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_punto_venta($id,$suc,$nom){
		$nom = trim($nom);
		
		$sql = "UPDATE vnt_punto_venta SET ";
		$sql.= "pv_nombre = '$nom'"; 
		
		$sql.= " WHERE pv_codigo = $id"; 	
		$sql.= " AND pv_sucursal = $suc;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_punto_venta($id,$suc,$sit){
		
		$sql = "UPDATE vnt_punto_venta SET ";
		$sql.= "pv_situacion = $sit"; 
				
		$sql.= " WHERE pv_codigo = $id"; 	
		$sql.= " AND pv_sucursal = $suc"; 	
		
		return $sql;
	}
	
	function max_punto_venta($suc){
        $sql = "SELECT max(pv_codigo) as max ";
		$sql.= " FROM vnt_punto_venta";
		$sql.= " WHERE pv_sucursal = $suc";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
	
/////// Movimiento de efectivo PV ///////
function get_mov_pv($cod,$pv = '',$suc = '',$mov = '',$mon = '',$tipo = '',$doc = '',$quien = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM  fin_mov_punto_venta, vnt_punto_venta, mast_sucursal, fin_moneda";
		$sql.= " WHERE pv_sucursal = suc_id";
		$sql.= " AND mpv_moneda = mon_id";
		$sql.= " AND mpv_punto_venta = pv_codigo";
		$sql.= " AND mpv_sucursal = pv_sucursal";
		if(strlen($cod)>0) { 
			  $sql.= " AND mpv_codigo = $cod"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pv_codigo = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pv_sucursal = $suc"; 
		}
		if(strlen($mov)>0) { 
			  $sql.= " AND mpv_movimiento = '$num'"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND mpv_moneda = '$mon'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mpv_tipo = '$tipo'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND mpv_doc = '$doc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND mpv_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND mpv_fecha BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mpv_situacion = $sit"; 
		}
		$sql.= " ORDER BY pv_codigo ASC, mpv_codigo ASC, mpv_movimiento ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_mov_pv($cod,$pv = '',$suc = '',$mov = '',$mon = '',$tipo = '',$doc = '',$quien = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM  fin_mov_punto_venta, vnt_punto_venta, mast_sucursal, fin_moneda";
		$sql.= " WHERE pv_sucursal = suc_id";
		$sql.= " AND caja_moneda = mon_id";
		$sql.= " AND mpv_punto_venta = pv_codigo";
		$sql.= " AND mpv_sucursal = pv_sucursal";
		if(strlen($cod)>0) { 
			  $sql.= " AND mpv_codigo = $cod"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pv_codigo = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pv_sucursal = $suc"; 
		}
		if(strlen($mov)>0) { 
			  $sql.= " AND mpv_movimiento = '$num'"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND mpv_moneda = '$mon'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mpv_tipo = '$tipo'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND mpv_doc = '$doc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND mpv_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND mpv_fecha BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mpv_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_saldo_actual($pv,$suc,$fini,$ffin) {
		
       	$fini = $this->regresa_fecha($fini);
		$ffin = $this->regresa_fecha($ffin);
		
		$sql= "SELECT *,";
		$sql.= " (SELECT SUM(mpv_monto) FROM fin_mov_punto_venta WHERE mpv_moneda = mon_id AND mpv_punto_venta = $pv AND mpv_sucursal = $suc AND mpv_movimiento = 'I' AND mpv_fecha BETWEEN '$fini 00:00' AND '$ffin 23:59') as ingresos,";
		$sql.= " (SELECT SUM(mpv_monto) FROM fin_mov_punto_venta WHERE mpv_moneda = mon_id AND mpv_punto_venta = $pv AND mpv_sucursal = $suc AND mpv_movimiento = 'E' AND mpv_fecha BETWEEN '$fini 00:00' AND '$ffin 23:59') as egresos";
		$sql.= " FROM  fin_moneda";
		$sql.= " WHERE 1 = 1"; 
		$sql.= " ORDER BY mon_id ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
	
	function get_saldo_anterior($pv,$suc,$fec) {
		
       	$fec = $this->regresa_fecha($fec);
		
		$sql= "SELECT *,";
		$sql.= " (SELECT SUM(mpv_monto) FROM fin_mov_punto_venta WHERE mpv_moneda = mon_id AND mpv_punto_venta = $pv AND mpv_sucursal = $suc AND mpv_movimiento = 'I' AND mpv_fecha < '$fec 00:00') as ingresos,";
		$sql.= " (SELECT SUM(mpv_monto) FROM fin_mov_punto_venta WHERE mpv_moneda = mon_id AND mpv_punto_venta = $pv AND mpv_sucursal = $suc AND mpv_movimiento = 'E' AND mpv_fecha < '$fec 00:00') as egresos";
		$sql.= " FROM  fin_moneda";
		$sql.= " WHERE 1 = 1"; 
		$sql.= " ORDER BY mon_id ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
	
	
	function insert_mov_pv($cod,$pv,$suc,$mov,$monto,$mon,$tcamb,$tipo,$motivo,$doc,$fecha){
		//--
		$fecha = $this->regresa_fecha($fecha);
		$fsis = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO fin_mov_punto_venta";
		$sql.= " VALUES ($cod,$pv,$suc,'$mov',$monto,$mon,$tcamb,'$tipo','$motivo','$doc','$fecha','$fsis',$usu,1); ";
		//echo $sql;
		return $sql;
	}
	
			
	function max_mov_pv($pv,$suc) {
		
        $sql = "SELECT max(mpv_codigo) as max ";
		$sql.= " FROM fin_mov_punto_venta";
		$sql.= " WHERE mpv_punto_venta = $pv "; 	
		$sql.= " AND mpv_sucursal = $suc "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
