<?php
require_once ("ClsConex.php");

class ClsArticuloPropio extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- Grupo Articulo---------//
    function get_grupo($cod,$nom = '',$sit = ''){
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_grupo_propio";
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
		$sql.= " FROM inv_grupo_propio";
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
		
	function insert_grupo($cod,$nom,$dep,$sit){
		$nom = trim($nom);
		
		$sql = "INSERT INTO inv_grupo_propio (gru_codigo,gru_nombre,gru_depreciacion,gru_situacion)";
		$sql.= " VALUES ($cod,'$nom',$dep,$sit); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_grupo($cod,$nom,$dep){
		$nom = trim($nom);
		
		$sql = "UPDATE inv_grupo_propio SET ";
		$sql.= "gru_nombre = '$nom',"; 
		$sql.= "gru_depreciacion = '$dep'"; 
		
		$sql.= " WHERE gru_codigo = $cod;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_grupo($cod,$sit){
		
		$sql = "UPDATE inv_grupo_propio SET ";
		$sql.= "gru_situacion = $sit"; 
				
		$sql.= " WHERE gru_codigo = $cod;"; 	
		
		return $sql;
	}
	
	function comprueba_sit_grupo($grup) {
		
		$sql = "SELECT art_situacion as sit";
		$sql.= " FROM inv_articulo_propio_propio";
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
		$sql.= " FROM inv_grupo_propio";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//---------- Articulo---------//
    function get_articulo($cod,$grup = '',$nom = '',$cumed = '',$umed = '',$sit = '',$suc = '') {
	    $nom = trim($nom);
	    
		if(strlen($suc)>0) {
			$cadena_sql = " AND inv_sucursal = $suc";
		}else{
			$cadena_sql = "";
		}
	        $sql= "SELECT * ";
	        $sql .= " ,(SELECT COUNT(inv_codigo) FROM inv_inventario_propio WHERE inv_articulo = art_codigo 
			    AND inv_grupo = art_grupo AND inv_situacion = 1$cadena_sql) as art_cant_suc";
	        $sql .= " ,(SELECT SUM(inv_precio_inicial * mon_cambio) FROM inv_inventario_propio,fin_moneda WHERE inv_articulo = art_codigo 
			    AND inv_grupo = art_grupo AND inv_moneda = mon_id$cadena_sql  ORDER BY inv_codigo LIMIT 0,1) as art_precio_inicial";
	        $sql .= " ,(SELECT SUM(inv_precio_actual * mon_cambio) FROM inv_inventario_propio,fin_moneda WHERE inv_articulo = art_codigo 
			    AND inv_grupo = art_grupo AND inv_moneda = mon_id$cadena_sql  ORDER BY inv_codigo LIMIT 0,1) as art_precio_actual";
	        $sql.= " FROM inv_articulo_propio, inv_grupo_propio, inv_unidad_medida";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
		if(strlen($cod)>0) { 
			  $sql.= " AND art_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND art_nombre like '%$nom%'"; 
		}
		if(strlen($cumed)>0) { 
			  $sql.= " AND u_clase = '$cumed'"; 
		}
		if(strlen($umed)>0) { 
			  $sql.= " AND art_unidad_medida = $umed"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND art_situacion = $sit"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, art_codigo ASC, art_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_articulo($cod,$grup = '',$nom = '',$cumed = '',$umed = '',$sit = '',$suc = '') {
	    $nom = trim($nom);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_articulo_propio, inv_grupo_propio, inv_unidad_medida";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND u_codigo = art_unidad_medida";
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
		
	function insert_articulo($cod,$grup,$nom,$desc,$marca,$umed){
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		
		$sql = "INSERT INTO inv_articulo_propio";
		$sql.= " VALUES ($cod,$grup,'$nom','$desc','$marca',$umed,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_articulo($cod,$grup,$nom,$desc,$marca,$umed){
		$nom = trim($nom);
		$desc = trim($desc);
		$marca = trim($marca);
		
		$sql = "UPDATE inv_articulo_propio SET ";
		$sql.= "art_nombre = '$nom',"; 
		$sql.= "art_desc = '$desc',"; 
		$sql.= "art_marca = '$marca',"; 
		$sql.= "art_unidad_medida = '$umed'"; 
		
		$sql.= " WHERE art_codigo = $cod "; 	
		$sql.= " AND art_grupo = $grup; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_articulo($art,$grup,$sit){
		
		$sql = "UPDATE inv_articulo_propio SET ";
		$sql.= "art_situacion = $sit"; 
				
		$sql.= " WHERE art_codigo = $art"; 	
		$sql.= " AND art_grupo = $grup; "; 	
		
		return $sql;
	}
	
	
	function comprueba_sit_articulo($art,$grup) {
		
		$sql = "SELECT SUM(inv_codigo) as cantidad";
		$sql.= " FROM inv_inventario_propio";
		$sql.= " WHERE inv_articulo = $art"; 	
		$sql.= " AND inv_grupo = $grup; "; 
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
		$sql.= " FROM inv_articulo_propio";
		$sql.= " WHERE art_grupo = $grup; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

//---------- Inventario Propio---------//
    function get_inventario($cod,$grup,$art,$nom = '', $desc = '',$marca = '',$suc = '',$sit = '') {
		if(strlen($suc)>0) {
			$cadena_sql = " AND inv_sucursal = $suc";
		}else{
			$cadena_sql = "";
		}
	    $sql= "SELECT *";
		$sql .= " ,(SELECT COUNT(inv_codigo) FROM inv_inventario_propio WHERE inv_articulo = art_codigo AND inv_grupo = art_grupo AND inv_situacion = 1$cadena_sql) as art_cant_suc";
	    $sql .= " ,(SELECT SUM(inv_precio_inicial * mon_cambio) FROM inv_inventario_propio,fin_moneda WHERE inv_articulo = art_codigo AND inv_grupo = art_grupo AND inv_moneda = mon_id$cadena_sql  ORDER BY inv_codigo LIMIT 0,1) as art_precio_inicial";
	    $sql .= " ,(SELECT SUM(inv_precio_actual * mon_cambio) FROM inv_inventario_propio,fin_moneda WHERE inv_articulo = art_codigo AND inv_grupo = art_grupo AND inv_moneda = mon_id$cadena_sql  ORDER BY inv_codigo LIMIT 0,1) as art_precio_actual";
	    $sql.= " FROM inv_inventario_propio, inv_articulo_propio, inv_grupo_propio, mast_sucursal, fin_moneda, inv_unidad_medida";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND inv_articulo = art_codigo";
		$sql.= " AND inv_grupo = art_grupo";
		$sql.= " AND inv_sucursal = suc_id";
		$sql.= " AND inv_moneda = mon_id";
		$sql.= " AND art_unidad_medida = u_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND inv_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND art_codigo = $art"; 
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
		if(strlen($suc)>0) { 
			  $sql.= " AND inv_sucursal = $suc"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND inv_situacion = $sit"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, art_codigo ASC, inv_codigo ASC, art_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_inventario($cod,$grup,$art,$nom = '', $desc = '',$marca = '',$suc = '',$sit = '') {
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_inventario_propio, inv_articulo_propio, inv_grupo_propio, mast_sucursal, fin_moneda, inv_unidad_medida";
		$sql.= " WHERE art_grupo = gru_codigo";
		$sql.= " AND inv_articulo = art_codigo";
		$sql.= " AND inv_grupo = art_grupo";
		$sql.= " AND inv_sucursal = suc_id";
		$sql.= " AND inv_moneda = mon_id";
		$sql.= " AND art_unidad_medida = u_codigo";
		
		if(strlen($cod)>0) { 
			  $sql.= " AND inv_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND art_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND art_codigo = $art"; 
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
		if(strlen($suc)>0) { 
			  $sql.= " AND inv_sucursal = $suc"; 
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
		
	function insert_inventario($cod,$grup,$art,$suc,$num,$prei,$prea,$mon){
	    $num = trim($num);
		//--
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO inv_inventario_propio ";
		$sql.= " VALUES ($cod,$grup,$art,$suc,'$num',$prei,$prea,$mon,'$fechor',$usu,1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_inventario($cod,$grup,$art,$suc,$num,$prei,$prea,$mon){
		$num = trim($num);
		//--
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "UPDATE inv_inventario_propio SET ";
		$sql.= "inv_sucursal = '$suc',"; 
		$sql.= "inv_numero = '$num',"; 
		$sql.= "inv_precio_inicial = '$prei',"; 
		$sql.= "inv_precio_actual = '$prea',"; 
		$sql.= "inv_fechor = '$fechor',"; 
		$sql.= "inv_quien = '$usu',"; 
		$sql.= "inv_moneda = '$mon'"; 
		
		$sql.= " WHERE inv_codigo = $cod "; 	
		$sql.= " AND inv_grupo = $grup "; 	
		$sql.= " AND inv_articulo = $art; "; 	
		//echo $sql;
		return $sql;
	}
	
	function actualiza_precios_inventario(){
		
		$sql = "UPDATE  ";
		$sql.= "INNER JOIN inv_articulo_propio ON art_codigo = inv_articulo AND inv_grupo = art_grupo ";
		$sql.= "INNER JOIN inv_grupo_propio ON art_grupo = gru_codigo ";
		$sql.= "SET inv_precio_actual = inv_precio_actual - (inv_precio_actual * (gru_depreciacion/100));"; 	
		//echo $sql;
		return $sql;
	}
	
	function max_inventario($grup,$art) {
		
        $sql = "SELECT max(inv_codigo) as max ";
		$sql.= " FROM inv_inventario_propio";
		$sql.= " WHERE inv_grupo = $grup "; 	
		$sql.= " AND inv_articulo = $art "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	function cambia_sit_inventario($cod,$grup,$art,$sit){
		
		$sql = "UPDATE inv_inventario_propio SET ";
		$sql.= "inv_situacion = $sit"; 
				
		$sql.= " WHERE inv_codigo = $cod"; 	
		$sql.= " AND inv_articulo = $art"; 	
		$sql.= " AND inv_grupo = $grup; "; 	
		
		return $sql;
	}
	
	
//---------- DEPRECIACIONES ---------//
    function get_depreciacion($grup,$art,$inv,$mes = '',$anio = '',$suc = '') {
		
	    $sql= "SELECT *";
		$sql.= " FROM inv_depreciacion, inv_inventario_propio, inv_articulo_propio, inv_grupo_propio, mast_sucursal, fin_moneda, inv_unidad_medida";
		$sql.= " WHERE dep_inventario = inv_codigo";
		$sql.= " AND dep_grupo = inv_grupo";
		$sql.= " AND dep_articulo = inv_articulo";
		$sql.= " AND inv_articulo = art_codigo";
		$sql.= " AND inv_grupo = art_grupo";
		$sql.= " AND art_grupo = gru_codigo";
		$sql.= " AND inv_sucursal = suc_id";
		$sql.= " AND inv_moneda = mon_id";
		$sql.= " AND art_unidad_medida = u_codigo";
		
		if(strlen($grup)>0) { 
			  $sql.= " AND dep_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND dep_codigo = $art"; 
		}
		if(strlen($inv)>0) { 
			  $sql.= " AND dep_inventario = $inv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND inv_sucursal = $suc"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND art_situacion = $sit"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, art_codigo ASC, inv_codigo ASC, dep_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_depreciacion($grup,$art,$inv,$mes = '',$anio = '',$suc = '') {
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_depreciacion, inv_inventario_propio, inv_articulo_propio, inv_grupo_propio, mast_sucursal, fin_moneda, inv_unidad_medida";
		$sql.= " WHERE dep_inventario = inv_codigo";
		$sql.= " AND dep_grupo = inv_grupo";
		$sql.= " AND dep_articulo = inv_articulo";
		$sql.= " AND inv_articulo = art_codigo";
		$sql.= " AND inv_grupo = art_grupo";
		$sql.= " AND art_grupo = gru_codigo";
		$sql.= " AND inv_sucursal = suc_id";
		$sql.= " AND inv_moneda = mon_id";
		$sql.= " AND art_unidad_medida = u_codigo";
		
		if(strlen($grup)>0) { 
			  $sql.= " AND dep_grupo = $grup"; 
		}
		if(strlen($art)>0) { 
			  $sql.= " AND dep_codigo = $art"; 
		}
		if(strlen($inv)>0) { 
			  $sql.= " AND dep_inventario = $inv"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND inv_sucursal = $suc"; 
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
	
	function insert_depreciacion($mes,$anio){
		
	    $sql = "INSERT INTO inv_depreciacion (dep_grupo,dep_articulo,dep_inventario,dep_porcent,dep_monto,dep_precio_actual,dep_mes,dep_anio) ";
	    $sql.= "SELECT inv_grupo, inv_articulo, inv_codigo, ";
	    $sql.= "ROUND((gru_depreciacion/100)/12,4), ";
	    $sql.= "ROUND(((gru_depreciacion/100)/12) * inv_precio_actual,4), ";
	    $sql.= "ROUND(inv_precio_actual - (((gru_depreciacion/100)/12) * inv_precio_actual),4), ";
	    $sql.= " $mes, $anio";
	    $sql.= " FROM inv_inventario_propio,inv_articulo_propio,inv_grupo_propio";
	    $sql.= " WHERE inv_articulo = art_codigo";
	    $sql.= " AND inv_grupo = art_grupo";
	    $sql.= " AND art_grupo = gru_codigo;"; 	
		//echo $sql;
	    return $sql;
	}
	
	
	function update_precio_actual(){
		
	    $sql = "UPDATE inv_inventario_propio, vista_precio_actual ";
	    $sql.= "SET inv_inventario_propio.inv_precio_actual = vista_precio_actual.precio_actual ";
	    $sql.= "WHERE inv_inventario_propio.inv_codigo = vista_precio_actual.inv_codigo ";
	    $sql.= "AND inv_inventario_propio.inv_articulo = vista_precio_actual.inv_articulo ";
	    $sql.= "AND inv_inventario_propio.inv_grupo = vista_precio_actual.inv_grupo;"; 	
		//echo $sql;
	    return $sql;
	}
	
	
	function max_anio_depreciacion() {
		
	    $sql = "SELECT max(dep_anio) as max_anio ";
		$sql.= " FROM inv_depreciacion";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max_anio"];
		}
		//echo $sql;
		return $max;
	}
	
	function max_mes_depreciacion($anio) {
		
	    $sql = "SELECT max(dep_mes) as max_mes ";
		$sql.= " FROM inv_depreciacion";
		$sql.= " WHERE dep_anio = $anio"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max_mes"];
		}
		//echo $sql;
		return $max;
	}
	
	
}	
?>
