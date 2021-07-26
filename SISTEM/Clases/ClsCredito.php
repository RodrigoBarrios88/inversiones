<?php
require_once ("ClsConex.php");

class ClsCredito extends ClsConex{
   
    function get_tipo_credito(){
	   $sql ="SELECT *";
	   $sql.=" FROM fin_tipo_pago";
	   $sql.=" WHERE 1 = 1";
	   $sql.=" ORDER BY tpago_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
	
	//---------- Creditos de venta ---------//
    function get_credito_venta($cod,$ven,$suc = '',$cliente = '',$fini = '',$ffin = '',$sit = '',$cli = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_credito,vnt_venta,fin_cliente,mast_sucursal,fin_moneda";
		$sql.= " WHERE cred_venta = ven_codigo";
		$sql.= " AND ven_cliente = cli_id";
		$sql.= " AND ven_sucursal = suc_id";
		$sql.= " AND cred_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND cred_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND cred_venta = $ven"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($cliente)>0) { 
			  $sql.= " AND ven_cliente = $cliente"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND cred_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cred_situacion = $sit"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND ven_cliente = $cli"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_codigo ASC, cred_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_credito_venta($cod,$ven,$suc = '',$cliente = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_credito,vnt_venta,fin_cliente,mast_sucursal,fin_moneda";
		$sql.= " WHERE cred_venta = ven_codigo";
		$sql.= " AND ven_cliente = cli_id";
		$sql.= " AND ven_sucursal = suc_id";
		$sql.= " AND cred_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND cred_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND cred_venta = $ven"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($cliente)>0) { 
			  $sql.= " AND ven_cliente = $cliente"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND cred_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cred_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_credito_venta_pv($cod,$ven,$suc = '',$pv = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_credito,fin_moneda,vnt_venta,vnt_punto_venta";
		$sql.= " WHERE cred_venta = ven_codigo";
		$sql.= " AND cred_moneda = mon_id";
		$sql.= " AND ven_pventa = pv_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND cred_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND cred_venta = $ven"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND ven_pventa = $pv"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND cred_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cred_situacion = $sit"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_codigo ASC, cred_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
		
	function insert_credito_venta($cod,$ven,$tipo,$cant,$mon,$tcamb,$opera,$doc,$obs){
		$doc = trim($doc);
		$obs = trim($obs);
		$opera = trim($opera);
		//--
		$fec = date("Y-m-d H:i:s");
		$caj = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_credito ";
		$sql.= "VALUES ($cod,$ven,$tipo,$cant,$mon,$tcamb,'$opera','$doc','$fec',$caj,'$obs',1); ";
		//echo $sql;
		return $sql;
	}
	
	function update_credito_venta($cod,$opera,$doc,$obs){
		$doc = trim($doc);
		$obs = trim($obs);
		$opera = trim($opera);
		
		$sql = "UPDATE vnt_credito SET ";
		$sql.= "cred_operador = '$opera',";
		$sql.= "cred_doc = '$doc',";
		$sql.= "cred_obs = '$obs'";
		
		$sql.= " WHERE cred_codigo = $cod; ";
		//echo $sql;
		return $sql;
	}
	
	function max_credito_venta() {
		
        $sql = "SELECT max(cred_codigo) as max ";
		$sql.= " FROM vnt_credito";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	function total_credito_venta($ven,$tcambio) {
		
        $sql = "SELECT cred_monto,cred_tcambio";
		$sql.= " FROM vnt_credito";
		$sql.= " WHERE cred_venta = $ven";
		//--
		$result = $this->exec_query($sql);
		$suma = 0;
		if(is_array($result)){
			foreach($result as $row){
				$cuanto = $row["cred_monto"];
				$de = $row["cred_tcambio"];
				//
				$dato = $de * $cuanto;
				$dato = $dato/$tcambio;
				$dato = number_format($dato, 2, '.', '');
				$suma += $dato;
			}
		}
		//echo $sql;
		return $suma;
	}
	
	function cambia_sit_credito_venta($cod,$vent,$sit){
		
		$sql = "UPDATE vnt_credito SET ";
		$sql.= "cred_situacion = $sit"; 
				
		$sql.= " WHERE cred_codigo = $cod "; 	
		$sql.= " AND  cred_venta = $vent; "; 	
		
		return $sql;
	}
	
	function delete_credito_venta($ven) {
		
		$sql = "DELETE FROM vnt_credito";
		$sql.= " WHERE cred_venta = $ven; "; 	
		//echo $sql;
		return $sql;
	}
		
	//---------- Creditos de Compras ---------//
	function get_credito_compra($cod,$comp,$doc = '',$tipocomp = '',$suc = '',$fini = '',$ffin = '',$sit = '',$usu = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM comp_credito,fin_tipo_pago,fin_moneda,comp_compra";
		$sql.= " WHERE cred_compra = com_codigo";
		$sql.= " AND cred_tipo_credito = tpago_codigo";
		$sql.= " AND cred_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND cred_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND cred_compra = $comp"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc = '$doc'"; 
		}
		if(strlen($tipocomp)>0) { 
			  $sql.= " AND com_tipo = '$tipocomp'"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND cred_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND cred_usuario = $usu"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cred_situacion = $sit"; 
		}
		$sql.= " ORDER BY com_sucursal ASC, com_codigo ASC, cred_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_credito_compra($cod,$comp,$tipo = '',$fini = '',$ffin = '',$sit = '',$usu = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM comp_credito,fin_tipo_pago,fin_moneda,comp_compra";
		$sql.= " WHERE cred_compra = com_codigo";
		$sql.= " AND cred_tipo_credito = tpago_codigo";
		$sql.= " AND cred_moneda = mon_id";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND cred_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND cred_compra = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND cred_tipo = $tipo"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND cred_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND cred_usuario = $usu"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cred_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_credito_compra($cod,$comp,$tipo,$cant,$mon,$tcamb,$opera,$doc,$obs){
		$doc = trim($doc);
		$obs = trim($obs);
		$opera = trim($opera);
		//--
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO comp_credito ";
		$sql.= "VALUES ($cod,$comp,$tipo,$cant,$mon,$tcamb,'$opera','$doc','$fec',$usu,'$obs',1); ";
		//echo $sql;
		return $sql;
	}
		
	function max_credito_compra() {
		
        $sql = "SELECT max(cred_codigo) as max ";
		$sql.= " FROM comp_credito";
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	function total_credito_compra($comp,$tcambio) {
		
        $sql = "SELECT cred_monto,cred_tcambio";
		$sql.= " FROM comp_credito";
		$sql.= " WHERE cred_compra = $comp";
		//--
		$result = $this->exec_query($sql);
		$suma = 0;
		if(is_array($result)){
			foreach($result as $row){
				$cuanto = $row["cred_monto"];
				$de = $row["cred_tcambio"];
				//
				$dato = $de * $cuanto;
				$dato = $dato/$tcambio;
				$dato = number_format($dato, 2, '.', '');
				$suma += $dato;
			}
		}
		//echo $sql;
		return $suma;
	}
	
	function cambia_sit_credito_compra($cod,$comp,$sit){
		
		$sql = "UPDATE comp_credito SET ";
		$sql.= "cred_situacion = $sit"; 
				
		$sql.= " WHERE cred_codigo = $cod "; 	
		$sql.= " AND  cred_compra = $comp; "; 	
		
		return $sql;
	}
	
	function delete_credito_compra($comp) {
		
		$sql = "DELETE FROM comp_credito";
		$sql.= " WHERE cred_compra = $comp; "; 	
		//echo $sql;
		return $sql;
	}
		
		
}	
?>
