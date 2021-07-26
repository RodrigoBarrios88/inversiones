<?php
require_once ("ClsConex.php");

class ClsPadre extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

	function __construct(){
		$this->departamento = 100;
		$this->municipio = 101;
	}		
   
    function get_padre($cui,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo = 3 AND usu_tipo_codigo = pad_cui AND usu_situacion = 1 LIMIT 0,1) AS pad_usu_id";
		$sql.= " FROM app_padres";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND pad_cui = '$cui'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND pad_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND pad_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pad_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY pad_apellido ASC, pad_nombre ASC, pad_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_padre($cui,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_padres";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND pad_cui = '$cui'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND pad_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND pad_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND pad_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_padre_secciones($pensum,$nivel,$grado,$seccion = '',$alumno = '',$padre = ''){
		
		$sql= "SELECT *, ";
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo = 3 AND usu_tipo_codigo = pad_cui) AS pad_usu_id,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo = 3 AND usu_tipo_codigo = pad_cui) AS pad_nombre_pantalla";
		$sql.= " FROM academ_nivel, academ_grado, academ_secciones, academ_seccion_alumno, app_alumnos, app_padre_alumno, app_padres";
		$sql.= " WHERE niv_pensum = gra_pensum";
		$sql.= " AND niv_codigo = gra_nivel";
		$sql.= " AND sec_pensum = gra_pensum";
		$sql.= " AND sec_nivel = gra_nivel";
		$sql.= " AND sec_grado = gra_codigo";
		$sql.= " AND seca_pensum = sec_pensum";
		$sql.= " AND seca_nivel = sec_nivel";
		$sql.= " AND seca_grado = sec_grado";
		$sql.= " AND seca_seccion = sec_codigo";
		$sql.= " AND seca_alumno COLLATE utf8_unicode_ci = alu_cui";
		$sql.= " AND pa_padre = pad_cui";
		$sql.= " AND pa_alumno = alu_cui";
		$sql.= " AND alu_situacion = 1";
		$sql.= " AND pad_situacion = 1";
		if(strlen($pensum)>0) { 
			  $sql.= " AND seca_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND seca_nivel IN($nivel)"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND seca_grado IN($grado)"; 
		}
		if(strlen($seccion)>0) { 
			  $sql.= " AND seca_seccion IN($seccion)"; 
		}
		if(strlen($alumno)>0) { 
			  $sql.= " AND seca_alumno = '$alumno'"; 
		}
		if(strlen($padre)>0) { 
			  $sql.= " AND pad_cui = '$padre'"; 
		}
		$sql.= " ORDER BY seca_pensum ASC, seca_nivel ASC, seca_grado ASC, sec_situacion DESC, sec_tipo ASC, sec_descripcion ASC, alu_apellido ASC, alu_nombre ASC, pad_apellido ASC, pad_nombre ASC ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	
	function insert_padre($cui,$nom,$ape,$parentesco,$tel,$mail,$dir,$trabajo){
		$nom = trim($nom);
		$ape = trim($ape);
		$parentesco = trim($parentesco);
		$tel = trim($tel);
		$dir = trim($dir);
		$trabajo = trim($trabajo);
		$mail = strtolower($mail);
		$fecha = date("Y-m-d");
		//--------
		$departamento = $this->departamento;
		$municipio = $this->municipio;
		//--------
		$sql = "INSERT INTO app_padres";
		$sql.= " VALUES ('$cui','DPI','$nom','$ape','$fecha','$parentesco','','','$tel','$tel','$mail','$dir',$departamento,$municipio,'$trabajo','','',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_padre($cui,$nom,$ape,$parentesco,$tel,$mail,$dir,$trabajo){
		$nom = trim($nom);
		$ape = trim($ape);
		$parentesco = trim($parentesco);
		$tel = trim($tel);
		$dir = trim($dir);
		$trabajo = trim($trabajo);
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_padres SET ";
		$sql.= "pad_nombre = '$nom',"; 
		$sql.= "pad_apellido = '$ape',"; 
		$sql.= "pad_parentesco = '$parentesco',"; 
		$sql.= "pad_telefono = '$tel',"; 		
		$sql.= "pad_mail = '$mail'";
		if(strlen($dir)>0) { 
		$sql.= ", pad_direccion = '$dir'";
		}
		if(strlen($trabajo)>0) { 
		$sql.= ", pad_lugar_trabajo = '$trabajo'";
		}
		
		$sql.= " WHERE pad_cui = '$cui'; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_padre_perfil($dpi,$tipodpi,$nombre,$apellido,$fecnac,$parentesco,$ecivil,$nacionalidad,$mail,$telcasa,$celular,$direccion,$departamento,$municipio,$trabajo,$teltrabajo,$profesion){
		//pasa a mayusculas
		$nombre = trim($nombre);
		$apellido = trim($apellido);
		$nacionalidad = trim($nacionalidad);
		$direccion = trim($direccion);
		$trabajo = trim($trabajo);
		$profesion = trim($profesion);
		//--
		$mail = strtolower($mail);
		//--------
		$fecnac = $this->regresa_fecha($fecnac);
		
		$sql = "UPDATE app_padres SET ";
		$sql.= "pad_tipo_dpi = '$tipodpi',"; 
		$sql.= "pad_nombre = '$nombre',"; 
		$sql.= "pad_apellido = '$apellido',"; 
		$sql.= "pad_fec_nac = '$fecnac',"; 		
		$sql.= "pad_parentesco = '$parentesco',"; 		
		$sql.= "pad_estado_civil = '$ecivil',"; 		
		$sql.= "pad_nacionalidad = '$nacionalidad',"; 		
		$sql.= "pad_mail = '$mail',";
		$sql.= "pad_telefono = '$telcasa',"; 		
		$sql.= "pad_celular = '$celular',"; 		
		$sql.= "pad_direccion = '$direccion',";
		$sql.= "pad_departamento = '$departamento',";
		$sql.= "pad_municipio = '$municipio',";
		$sql.= "pad_lugar_trabajo = '$trabajo',";
		$sql.= "pad_telefono_trabajo = '$teltrabajo',";
		$sql.= "pad_profesion = '$profesion'";
		
		$sql.= " WHERE pad_cui = '$dpi'; "; 	
		//echo $sql;
		return $sql;
	}
	
	function modificar_mail($cui,$mail){
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_padres SET ";
		$sql.= "pad_mail = '$mail'"; 
				
		$sql.= " WHERE pad_cui = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function modificar_campo($campo,$valor,$cui){
		$valor = trim($valor);
		
		$sql = "UPDATE app_padres SET ";
		$sql.= "$campo = '$valor'"; 
		
		$sql.= " WHERE pad_cui = '$cui'; "; 	
		
		return $sql;
	}
	
	
	function cambia_sit_padre($cui,$sit){
		
		$sql = "UPDATE app_padres SET ";
		$sql.= "pad_situacion = $sit"; 
				
		$sql.= " WHERE pad_cui = '$cui'; "; 	
		
		return $sql;
	}
	
	function max_padre(){
	        $sql = "SELECT max(pad_cui) as max ";
		$sql.= " FROM app_padres";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
