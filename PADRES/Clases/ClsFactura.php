<?php
require_once ("ClsConex.php");

class ClsFactura extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
 
/////////// SERIE ////////////////////////////////// 
    function get_serie($cod,$num = '',$desc = '') {
		$num = trim($num);
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_serie";
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
	
	function count_serie($cod,$num = '',$desc = '') {
		$num = trim($num);
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_serie";
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
	
	
	
	function insert_serie($cod,$num,$desc){
		$num = trim($num);
		$desc = trim($desc);
		
		$sql = "INSERT INTO vnt_serie ";
		$sql.= " VALUES ($cod,'$num','$desc');";
		//echo $sql;
		return $sql;
	}
	
	function modifica_serie($cod,$num,$desc){
		$num = trim($num);
		$desc = trim($desc);
		
		$sql = "UPDATE vnt_serie SET ";
		$sql.= "ser_numero = '$num',"; 
		$sql.= "ser_descripcion = '$desc'"; 
		
		$sql.= " WHERE ser_codigo = $cod"; 	
		//echo $sql;
		return $sql;
	}
		
	function max_serie() {
		
        $sql = "SELECT max(ser_codigo) as max ";
		$sql.= " FROM vnt_serie";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
/////////// BASE DE NUMERO DE FAC. ////////////////////////////////// 
    function get_fac_base($pv,$suc,$ser = '',$num = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_factura_base,vnt_serie,vnt_punto_venta,mast_sucursal";
		$sql.= " WHERE ser_codigo = fbase_serie";
		$sql.= " AND pv_codigo = fbase_punto_venta";
		$sql.= " AND pv_sucursal = fbase_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		if(strlen($pv)>0) { 
			  $sql.= " AND fbase_punto_venta = $pv"; 
		} 
		if(strlen($suc)>0) { 
			  $sql.= " AND fbase_sucursal = $suc";
		}
		if(strlen($ser)>0) { 
			  $sql.= " AND fbase_serie = $ser"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND fbase_numero = $num"; 
		}
		$sql.= " ORDER BY fbase_sucursal ASC, fbase_punto_venta ASC, fbase_serie ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_fac_base($pv,$suc,$ser = '',$num = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_factura_base,vnt_serie,vnt_punto_venta,mast_sucursal";
		$sql.= " WHERE ser_codigo = fbase_serie";
		$sql.= " AND pv_codigo = fbase_punto_venta";
		$sql.= " AND pv_sucursal = fbase_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		if(strlen($pv)>0) { 
			  $sql.= " AND fbase_punto_venta = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND fbase_sucursal = $suc";
		}
		if(strlen($ser)>0) { 
			  $sql.= " AND fbase_serie = $ser"; 
		}
		if(strlen($num)>0) { 
			  $sql.= " AND fbase_numero = $num"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_fac_base($pv,$suc,$ser,$num){
		
		$sql = "INSERT INTO vnt_factura_base ";
		$sql.= " VALUES ($pv,$suc,$ser,$num);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_fac_base($pv,$suc,$ser,$num){
		
		$sql = "UPDATE vnt_factura_base SET ";
		$sql.= "fbase_numero = $num"; 
		
		$sql.= " WHERE fbase_punto_venta = $pv"; 
		$sql.= " AND fbase_sucursal = $suc";
		$sql.= " AND fbase_serie = $ser;";  
		//echo $sql;
		return $sql;
	}
	
	function max_factura_base($suc,$pv,$ser) {
		
        $sql = "SELECT max(fbase_numero) as max ";
		$sql.= " FROM vnt_factura_base";
		$sql.= " WHERE fbase_punto_venta = $pv"; 
		//$sql.= " AND fbase_sucursal = $suc";
		$sql.= " AND fbase_serie = $ser";  
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
			$max++;
		}
		//echo $sql;
		return $max;
	}
		

////////////////////// Historial de Facturas //////////////////////////////////
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

	function get_factura($num,$ser,$ven = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fven = '',$ffac = '',$sit = '',$fini = '',$ffin = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_factura,vnt_serie,vnt_venta,vnt_factura_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE fv_venta = ven_codigo";
		$sql.= " AND fac_serie = fv_serie";
		$sql.= " AND fac_numero = fv_numero";
		$sql.= " AND fac_serie = ser_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($num)>0) { 
			  $sql.= " AND fac_numero = $num"; 
		}
		if(strlen($ser)>0) { 
			  $sql.= " AND fac_serie = $ser"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND ven_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND ven_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND ven_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND ven_vendedor = $vend"; 
		}
		if(strlen($fven)>0) { 
			$fven = $this->regresa_fecha($fven);
			$sql.= " AND ven_fecha BETWEEN '$fven' AND '$fven'"; 
		}
		if(strlen($ffac)>0) { 
			$ffac = $this->regresa_fecha($ffac);
			$sql.= " AND fac_fecha BETWEEN '$ffac' AND '$ffac'"; 
		}
		if(strlen($fini)>0 && strlen($ffin)>0) { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND fac_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, ven_fechor DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_factura($num,$ser,$ven = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fven = '',$ffac = '',$sit = '',$fini = '',$ffin = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_factura,vnt_serie,vnt_venta,vnt_factura_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE fv_venta = ven_codigo";
		$sql.= " AND fac_serie = fv_serie";
		$sql.= " AND fac_numero = fv_numero";
		$sql.= " AND fac_serie = ser_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($num)>0) { 
			  $sql.= " AND fac_numero = $num"; 
		}
		if(strlen($ser)>0) { 
			  $sql.= " AND fac_serie = $ser"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND ven_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND ven_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND ven_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND ven_vendedor = $vend"; 
		}
		if(strlen($fven)>0) { 
			$fven = $this->regresa_fecha($fven);
			$sql.= " AND ven_fecha BETWEEN '$fven' AND '$fven'"; 
		}
		if(strlen($ffac)>0) { 
			$ffac = $this->regresa_fecha($ffac);
			$sql.= " AND fac_fecha BETWEEN '$ffac' AND '$ffac'"; 
		}
		if(strlen($fini)>0 && strlen($ffin)>0) { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND fac_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND ven_situacion IN($sit)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

	function insert_factura($num,$ser,$fec){
		
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$fec = $this->regresa_fecha($fec);
		$sql = "INSERT INTO vnt_factura ";
		$sql.= "VALUES ($num,$ser,'$fec','$fechor',$usu,1);";
		//echo $sql;
		return $sql;
	}
	
	
	function insert_factura_venta($num,$ser,$ven){
		
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_factura_venta ";
		$sql.= "VALUES ($num,$ser,$ven,'$fechor',$usu);";
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_factura($num,$ser,$sit){
		
		$sql = "UPDATE vnt_factura SET ";
		$sql.= "fac_situacion = $sit"; 
				
		$sql.= " WHERE fac_numero = $num"; 
		$sql.= " AND fac_serie = $ser;";
		
		return $sql;
	}
	
	function pone_factura($vent){
		
		$sql = "UPDATE vnt_venta SET ";
		$sql.= "ven_factura = 1"; 
				
		$sql.= " WHERE ven_codigo = $vent;"; 
		
		return $sql;
	}
	
	
	function comprueba_factura($num,$ser) {
		
		$sql = "SELECT fac_numero as factura";
		$sql.= " FROM vnt_factura";
		$sql.= " WHERE fac_numero = $num"; 
		$sql.= " AND fac_serie = $ser"; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			return true;
		}
		//echo $sql;
		return false;
	}
	
}	
?>
