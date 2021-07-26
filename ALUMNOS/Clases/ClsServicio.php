<?php
require_once ("ClsConex.php");

class ClsServicio extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- Grupo Articulo---------//
    function get_grupo($cod,$nom = '',$sit = ''){
		$nom = trim($nom);
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_grupo_servicios";
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
		$sql.= " FROM inv_grupo_servicios";
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
		
		$sql = "INSERT INTO inv_grupo_servicios (gru_codigo,gru_nombre,gru_situacion)";
		$sql.= " VALUES ($cod,'$nom',$sit); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_grupo($cod,$nom){
		$nom = trim($nom);
		
		$sql = "UPDATE inv_grupo_servicios SET ";
		$sql.= "gru_nombre = '$nom'"; 
		
		$sql.= " WHERE gru_codigo = $cod;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_grupo($cod,$sit){
		
		$sql = "UPDATE inv_grupo_servicios SET ";
		$sql.= "gru_situacion = $sit"; 
				
		$sql.= " WHERE gru_codigo = $cod;"; 	
		
		return $sql;
	}
	
	function comprueba_sit_grupo($grup) {
		
		$sql = "SELECT ser_situacion as sit";
		$sql.= " FROM inv_servicio";
		$sql.= " WHERE ser_grupo = $grup;"; 	
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
		$sql.= " FROM inv_grupo_servicios";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//---------- Articulo---------//
    function get_servicio($cod,$grup = '',$nom = '',$desc = '',$barc = '',$sit = '') {
		$nom = trim($nom);
		$desc = trim($desc);
		$barc = trim($barc);
		
	    $sql= "SELECT * ";
		$sql.= " FROM inv_servicio, inv_grupo_servicios, fin_moneda";
		$sql.= " WHERE ser_grupo = gru_codigo";
		$sql.= " AND mon_id = ser_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND ser_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND ser_grupo = $grup"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND ser_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND ser_desc like '%$desc%'"; 
		}
		if(strlen($barc)>0) { 
			  $sql.= " AND ser_barcode = '$barc'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ser_situacion = $sit"; 
		}
		$sql.= " ORDER BY gru_codigo ASC, ser_codigo ASC, ser_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_servicio($cod,$grup = '',$nom = '',$desc = '',$barc = '',$sit = '') {
		$nom = trim($nom);
		$desc = trim($desc);
		$barc = trim($barc);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_servicio, inv_grupo_servicios, fin_moneda";
		$sql.= " WHERE ser_grupo = gru_codigo";
		$sql.= " AND mon_id = ser_moneda";
		if(strlen($cod)>0) { 
			  $sql.= " AND ser_codigo = $cod"; 
		}
		if(strlen($grup)>0) { 
			  $sql.= " AND ser_grupo = $grup"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND ser_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND ser_desc like '%$desc%'"; 
		}
		if(strlen($barc)>0) { 
			  $sql.= " AND ser_barcode = '$barc'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND ser_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_servicio($cod,$grup,$barc,$nom,$desc,$prec,$prev,$mon,$sit){
		$nom = trim($nom);
		$desc = trim($desc);
		$barc = trim($barc);
		
		$sql = "INSERT INTO inv_servicio ";
		$sql.= " VALUES ($cod,$grup,'$barc','$nom','$desc','$prec','$prev',$mon,$sit); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_servicio($cod,$grup,$barc,$nom,$desc,$prec,$prev,$mon){
		$nom = trim($nom);
		$desc = trim($desc);
		$barc = trim($barc);
		
		$sql = "UPDATE inv_servicio SET ";
		$sql.= "ser_barcode = '$barc',"; 
		$sql.= "ser_nombre = '$nom',"; 
		$sql.= "ser_desc = '$desc',"; 
		$sql.= "ser_precio_costo = '$prec',"; 
		$sql.= "ser_precio_venta = $prev,"; 
		$sql.= "ser_moneda = '$mon'"; 
		
		$sql.= " WHERE ser_codigo = $cod "; 	
		$sql.= " AND ser_grupo = $grup; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_servicio($ser,$grup,$sit){
		
		$sql = "UPDATE inv_servicio SET ";
		$sql.= "ser_situacion = $sit"; 
				
		$sql.= " WHERE ser_codigo = $ser"; 	
		$sql.= " AND ser_grupo = $grup; "; 	
		
		return $sql;
	}
	
	
	
	function max_servicio($grup) {
		
	    $sql = "SELECT max(ser_codigo) as max ";
		$sql.= " FROM inv_servicio";
		$sql.= " WHERE ser_grupo = $grup; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	


}	
?>
