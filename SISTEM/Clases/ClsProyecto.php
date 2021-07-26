<?php
require_once ("ClsConex.php");

class ClsProyecto extends ClsConex{
/* Situacion 1 = PENDIENTE DE PAGO, Situacion 2 = PAGADA, 0 = INACTIVO */
   
//---------- Venta ---------//
/* Factura 1 = SI se emitio, 0 = No se emitio */
    function get_proyecto($cod,$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM vnt_proyecto,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = pro_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND pro_codigo = $cod"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_sucursal ASC, pro_pventa ASC, pro_codigo ASC, pro_fechor DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_proyecto($cod,$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_proyecto,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = pro_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND pro_codigo = $cod"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function insert_proyecto($cod,$cli,$pv,$suc,$fec,$vend,$subt,$desc,$tot,$mon,$tcamb,$sit) {
		//--
		$fec = $this->regresa_fecha($fec);
		$fechor = date("Y-m-d H:i:s");
		$caj = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO vnt_proyecto ";
		$sql.= "VALUES ($cod,$cli,$pv,$suc,$caj,'$fec','$fechor',$vend,$subt,$desc,$tot,$mon,$tcamb,$sit); ";
		//echo $sql;
		return $sql;
	}
		
	function cambia_sit_proyecto($cod,$sit){
		
		$sql = "UPDATE vnt_proyecto SET ";
		$sql.= "pro_situacion = $sit"; 
				
		$sql.= " WHERE pro_codigo = $cod; "; 	
		
		return $sql;
	}
	
	
	function devuelve_producto_proyecto($cod){
		
	    $sql = "SELECT det_lote, det_articulo, det_grupo, det_cantidad, inv_codigo";
	    $sql.= " FROM inv_inventario,inv_det_inventario,vnt_det_proyecto";
	    $sql.= " WHERE dpro_articulo = det_articulo";
	    $sql.= " AND dpro_grupo = det_grupo";
	    $sql.= " AND det_inventario = inv_codigo"; 
	    $sql.= " AND det_tipo = inv_tipo";
	    $sql.= " AND CAST(inv_documento AS SIGNED) = dpro_proyecto"; 
	    $sql.= " AND inv_tipo = 3";
	    $sql.= " AND inv_clase = 'V'";
	    $sql.= " AND dpro_proyecto = $cod";
	    
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
	
	
	function max_proyecto() {
		
        $sql = "SELECT max(pro_codigo) as max ";
		$sql.= " FROM vnt_proyecto";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

   //---------- Detalle de venta ---------//
    function get_det_proyecto($cod,$pro,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE pro_moneda = mon_id) as mon_simbolo_proyecto ";
		$sql.= " FROM vnt_proyecto,vnt_det_proyecto,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dpro_proyecto = pro_codigo";
		$sql.= " AND cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dpro_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dpro_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dpro_tipo = '$tipo'"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_sucursal ASC, pro_pventa ASC, pro_codigo ASC, dpro_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_det_proyecto($cod,$pro,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM vnt_proyecto,vnt_det_proyecto,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dpro_proyecto = pro_codigo";
		$sql.= " AND cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dpro_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dpro_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dpro_tipo = '$tipo'"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_det_proyecto_producto($cod,$pro,$tipo = '',$descar = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE pro_moneda = mon_id) as mon_simbolo_proyecto ";
		$sql.= " FROM vnt_proyecto,vnt_det_proyecto,inv_articulo,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dpro_proyecto = pro_codigo";
		$sql.= " AND dpro_grupo = art_grupo";
		$sql.= " AND dpro_articulo = art_codigo";
		$sql.= " AND cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = pro_moneda";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dpro_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dpro_tipo = '$tipo'"; 
		}
		if(strlen($descar)>0) { 
			  $sql.= " AND dpro_descarga = $descar"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_sucursal ASC, pro_pventa ASC, pro_codigo ASC, dpro_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_hist_proyecto_lotes($cod,$pro,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE pro_moneda = mon_id) as mon_simbolo_proyecto ";
		$sql.= " FROM vnt_proyecto,vnt_det_proyecto,inv_lote, inv_det_inventario, inv_inventario,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dpro_proyecto = pro_codigo";
		$sql.= " AND cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dpro_moneda";
		$sql.= " AND dpro_tipo = 'P'";
		//--
		$sql.= " AND dpro_articulo = lot_articulo"; 
		$sql.= " AND dpro_grupo = lot_grupo";
		$sql.= " AND det_inventario = inv_codigo"; 
		$sql.= " AND det_tipo = inv_tipo"; 
		$sql.= " AND det_lote = lot_codigo"; 
		$sql.= " AND det_articulo = lot_articulo"; 
		$sql.= " AND det_grupo = lot_grupo"; 
		$sql.= " AND inv_tipo = 2"; 
		$sql.= " AND inv_clase = 'V'"; 
		$sql.= " AND CAST(inv_documento AS SIGNED) = pro_codigo"; 
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dpro_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND lot_grupo = $tipo"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_sucursal ASC, pro_pventa ASC, pro_codigo ASC, dpro_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_hist_proyecto_servicios($cod,$pro,$tipo = '',$cli = '',$pv = '',$suc = '',$caj = '',$vend = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT mon_simbolo FROM fin_moneda WHERE pro_moneda = mon_id) as mon_simbolo_proyecto ";
		$sql.= " FROM vnt_proyecto,vnt_det_proyecto,inv_servicio,fin_cliente,mast_sucursal,vnt_punto_venta,fin_moneda";
		$sql.= " WHERE dpro_proyecto = pro_codigo";
		$sql.= " AND cli_id = pro_cliente";
		$sql.= " AND pv_codigo = pro_pventa";
		$sql.= " AND pv_sucursal = pro_sucursal";
		$sql.= " AND pv_sucursal = suc_id";
		$sql.= " AND mon_id = dpro_moneda";
		$sql.= " AND dpro_tipo = 'S'";
		//--
		$sql.= " AND dpro_articulo = ser_codigo"; 
		$sql.= " AND dpro_grupo = ser_grupo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dpro_codigo = $cod"; 
		}
		if(strlen($pro)>0) { 
			  $sql.= " AND pro_codigo = $pro"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND ser_grupo = $tipo"; 
		}
		if(strlen($cli)>0) { 
			  $sql.= " AND pro_cliente = $cli"; 
		}
		if(strlen($pv)>0) { 
			  $sql.= " AND pro_pventa = $pv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND pro_sucursal = $suc"; 
		}
		if(strlen($caj)>0) { 
			  $sql.= " AND pro_cajero = $caj"; 
		}
		if(strlen($vend)>0) { 
			  $sql.= " AND pro_vendedor = $vend"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND pro_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pro_situacion = $sit"; 
		}
		$sql.= " ORDER BY pro_sucursal ASC, pro_pventa ASC, pro_codigo ASC, dpro_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
		
	function insert_det_proyecto($cod,$pro,$tipo,$det,$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot,$descar){
		$det = trim($det);
		
		$sql = "INSERT INTO vnt_det_proyecto ";
		$sql.= " VALUES ($cod,$pro,'$tipo','$det',$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot,$descar); ";
		//echo $sql;
		return $sql;
	}
		
	function descargar_det_proyecto($pro,$desc,$art,$grup){
		
		$sql = "UPDATE vnt_det_proyecto SET ";
		$sql.= "dpro_descarga = $desc"; 
				
		$sql.= " WHERE dpro_proyecto = $pro"; 	
		$sql.= " AND dpro_articulo = $art "; 	
		$sql.= " AND dpro_grupo = $grup; "; 	
		
		return $sql;
	}

		
	function max_det_proyecto($pro) {
		
        $sql = "SELECT max(dpro_codigo) as max ";
		$sql.= " FROM vnt_det_proyecto";
		$sql.= " WHERE dpro_proyecto = $pro"; 
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
