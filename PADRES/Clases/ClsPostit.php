<?php
require_once ("ClsConex.php");

class ClsPostit extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  POST-IT o Notificaciones //////////////////////////////////////
//////////////  TODOS //////////////////
  
    function get_postit($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$target = '',$desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT *, ";
		//--- subquery de nivel --//
		$sql.= " (SELECT niv_descripcion FROM academ_nivel";
		$sql.= " WHERE niv_pensum = post_pensum"; 
		$sql.= " AND niv_codigo = post_nivel) as post_nivel_desc, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = post_pensum"; 
		$sql.= " AND gra_nivel = post_nivel"; 
		$sql.= " AND gra_codigo = post_grado) as post_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = post_pensum"; 
		$sql.= " AND sec_nivel = post_nivel"; 
		$sql.= " AND sec_grado = post_grado"; 
		$sql.= " AND sec_codigo = post_seccion) as post_seccion_desc, ";
		//--- subquery maestro --//
		$sql.= " (SELECT CONCAT(TRIM(mae_nombre),' ',TRIM(mae_apellido)) FROM app_maestros";
		$sql.= " WHERE mae_cui = post_maestro) as post_maestro_nombre,";
		//--- subquery target --//
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = post_target) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(alu_nombre),' ',TRIM(alu_apellido)) FROM app_alumnos";
		$sql.= " WHERE alu_situacion = 1"; 
		$sql.= " AND alu_cui = post_target) as post_target_nombre";  
		//--	
		$sql.= " FROM app_postit";
		$sql.= " WHERE 1 = 1";
		$sql.= " AND YEAR(post_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND post_codigo IN($codigo)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND post_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND post_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND post_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND post_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND post_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND post_maestro = $maestro"; 
		}
		if(trim($target) == "TODOS") { 
		    $sql.= " AND post_target = ''"; 
		}else if(strlen($target)>0) { 
		    $sql.= " AND post_target = '$target'"; 
		}
		if(strlen($titulo)>0) { 
		    $sql.= " AND post_titulo like '%$titulo%'"; 
		}
		if(strlen($desc)>0) { 
		    $sql.= " AND post_descripcion like '%$desc%'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND post_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			//$sql.= " AND post_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND post_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND post_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY post_fecha_registro DESC, post_maestro ASC";
		
		$result = $this->exec_query($sql);
		//echo "<br>".$sql;
		return $result;
	}
	
	
	
	function count_postit($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$target = '',$desde = '',$fecha = '',$sit = '') {
		$titulo = trim($titulo);
		$desc = trim($desc);
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_postit";
		$sql.= " WHERE 1 = 1";
		$sql.= " AND YEAR(post_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND post_codigo IN($codigo)"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND post_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND post_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND post_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND post_seccion IN($seccion)";
		}	
		if(strlen($materia)>0) { 
		    $sql.= " AND post_materia = $materia"; 
		}
		if(strlen($maestro)>0) { 
		    $sql.= " AND post_maestro = $maestro"; 
		}
		if(trim($target) == "TODOS") { 
		    $sql.= " AND post_target = ''"; 
		}else if(strlen($target)>0) { 
		    $sql.= " AND post_target = '$target'"; 
		}
		if(strlen($titulo)>0) { 
		    $sql.= " AND post_titulo like '%$titulo%'"; 
		}
		if(strlen($desc)>0) { 
		    $sql.= " AND post_descripcion like '%$desc%'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND post_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
			$sql.= " AND post_fecha_registro > '$desde 00:00:00'"; 
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fechaHora($fecha);
			$sql.= " AND post_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND post_situacion = '$sit'"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_postit_codigos($codigo,$pensum = '',$nivel = '',$grado = '',$seccion = '',$materia = '',$maestro = '',$target = '',$desde = '',$fecha = '',$sit = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT post_codigo as codigo";
		$sql.= " FROM app_postit";
		$sql.= " WHERE 1 = 1";
		$sql.= " AND YEAR(post_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigo)>0) { 
		    $sql.= " AND post_codigo = $codigo"; 
		}
		if(strlen($pensum)>0) { 
			$sql.= " AND post_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND post_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND post_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			$sql.= " AND post_seccion IN($seccion)";
		}	
		if(strlen($maestro)>0) { 
		    $sql.= " AND post_maestro = $maestro"; 
		}
		if(trim($target) == "TODOS") { 
		    $sql.= " AND post_target = ''"; 
		}else if(strlen($target)>0) { 
		    $sql.= " AND post_target IN($target)"; 
		}
		if(strlen($titulo)>0) { 
		    $sql.= " AND post_titulo like '%$titulo%'"; 
		}
		if(strlen($desc)>0) { 
		    $sql.= " AND post_descripcion like '%$desc%'"; 
		}
		if(strlen($desde)>0) { 
			$desde = $this->regresa_fecha($desde);
			$sql.= " AND post_fecha_registro > '$desde 00:00:00'"; 
		}else{
			$desde = Fecha_resta_dias(date("d/m/Y"), 10);
			$desde = $this->regresa_fechaHora($desde);
		}
		if(strlen($fecha)>0) { 
			$fecha = $this->regresa_fecha($fecha);
			$sql.= " AND post_fecha_registro BETWEEN '$fecha 00:00:00' AND '$fecha 23:59:00'"; 
		}
		if(strlen($sit)>0) { 
		    $sql.= " AND post_situacion = '$sit'"; 
		}
		
		$codigos = '';
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;
	}
	
	
	
	function get_postit_limit($codigos,$limit1 = '',$limit2 = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
		$sql= "SELECT *, ";
		//--- subquery de nivel --//
		$sql.= " (SELECT niv_descripcion FROM academ_nivel";
		$sql.= " WHERE niv_pensum = post_pensum"; 
		$sql.= " AND niv_codigo = post_nivel) as post_nivel_desc, ";
		//--- subquery de grados --//
		$sql.= " (SELECT gra_descripcion FROM academ_nivel, academ_grado";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND gra_pensum = post_pensum"; 
		$sql.= " AND gra_nivel = post_nivel"; 
		$sql.= " AND gra_codigo = post_grado) as post_grado_desc, ";
		//--- subquery de secciones --//
		$sql.= " (SELECT sec_descripcion FROM academ_nivel, academ_grado, academ_secciones";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND sec_pensum = post_pensum"; 
		$sql.= " AND sec_nivel = post_nivel"; 
		$sql.= " AND sec_grado = post_grado"; 
		$sql.= " AND sec_codigo = post_seccion) as post_seccion_desc, ";
		//--- subquery maestro --//
		$sql.= " (SELECT CONCAT(TRIM(mae_nombre),' ',TRIM(mae_apellido)) FROM app_maestros";
		$sql.= " WHERE mae_cui = post_maestro) as post_maestro_nombre,";
		//--- subquery target --//
		$sql.= " (SELECT fot_string FROM app_foto_alumno WHERE fot_cui = post_target) as alu_foto,";
		$sql.= " (SELECT CONCAT(TRIM(alu_nombre),' ',TRIM(alu_apellido)) FROM app_alumnos";
		$sql.= " WHERE alu_cui = post_target) as post_target_nombre"; 
		//--	
		$sql.= " FROM app_postit";
		$sql.= " WHERE 1 = 1";
		$sql.= " AND YEAR(post_fecha_registro) BETWEEN $anio1 AND $anio2";
		if(strlen($codigos)>0) { 
		    $sql.= " AND post_codigo IN($codigos)"; 
		}else{
			$sql.= " AND post_codigo = 0"; 
		}
		if(strlen($limit1)>0 && strlen($limit2)>0) { 
			$limite = "LIMIT $limit1,$limit2"; 
		}
		$sql.= " ORDER BY post_fecha_registro DESC, post_maestro ASC $limite";
		
		$result = $this->exec_query($sql);
		//echo "<br>".$sql;
		return $result;
	}
	
	
	
	function insert_postit($codigo,$pensum,$nivel,$grado,$seccion,$maestro,$target,$titulo,$desc){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_postit";
		$sql.= " VALUES ($codigo,$pensum,$nivel,$grado,$seccion,$maestro,'$target','$titulo','$desc','$freg',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_postit_datos($codigo,$titulo,$desc){
		$titulo = trim($titulo);
		$desc = trim($desc);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_postit SET ";
		$sql.= "post_titulo = '$titulo',"; 
		$sql.= "post_descripcion = '$desc',"; 		
		$sql.= "post_fecha_registro = '$freg'";
		
		$sql.= " WHERE post_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}

	
	function modifica_postits_aulumnos($codigo,$pensum,$nivel,$grado,$seccion,$target){
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_postit SET ";
		$sql.= "post_pensum = '$pensum',"; 
		$sql.= "post_nivel = '$nivel',"; 		
		$sql.= "post_grado = '$grado',";
		$sql.= "post_seccion = '$seccio',";
		$sql.= "post_target = '$target'"; 
		
		$sql.= " WHERE post_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_postit($codigo,$sit){
		$sql = "UPDATE app_postit SET ";
		$sql.= "post_situacion = $sit";
		$sql.= " WHERE post_codigo = $codigo ;"; 	
		
		return $sql;
	}
	
	function delete_postit($codigo){
		$sql = "DELETE FROM app_postit ";
		$sql.= " WHERE post_codigo IN($codigo);"; 	
		
		return $sql;
	}
	

	function max_postit(){
	  
	    $sql = "SELECT max(post_codigo) as max ";
		$sql.= " FROM app_postit";
		$sql.= " WHERE 1 = 1";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>