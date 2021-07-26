<?php
require_once ("ClsConex.php");

class ClsVenta extends ClsConex{
/* Situacion 1 = PENDIENTE DE PAGO, Situacion 2 = PAGADA, 0 = INACTIVO */
   
//---------- Venta ---------//
/* Factura 1 = SI se emitio, 0 = No se emitio */
    function get_venta($cod,$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT ser_codigo FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_codigo, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/ven_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta) as ven_pagado ";
		$sql.= " FROM vnt_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND ven_codigo IN($cod)"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, ven_fechor DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_venta($cod,$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND ven_codigo = $cod"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
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
	
	
	function get_ventas_varias($ventas) {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT ser_codigo FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_codigo, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/ven_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta) as ven_pagado ";
		$sql.= " FROM vnt_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($ventas)>0) { 
			$sql.= " AND ven_codigo IN($ventas)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, ven_fechor DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_ventas_pagos($cod,$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT ser_codigo FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_codigo, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 1) as ven_pago_efectivo, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 1 LIMIT 0,1) as ven_pago_moneda_efectivo, ";
		$sql.= "(SELECT pag_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 1 LIMIT 0,1) as ven_tcambio_efectivo, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 2) as ven_pago_tarjeta, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 2 LIMIT 0,1) as ven_pago_moneda_tarjeta, ";
		$sql.= "(SELECT pag_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 2 LIMIT 0,1) as ven_tcambio_tarjeta, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 4) as ven_pago_cheque, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 4 LIMIT 0,1) as ven_pago_moneda_cheque, ";
		$sql.= "(SELECT pag_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 4 LIMIT 0,1) as ven_tcambio_cheque, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 5) as ven_pago_credito, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 5 LIMIT 0,1) as ven_pago_moneda_credito, ";
		$sql.= "(SELECT pag_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 5 LIMIT 0,1) as ven_tcambio_credito, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/ven_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta) as ven_pagado ";
		$sql.= " FROM vnt_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND ven_codigo = $cod"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, ven_fechor DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
		
	
	function insert_venta($cod,$fac,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$tot,$mon,$tcamb,$sit) {
		//--
		$fec = $this->regresa_fecha($fec);
		$fechor = date("Y-m-d H:i:s");
		$caj = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_venta ";
		$sql.= "VALUES ($cod,$fac,$cli,$pv,$suc,$caj,'$fec','$fechor',$vend,$subt,$desc,$tot,$mon,$tcamb,$sit); ";
		//echo $sql;
		return $sql;
	}
		
	function cambia_sit_venta($cod,$sit){
		
		$sql = "UPDATE vnt_venta SET ";
		$sql.= "ven_situacion = $sit"; 
				
		$sql.= " WHERE ven_codigo = $cod; "; 	
		
		return $sql;
	}
	
	
	function devuelve_producto_venta($cod){
		
	    $sql = "SELECT det_lote, det_articulo, det_grupo, det_cantidad, inv_codigo";
	    $sql.= " FROM inv_inventario,inv_det_inventario,vnt_det_venta";
	    $sql.= " WHERE dven_articulo = det_articulo";
	    $sql.= " AND dven_grupo = det_grupo";
	    $sql.= " AND det_inventario = inv_codigo"; 
	    $sql.= " AND det_tipo = inv_tipo";
	    $sql.= " AND CAST(inv_documento AS SIGNED) = dven_venta"; 
	    $sql.= " AND inv_tipo = 2";
	    $sql.= " AND inv_clase = 'V'";
	    $sql.= " AND dven_venta = $cod";
	    
	    $result = $this->exec_query($sql);
		$sql="";
		if(is_array($result)){
		    foreach($result as $row){
			    $lot = $row['det_lote'];
			    $art = $row['det_articulo'];
			    $gru = $row['det_grupo'];
			    $cant = $row['det_cantidad'];
			    $inv = $row['inv_codigo'];
			$sql.= "UPDATE inv_lote";
			$sql.= " SET lot_cantidad = lot_cantidad + $cant";
			$sql.= " WHERE lot_codigo = $lot";
			$sql.= " AND lot_articulo = $art";
			$sql.= " AND lot_grupo = $gru;";
		    }
		    $sql.= "UPDATE inv_inventario";
		    $sql.= " SET inv_situacion = 0";
		    $sql.= " WHERE inv_codigo = $inv";
		    $sql.= " AND inv_tipo = 2";
		    $sql.= " AND inv_clase = 'V';";
		    
		}
		return $sql;
	}
	
	function cambia_cliente_venta($cod,$cli){
		
		$sql = "UPDATE vnt_venta SET ";
		$sql.= "ven_cliente = $cli"; 
				
		$sql.= " WHERE ven_codigo = $cod; "; 	
		
		return $sql;
	}
	
	
	function max_venta() {
		
        $sql = "SELECT max(ven_codigo) as max ";
		$sql.= " FROM vnt_venta";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

   //---------- Detalle de venta ---------//
    function get_det_venta($cod,$ven,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
		$sql= "SELECT *, "; 
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dven_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo IN($ven)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dven_tipo = '$tipo'"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_det_venta($cod,$ven,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_venta,vnt_det_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dven_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo IN($ven)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dven_tipo = '$tipo'"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
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
	
	function get_det_venta_producto($cod,$ven,$tipo = '',$descar = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,inv_articulo,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND dven_grupo = art_grupo";
		$sql.= " AND dven_articulo = art_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dven_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dven_tipo = '$tipo'"; 
		}
		if(strlen($descar)>0) { 
			  $sql.= " AND dven_descarga = $descar"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_hist_venta_lotes($cod,$ven,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
		$sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,inv_lote, inv_det_inventario, inv_inventario,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		$sql.= " AND dven_tipo = 'P'";
		//--
		$sql.= " AND dven_articulo = lot_articulo"; 
		$sql.= " AND dven_grupo = lot_grupo";
		$sql.= " AND det_inventario = inv_codigo"; 
		$sql.= " AND det_tipo = inv_tipo"; 
		$sql.= " AND det_lote = lot_codigo"; 
		$sql.= " AND det_articulo = lot_articulo"; 
		$sql.= " AND det_grupo = lot_grupo"; 
		$sql.= " AND inv_tipo = 2"; 
		$sql.= " AND inv_clase = 'V'"; 
		$sql.= " AND CAST(inv_documento AS SIGNED) = ven_codigo"; 
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dven_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND lot_grupo = $tipo"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN ($sit)"; 
		}
        $sql.= " GROUP BY ven_codigo, dven_codigo";
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		//echo "<br>";
		return $result;

	}
	
	function get_hist_venta_servicios($cod,$ven,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
	    $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,inv_servicio,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		$sql.= " AND dven_tipo = 'S'";
		//--
		$sql.= " AND dven_articulo = ser_codigo"; 
		$sql.= " AND dven_grupo = ser_grupo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dven_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ser_grupo = $tipo"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN ($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_det_ventas_pagos($ven,$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$fac = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT ser_codigo FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_codigo, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 1) as ven_pago_efectivo, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 1 LIMIT 0,1) as ven_pago_moneda_efectivo, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 2) as ven_pago_tarjeta, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 2 LIMIT 0,1) as ven_pago_moneda_tarjeta, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 4) as ven_pago_cheque, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 4 LIMIT 0,1) as ven_pago_moneda_cheque, ";
		$sql.= "(SELECT SUM(pag_monto) FROM vnt_pago WHERE ven_codigo = pag_venta AND pag_tipo_pago = 5) as ven_pago_credito, ";
		$sql.= "(SELECT mon_simbolo FROM vnt_pago,fin_moneda WHERE ven_codigo = pag_venta AND mon_id = pag_moneda AND pag_tipo_pago = 5 LIMIT 0,1) as ven_pago_moneda_credito, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/ven_tcambio FROM vnt_pago WHERE ven_codigo = pag_venta) as ven_pagado, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo IN($ven)"; 
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
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	//////////// DETALES DE VENTAS POR REGLONES //////////////////////////////////////////////////////////
	
