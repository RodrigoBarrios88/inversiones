<?php
require_once ("ClsConex.php");

class ClsPensum extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
//---------- PENSUM ---------//
    function get_pensum($codigo,$anio = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa";
		$sql.= " FROM academ_pensum";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND pen_codigo = $codigo"; 
		}
		if(strlen($anio)>0) { 
			$sql.= " AND pen_anio = $anio"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND pen_situacion IN($sit)"; 
		}
		$sql.= " ORDER BY pen_anio ASC, pen_codigo ASC, pen_situacion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_pensum($codigo,$anio = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND pen_codigo = $codigo"; 
		}
		if(strlen($anio)>0) { 
			$sql.= " AND pen_anio = $anio"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND pen_situacion IN($sit)";  
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_pensum($codigo,$descripcion,$anio){
		$descripcion = trim($descripcion);
		
		$sql = "INSERT INTO academ_pensum ";
		$sql.= " VALUES ($codigo,'$descripcion',$anio,0,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_pensum($codigo,$descripcion,$anio){
		$descripcion = trim($descripcion);
		
		$sql = "UPDATE academ_pensum SET ";
		$sql.= "pen_descripcion = '$descripcion',"; 
		$sql.= "pen_anio = $anio"; 
		
		$sql.= " WHERE pen_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_pensum($codigo,$sit){
		
		$sql = "UPDATE academ_pensum SET ";
		$sql.= "pen_situacion = $sit"; 		
		$sql.= " WHERE pen_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	
	function cambia_pensum_activo($codigo){
		//--inactiva a todos
		$sql = "UPDATE academ_pensum SET ";
		$sql.= "pen_activo = 0"; 
		$sql.= " WHERE 1 = 1;"; 
		//--activa al elegido
		$sql.= "UPDATE academ_pensum SET ";
		$sql.= "pen_activo = 1"; 
		$sql.= " WHERE pen_codigo = $codigo;"; 	
		
		return $sql;
	}

	
	function max_pensum() {
		
        $sql = "SELECT max(pen_codigo) as max ";
		$sql.= " FROM academ_pensum";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function get_pensum_activo() {
		
        $sql = "SELECT pen_codigo ";
		$sql.= " FROM academ_pensum";
		$sql.= " WHERE pen_activo = 1";
		$sql.= " LIMIT 0,1";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$activo = $row["pen_codigo"];
			}
		}else{
			$activo = 0;
		}
		//echo $sql;
		return $activo;
	}
	
	function get_anio_pensum($codigo) {
		
        $sql = "SELECT pen_anio ";
		$sql.= " FROM academ_pensum";
		$sql.= " WHERE pen_codigo = $codigo"; 
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$anio = $row["pen_anio"];
			}
		}
		//echo $sql;
		return $anio;
	}
    
    function get_pensum_anio($anio) {
		
        $sql = "SELECT pen_codigo ";
		$sql.= " FROM academ_pensum";
		$sql.= " WHERE pen_anio = $anio";
        $sql.= " AND pen_situacion = 1";
		$sql.= " LIMIT 0,1";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$pensum = $row["pen_codigo"];
			}
		}
		//echo $sql;
		return $pensum;
	}

	
//---------- NIVEL ---------//

