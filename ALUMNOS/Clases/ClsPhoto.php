<?php
require_once ("ClsConex.php");

class ClsPhoto extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

    function __construct(){
		$this->anio = date("Y");
        if($_SESSION["pensum"] == "") {
            require_once("ClsPensum.php");
            $ClsPen = new ClsPensum();
            $this->pensum = $ClsPen->get_pensum_activo();
        }else{
            $this->pensum = $_SESSION["pensum"];
        }
	}	

/////////////////////////////  PHOTO  //////////////////////////////////////
  
    function get_photo($codigo,$maestro = '',$desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
        
		$sql = "SELECT *, ";
        $sql.= " (SELECT ipho_imagen FROM app_photo_img WHERE pho_codigo = ipho_album ORDER BY ipho_imagen LIMIT 0 , 1) as pho_portada";
        $sql.= " FROM app_photo";
		$sql.= " WHERE 1 = 1";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND pho_maestro = $maestro"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY pho_fecha_registro DESC, pho_maestro ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function count_photo($codigo,$maestro = '',$desde = '',$fecha = '',$sit = '') {
		$titulo = trim($titulo);
		$desc = trim($desc);
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_photo";
		$sql.= " WHERE 1 = 1";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND pho_maestro = $maestro"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

    
	function get_album_unique($codigo,$maestro = '',$desde = '',$fecha = '',$sit = '') {
        $anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql = "SELECT pho_codigo,pho_maestro,pho_descripcion,pho_fecha_registro,pho_situacion,";
        $sql.= " (SELECT COUNT(ipho_imagen) FROM app_photo_img WHERE pho_codigo = ipho_album) as pho_cantidad,";
        $sql.= " (SELECT ipho_imagen FROM app_photo_img WHERE pho_codigo = ipho_album ORDER BY ipho_imagen LIMIT 0 , 1) as pho_portada";
        $sql.= " FROM app_photo";
		$sql.= " WHERE 1 = 1";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND pho_maestro = $maestro"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
        $sql.= " GROUP BY pho_codigo";
		$sql.= " ORDER BY pho_fecha_registro DESC, pho_maestro ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
    
	
	function insert_photo($codigo,$maestro,$desc){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_photo";
		$sql.= " VALUES ($codigo,$maestro,'$desc','$freg',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_photo($codigo,$desc){
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_photo SET ";
		$sql.= "pho_descripcion = '$desc'"; 		
		
		$sql.= " WHERE pho_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}

	
	function cambia_sit_photo($codigo,$sit){
		$sql = "UPDATE app_photo SET ";
		$sql.= "pho_situacion = $sit";
		$sql.= " WHERE pho_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_photo($codigo){
		$sql = "DELETE FROM app_photo ";
		$sql.= " WHERE pho_codigo = $codigo;"; 	
		
		return $sql;
	}

	function max_photo(){
	  
	    $sql = "SELECT max(pho_codigo) as max ";
		$sql.= " FROM app_photo";
		$sql.= " WHERE 1 = 1";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/////////////////////////////  TAGS  //////////////////////////////////////

	function get_photos_alumno($codigo,$alumno = '',$desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
        
		$sql= "SELECT * ";
		$sql.= " FROM app_photo, app_photo_tag, app_alumnos";
		$sql.= " WHERE pho_codigo = tpho_album";
		$sql.= " AND tpho_alumno = alu_cui";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
		if(strlen($alumno)>0) { 
		    $sql.= " AND tpho_alumno IN($alumno)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY pho_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo "<br>".$sql;
		return $result;

	}
	
	
	function get_photos_hijos($codigo,$padre = '',$hijo = '',$desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
        
		$sql= "SELECT * ";
		$sql.= " FROM app_photo, app_photo_tag, app_padre_alumno";
		$sql.= " WHERE pho_codigo = tpho_album";
		$sql.= " AND tpho_alumno = pa_alumno";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
		if(strlen($padre)>0) { 
		    $sql.= " AND pa_padre = $padre"; 
		}
		if(strlen($hijo)>0) { 
		    $sql.= " AND pa_alumno IN($hijo)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY pho_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo "<br>".$sql;
		return $result;

	}
	
	
	function get_album_accesos($codigo,$pensum = '', $nivel = '', $grado = '', $desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
        if($pensum == ""){
			$pensum = $this->pensum;
		}
        
		$sql= "SELECT * ";
		$sql.= " FROM app_photo, app_photo_tag, app_alumnos, academ_grado_alumno";
		$sql.= " WHERE pho_codigo = tpho_album";
		$sql.= " AND tpho_alumno = alu_cui";
        $sql.= " AND graa_alumno = alu_cui";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
        if(strlen($pensum)>0) { 
			  $sql.= " AND graa_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND graa_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND graa_grado IN($grado)"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
        $sql.= " ORDER BY pho_fecha_registro DESC, alu_apellido ASC, alu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo "<br>".$sql;
		return $result;
	}
	
	
	function insert_tag($album,$alumno){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_photo_tag";
		$sql.= " VALUES ($album,'$alumno','$freg')";
		$sql.= " ON DUPLICATE KEY UPDATE tpho_fecha_registro = '$freg';";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_tag($album,$alumno){
		$sql = "DELETE FROM app_photo_tag ";
		$sql.= " WHERE tpho_album = $album"; 	
		$sql.= " AND tpho_alumno = '$alumno';"; 	
		
		return $sql;
	}
    
    function delete_tags($album){ /// Todos
		$sql = "DELETE FROM app_photo_tag ";
		$sql.= " WHERE tpho_album = $album;"; 	
		
		return $sql;
	}
	
/////////////////////////////  IMAGENES  //////////////////////////////////////

	function get_imagenes($codigo,$imagen = '',$desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
        
		$sql= "SELECT * ";
		$sql.= " FROM app_photo, app_photo_img";
		$sql.= " WHERE pho_codigo = ipho_album";
        $sql.= " AND YEAR(pho_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND pho_codigo IN($codigo)"; 
		}
		if(strlen($imagen)>0) { 
		    $sql.= " AND ipho_imagen = '$imagen'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND pho_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND pho_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND pho_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY pho_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo "<br>".$sql;
		return $result;

	}
	
	function insert_imagen($album,$imagen){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_photo_img";
		$sql.= " VALUES ($album,'$imagen','$freg')";
		$sql.= " ON DUPLICATE KEY UPDATE ipho_fecha_registro = '$freg';";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_imagen($album,$imagen){
		$sql = "DELETE FROM app_photo_img ";
		$sql.= " WHERE ipho_album = $album"; 	
		$sql.= " AND ipho_imagen = '$imagen';"; 	
		
		return $sql;
	}

}	
?>