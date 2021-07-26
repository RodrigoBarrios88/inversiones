<?php
require_once ("ClsConex.php");

class ClsOtrosUsu extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
    function get_otros_usuarios($cui,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	    $sql= "SELECT *, ";
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo = 1 AND usu_tipo_codigo = otro_cui) AS otro_usu_id";
		$sql.= " FROM app_otros_usuarios";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND otro_cui = $cui"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND otro_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND otro_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND otro_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY otro_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_otros_usuarios($cui,$nom = '',$ape = '',$sit = '') {
		$nom = trim($nom);
		$ape = trim($ape);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_otros_usuarios";
		$sql.= " WHERE 1 = 1";
		if(strlen($cui)>0) { 
			  $sql.= " AND otro_cui = $cui"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND otro_nombre like '%$nom%'"; 
		}
		if(strlen($ape)>0) { 
			  $sql.= " AND otro_apellido like '%$ape%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND otro_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_otros_usuarios($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$tel = trim($tel);
		$mail = strtolower($mail);
		$fecnac = $this->regresa_fecha($fecnac);
		
		$sql = "INSERT INTO app_otros_usuarios";
		$sql.= " VALUES ($cui,'$nom','$ape','$titulo','$fecnac','$tel','$mail',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_otros_usuarios($cui,$nom,$ape,$titulo,$fecnac,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$tel = trim($tel);
		$mail = strtolower($mail);
		$fecnac = $this->regresa_fecha($fecnac);
		
		$sql = "UPDATE app_otros_usuarios SET ";
		$sql.= "otro_nombre = '$nom',"; 
		$sql.= "otro_apellido = '$ape',"; 
		$sql.= "otro_titulo = '$titulo',"; 
		$sql.= "otro_fecha_nacimiento = '$fecnac',"; 
		$sql.= "otro_telefono = '$tel',"; 		
		$sql.= "otro_mail = '$mail'";
		
		$sql.= " WHERE otro_cui = $cui; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_otros_usuarios_perfil($cui,$nom,$ape,$titulo,$tel,$mail){
		$nom = trim($nom);
		$ape = trim($ape);
		$titulo = trim($titulo);
		$tel = trim($tel);
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_otros_usuarios SET ";
		$sql.= "otro_nombre = '$nom',"; 
		$sql.= "otro_apellido = '$ape',"; 
		$sql.= "otro_titulo = '$titulo',"; 		
		$sql.= "otro_telefono = '$tel',"; 		
		$sql.= "otro_mail = '$mail'";
		
		$sql.= " WHERE otro_cui = $cui; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_otros_usuarios($cui,$sit){
		
		$sql = "UPDATE app_otros_usuarios SET ";
		$sql.= "otro_situacion = $sit"; 
				
		$sql.= " WHERE otro_cui = $cui"; 	
		
		return $sql;
	}
	
}	
?>
