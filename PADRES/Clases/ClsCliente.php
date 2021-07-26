<?php
require_once ("ClsConex.php");

class ClsCliente extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
    function get_cliente($id,$nit = '',$nom = '') {
		$nom = trim($nom);
		$contac = trim($contac);
		
        $sql= "SELECT * ";
		$sql.= " FROM fin_cliente";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND cli_id = $id"; 
		}
		if(strlen($nit)>0) { 
			  $sql.= " AND cli_nit = '$nit'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND cli_nombre like '%$nom%'"; 
		}
		$sql.= " ORDER BY cli_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_cliente($id,$nit = '',$nom = '') {
		$nom = trim($nom);
		$contac = trim($contac);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM fin_cliente";
		$sql.= " WHERE 1 = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND cli_id = $id"; 
		}
		if(strlen($nit)>0) { 
			  $sql.= " AND cli_nit = '$nit'"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND cli_nombre like '%$nom%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
		$mail = strtolower($mail);
		
		$sql = "INSERT INTO fin_cliente (cli_id,cli_nit,cli_nombre,cli_direccion,cli_tel1,cli_tel2,cli_mail)";
		$sql.= " VALUES ($id,'$nit','$nom','$direc','$tel1','$tel2','$mail');";
		//echo $sql;
		return $sql;
	}
	
	function modifica_cliente($id,$nit,$nom,$direc,$tel1,$tel2,$mail){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel1 = trim($tel1);
		$tel2 = trim($tel2);
		$contact = trim($contact);
		$telc = trim($telc);
		$mail = strtolower($mail);
		
		$sql = "UPDATE fin_cliente SET ";
		$sql.= "cli_nit = '$nit',"; 
		$sql.= "cli_nombre = '$nom',"; 
		$sql.= "cli_direccion = '$direc',"; 
		$sql.= "cli_tel1 = '$tel1',"; 		
		$sql.= "cli_tel2 = '$tel2',"; 
		$sql.= "cli_mail = '$mail'";
		
		$sql.= " WHERE cli_id = $id"; 	
		//echo $sql;
		return $sql;
	}
	
	function max_cliente(){
        $sql = "SELECT max(cli_id) as max ";
		$sql.= " FROM fin_cliente";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