	function get_det_reglon_producto($tipo = '',$grupo = '',$pv = '',$suc = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,inv_articulo,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND dven_grupo = art_grupo";
		$sql.= " AND dven_articulo = art_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($tipo)>0) { 
			$sql.= " AND dven_tipo = '$tipo'"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND dven_grupo = '$grupo'"; 
		}
		if(strlen($pv)>0) { 
			$sql.= " AND ven_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			$sql.= " AND ven_sucursal = $suc"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			$sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_det_reglon_servicios($tipo = '',$grupo = '',$pv = '',$suc = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT fac_numero FROM vnt_factura_venta,vnt_factura WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_situacion = 1) as ven_fac_numero, ";
		$sql.= "(SELECT ser_numero FROM vnt_factura_venta,vnt_factura,vnt_serie WHERE fv_venta = ven_codigo AND fac_serie = fv_serie AND fac_numero = fv_numero AND fac_serie = ser_codigo AND fac_situacion = 1) as ven_ser_numero, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE ven_moneda = mon_id) as mon_simbolo_venta ";
		$sql.= " FROM vnt_venta,vnt_det_venta,inv_servicio,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND dven_grupo = ser_grupo";
		$sql.= " AND dven_articulo = ser_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = ven_moneda";
		if(strlen($tipo)>0) { 
			$sql.= " AND dven_tipo = '$tipo'"; 
		}
		if(strlen($grupo)>0) { 
			$sql.= " AND dven_grupo = '$grupo'"; 
		}
		if(strlen($pv)>0) { 
			$sql.= " AND ven_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			$sql.= " AND ven_sucursal = $suc"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			$sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		
	function insert_det_venta($cod,$ven,$tipo,$det,$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot,$descar){
		$det = trim($det);
		
		$sql = "INSERT INTO vnt_det_venta ";
		$sql.= " VALUES ($cod,$ven,'$tipo','$det',$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot,$descar); ";
		//echo $sql;
		return $sql;
	}
		
	function descargar_det_venta($vent,$desc,$art,$grup){
		
		$sql = "UPDATE vnt_det_venta SET ";
		$sql.= "dven_descarga = $desc"; 
				
		$sql.= " WHERE dven_venta = $vent"; 	
		$sql.= " AND dven_articulo = $art "; 	
		$sql.= " AND dven_grupo = $grup; "; 	
		
		return $sql;
	}

		
	function max_det_venta($ven) {
		
        $sql = "SELECT max(dven_codigo) as max ";
		$sql.= " FROM vnt_det_venta";
		$sql.= " WHERE dven_venta = $ven"; 
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	

	////// Lista los productos que ha vendido un cliente ordenados por la frecuencia con que vende el producto y promedia la cantidad que vende de cada articulo	
	function get_productos_cliente($vent = '',$cli = '',$suc = '') { 
		
        $sql= "SELECT *, AVG(dven_cantidad) as dven_cantidad_promedio, COUNT(dven_articulo) as dven_frecuencia ";
		$sql.= " FROM vnt_det_venta,vnt_venta,fin_cliente,mast_sucursal,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND ven_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		$sql.= " AND ven_situacion <> 0"; 
		if(strlen($vent)>0) { 
			  $sql.= " AND ven_codigo = $vent"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND ven_cliente = $cli"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND ven_sucursal = $suc"; 
		}
		$sql.= " GROUP BY dven_tipo, dven_grupo, dven_articulo";
		$sql.= " ORDER BY dven_frecuencia DESC, dven_grupo ASC, dven_articulo ASC, dven_cantidad ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

	
/////////////////// DETALLE TEMPORAL DE VENTAS  ///////////////////////
	//---------- Detalle Temporal de venta ---------//
    function get_detalle_temporal($pv,$suc,$codigo = '',$tipo = ''){
		
		$sql= "SELECT *";
		$sql.= " FROM vnt_detalle_temporal,fin_moneda";
		$sql.= " WHERE mon_id = dventemp_moneda";
		$sql.= " AND dventemp_pventa = $pv";
		$sql.= " AND dventemp_sucursal = $suc";
		if(strlen($codigo)>0) { 
			$sql.= " AND dventemp_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND dventemp_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY dventemp_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_detalle_temporal($pv,$suc,$codigo = '',$tipo = ''){
		
		$sql= "SELECT COUNT(dventemp_codigo) as total";
		$sql.= " FROM vnt_detalle_temporal,fin_moneda";
		$sql.= " WHERE mon_id = dventemp_moneda";
		$sql.= " AND dventemp_pventa = $pv";
		$sql.= " AND dventemp_sucursal = $suc";
		if(strlen($codigo)>0) { 
			$sql.= " AND dventemp_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND dventemp_tipo = '$tipo'"; 
		}
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row["total"];
		}
		//echo $sql;
		return $total;

	}

		
	function insert_detalle_temporal($cod,$pv,$suc,$tipo,$det,$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot){
		$det = trim($det);
		
		$sql = "INSERT INTO vnt_detalle_temporal ";
		$sql.= " VALUES ($cod,$pv,$suc,'$tipo','$det',$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot); ";
		//echo $sql;
		return $sql;
	}
    
    
    function delete_item_detalle_temporal($cod,$pv,$suc) { //Elimina un item o una fila
		
        $sql = "DELETE FROM vnt_detalle_temporal";
		$sql.= " WHERE dventemp_codigo = $cod";
		$sql.= " AND dventemp_pventa = $pv";
		$sql.= " AND dventemp_sucursal = $suc;";
		//echo $sql;
		return $sql;
	}
    
    
    function delete_detalle_temporal($pv,$suc) { ///Limpia todo el detalle (elimina todas las filas)
		
        $sql = "DELETE FROM vnt_detalle_temporal";
		$sql.= " WHERE dventemp_pventa = $pv";
		$sql.= " AND dventemp_sucursal = $suc;";
		//echo $sql;
		return $sql;
	}

		
	function max_detalle_temporal($pv,$suc) {
		
        $sql = "SELECT max(dventemp_codigo) as max ";
		$sql.= " FROM vnt_detalle_temporal";
		$sql.= " WHERE dventemp_pventa = $pv";
		$sql.= " AND dventemp_sucursal = $suc";
		//--
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$max = $row["max"];
			}
		}
		//echo $sql;
		return $max;
	}
	
	
	function insert_detalle_desde_temporal($venta,$pv,$suc){
		
		$sql.= "INSERT INTO vnt_det_venta (dven_codigo, dven_venta, dven_tipo, dven_detalle, dven_articulo, dven_grupo, dven_cantidad, dven_precio, dven_moneda, dven_tcambio, dven_subtotal, dven_descuento, dven_total, dven_descarga)";
		$sql.= " SELECT dventemp_codigo, $venta, dventemp_tipo, dventemp_detalle, dventemp_articulo, dventemp_grupo, dventemp_cantidad, dventemp_precio, dventemp_moneda, dventemp_tcambio, dventemp_subtotal, dventemp_descuento, dventemp_total, 0";
		$sql.= " FROM vnt_detalle_temporal";
		$sql.= " WHERE dventemp_pventa = '$pv'";
		$sql.= " AND dventemp_sucursal = '$suc';";
		//echo $sql;
		return $sql;
	}


	
	
/////////////////// ESTADISTICAS DE PRESUPUESTOS ////////////

	function get_venta_estadisticas($cod,$ven,$tipo = '',$grupo = '',$pv = '',$suc = '',$caj = '',$vend = '',$mes = '', $anio = '',$fini = '',$ffin = '',$fac = '',$sit = ''){
		
	    $sql= "SELECT *, ";
		$sql.= "(SELECT gru_nombre FROM inv_grupo_servicios WHERE dven_grupo = gru_codigo) as ven_grupo_servicios, ";
		$sql.= "(SELECT gru_nombre FROM inv_grupo_articulos WHERE dven_grupo = gru_codigo) as ven_grupo_productos ";
		$sql.= " FROM vnt_venta,vnt_det_venta,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dven_venta = ven_codigo";
		$sql.= " AND cli_id = ven_cliente";
		$sql.= " AND pv_codigo = ven_pventa";
		$sql.= " AND pv_sucursal = ven_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dven_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dven_codigo = $cod"; 
		}
		if(strlen($ven)>0) { 
			  $sql.= " AND ven_codigo = $ven"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dven_tipo = '$tipo'"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND dven_grupo = $grupo"; 
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
		if(strlen($mes)>0) { 
			  $sql.= " AND MONTH(ven_fecha) = $mes"; 
		}
		if(strlen($anio)>0) { 
			  $sql.= " AND YEAR(ven_fecha) = $anio"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND ven_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($fac)>0) { 
			  $sql.= " AND ven_factura = $fac"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ven_situacion IN ($sit)"; 
		}
		$sql.= " ORDER BY dven_grupo ASC, dven_articulo ASC, ven_sucursal ASC, ven_pventa ASC, ven_codigo ASC, dven_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}

}	
?>
