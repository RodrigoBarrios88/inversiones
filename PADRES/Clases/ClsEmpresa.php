<?php
require_once ("ClsConex.php");

class ClsEmpresa extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
    function get_sucursal($id,$nom = '',$contac = '',$sit = '') {
		$nom = trim($nom);
		$contac = trim($contac);
		
        $sql= "SELECT * ";
		$sql.= " FROM mast_sucursal";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND suc_id = $id"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND suc_nombre like '%$nom%'"; 
		}
		if(strlen($contac)>0) { 
			  $sql.= " AND suc_contacto like '%$contac%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND suc_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY suc_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_sucursal($id,$nom = '',$contac = '',$sit = '') {
		$nom = trim($nom);
		$contac = trim($contac);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM mast_sucursal";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND suc_id = $id"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND suc_nombre like '%$nom%'"; 
		}
		if(strlen($contac)>0) { 
			  $sql.= " AND suc_contacto like '%$contac%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND suc_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_sucursal($id,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
		$mail = strtolower($mail);
		
		$sql = "INSERT INTO mast_sucursal (suc_id,suc_nombre,suc_direccion,suc_tel1,suc_tel2,suc_mail,suc_contacto,suc_cont_tel,suc_situacion)";
		$sql.= " VALUES ($id,'$nom','$direc','$tel1','$tel2','$mail','$contact','$telc',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_sucursal($id,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
		$mail = strtolower($mail);
		
		$sql = "UPDATE mast_sucursal SET ";
		$sql.= "suc_nombre = '$nom',"; 
		$sql.= "suc_direccion = '$direc',"; 
		$sql.= "suc_tel1 = '$tel1',"; 		
		$sql.= "suc_tel2 = '$tel2',"; 
		$sql.= "suc_mail = '$mail',";
		$sql.= "suc_contacto = '$contact',"; 
		$sql.= "suc_cont_tel = '$telc'";
		
		$sql.= " WHERE suc_id = $id"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_sucursal($id,$sit){
		
		$sql = "UPDATE mast_sucursal SET ";
		$sql.= "suc_situacion = $sit"; 
				
		$sql.= " WHERE suc_id = $id"; 	
		
		return $sql;
	}
	
	function max_sucursal(){
        $sql = "SELECT max(suc_id) as max ";
		$sql.= " FROM mast_sucursal";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
