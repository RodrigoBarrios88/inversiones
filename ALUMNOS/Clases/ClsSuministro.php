<?php
require_once ("ClsConex.php");

class ClsSuministro extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- Grupo Articulo---------//
    function get_grupo($cod,$nom = '',$sit = ''){
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_grupo_articulos_suministro";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND gru_codigo = $cod"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND gru_nombre like '%$nom%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gru_situacion = $sit"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, gru_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_grupo($cod,$nom = '',$sit = ''){
		$nom = trim($nom);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_grupo_articulos_suministro";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND gru_codigo = $cod"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND gru_nombre like '%$nom%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gru_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_grupo($cod,$nom,$sit){
		$nom = trim($nom);
		
		$sql = "INSERT INTO inv_grupo_articulos_suministro (gru_codigo,gru_nombre,gru_situacion)";
		$sql.= " VALUES ($cod,'$nom',$sit); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_grupo($cod,$nom){
		$nom = trim($nom);
		
		$sql = "UPDATE inv_grupo_articulos_suministro SET ";
		$sql.= "gru_nombre = '$nom'"; 
		
		$sql.= " WHERE gru_codigo = $cod;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_grupo($cod,$sit){
		
		$sql = "UPDATE inv_grupo_articulos_suministro SET ";
		$sql.= "gru_situacion = $sit"; 
				
		$sql.= " WHERE gru_codigo = $cod;"; 	
		
		return $sql;
	}
	
	function comprueba_sit_grupo($grup) {
		
		$sql = "SELECT art_situacion as sit";
		$sql.= " FROM inv_articulo_suministro";
		$sql.= " WHERE art_grupo = $grup;"; 	
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$sit = $row["sit"];
				if($sit == 1){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
	
	
	function max_grupo() {
		
        $sql = "SELECT max(gru_codigo) as max ";
		$sql.= " FROM inv_grupo_articulos_suministro";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//---------- Articulo---------//
    function get_articulo($cod,$grup = '',$nom = '',$desc = '',$marca = '',$cumed = '',$umed = '',$barc = '',$sit = '',$suc = '') {
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
		
        $sql= "SELECT *, ";
		$sql.= " CONCAT('00',art_codigo,'A00',art_grupo) as art_lote,";
		$sql.= "(SELECT MAX(lot_precio_costo) FROM inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo) as art_precio_costo";
		if(strlen($suc)>0) {
			$sql .= " ,(SELECT SUM(lot_cantidad) FROM inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo AND lot_sucursal = $suc) as art_cant_suc";
			$sql .= " ,(SELECT MAX(lot_precio_costo) FROM inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo AND lot_sucursal = $suc ORDER BY lot_codigo LIMIT 0,1) as art_precio_costo";
			$sql .= " ,(SELECT MAX(lot_precio_manufactura) FROM inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo AND lot_sucursal = $suc ORDER BY lot_codigo LIMIT 0,1) as art_precio_manufactura";
			$sql .= " ,(SELECT prov_id FROM fin_proveedor,inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo AND lot_sucursal = $suc AND lot_proveedor = prov_id ORDER BY lot_codigo LIMIT 0,1) as prov_id";
			$sql .= " ,(SELECT prov_nombre FROM fin_proveedor,inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo AND lot_sucursal = $suc AND lot_proveedor = prov_id ORDER BY lot_codigo LIMIT 0,1) as prov_nombre";
			$sql .= " ,(SELECT prov_nit FROM fin_proveedor,inv_lote_suministro WHERE lot_articulo = art_codigo 
					AND lot_grupo = art_grupo AND lot_sucursal = $suc AND lot_proveedor = prov_id ORDER BY lot_codigo LIMIT 0,1) as prov_nit";
		}
		$sql.= " FROM inv_articulo_suministro, inv_grupo_articulos_suministro, inv_unidad_medida, fin_moneda";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
		$sql.= " AND mon_id = art_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND art_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND art_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND art_desc like '%$desc%'"; 
		}
		if(strlen($marca)>0) { 
			  $sql.= " AND art_marca like '%$marca%'"; 
		}
		if(strlen($cumed)>0) { 
			  $sql.= " AND u_clase = '$cumed'"; 
		}
		if(strlen($umed)>0) { 
			  $sql.= " AND art_unidad_medida = $umed"; 
		}
		if(strlen($barc)>0) { 
			  $sql.= " AND art_barcode = '$barc'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND art_situacion = $sit"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, art_codigo ASC, art_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_articulo($cod,$grup = '',$nom = '',$desc = '',$marca = '',$cumed = '',$umed = '',$barc = '',$sit = '',$suc = '') {
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_articulo_suministro, inv_grupo_articulos_suministro, inv_unidad_medida, fin_moneda";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
		$sql.= " AND mon_id = art_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND art_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND art_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND art_desc like '%$desc%'"; 
		}
		if(strlen($marca)>0) { 
			  $sql.= " AND art_marca like '%$marca%'"; 
		}
		if(strlen($cumed)>0) { 
			  $sql.= " AND u_clase = '$cumed'"; 
		}
		if(strlen($umed)>0) { 
			  $sql.= " AND art_unidad_medida = $umed"; 
		}
		if(strlen($barc)>0) { 
			  $sql.= " AND art_barcode = '$barc'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND art_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_articulo_cantidades($cod = '',$grup = '',$suc = '',$minimo = '',$maximo = '') {
		
        $sql= "SELECT * ";
		$sql.= " FROM vista_suministro_cantidad";
		$sql.= " WHERE art_situacion = 1"; 
		if(strlen($cod)>0) { 
			  $sql.= " AND art_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo IN($grup)"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND lot_sucursal = $suc"; 
		}
		if(strlen($minimo)>0) { 
			  $sql.= " AND articulo_cantidad <= $minimo"; 
		}
		if(strlen($maximo)>0) { 
			  $sql.= " AND articulo_cantidad >= $maximo"; 
		}
		$sql.= " ORDER BY articulo_cantidad ASC,gru_codigo ASC, art_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
		
	function insert_articulo($cod,$grup,$barc,$nom,$desc,$marca,$margen,$mon,$umed,$sit){
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		
		$sql = "INSERT INTO inv_articulo_suministro (art_codigo,art_grupo,art_barcode,art_nombre,art_desc,art_marca,art_precio,art_moneda,art_margen,art_unidad_medida,art_situacion)";
		$sql.= " VALUES ($cod,$grup,'$barc','$nom','$desc','$marca',0,$mon,$margen,$umed,$sit); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_articulo($cod,$grup,$barc,$nom,$desc,$umed,$marca,$margen){
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		$barc = trim($barc);
		
		$sql = "UPDATE inv_articulo_suministro SET ";
		$sql.= "art_barcode = '$barc',"; 
		$sql.= "art_nombre = '$nom',"; 
		$sql.= "art_desc = '$desc',"; 
		$sql.= "art_marca = '$marca',"; 
		$sql.= "art_margen = $margen,"; 
		$sql.= "art_unidad_medida = '$umed'"; 
		
		$sql.= " WHERE art_codigo = $cod "; 	
		$sql.= " AND art_grupo = $grup; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_articulo($art,$grup,$sit){
		
		$sql = "UPDATE inv_articulo_suministro SET ";
		$sql.= "art_situacion = $sit"; 
				
		$sql.= " WHERE art_codigo = $art"; 	
		$sql.= " AND art_grupo = $grup; "; 	
		
		return $sql;
	}
	
	function cambia_precio_articulo($art,$grup,$prec,$margen,$mon){
		
		//--actualiza el precio de venta oficial de este articulo
		$sql = "UPDATE inv_articulo_suministro SET ";
		$sql.= "art_precio = $prec, "; 
		$sql.= "art_margen = $margen, "; 
		$sql.= "art_moneda = $mon"; 
		$sql.= " WHERE art_codigo = $art"; 	
		$sql.= " AND art_grupo = $grup; "; 	
		//--actualiza el precio de venta de todos los lotes de este articulo
		$sql.= "UPDATE inv_lote_suministro SET ";
		$sql.= "lot_precio_costo = $prec"; 
		$sql.= " WHERE lot_grupo = $grup "; 	
		$sql.= " AND lot_articulo = $art; "; 	
		//echo $sql;
		
		return $sql;
	}
	
	function estandariza_precio_articulo($art,$grup){
		
		//--estandariza el precio de venta de todos los lotes de este articulo
		$sql.= "UPDATE inv_lote_suministro SET ";
		$sql.= "lot_precio_costo = (SELECT art_precio FROM inv_articulo_suministro WHERE art_codigo = $art AND art_grupo = $grup) "; 
		$sql.= " WHERE lot_grupo = $grup "; 	
		$sql.= " AND lot_articulo = $art; "; 	
		//echo $sql;
		
		return $sql;
	}
	
	function comprueba_sit_articulo($art,$grup) {
		
		$sql = "SELECT lot_cantidad as cantidad";
		$sql.= " FROM inv_lote_suministro";
		$sql.= " WHERE lot_articulo = $art"; 	
		$sql.= " AND lot_grupo = $grup; "; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cant = $row["cantidad"];
				if($cant > 0){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
	
	
	function max_articulo($grup) {
		
        $sql = "SELECT max(art_codigo) as max ";
		$sql.= " FROM inv_articulo_suministro";
		$sql.= " WHERE art_grupo = $grup; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

//---------- Lote---------//
    function get_lote($cod,$grup,$art,$barc = '',$suc = '',$prov = '',$quien = '',$sit = '') {
		$barc = trim($barc);
		
        $sql= "SELECT *,";
		$sql.= " CONCAT('00',lot_codigo,'A00',art_codigo,'A00',art_grupo) as art_lote,";
		$sql.= " CONCAT('00',lot_codigo,'A00',art_codigo,'A00',art_grupo,' / ',art_nombre) as art_lote_desc";
		$sql.= " FROM inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, fin_proveedor, mast_sucursal, fin_moneda, inv_unidad_medida";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_proveedor = prov_id";
		$sql.= " AND lot_sucursal = suc_id";
		$sql.= " AND art_moneda = mon_id";
		$sql.= " AND art_unidad_medida = u_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND lot_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND art_codigo = $art"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND lot_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND lot_sucursal = $suc"; 
		}
		if(strlen($barc)>0) { 
			  $sql.= " AND art_barcode = '$barc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND lot_quien = $quien"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND art_situacion = $sit"; 
		}
		$sql.= " ORDER BY lot_codigo ASC, gru_codigo ASC, art_codigo ASC, art_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_lote($cod,$grup,$art,$barc = '',$suc = '',$prov = '',$quien = '',$sit = '') {
		$barc = trim($barc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_lote_suministro, inv_articulo_suministro, inv_grupo_articulos_suministro, fin_proveedor, mast_sucursal, fin_moneda, inv_unidad_medida";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND lot_articulo = art_codigo";
		$sql.= " AND lot_grupo = art_grupo";
		$sql.= " AND lot_proveedor = prov_id";
		$sql.= " AND lot_sucursal = suc_id";
		$sql.= " AND art_moneda = mon_id";
		$sql.= " AND art_unidad_medida = u_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND lot_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND art_codigo = $art"; 
		}
		if(strlen($prov)>0) { 
			  $sql.= " AND lot_proveedor = $prov"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND lot_sucursal = $suc"; 
		}
		if(strlen($barc)>0) { 
			  $sql.= " AND art_barcode = '$barc'"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND lot_quien = $quien"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND art_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_lote($cod,$grup,$art,$prov,$suc,$prec,$prev,$prem,$cant){
		//--
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO inv_lote_suministro ";
		$sql.= " VALUES ($cod,$grup,$art,$prov,$suc,$prec,$prev,$prem,$cant,'$fec',$usu); ";
		//echo $sql;
		return $sql;
	}
	
	function insert_lote_execute($cod,$grup,$art,$prov,$suc,$prec,$prev,$prem,$cant){
		//--
		$fec = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO inv_lote_suministro ";
		$sql.= " VALUES ($cod,$grup,$art,$prov,$suc,$prec,$prev,$prem,$cant,'$fec',$usu); ";
		$rs = $this->exec_sql($sql);
		//echo $sql;
		return $rs;
	}
	
	function modifica_lote($cod,$grup,$art,$prov,$prec,$prev,$prem){
		
		$sql = "UPDATE inv_lote_suministro SET ";
		$sql.= "lot_proveedor = $prov,"; 
		$sql.= "lot_precio_manufactura = '$prem',"; 
		$sql.= "lot_precio_costo = '$prec',"; 
		$sql.= "lot_precio_venta = '$prev'"; 
		
		$sql.= " WHERE lot_codigo = $cod "; 	
		$sql.= " AND lot_grupo = $grup "; 	
		$sql.= " AND lot_articulo = $art; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cantidad_lote($cod,$grup,$art,$cant,$signo){
		
		$sql = "UPDATE inv_lote_suministro SET ";
		if($signo == "+") { 
			$sql.= "lot_cantidad = lot_cantidad + $cant"; 
		}else if($signo == "-") { 
			$sql.= "lot_cantidad = lot_cantidad - $cant"; 
		}
		
		$sql.= " WHERE lot_codigo = $cod "; 	
		$sql.= " AND lot_grupo = $grup "; 	
		$sql.= " AND lot_articulo = $art; "; 	
		//echo $sql;
		return $sql;
	}
	
	function max_lote($grup,$art) {
		
        $sql = "SELECT max(lot_codigo) as max ";
		$sql.= " FROM inv_lote_suministro";
		$sql.= " WHERE lot_grupo = $grup "; 	
		$sql.= " AND lot_articulo = $art "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	
	function descargar_lote($grup,$art,$suc) {
		
        $sql= "SELECT lot_codigo,lot_cantidad";
		$sql.= " FROM inv_lote_suministro";
		$sql.= " WHERE lot_articulo = $art";
		$sql.= " AND lot_grupo = $grup";
		$sql.= " AND lot_sucursal = $suc";
		$sql.= " AND lot_cantidad > 0";
		$sql.= " ORDER BY lot_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
}	
?>