function get_nivel($pensum,$codigo = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa ";
		$sql.= " FROM academ_nivel, academ_pensum";
		$sql.= " WHERE pen_codigo = niv_pensum";
		if(strlen($pensum)>0) { 
			  $sql.= " AND niv_pensum = $pensum"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND niv_codigo IN($codigo)"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND niv_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, pen_codigo ASC, pen_situacion ASC, niv_codigo ASC, niv_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_nivel($pensum,$codigo = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_nivel, academ_pensum";
		$sql.= " WHERE pen_codigo = niv_pensum";
		if(strlen($pensum)>0) { 
			  $sql.= " AND niv_pensum = $pensum"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND niv_codigo IN($codigo)"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND niv_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_nivel($pensum,$codigo,$descripcion){
		$descripcion = trim($descripcion);
		
		$sql = "INSERT INTO academ_nivel ";
		$sql.= " VALUES ($pensum,$codigo,'$descripcion',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_nivel($pensum,$codigo,$descripcion){
		$descripcion = trim($descripcion);
		
		$sql = "UPDATE academ_nivel SET ";
		$sql.= "niv_descripcion = '$descripcion'"; 
		
		$sql.= " WHERE niv_pensum = $pensum"; 	
		$sql.= " AND niv_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_nivel($pensum,$codigo,$sit){
		
		$sql = "UPDATE academ_nivel SET ";
		$sql.= "niv_situacion = $sit"; 
				
		$sql.= " WHERE niv_pensum = $pensum"; 	
		$sql.= " AND niv_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function cambia_sit_todos_nivel($pensum,$sit){
		
		$sql = "UPDATE academ_nivel SET ";
		$sql.= "niv_situacion = $sit"; 
				
		$sql.= " WHERE niv_pensum = $pensum; "; 	
		
		return $sql;
	}

	function max_nivel($pensum){
		
        $sql = "SELECT max(niv_codigo) as max ";
		$sql.= " FROM academ_nivel";
		$sql.= " WHERE niv_pensum = $pensum"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//---------- GRADOS ---------//

	function get_grado($pensum,$nivel,$codigo = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, CONCAT(gra_pensum,'.',gra_nivel,'.',gra_codigo) as gra_nomenclatura ";
		$sql.= " FROM academ_grado, academ_nivel, academ_pensum";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		if(strlen($pensum)>0) { 
			  $sql.= " AND gra_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND gra_nivel IN($nivel)"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND gra_codigo IN($codigo)"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gra_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, pen_codigo ASC, niv_codigo ASC, pen_situacion ASC, gra_codigo ASC, gra_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_grado($pensum,$nivel,$codigo = '',$sit = ''){
		$anio = trim($anio);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_grado, academ_nivel, academ_pensum";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		if(strlen($pensum)>0) { 
			  $sql.= " AND gra_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND gra_nivel IN($nivel)"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND gra_codigo IN($codigo)"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gra_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_grado($pensum,$nivel,$codigo,$descripcion){
		$descripcion = trim($descripcion);
		
		$sql = "INSERT INTO academ_grado ";
		$sql.= " VALUES ($pensum,$nivel,$codigo,'$descripcion',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_grado($pensum,$nivel,$codigo,$descripcion){
		$descripcion = trim($descripcion);
		
		$sql = "UPDATE academ_grado SET ";
		$sql.= "gra_descripcion = '$descripcion'"; 
		
		$sql.= " WHERE gra_pensum = $pensum"; 	
		$sql.= " AND gra_nivel = $nivel"; 	
		$sql.= " AND gra_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_grado($pensum,$nivel,$codigo,$sit){
		
		$sql = "UPDATE academ_grado SET ";
		$sql.= "gra_situacion = $sit"; 
				
		$sql.= " WHERE gra_pensum = $pensum"; 	
		$sql.= " AND gra_nivel = $nivel"; 	
		$sql.= " AND gra_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function cambia_sit_todos_grado($pensum,$sit){
		
		$sql = "UPDATE academ_grado SET ";
		$sql.= "gra_situacion = $sit"; 
				
		$sql.= " WHERE gra_pensum = $pensum; "; 	
		
		return $sql;
	}

	function max_grado($pensum,$nivel){
		
        $sql = "SELECT max(gra_codigo) as max ";
		$sql.= " FROM academ_grado";
		$sql.= " WHERE gra_pensum = $pensum"; 	
		$sql.= " AND gra_nivel = $nivel"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//---------- MATERIA ---------//

	function get_materia($pensum,$nivel,$grado,$codigo = '',$tipo = '',$sit = ''){
		$descripcion = trim($descripcion);
		$dct = trim($dct);
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, CONCAT(mat_pensum,'.',mat_nivel,'.',mat_codigo) as mat_nomenclatura ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		$sql.= " AND mat_situacion != 0"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND mat_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND mat_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND mat_grado = $grado"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND mat_codigo IN($codigo)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mat_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, mat_pensum ASC, mat_nivel ASC, mat_grado ASC, mat_orden ASC, mat_descripcion ASC, mat_tipo DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br>";
		return $result;

	}
	
	function count_materia($pensum,$nivel,$grado,$codigo = '',$tipo = '',$sit = ''){
		$descripcion = trim($descripcion);
		$dct = trim($dct);
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_materia";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND mat_pensum = gra_pensum";
		$sql.= " AND mat_nivel = gra_nivel";
		$sql.= " AND mat_grado = gra_codigo";
		if(strlen($pensum)>0) { 
			  $sql.= " AND mat_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND mat_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND mat_grado = $grado"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND mat_codigo IN($codigo)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND mat_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mat_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_materia($pensum,$nivel,$grado,$codigo,$tipo,$cate,$orden,$descripcion,$dct){
		$descripcion = trim($descripcion);
		$dct = trim($dct);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_materia ";
		$sql.= " VALUES ($pensum,$nivel,$grado,$codigo,'$tipo','$cate','$orden','$descripcion','$dct',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_materia($pensum,$nivel,$grado,$codigo,$tipo,$cate,$orden,$descripcion,$dct){
		$descripcion = trim($descripcion);
		$dct = trim($dct);
		$tipo = trim($tipo);
		
		$sql = "UPDATE academ_materia SET ";
		$sql.= "mat_tipo = '$tipo',";
		$sql.= "mat_categoria = '$cate',";
		$sql.= "mat_orden = '$orden',"; 
		$sql.= "mat_descripcion = '$descripcion',"; 
		$sql.= "mat_desc_ct = '$dct'"; 
		
		$sql.= " WHERE mat_pensum = $pensum"; 	
		$sql.= " AND mat_nivel = $nivel"; 	
		$sql.= " AND mat_grado = $grado"; 	
		$sql.= " AND mat_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_materia($pensum,$nivel,$grado,$codigo,$sit){
		
		$sql = "UPDATE academ_materia SET ";
		$sql.= "mat_situacion = $sit"; 
				
		$sql.= " WHERE mat_pensum = $pensum"; 	
		$sql.= " AND mat_nivel = $nivel"; 	
		$sql.= " AND mat_grado = $grado"; 	
		$sql.= " AND mat_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function cambia_sit_toda_materia($pensum,$sit){
		
		$sql = "UPDATE academ_materia SET ";
		$sql.= "mat_situacion = $sit"; 
				
		$sql.= " WHERE mat_pensum = $pensum; "; 	
		
		return $sql;
	}

	function max_materia($pensum,$nivel,$grado){
		
        $sql = "SELECT max(mat_codigo) as max ";
		$sql.= " FROM academ_materia";
		$sql.= " WHERE mat_pensum = $pensum"; 	
		$sql.= " AND mat_nivel = $nivel"; 	
		$sql.= " AND mat_grado = $grado"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	//---------- SECCION ---------//

	function get_seccion($pensum,$nivel,$grado,$codigo = '',$tipo = '',$sit = ''){
		$descripcion = trim($descripcion);
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, CONCAT(sec_pensum,'.',sec_nivel,'.',sec_grado,'.',sec_codigo) as sec_nomenclatura ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		if(strlen($pensum)>0) { 
			  $sql.= " AND sec_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND sec_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND sec_grado = $grado"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND sec_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND sec_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, sec_pensum ASC, sec_nivel ASC, sec_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_seccion($pensum,$nivel,$grado,$codigo = '',$tipo = '',$sit = ''){
		$descripcion = trim($descripcion);
		$tipo = trim($tipo);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		if(strlen($pensum)>0) { 
			  $sql.= " AND sec_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND sec_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND sec_grado = $grado"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND sec_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND sec_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_seccion_IN($pensum,$nivel,$grado,$codigo = '',$tipo = '',$sit = ''){
		$descripcion = trim($descripcion);
		$tipo = trim($tipo);
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, CONCAT(sec_pensum,'.',sec_nivel,'.',sec_grado,'.',sec_codigo) as sec_nomenclatura ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		if(strlen($pensum)>0) { 
			  $sql.= " AND sec_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND sec_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND sec_grado IN($grado)"; 
		}
		if(strlen($codigo)>0) { 
			  $sql.= " AND sec_codigo IN($codigo)"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND sec_tipo = '$tipo'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND sec_situacion = $sit"; 
		}
		$sql.= " ORDER BY pen_anio ASC, sec_pensum ASC, sec_nivel ASC, sec_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
		
	function insert_seccion($pensum,$nivel,$grado,$codigo,$tipo,$descripcion){
		$descripcion = trim($descripcion);
		$tipo = trim($tipo);
		
		$sql = "INSERT INTO academ_secciones ";
		$sql.= " VALUES ($pensum,$nivel,$grado,$codigo,'$tipo','$descripcion',1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_seccion($pensum,$nivel,$grado,$codigo,$tipo,$descripcion){
		$descripcion = trim($descripcion);
		$tipo = trim($tipo);
		
		$sql = "UPDATE academ_secciones SET ";
		$sql.= "sec_tipo = '$tipo',"; 
		$sql.= "sec_descripcion = '$descripcion'"; 
		
		$sql.= " WHERE sec_pensum = $pensum"; 	
		$sql.= " AND sec_nivel = $nivel"; 	
		$sql.= " AND sec_grado = $grado"; 	
		$sql.= " AND sec_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_seccion($pensum,$nivel,$grado,$codigo,$sit){
		
		$sql = "UPDATE academ_secciones SET ";
		$sql.= "sec_situacion = $sit"; 
				
		$sql.= " WHERE sec_pensum = $pensum"; 	
		$sql.= " AND sec_nivel = $nivel"; 	
		$sql.= " AND sec_grado = $grado"; 	
		$sql.= " AND sec_codigo = $codigo;"; 	
		
		return $sql;
	}
	
	function cambia_sit_toda_seccion($pensum,$sit){
		
		$sql = "UPDATE academ_secciones SET ";
		$sql.= "sec_situacion = $sit"; 
				
		$sql.= " WHERE sec_pensum = $pensum; "; 	
		
		return $sql;
	}

	function max_seccion($pensum,$nivel,$grado){
		
        $sql = "SELECT max(sec_codigo) as max ";
		$sql.= " FROM academ_secciones";
		$sql.= " WHERE sec_pensum = $pensum"; 	
		$sql.= " AND sec_nivel = $nivel"; 	
		$sql.= " AND sec_grado = $grado"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	function get_nivel_bloqueo($pensum,$codigo ='',$nivel ='',$sit='' ){
		
        $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa";
		$sql.= " FROM academ_pensum,academ_notas_visualizacion,academ_nivel";
		$sql.= " WHERE notv_pensum = $pensum";
		$sql.= " AND notv_nivel = niv_codigo";
		$sql.= " AND niv_situacion = 1";
		$sql.= " AND niv_pensum = notv_pensum";
		if(strlen($pensum)>0) { 
			$sql.= " AND pen_codigo = $pensum"; 
		}
		if(strlen($codigo)>0) { 
			$sql.= " AND notv_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND notv_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND notv_nivel = $nivel"; 
		}
		if(strlen($desnivel)>0) { 
			$sql.= " AND niv_descripcion = $desnivel"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND notv_status IN($sit)"; 
		}
		$sql.= " ORDER BY notv_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_nivel_bloqueo_alumno($pensum,$codigo ='',$nivel,$sit='' ){
	
    $sql= "SELECT *, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa";
	$sql.= " FROM academ_pensum,academ_notas_visualizacion,academ_nivel";
	$sql.= " WHERE notv_pensum = $pensum";
	$sql.= " AND notv_nivel = niv_codigo";
	$sql.= " AND niv_situacion = 1";
	$sql.= " AND niv_pensum = notv_pensum";
	$sql.= " AND niv_codigo = $nivel";	
	if(strlen($pensum)>0) { 
		$sql.= " AND pen_codigo = $pensum"; 
	}
	if(strlen($codigo)>0) { 
		$sql.= " AND notv_codigo = $codigo"; 
	}
	if(strlen($pensum)>0) { 
		$sql.= " AND notv_pensum = $pensum"; 
	}
	if(strlen($nivel)>0) { 
		$sql.= " AND notv_nivel = $nivel"; 
	}
	if(strlen($desnivel)>0) { 
		$sql.= " AND niv_descripcion = $desnivel"; 
	}
	if(strlen($sit)>0) { 
		$sql.= " AND notv_status IN($sit)"; 
	}
	$sql.= " ORDER BY notv_codigo ASC";
	
	$result = $this->exec_query($sql);
	echo $sql;
	return $result;
}

	function get_nivel_alumno($cui,$nivel='',$pensum){
        $sql= "SELECT *";
		$sql.= " FROM academ_grado_alumno";
		$sql.= " LEFT JOIN academ_seccion_alumno ON graa_alumno = seca_alumno ";
		$sql.= " WHERE graa_alumno = $cui";
		$sql.= " AND graa_pensum = $pensum";
		if(strlen($codigo)>0) { 
			$sql.= " AND graa_codigo = $codigo"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND graa_nivel = $nivel"; 
		}
		$result = $this->exec_query($sql);
		if(strlen($pensum)>0) { 
			$sql.= " AND graa_pensum = $pensum"; 
		}
		 //echo $sql;
		return $result;
	}
	//---------- NOTAS ---------//	
	function cambia_sit_notas($codigo,$sit){
		$sql = "UPDATE academ_notas_visualizacion SET ";
		$sql.= "notv_status = $sit"; 		
		$sql.= " WHERE notv_codigo = $codigo;"; 	
		return $sql;
	}

	
}	
?>
