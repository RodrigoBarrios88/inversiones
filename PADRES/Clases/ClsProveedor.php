<?php
require_once ("ClsConex.php");

class ClsProveedor extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
    function get_proveedor($id,$nit = '',$nom = '',$contac = '',$sit = '') {
		$nom = trim($nom);
		$contac = trim($contac);
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_proveedor";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND prov_id = $id"; 
		}
		if(strlen($nit)>0) { 
			  $sql.= " AND prov_nit = '$nit'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND prov_nombre like '%$nom%'"; 
		}
		if(strlen($contac)>0) { 
			  $sql.= " AND prov_contacto like '%$contac%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND prov_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY prov_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_proveedor($id,$nit = '',$nom = '',$contac = '',$sit = '') {
		$nom = trim($nom);
		$contac = trim($contac);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_proveedor";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND prov_id = $id"; 
		}
		if(strlen($nit)>0) { 
			  $sql.= " AND prov_nit = '$nit'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND prov_nombre like '%$nom%'"; 
		}
		if(strlen($contac)>0) { 
			  $sql.= " AND prov_contacto like '%$contac%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND prov_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_proveedor($id,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
		$mail = strtolower($mail);
		
		$sql = "INSERT INTO fin_proveedor (prov_id,prov_nit,prov_nombre,prov_direccion,prov_tel1,prov_tel2,prov_mail,prov_contacto,prov_cont_tel,prov_situacion)";
		$sql.= " VALUES ($id,'$nit','$nom','$direc','$tel1','$tel2','$mail','$contact','$telc',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_proveedor($id,$nit,$nom,$direc,$tel1,$tel2,$mail,$contact,$telc){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
		$mail = strtolower($mail);
		
		$sql = "UPDATE fin_proveedor SET ";
		$sql.= "prov_nit = '$nit',"; 
		$sql.= "prov_nombre = '$nom',"; 
		$sql.= "prov_direccion = '$direc',"; 
		$sql.= "prov_tel1 = '$tel1',"; 		
		$sql.= "prov_tel2 = '$tel2',"; 
		$sql.= "prov_mail = '$mail',";
		$sql.= "prov_contacto = '$contact',"; 
		$sql.= "prov_cont_tel = '$telc'";
		
		$sql.= " WHERE prov_id = $id"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_proveedor($id,$sit){
		
		$sql = "UPDATE fin_proveedor SET ";
		$sql.= "prov_situacion = $sit"; 
				
		$sql.= " WHERE prov_id = $id"; 	
		
		return $sql;
	}
	
	function max_proveedor(){
        $sql = "SELECT max(prov_id) as max ";
		$sql.= " FROM fin_proveedor";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
