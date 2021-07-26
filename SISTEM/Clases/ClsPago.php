<?php
require_once ("ClsConex.php");

class ClsPago extends ClsConex{
   
    function get_tipo_pago(){
	   $sql ="SELECT *";
	   $sql.=" FROM fin_tipo_pago";
	   $sql.=" WHERE 1 = 1";
	   $sql.=" ORDER BY tpago_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
	
    //---------- Pagos de venta ---------//
    function get_pago_venta($cod,$ven,$tipo = '',$fini = '',$ffin = '',$sit = '',$caj = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_pago,fin_tipo_pago,fin_moneda,vnt_venta";
		$sql.= " WHERE pag_venta = ven_codigo";
		$sql.= " AND pag_tipo_pago = tpago_codigo";
		$sql.= " AND pag_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND pag_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND pag_venta = $ven"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND pag_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pag_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pag_cajero = $caj"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pag_situacion = $sit"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_codigo ASC, pag_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_pago_venta($cod,$ven,$tipo = '',$fini = '',$ffin = '',$sit = '',$caj = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_pago,fin_tipo_pago,fin_moneda,vnt_venta";
		$sql.= " WHERE pag_venta = ven_codigo";
		$sql.= " AND pag_tipo_pago = tpago_codigo";
		$sql.= " AND pag_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND pag_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND pag_venta = $ven"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND pag_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pag_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pag_cajero = $caj"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pag_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_pago_venta($cod,$ven,$tipo,$cant,$mon,$tcamb,$opera,$doc,$obs){
		$doc = trim($doc);
		$obs = trim($obs);
		$opera = trim($opera);
		//--
		$fec = date("Y-m-d H:i:s");
		$caj = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_pago ";
		$sql.= "VALUES ($cod,$ven,$tipo,$cant,$mon,$tcamb,'$opera','$doc','$fec',$caj,'$obs',1); ";
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_pago_venta($ven) {
		
        $sql = "UPDATE vnt_pago SET pag_situacion = 0 WHERE pag_venta = $ven; ";
		//echo $sql;
		return $max;
	}	
		
	function max_pago_venta() {
		
        $sql = "SELECT max(pag_codigo) as max ";
		$sql.= " FROM vnt_pago";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
		
	//---------- Pagos de Compras ---------//
	function get_pago_compra($cod,$comp,$tipo = '',$fini = '',$ffin = '',$sit = '',$usu = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM comp_pago,fin_tipo_pago,fin_moneda,comp_compra";
		$sql.= " WHERE pag_compra = com_codigo";
		$sql.= " AND pag_tipo_pago = tpago_codigo";
		$sql.= " AND pag_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND pag_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND pag_compra = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND pag_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pag_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND pag_usuario = $usu"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pag_situacion = $sit"; 
		}
		$sql.= " ORDER BY com_sucursal ASC, com_codigo ASC, pag_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_pago_compra($cod,$comp,$tipo = '',$fini = '',$ffin = '',$sit = '',$usu = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM comp_pago,fin_tipo_pago,fin_moneda,comp_compra";
		$sql.= " WHERE pag_compra = com_codigo";
		$sql.= " AND pag_tipo_pago = tpago_codigo";
		$sql.= " AND pag_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND pag_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND pag_compra = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND pag_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pag_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND pag_usuario = $usu"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pag_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_pago_compra($cod,$comp,$tipo,$cant,$mon,$tcamb,$opera,$doc,$obs){
		$doc = trim($doc);
		$obs = trim($obs);
		$opera = trim($opera);
		//--
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO comp_pago ";
		$sql.= "VALUES ($cod,$comp,$tipo,$cant,$mon,$tcamb,'$opera','$doc','$fec',$usu,'$obs',1); ";
		//echo $sql;
		return $sql;
	}
		
	function max_pago_compra() {
		
        $sql = "SELECT max(pag_codigo) as max ";
		$sql.= " FROM comp_pago";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
    //---------- Pagos de proyectos ---------//
    function get_pago_proyecto($cod,$pro,$tipo = '',$fini = '',$ffin = '',$sit = '',$caj = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_pago_proyecto,fin_tipo_pago,fin_moneda,vnt_proyecto";
		$sql.= " WHERE pag_proyecto = pro_codigo";
		$sql.= " AND pag_tipo_pago = tpago_codigo";
		$sql.= " AND pag_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND pag_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pag_proyecto = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND pag_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pag_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pag_cajero = $caj"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pag_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_sucursal ASC, pro_codigo ASC, pag_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_pago_proyecto($cod,$pro,$tipo = '',$fini = '',$ffin = '',$sit = '',$caj = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_pago_proyecto,fin_tipo_pago,fin_moneda,vnt_proyecto";
		$sql.= " WHERE pag_proyecto = pro_codigo";
		$sql.= " AND pag_tipo_pago = tpago_codigo";
		$sql.= " AND pag_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND pag_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pag_proyecto = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND pag_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pag_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pag_cajero = $caj"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pag_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_pago_proyecto($cod,$pro,$tipo,$cant,$mon,$tcamb,$opera,$doc,$obs){
		$doc = trim($doc);
		$obs = trim($obs);
		$opera = trim($opera);
		//--
		$fec = date("Y-m-d H:i:s");
		$caj = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_pago_proyecto ";
		$sql.= "VALUES ($cod,$pro,$tipo,$cant,$mon,$tcamb,'$opera','$doc','$fec',$caj,'$obs',1); ";
		//echo $sql;
		return $sql;
	}
		
	function max_pago_proyecto() {
		
        $sql = "SELECT max(pag_codigo) as max ";
		$sql.= " FROM vnt_pago_proyecto";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
		
		
}	
?>
