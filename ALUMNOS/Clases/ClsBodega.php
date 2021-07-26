<?php
require_once ("ClsConex.php");

class ClsBodega extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
   
    function get_bodega($id,$emp,$nom = '',$dir = '',$sit = '') {
		$nom = trim($nom);
		$dir = trim($dir);
		
        $sql= "SELECT * ";
		$sql.= " FROM inv_bodega, mast_sucursal";
		$sql.= " WHERE bod_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND bod_codigo = $id"; 
		}
		if(strlen($emp)>0) { 
			  $sql.= " AND bod_sucursal = $emp"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND bod_nombre like '%$nom%'"; 
		}
		if(strlen($dir)>0) { 
			  $sql.= " AND bod_direccion like '%$dir%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND bod_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY bod_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_bodega($id,$emp,$nom = '',$dir = '',$sit = '') {
		$nom = trim($nom);
		$dir = trim($dir);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM inv_bodega, mast_sucursal";
		$sql.= " WHERE bod_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND bod_codigo = $id"; 
		}
		if(strlen($emp)>0) { 
			  $sql.= " AND bod_sucursal = $emp"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND bod_nombre like '%$nom%'"; 
		}
		if(strlen($dir)>0) { 
			  $sql.= " AND bod_direccion like '%$dir%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND bod_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_bodega($id,$emp,$nom,$direc,$tel){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel = trim($tel);
		
		$sql = "INSERT INTO inv_bodega (bod_codigo,bod_sucursal,bod_nombre,bod_direccion,bod_telefono,bod_situacion)";
		$sql.= " VALUES ($id,$emp,'$nom','$direc','$tel',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_bodega($id,$emp,$nom,$direc,$tel){
		$nom = trim($nom);
		$direc = trim($direc);
		$tel = trim($tel);
		
		$sql = "UPDATE inv_bodega SET ";
		$sql.= "bod_nombre = '$nom',"; 
		$sql.= "bod_direccion = '$direc',"; 
		$sql.= "bod_telefono = '$tel'"; 		
		
		$sql.= " WHERE bod_codigo = $id";
		$sql.= " AND bod_sucursal = $emp";		
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_bodega($id,$emp,$sit){
		
		$sql = "UPDATE inv_bodega SET ";
		$sql.= "bod_situacion = $sit"; 
				
		$sql.= " WHERE bod_codigo = $id"; 
		$sql.= " AND bod_sucursal = $emp";
		
		return $sql;
	}
	
	function max_bodega($emp){
        $sql = "SELECT max(bod_codigo) as max ";
		$sql.= " FROM inv_bodega";
		$sql.= " WHERE bod_sucursal = $emp"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
