<?php
require_once ("ClsConex.php");

class ClsInventarioSuministro extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- Inventario ---------//
/* Tipo 1 = Ingreso, 2 = Egreso */
/* Clase C = COMPRA, P = PRODUCCIÓN, D = DONACIÓN, V = VENTA, D2 = DESCARGA POR DESECHO */
    function get_inventario($cod,$tipo = '',$clase = '',$doc = '',$suc = '',$quien = '',$fini = '',$ffin = '',$sit = '') {
		$tipo = trim($tipo);
		$clase = trim($clase);
		$doc = trim($doc);
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_inventario_suministro,mast_sucursal";
		$sql.= " WHERE inv_sucursal = suc_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND inv_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND inv_tipo = $tipo"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND inv_clase = '$clase'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND inv_documento = $doc"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND inv_sucursal = $suc"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND inv_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND inv_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND inv_situacion = $sit"; 
		}
		$sql.= " ORDER BY inv_tipo ASC, inv_codigo ASC, inv_fechor DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_inventario($cod,$tipo = '',$clase = '',$doc = '',$suc = '',$quien = '',$fini = '',$ffin = '',$sit = '') {
		$tipo = trim($tipo);
		$clase = trim($clase);
		$doc = trim($doc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_inventario_suministro,mast_sucursal";
		$sql.= " WHERE inv_sucursal = suc_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND inv_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND inv_tipo = $tipo"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND inv_clase = '$clase'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND inv_documento = $doc"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND inv_sucursal = $suc"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND inv_quien = $quien"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND inv_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND inv_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_inventario($cod,$tipo,$clase,$doc,$suc,$fec,$sit) {
		$tipo = trim($tipo);
		$clase = trim($clase);
		$doc = trim($doc);
		//--
		$fec = $this->regresa_fecha($fec);
		$hor = date("H:i:s");
		$fecha = "$fec $hor";
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO inv_inventario_suministro (inv_codigo,inv_tipo,inv_clase,inv_documento,inv_sucursal,inv_quien,inv_fechor,inv_situacion)";
		$sql.= " VALUES ($cod,$tipo,'$clase','$doc',$suc,$usu,'$fecha',$sit); ";
		//echo $sql;
		return $sql;
	}
		
	function cambia_sit_inventario($cod,$tipo,$sit){
		
		$sql = "UPDATE inv_inventario_suministro SET ";
		$sql.= "inv_situacion = $sit"; 
				
		$sql.= " WHERE inv_codigo = $cod"; 	
		$sql.= " AND inv_tipo = $tipo; "; 	
		
		return $sql;
	}
	
	function devuelve_producto_inventario($cod,$tipo,$sit){
		
	    $sql = "SELECT det_lote, det_articulo, det_grupo, det_cantidad";
	    $sql.= " FROM inv_inventario_suministro,inv_det_inventario_suministro";
	    $sql.= " WHERE det_inventario = inv_codigo"; 
	    $sql.= " AND det_tipo = inv_tipo";
	    $sql.= " AND inv_tipo = $tipo";
	    $sql.= " AND inv_codigo = $cod";
	    
	    $signo = ($sit == 1)?" + ":" - ";
	    $result = $this->exec_query($sql);
		$sql="";
		if(is_array($result)){
		    foreach($result as $row){
			    $lot = $row['det_lote'];
			    $art = $row['det_articulo'];
			    $gru = $row['det_grupo'];
			    $cant = $row['det_cantidad'];
			$sql.= "UPDATE inv_lote_suministro";
			$sql.= " SET lot_cantidad = lot_cantidad $signo $cant";
			$sql.= " WHERE lot_codigo = $lot";
			$sql.= " AND lot_articulo = $art";
			$sql.= " AND lot_grupo = $gru;";
		    }
		}
		return $sql;
	}
	
	
	function max_inventario($tipo) {
		
        $sql = "SELECT max(inv_codigo) as max ";
		$sql.= " FROM inv_inventario_suministro";
		$sql.= " WHERE inv_tipo = $tipo; ";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

   //---------- Detalle de Inventario ---------//
    function get_det_inventario($cod,$inv,$tipo,$grup = '',$art = '',$lote = '',$suc = '',$clase = '',$doc = '',$fini = '',$ffin = '',$sit = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_inventario_suministro, inv_det_inventario_suministro, inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, inv_unidad_medida, fin_proveedor";
		$sql.= " WHERE det_inventario = inv_codigo";
		$sql.= " AND art_grupo = gru_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND lot_proveedor = prov_id";
		$sql.= " AND det_grupo = lot_grupo";
		$sql.= " AND det_articulo = lot_articulo";
		$sql.= " AND det_lote = lot_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
		if(strlen($cod)>0) { 
			  $sql.= " AND det_codigo = $cod"; 
		}
		if(strlen($inv)>0) { 
			  $sql.= " AND det_inventario = $inv"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND inv_tipo = $tipo";
			  $sql.= " AND det_tipo = $tipo"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND det_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND det_articulo = $art"; 
		}
		if(strlen($lote)>0) { 
			  $sql.= " AND det_lote = $lote"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND lot_sucursal = $suc"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND inv_clase = '$clase'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND inv_documento = $doc"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND inv_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND inv_situacion = $sit"; 
		}
		$sql.= " ORDER BY det_inventario ASC,det_tipo ASC,det_codigo ASC,det_grupo ASC,det_articulo ASC,det_lote ASC,det_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_det_inventario($cod,$inv,$tipo,$grup = '',$art = '',$lote = '',$suc = '',$clase = '',$doc = '',$fini = '',$ffin = '',$sit = ''){
		$nom = trim($nom);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_inventario_suministro, inv_det_inventario_suministro, inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, inv_unidad_medida, fin_proveedor";
		$sql.= " WHERE det_inventario = inv_codigo";
		$sql.= " AND art_grupo = gru_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND lot_proveedor = prov_id";
		$sql.= " AND det_grupo = lot_grupo";
		$sql.= " AND det_articulo = lot_articulo";
		$sql.= " AND det_lote = lot_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
		if(strlen($cod)>0) { 
			  $sql.= " AND det_codigo = $cod"; 
		}
		if(strlen($inv)>0) { 
			  $sql.= " AND det_inventario = $inv"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND inv_tipo = $tipo";
			  $sql.= " AND det_tipo = $tipo"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND det_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND det_articulo = $art"; 
		}
		if(strlen($lote)>0) { 
			  $sql.= " AND det_lote = $lote"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND lot_sucursal = $suc"; 
		}
		if(strlen($clase)>0) { 
			  $sql.= " AND inv_clase = '$clase'"; 
		}
		if(strlen($doc)>0) { 
			  $sql.= " AND inv_documento = $doc"; 
		}
		if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND inv_fechor BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND inv_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function get_det_inventario_kardex($art = '',$grup = '',$suc = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_inventario_suministro, inv_det_inventario_suministro, inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, inv_unidad_medida, fin_proveedor, fin_moneda, mast_sucursal";
		$sql.= " WHERE det_inventario = inv_codigo";
		$sql.= " AND det_tipo = inv_tipo";
		$sql.= " AND art_grupo = gru_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND lot_sucursal = suc_id";
		$sql.= " AND lot_proveedor = prov_id";
		$sql.= " AND det_grupo = lot_grupo";
		$sql.= " AND det_articulo = lot_articulo";
		$sql.= " AND det_lote = lot_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
		$sql.= " AND art_moneda = mon_id";
		
		if(strlen($grup)>0) { 
			  $sql.= " AND det_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND det_articulo = $art"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND lot_sucursal = $suc"; 
		}
		$sql.= " ORDER BY lot_sucursal ASC, inv_fechor ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
		
	function insert_det_inventario($cod,$inv,$tipo,$grup,$art,$lote,$cant){
		$nom = trim($nom);
		
		$sql = "INSERT INTO inv_det_inventario_suministro (det_codigo,det_inventario,det_tipo,det_grupo,det_articulo,det_lote,det_cantidad)";
		$sql.= " VALUES ($cod,$inv,$tipo,$grup,$art,$lote,$cant); ";
		//echo $sql;
		return $sql;
	}
		
	function max_det_inventario($inv,$tipo) {
		
        $sql = "SELECT max(det_codigo) as max ";
		$sql.= " FROM inv_det_inventario_suministro";
		$sql.= " WHERE det_inventario = $inv"; 
		$sql.= " AND det_tipo = $tipo"; 
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	
	//---------- Costos ---------//
    function get_costo($cod,$lot = '',$art = '',$gru = '',$comp = '',$mon = '',$sit = ''){
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_costos, inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, fin_moneda, comp_compra, comp_det_compra";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND cos_compra = com_codigo";
		$sql.= " AND cos_grupo = lot_grupo";
		$sql.= " AND cos_articulo = lot_articulo";
		$sql.= " AND cos_lote = lot_codigo";
		$sql.= " AND com_codigo = dcom_compra";
		$sql.= " AND dcom_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND cos_codigo = $cod"; 
		}
		if(strlen($lot)>0) { 
			  $sql.= " AND cos_lote = $lot"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND cos_articulo = $art"; 
		}
		if(strlen($gru)>0) { 
			  $sql.= " AND cos_grupo = $gru"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND cos_compra = $comp"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND cos_moneda = $mon"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cos_situacion = $sit"; 
		}
		$sql.= " ORDER BY cos_grupo ASC,cos_articulo ASC,cos_lote ASC,cos_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_costo($cod,$lot = '',$art = '',$gru = '',$comp = '',$mon = '',$sit = ''){
		$nom = trim($nom);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_costos, inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, fin_moneda, comp_compra, comp_det_compra";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND cos_compra = com_codigo";
		$sql.= " AND cos_grupo = lot_grupo";
		$sql.= " AND cos_articulo = lot_articulo";
		$sql.= " AND cos_lote = lot_codigo";
		$sql.= " AND com_codigo = dcom_compra";
		$sql.= " AND dcom_moneda = mon_id";
		if(strlen($cod)>0) { 
			  $sql.= " AND cos_codigo = $cod"; 
		}
		if(strlen($lot)>0) { 
			  $sql.= " AND cos_lote = $lot"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND cos_articulo = $art"; 
		}
		if(strlen($gru)>0) { 
			  $sql.= " AND cos_grupo = $gru"; 
		}
		if(strlen($comp)>0) { 
			  $sql.= " AND cos_compra = $comp"; 
		}
		if(strlen($mon)>0) { 
			  $sql.= " AND cos_moneda = $mon"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND cos_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
			
	function insert_costo($lot,$art,$gru,$comp,$mont,$mon,$tcamb){
		$nom = trim($nom);
		
		$sql = "INSERT INTO inv_costos ";
		$sql.= " VALUES (0,$lot,$art,$gru,$comp,$mont,$mon,$tcamb,1); ";
		//echo $sql;
		return $sql;
	}
	
	function get_lote_tcambio($art,$gru) {
		
        $sql = "SELECT mon_cambio ";
		$sql.= " FROM inv_articulo_suministro,fin_moneda";
		$sql.= " WHERE art_moneda = mon_id"; 
		$sql.= " AND art_codigo = $art"; 
		$sql.= " AND art_grupo = $gru"; 
		//--
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$tcamb = $row["mon_cambio"];
		}
		//echo $sql;
		return $tcamb;
	}
	
	function update_precio_costo($lot,$art,$gru,$monto){
		
		$sql = "UPDATE inv_lote_suministro";
		$sql.= " SET lot_precio_costo = lot_precio_costo + ($monto/lot_cantidad) ";
		$sql.= " WHERE lot_codigo = $lot";
		$sql.= " AND lot_articulo = $art";
		$sql.= " AND lot_grupo = $gru;";
				
		return $sql;
	}
	
	function cambia_sit_costo($cod,$sit){
		
		$sql = "UPDATE inv_inventario_suministro SET ";
		$sql.= "inv_situacion = $sit"; 
				
		$sql.= " WHERE inv_codigo = $cod; "; 	
		
		return $sql;
	}
		
}	
?>
