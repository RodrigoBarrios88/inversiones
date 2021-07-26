<?php
require_once ("ClsConex.php");

class ClsVntCredito extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
      
	
/////// REGISTRA LAS CUENTAS POR COBRAR A BANCOS Y TARJETAS POR MOVIMIENTOS DE TARJETAS DE DEBITO, CREDITO y BANCOS ///////
function get_cobro_creditos($cod,$ven = '',$suc = '',$mon = '',$tipo = '',$opera = '',$doc = '',$quien1 = '',$quien2 = '',$fini1 = '',$ffin1 = '',$fini2 = '',$ffin2 = '',$sit = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM  vnt_cobro_x_creditos, vnt_venta, mast_sucursal, fin_moneda";
		$sql.= " WHERE ccred_venta = ven_codigo";
		$sql.= " AND ccred_moneda = mon_id";
		$sql.= " AND ven_sucursal = suc_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND ccred_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND ccred_moneda = '$mon'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ccred_tipo = $tipo"; 
		}
		if(strlen($opera)>0) { 
			  $sql.= " AND ccred_operador like '%$opera%'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND ccred_boucher = '$doc'"; 
		}
		if(strlen($quien1)>0) { 
			  $sql.= " AND ccred_quien_venta = $quien1"; 
		}
		if(strlen($quien2)>0) { 
			  $sql.= " AND ccred_fechor_venta = $quien2"; 
		}
		if($fini1 != "" && $ffin1 != "") { 
			$fini1 = $this->regresa_fecha($fini1);
			$ffin1 = $this->regresa_fecha($ffin1);
			$sql.= " AND ven_fecha BETWEEN '$fini1' AND '$ffin1'"; 
		}
		if($fini2 != "" && $ffin2 != "") { 
			$fini2 = $this->regresa_fecha($fini2);
			$ffin2 = $this->regresa_fecha($ffin2);
			$sql.= " AND ccred_fechor_venta BETWEEN '$fini2 00:00' AND '$ffin2 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ccred_situacion IN($sit)";  
		}
		$sql.= " ORDER BY ven_codigo ASC, ccred_codigo ASC, ccred_tipo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cobro_creditos($cod,$ven = '',$suc = '',$mon = '',$tipo = '',$opera = '',$doc = '',$quien1 = '',$quien2 = '',$fini1 = '',$ffin1 = '',$fini2 = '',$ffin2 = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM  vnt_cobro_x_creditos, vnt_venta, mast_sucursal, fin_moneda";
		$sql.= " WHERE ccred_venta = ven_codigo";
		$sql.= " AND ccred_moneda = mon_id";
		$sql.= " AND ven_sucursal = suc_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND ccred_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND ccred_moneda = '$mon'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ccred_tipo = $tipo"; 
		}
		if(strlen($opera)>0) { 
			  $sql.= " AND ccred_operador like '%$opera%'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND ccred_boucher = '$doc'"; 
		}
		if(strlen($quien1)>0) { 
			  $sql.= " AND ccred_quien_venta = $quien1"; 
		}
		if(strlen($quien2)>0) { 
			  $sql.= " AND ccred_fechor_venta = $quien2"; 
		}
		if($fini1 != "" && $ffin1 != "") { 
			$fini1 = $this->regresa_fecha($fini1);
			$ffin1 = $this->regresa_fecha($ffin1);
			$sql.= " AND ven_fecha BETWEEN '$fini1' AND '$ffin1'";  
		}
		if($fini2 != "" && $ffin2 != "") { 
			$fini2 = $this->regresa_fecha($fini2);
			$ffin2 = $this->regresa_fecha($ffin2);
			$sql.= " AND ccred_fechor_venta BETWEEN '$fini2 00:00' AND '$ffin2 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ccred_situacion IN($sit)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_cobro_creditos_pv($cod,$ven = '',$suc = '',$pv = '',$tipo = '',$fini1 = '',$ffin1 = '',$fini2 = '',$ffin2 = '',$sit = ''){
		
		$sql= "SELECT * ";
		$sql.= " FROM  vnt_cobro_x_creditos, vnt_venta, mast_sucursal, vnt_punto_venta, fin_moneda";
		$sql.= " WHERE ccred_venta = ven_codigo";
		$sql.= " AND ccred_moneda = mon_id";
		$sql.= " AND ven_sucursal = suc_id";
		$sql.= " AND ven_pventa = pv_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND ccred_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND ven_pventa = $pv"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ccred_tipo = $tipo"; 
		}
		if($fini1 != "" && $ffin1 != "") { 
			$fini1 = $this->regresa_fecha($fini1);
			$ffin1 = $this->regresa_fecha($ffin1);
			$sql.= " AND ven_fecha BETWEEN '$fini1' AND '$ffin1'"; 
		}
		if($fini2 != "" && $ffin2 != "") { 
			$fini2 = $this->regresa_fecha($fini2);
			$ffin2 = $this->regresa_fecha($ffin2);
			$sql.= " AND ccred_fechor_venta BETWEEN '$fini2 00:00' AND '$ffin2 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ccred_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_codigo ASC, ccred_codigo ASC, ccred_tipo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function insert_cobro_creditos($cod,$ven,$monto,$mon,$tcamb,$tipo,$opera,$doc,$obs,$fec){
		//--
		$fec = ($fec == "")?date("d/m/Y H:i:s"):$fec;
		$fec = $this->regresa_fechaHora($fec);
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_cobro_x_creditos";
		$sql.= " VALUES ($cod,$ven,$monto,$mon,$tcamb,$tipo,'$opera','$doc','$obs','$fec','0000-00-00 00:00:00',$usu,0,1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function ejecuta_cobro_creditos($cod,$ven,$sit){
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		
		$sql = "UPDATE vnt_cobro_x_creditos SET ";
		$sql.= "ccred_quien_cobra = $usu,"; 
		$sql.= "ccred_fechor_cobra = '$fec',"; 
		$sql.= "ccred_situacion = $sit"; 
				
		$sql.= " WHERE ccred_codigo = $cod"; 	
		$sql.= " AND ccred_venta = $ven;"; 	
		
		return $sql;
	}
	
	function cambia_sit_cobro_creditos($cod,$ven,$sit){
		
		$sql = "UPDATE vnt_cobro_x_creditos SET ";
		$sql.= "ccred_situacion = $sit"; 
				
		$sql.= " WHERE ccred_codigo = $cod"; 	
		$sql.= " AND ccred_venta = $ven;"; 	
		
		return $sql;
	}
	
	function delete_cobro_creditos($ven) {
		
		$sql = "DELETE FROM vnt_cobro_x_creditos";
		$sql.= " WHERE ccred_venta = $ven; "; 	
		//echo $sql;
		return $sql;
	}
				
	function max_cobro_creditos($ven) {
		
        $sql = "SELECT max(ccred_codigo) as max ";
		$sql.= " FROM vnt_cobro_x_creditos";
		$sql.= " WHERE ccred_venta = $ven "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////// Proyectos ///////
function get_cobro_creditos_proyecto($cod,$pro = '',$suc = '',$mon = '',$tipo = '',$opera = '',$doc = '',$quien1 = '',$quien2 = '',$fini1 = '',$ffin1 = '',$fini2 = '',$ffin2 = '',$sit = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM  vnt_cobro_x_creditos_proyecto, vnt_proyecto, mast_sucursal, fin_moneda";
		$sql.= " WHERE ccred_proyecto = pro_codigo";
		$sql.= " AND ccred_moneda = mon_id";
		$sql.= " AND pro_sucursal = suc_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND ccred_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND ccred_moneda = '$mon'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ccred_tipo = $tipo"; 
		}
		if(strlen($opera)>0) { 
			  $sql.= " AND ccred_operador like '%$opera%'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND ccred_boucher = '$doc'"; 
		}
		if(strlen($quien1)>0) { 
			  $sql.= " AND ccred_quien_proyecto = $quien1"; 
		}
		if(strlen($quien2)>0) { 
			  $sql.= " AND ccred_fechor_venta = $quien2"; 
		}
		if($fini1 != "" && $ffin1 != "") { 
			$fini1 = $this->regresa_fecha($fini1);
			$ffin1 = $this->regresa_fecha($ffin1);
			$sql.= " AND ccred_fechor_proyecto BETWEEN '$fini1 00:00' AND '$ffin1 23:59'"; 
		}
		if($fini2 != "" && $ffin2 != "") { 
			$fini2 = $this->regresa_fecha($fini2);
			$ffin2 = $this->regresa_fecha($ffin2);
			$sql.= " AND ccred_fechor_venta BETWEEN '$fini2 00:00' AND '$ffin2 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ccred_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_codigo ASC, ccred_codigo ASC, ccred_tipo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cobro_creditos_proyecto($cod,$pro = '',$suc = '',$mon = '',$tipo = '',$opera = '',$doc = '',$quien1 = '',$quien2 = '',$fini1 = '',$ffin1 = '',$fini2 = '',$ffin2 = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM  vnt_cobro_x_creditos_proyecto, vnt_proyecto, mast_sucursal, fin_moneda";
		$sql.= " WHERE ccred_proyecto = pro_codigo";
		$sql.= " AND ccred_moneda = mon_id";
		$sql.= " AND pro_sucursal = suc_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND ccred_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND ccred_moneda = '$mon'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ccred_tipo = $tipo"; 
		}
		if(strlen($opera)>0) { 
			  $sql.= " AND ccred_operador like '%$opera%'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND ccred_boucher = '$doc'"; 
		}
		if(strlen($quien1)>0) { 
			  $sql.= " AND ccred_quien_proyecto = $quien1"; 
		}
		if(strlen($quien2)>0) { 
			  $sql.= " AND ccred_fechor_venta = $quien2"; 
		}
		if($fini1 != "" && $ffin1 != "") { 
			$fini1 = $this->regresa_fecha($fini1);
			$ffin1 = $this->regresa_fecha($ffin1);
			$sql.= " AND ccred_fechor_proyecto BETWEEN '$fini1 00:00' AND '$ffin1 23:59'"; 
		}
		if($fini2 != "" && $ffin2 != "") { 
			$fini2 = $this->regresa_fecha($fini2);
			$ffin2 = $this->regresa_fecha($ffin2);
			$sql.= " AND ccred_fechor_venta BETWEEN '$fini2 00:00' AND '$ffin2 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ccred_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_cobro_creditos_proyecto($cod,$pro,$monto,$mon,$tcamb,$tipo,$opera,$doc,$obs){
		//--
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_cobro_x_creditos_proyecto";
		$sql.= " VALUES ($cod,$pro,$monto,$mon,$tcamb,$tipo,'$opera','$doc','$obs','$fec','0000-00-00 00:00:00',$usu,0,1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function ejecuta_cobro_creditos_proyecto($cod,$pro,$sit){
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		
		$sql = "UPDATE vnt_cobro_x_creditos_proyecto SET ";
		$sql.= "ccred_quien_cobra = $usu,"; 
		$sql.= "ccred_fechor_cobra = '$fec',"; 
		$sql.= "ccred_situacion = $sit"; 
				
		$sql.= " WHERE ccred_codigo = $cod"; 	
		$sql.= " AND ccred_proyecto = $pro;"; 	
		
		return $sql;
	}
	
	function cambia_sit_cobro_creditos_proyecto($cod,$pro,$sit){
		
		$sql = "UPDATE vnt_cobro_x_creditos_proyecto SET ";
		$sql.= "ccred_situacion = $sit"; 
				
		$sql.= " WHERE ccred_codigo = $cod"; 	
		$sql.= " AND ccred_proyecto = $pro;"; 	
		
		return $sql;
	}
	

	
				
	function max_cobro_creditos_proyecto($pro) {
		
		$sql = "SELECT max(ccred_codigo) as max ";
		$sql.= " FROM vnt_cobro_x_creditos_proyecto";
		$sql.= " WHERE ccred_proyecto = $pro "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
