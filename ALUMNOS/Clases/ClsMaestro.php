<?php
require_once ("ClsConex.php");

class ClsMaestro extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
      function get_maestro($codigo,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	    $sql= "SELECT *, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo, ";
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo = 2 AND usu_tipo_codigo = mae_cui) AS mae_usu_id";
		$sql.= " FROM app_maestros";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			$sql.= " AND mae_cui = $codigo"; 
		}
		if(strlen($nom)>0) { 
			$sql.= " AND mae_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			$sql.= " AND mae_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND mae_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY mae_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_maestro($codigo,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	      $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_maestros";
		$sql.= " WHERE 1 = 1";
		if(strlen($codigo)>0) { 
			  $sql.= " AND mae_cui = $codigo"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND mae_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND mae_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND mae_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_maestro_IN($maestros) {
		
		$sql= "SELECT *, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM app_maestros";
		$sql.= " WHERE 1 = 1";
		if(strlen($maestros)>0) { 
			$sql.= " AND mae_cui IN($maestros)"; 
		}
		$sql.= " ORDER BY mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_nivel_maestro($pensum,$nivel,$maestro = ''){
		$tipo = trim($tipo);
		
		$sql= "SELECT DISTINCT mae_cui, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, niv_descripcion, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND secm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($pensum)>0) { 
			  $sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND secm_nivel IN($nivel)"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro = '$maestro'"; 
		}
		$sql.= " ORDER BY pen_anio ASC, secm_pensum ASC, secm_nivel ASC, secm_grado ASC, gra_descripcion ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function get_grado_maestro($pensum,$nivel,$grado = '',$maestro = ''){
		$tipo = trim($tipo);

		$sql= "SELECT DISTINCT mae_cui, CONCAT(pen_descripcion,' - ',pen_anio) as pen_descripcion_completa, gra_descripcion, niv_descripcion, mae_nombre, mae_apellido, CONCAT(mae_nombre,' ',mae_apellido) as mae_nombre_completo ";
		$sql.= " FROM academ_pensum, academ_nivel, academ_grado, academ_secciones, academ_seccion_maestro, app_maestros";
		$sql.= " WHERE niv_pensum = pen_codigo";
		$sql.= " AND niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND secm_pensum = sec_pensum";
		$sql.= " AND secm_nivel = sec_nivel";
		$sql.= " AND secm_grado = sec_grado";
		$sql.= " AND secm_seccion = sec_codigo";
		$sql.= " AND secm_maestro = mae_cui";
		$sql.= " AND mae_situacion = 1"; 
		if(strlen($pensum)>0) { 
			$sql.= " AND secm_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			$sql.= " AND secm_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			$sql.= " AND secm_grado IN($grado)"; 
		}
		if(strlen($maestro)>0) { 
			  $sql.= " AND secm_maestro IN($maestro)"; 
		}
		$sql.= " ORDER BY pen_anio ASC, secm_pensum ASC, secm_nivel ASC, secm_grado ASC, gra_descripcion ASC, mae_apellido ASC, mae_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function insert_maestro($codigo,$nom,$ape,$titulo,$fecnac,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$tel = trim($tel);
		$mail = strtolower($mail);
		$fecnac = $this->regresa_fecha($fecnac);
		
		$sql = "INSERT INTO app_maestros";
		$sql.= " VALUES ($codigo,'$nom','$ape','$titulo','$fecnac','$tel','$mail',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_maestro($codigo,$nom,$ape,$titulo,$fecnac,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$tel = trim($tel);
		$mail = strtolower($mail);
		$fecnac = $this->regresa_fecha($fecnac);
		
		$sql = "UPDATE app_maestros SET ";
		$sql.= "mae_nombre = '$nom',"; 
		$sql.= "mae_apellido = '$ape',"; 
		$sql.= "mae_titulo = '$titulo',"; 
		$sql.= "mae_fecha_nacimiento = '$fecnac',"; 
		$sql.= "mae_telefono = '$tel',"; 		
		$sql.= "mae_mail = '$mail'";
		
		$sql.= " WHERE mae_cui = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_maestro_perfil($codigo,$nom,$ape,$titulo,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$tel = trim($tel);
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_maestros SET ";
		$sql.= "mae_nombre = '$nom',"; 
		$sql.= "mae_apellido = '$ape',"; 
		$sql.= "mae_titulo = '$titulo',"; 
		$sql.= "mae_telefono = '$tel',"; 		
		$sql.= "mae_mail = '$mail'";
		
		$sql.= " WHERE mae_cui = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_maestro($codigo,$sit){
		
		$sql = "UPDATE app_maestros SET ";
		$sql.= "mae_situacion = $sit"; 
				
		$sql.= " WHERE mae_cui = $codigo"; 	
		
		return $sql;
	}
	
	function max_maestro(){
	        $sql = "SELECT max(mae_cui) as max ";
		$sql.= " FROM app_maestros";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
