<?php
require_once ("ClsConex.php");

class ClsCompra extends ClsConex{
/* Situacion 1 = PENDIENTE DE PAGO, Situacion 2 = PAGADA, 0 = INACTIVO */
   
//---------- Venta ---------//
/* Factura 1 = SI se emitio, 0 = No se emitio */
    function get_compra($cod,$tipo = '',$prov = '',$suc = '',$doc = '',$usu = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/com_tcambio FROM comp_pago WHERE com_codigo = pag_compra) as com_pagado ";
		$sql.= " FROM comp_compra,fin_proveedor,mast_sucursal,fin_moneda";
		$sql.= " WHERE prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = com_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND com_codigo = '$cod'"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND com_tipo = '$tipo'"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc like '%$doc%'"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND com_usuario = $usu"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY com_tipo ASC, com_sucursal ASC, com_fecha DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
		//return $sql;

	}
	
	function count_compra($cod,$tipo = '',$prov = '',$suc = '',$doc = '',$usu = '',$fini = '',$ffin = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM comp_compra,fin_proveedor,mast_sucursal,fin_moneda";
		$sql.= " WHERE prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = com_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND com_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND com_tipo = '$tipo'"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc like '%$doc%'"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND com_usuario = $usu"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN($sit)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_compra($cod,$prov,$tipo,$doc,$suc,$fec,$subt,$desc,$tot,$mon,$tcamb,$sit) {
		$tipo = trim($tipo);
		$doc = trim($doc);
		//--
		$fec = $this->regresa_fecha($fec);
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO comp_compra ";
		$sql.= "VALUES ($cod,$prov,'$tipo','$doc',$suc,$usu,'$fec','$fechor',$subt,$desc,$tot,$mon,$tcamb,$sit); ";
		//echo $sql;
		return $sql;
	}
		
	function cambia_sit_compra($cod,$sit){
		
		$sql = "UPDATE comp_compra SET ";
		$sql.= "com_situacion = $sit"; 
				
		$sql.= " WHERE com_codigo = $cod; "; 	
		
		return $sql;
	}
	
	
	function max_compra() {
		
        $sql = "SELECT max(com_codigo) as max ";
		$sql.= " FROM comp_compra";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

   //---------- Detalle de venta ---------//
    function get_det_compra($cod,$comp = '',$tipo = '',$prov = '',$suc = '',$doc = '',$usu = '',$fini = '',$ffin = '',$par = '',$reg = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/com_tcambio FROM comp_pago WHERE com_codigo = pag_compra) as com_pagado ";
		$sql.= " FROM comp_det_compra,comp_compra,fin_proveedor,mast_sucursal,fin_moneda,fin_partida,fin_reglon";
		$sql.= " WHERE dcom_compra = com_codigo";
		$sql.= " AND prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = dcom_moneda";
		$sql.= " AND reg_codigo = dcom_reglon";
		$sql.= " AND reg_partida = dcom_partida";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND dcom_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND com_codigo = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND com_tipo = '$tipo'"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc like '%$doc%'"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND com_usuario = $usu"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($par)>0) { 
			  $sql.= " AND dcom_partida = $par"; 
		}
		if(strlen($reg)>0) { 
			  $sql.= " AND dcom_reglon = $reg"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY com_tipo ASC, com_sucursal ASC, com_fecha ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_det_compra($cod,$comp = '',$tipo = '',$prov = '',$suc = '',$doc = '',$usu = '',$fini = '',$ffin = '',$par = '',$reg = '',$sit = '') {
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM comp_det_compra,comp_compra,fin_proveedor,mast_sucursal,fin_moneda,fin_partida,fin_reglon";
		$sql.= " WHERE dcom_compra = com_codigo";
		$sql.= " AND prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = dcom_moneda";
		$sql.= " AND reg_codigo = dcom_reglon";
		$sql.= " AND reg_partida = dcom_partida";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND dcom_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND com_codigo = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND com_tipo = '$tipo'"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc like '%$doc%'"; 
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND com_usuario = $usu"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($par)>0) { 
			  $sql.= " AND dcom_partida = $par"; 
		}
		if(strlen($reg)>0) { 
			  $sql.= " AND dcom_reglon = $reg"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN($sit)"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_det_compra_producto($cod,$comp = '',$tipo = '',$cargar = '',$prov = '',$suc = '',$doc = '',$usu = '',$fini = '',$ffin = '',$par = '',$reg = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/com_tcambio FROM comp_pago WHERE com_codigo = pag_compra) as com_pagado ";
		$sql.= " FROM comp_det_compra,comp_compra,fin_proveedor,mast_sucursal,fin_moneda,fin_partida,fin_reglon,inv_articulo";
		$sql.= " WHERE dcom_compra = com_codigo";
		$sql.= " AND prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = dcom_moneda";
		$sql.= " AND reg_codigo = dcom_reglon";
		$sql.= " AND reg_partida = dcom_partida";
		$sql.= " AND reg_partida = par_codigo";
		$sql.= " AND dcom_grupo = art_grupo";
		$sql.= " AND dcom_articulo = art_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dcom_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND com_codigo = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dcom_tipo = '$tipo'"; 
		}
		if(strlen($cargar)>0) { 
			  $sql.= " AND dcom_carga = $cargar"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc like '%$doc%'";  
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND com_usuario = $usu"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($par)>0) { 
			  $sql.= " AND dcom_partida = $par"; 
		}
		if(strlen($reg)>0) { 
			  $sql.= " AND dcom_reglon = $reg"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY com_tipo ASC, com_sucursal ASC, dcom_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_det_compra_suministro($cod,$comp = '',$tipo = '',$cargar = '',$prov = '',$suc = '',$doc = '',$usu = '',$fini = '',$ffin = '',$par = '',$reg = '',$sit = '') {
		
        $sql= "SELECT *, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/com_tcambio FROM comp_pago WHERE com_codigo = pag_compra) as com_pagado ";
		$sql.= " FROM comp_det_compra,comp_compra,fin_proveedor,mast_sucursal,fin_moneda,fin_partida,fin_reglon,inv_articulo_suministro";
		$sql.= " WHERE dcom_compra = com_codigo";
		$sql.= " AND prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = dcom_moneda";
		$sql.= " AND reg_codigo = dcom_reglon";
		$sql.= " AND reg_partida = dcom_partida";
		$sql.= " AND reg_partida = par_codigo";
		$sql.= " AND dcom_grupo = art_grupo";
		$sql.= " AND dcom_articulo = art_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND dcom_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND com_codigo = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND dcom_tipo = '$tipo'"; 
		}
		if(strlen($cargar)>0) { 
			  $sql.= " AND dcom_carga = $cargar"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND com_doc like '%$doc%'";  
		}
		if(strlen($usu)>0) { 
			  $sql.= " AND com_usuario = $usu"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($par)>0) { 
			  $sql.= " AND dcom_partida = $par"; 
		}
		if(strlen($reg)>0) { 
			  $sql.= " AND dcom_reglon = $reg"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY com_tipo ASC, com_sucursal ASC, com_codigo ASC, dcom_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
////// Lista los productos que ha vendido un proveedor ordenados por la frecuencia con que vende el producto y promedia la cantidad que vende de cada articulo	
	function get_productos_proveedor($comp = '',$tipo_compra = '',$tipo_productos = '',$prov = '',$suc = '') { 
		
        $sql= "SELECT *, AVG(dcom_cantidad) as dcom_cantidad_promedio, COUNT(dcom_articulo) as dcom_frecuencia ";
		$sql.= " FROM comp_det_compra,comp_compra,fin_proveedor,mast_sucursal,fin_moneda,fin_partida,fin_reglon";
		$sql.= " WHERE dcom_compra = com_codigo";
		$sql.= " AND prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = dcom_moneda";
		$sql.= " AND reg_codigo = dcom_reglon";
		$sql.= " AND reg_partida = dcom_partida";
		$sql.= " AND reg_partida = par_codigo";
		$sql.= " AND com_situacion <> 0"; 
		if(strlen($comp)>0) { 
			  $sql.= " AND com_codigo = $comp"; 
		}
		if(strlen($tipo_compra)>0) { 
			  $sql.= " AND com_tipo = '$tipo_compra'"; 
		}
		if(strlen($tipo_productos)>0) { 
			  $sql.= " AND dcom_tipo = '$tipo_productos'"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND com_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		$sql.= " GROUP BY dcom_tipo, dcom_grupo, dcom_articulo";
		$sql.= " ORDER BY dcom_frecuencia DESC, dcom_grupo ASC, dcom_articulo ASC, dcom_cantidad ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
		
	function insert_det_compra($cod,$comp,$tipo,$reg,$par,$det,$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot,$carga){
		$det = trim($det);
		
		$sql = "INSERT INTO comp_det_compra ";
		$sql.= " VALUES ($cod,$comp,'$tipo',$reg,$par,'$det',$art,$grup,$cant,$prec,$mon,$tcamb,$subt,$desc,$tot,$carga); ";
		//echo $sql;
		return $sql;
	}
		
	function cargar_det_compra($comp,$carga,$art,$grup){
		
		$sql = "UPDATE comp_det_compra SET ";
		$sql.= "dcom_carga = $carga"; 
				
		$sql.= " WHERE dcom_compra = $comp"; 	
		$sql.= " AND dcom_articulo = $art "; 	
		$sql.= " AND dcom_grupo = $grup; "; 	
		
		return $sql;
	}

		
	function max_det_compra($comp) {
		
        $sql = "SELECT max(dcom_codigo) as max ";
		$sql.= " FROM comp_det_compra";
		$sql.= " WHERE dcom_compra = $comp"; 
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////// DETALLE TEMPORAL DE COMPRAS  ///////////////////////
	//---------- Detalle Temporal de compras ---------//
    
    function get_detalle_temporal($clase,$suc,$codigo = '',$tipo = ''){
		
		$sql= "SELECT *";
		$sql.= " FROM comp_detalle_temporal,fin_moneda";
		$sql.= " WHERE mon_id = dcomtemp_moneda";
		$sql.= " AND dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc";
		if(strlen($codigo)>0) { 
			$sql.= " AND dcomtemp_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND dcomtemp_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY dcomtemp_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_detalle_temporal($clase,$suc,$codigo = '',$tipo = ''){
		
		$sql= "SELECT COUNT(dcomtemp_codigo) as total";
		$sql.= " FROM comp_detalle_temporal,fin_moneda";
		$sql.= " WHERE mon_id = dcomtemp_moneda";
		$sql.= " AND dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc";
		if(strlen($codigo)>0) { 
			$sql.= " AND dcomtemp_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND dcomtemp_tipo = '$tipo'"; 
		}
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row["total"];
		}
		//echo $sql;
		return $total;

	}

		
	function insert_detalle_temporal($cod,$clase,$suc,$tipo,$reglon,$partida,$detalle,$art,$grupo,$cantidad,$precio,$moneda,$tcambio,$subtotal,$descuento,$total){
		$det = trim($det);
		
		$sql = "INSERT INTO comp_detalle_temporal ";
		$sql.= " VALUES ($cod,'$clase','$suc','$tipo','$reglon','$partida','$detalle','$art','$grupo','$cantidad','$precio','$moneda','$tcambio','$subtotal','$descuento','$total'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_item_detalle_temporal($cod,$clase,$suc,$cantidad,$precio,$moneda,$tcambio,$subtotal,$descuento,$total) { //Elimina un item o una fila
		
        $sql = "UPDATE comp_detalle_temporal SET ";
		$sql.= " dcomtemp_cantidad = '$cantidad',";
		$sql.= " dcomtemp_precio = '$precio',";
		$sql.= " dcomtemp_moneda = '$moneda',";
		$sql.= " dcomtemp_tcambio = '$tcambio',";
		$sql.= " dcomtemp_subtotal = '$subtotal',";
		$sql.= " dcomtemp_descuento = '$descuento',";
		$sql.= " dcomtemp_total = '$total'";
		
		$sql.= " WHERE dcomtemp_codigo = $cod";
		$sql.= " AND dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc;";
		//echo $sql;
		return $sql;
	}
    
    
    function delete_item_detalle_temporal($cod,$clase,$suc) { //Elimina un item o una fila
		
        $sql = "DELETE FROM comp_detalle_temporal";
		$sql.= " WHERE dcomtemp_codigo = $cod";
		$sql.= " AND dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc;";
		//echo $sql;
		return $sql;
	}
    
    
    function delete_detalle_temporal($clase,$suc) { ///Limpia todo el detalle (elimina todas las filas)
		
        $sql = "DELETE FROM comp_detalle_temporal";
		$sql.= " WHERE dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc;";
		//echo $sql;
		return $sql;
	}

		
	function max_detalle_temporal($clase,$suc) {
		
        $sql = "SELECT max(dcomtemp_codigo) as max ";
		$sql.= " FROM comp_detalle_temporal";
		$sql.= " WHERE dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc";
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
	
	
	function insert_detalle_desde_temporal($compra,$clase,$suc){
		
		$sql.= "INSERT INTO comp_det_compra (dcom_codigo, dcom_compra, dcom_tipo, dcom_reglon, dcom_partida, dcom_detalle, dcom_articulo, dcom_grupo, dcom_cantidad, dcom_precio, dcom_moneda, dcom_tcambio, dcom_subtotal, dcom_descuento, dcom_total, dcom_carga)";
		$sql.= " SELECT dcomtemp_codigo, $compra, dcomtemp_tipo, dcomtemp_reglon, dcomtemp_partida, dcomtemp_detalle, dcomtemp_articulo, dcomtemp_grupo, dcomtemp_cantidad, dcomtemp_precio, dcomtemp_moneda, dcomtemp_tcambio, dcomtemp_subtotal, dcomtemp_descuento, dcomtemp_total, 0";
		$sql.= " FROM comp_detalle_temporal";
		$sql.= " WHERE dcomtemp_clase = '$clase'";
		$sql.= " AND dcomtemp_sucursal = $suc;";
		//echo $sql;
		return $sql;
	}
	
	
/////////////////// ESTADISTICAS DE PRESUPUESTOS ////////////

	function get_compra_estadisticas($cod,$comp,$tipo = '',$suc = '',$mes = '', $anio = '',$fini = '',$ffin = '',$par = '',$reg = '',$sit = ''){
		
	    $sql= "SELECT *, ";
		$sql.= "(SELECT SUM(pag_tcambio * pag_monto)/com_tcambio FROM comp_pago WHERE com_codigo = pag_compra) as com_pagado ";
		$sql.= " FROM comp_det_compra,comp_compra,fin_proveedor,mast_sucursal,fin_moneda,fin_partida,fin_reglon";
		$sql.= " WHERE dcom_compra = com_codigo";
		$sql.= " AND prov_id = com_proveedor";
		$sql.= " AND com_sucursal = suc_id";
		$sql.= " AND mon_id = dcom_moneda";
		$sql.= " AND reg_codigo = dcom_reglon";
		$sql.= " AND reg_partida = dcom_partida";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND dcom_codigo = $cod"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND com_codigo = $comp"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND com_tipo = '$tipo'"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND com_sucursal = $suc"; 
		}
		if(strlen($mes)>0) { 
			  $sql.= " AND MONTH(com_fecha) = $mes"; 
		}
		if(strlen($anio)>0) { 
			  $sql.= " AND YEAR(com_fecha) = $anio"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND com_fecha BETWEEN '$fini' AND '$ffin'"; 
		}
		if(strlen($par)>0) { 
			  $sql.= " AND dcom_partida = $par"; 
		}
		if(strlen($reg)>0) { 
			  $sql.= " AND dcom_reglon = $reg"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND com_situacion IN ($sit)"; 
		}
		$sql.= " ORDER BY dcom_partida ASC, dcom_reglon ASC, com_sucursal ASC, dcom_codigo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}	

}	
?>
