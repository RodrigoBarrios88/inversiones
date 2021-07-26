<?php
require_once ("ClsConex.php");

class ClsRoll extends ClsConex{
/* ROLL */
//////////////////////////////////////////////////////////////////
   
    function get_roll($id,$nom = '',$desc = ''){
		$nom = trim($nom);
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM perm_roll";
		$sql.= " WHERE roll_situacion = 1";
		$sql.= " AND roll_id > 0";
		if(strlen($id)>0){ 
			  $sql.= " AND roll_id = $id"; 
		}
		if(strlen($nom)>0){ 
			  $sql.= " AND roll_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0){ 
			  $sql.= " AND roll_desc like '%$desc%'"; 
		}
		$sql.= " ORDER BY roll_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_roll($id,$nom = '',$desc = ''){
		$nom = trim($nom);
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM perm_roll";
		$sql.= " WHERE roll_situacion = 1";
		$sql.= " AND roll_id > 0";
		if(strlen($id)>0){ 
			  $sql.= " AND roll_id = $id"; 
		}
		if(strlen($nom)>0){ 
			  $sql.= " AND roll_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0){ 
			  $sql.= " AND roll_desc like '%$desc%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_roll_libre($id,$nom = '',$desc = ''){
		$nom = trim($nom);
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM perm_roll";
		$sql.= " WHERE roll_situacion = 1";
		if(strlen($id)>0){ 
			  $sql.= " AND roll_id = $id"; 
		}
		if(strlen($nom)>0){ 
			  $sql.= " AND roll_nombre like '%$nom%'"; 
		}
		if(strlen($desc)>0){ 
			  $sql.= " AND roll_desc like '%$desc%'"; 
		}
		$sql.= " ORDER BY roll_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function insert_roll($id,$nom,$desc){
		$desc = trim($desc);
		
		$sql = "INSERT INTO perm_roll VALUES ($id,'$nom','$desc',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_roll($id,$nom,$desc){
		$desc = trim($desc);
		
		$sql = "UPDATE perm_roll SET roll_nombre = '$nom', roll_desc = '$desc'"; 
		$sql.= " WHERE roll_id = $id;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_roll($id,$sit){
		
		$sql = "UPDATE perm_roll SET roll_situacion = $sit"; 
		$sql.= " WHERE roll_id = $id;"; 	
		
		return $sql;
	}
	
	function max_roll() {
		
        $sql = "SELECT max(roll_id) as max ";
		$sql.= " FROM perm_roll";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/* DETALLE DE ROLL*/
//////////////////////////////////////////////////////////////////
   
    function get_det_roll($perm,$grupo,$roll){
		
        $sql= "SELECT * ";
		$sql.= " FROM perm_permisos,perm_grupo_permisos,perm_roll,perm_det_roll";
		$sql.= " WHERE droll_roll = roll_id";
		$sql.= " AND droll_grupo = gperm_id";
		$sql.= " AND droll_permiso = perm_id";
		$sql.= " AND perm_grupo = gperm_id";
		if(strlen($perm)>0) { 
			  $sql.= " AND droll_permiso = $perm"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND droll_grupo = $grupo"; 
		}
		if(strlen($roll)>0) { 
			  $sql.= " AND droll_roll = $roll"; 
		}
		$sql.= " ORDER BY droll_grupo ASC, droll_permiso ASC, droll_roll ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_det_roll($perm,$grupo,$roll){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM perm_permisos,perm_grupo_permisos,perm_roll,perm_det_roll";
		$sql.= " WHERE droll_roll = roll_id";
		$sql.= " AND droll_grupo = gperm_id";
		$sql.= " AND droll_permiso = perm_id";
		$sql.= " AND perm_grupo = gperm_id";
		if(strlen($perm)>0) { 
			  $sql.= " AND droll_permiso = $perm"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND droll_grupo = $grupo"; 
		}
		if(strlen($roll)>0) { 
			  $sql.= " AND droll_roll = $roll"; 
		}
		$sql.= " ORDER BY droll_grupo ASC, droll_permiso ASC, droll_roll ASC";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function get_det_roll_outer_edit($roll){
		
        $sql= "SELECT *, ";
		//subquery
			$sql.= "(SELECT COUNT(*) FROM perm_det_roll ";
			$sql.= " WHERE droll_roll = $roll";
			$sql.= " AND droll_grupo = perm_grupo";
			$sql.= " AND droll_permiso = perm_id) as activo ";
		//fin subquery
		$sql.= " FROM perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE perm_grupo = gperm_id";
		$sql.= " ORDER BY perm_grupo ASC, perm_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function insert_det_roll($perm,$grupo,$roll){
		
		$sql = "INSERT INTO perm_det_roll VALUES ($perm,$grupo,$roll);";
		//echo $sql;
		return $sql;
	}
	
	function delet_det_roll($perm,$grupo,$roll){
		$sql = "DELETE FROM perm_det_roll"; 
		$sql.= " WHERE droll_permiso = $perm";
		$sql.= " AND droll_grupo = $grupo"; 
		$sql.= " AND droll_roll = $roll;"; 
		//echo $sql;
		return $sql;
	}
	
	function delet_det_roll_grupo($roll){
		$sql = "DELETE FROM perm_det_roll"; 
		$sql.= " WHERE droll_roll = $roll;"; 
		//echo $sql;
		return $sql;
	}

}	
?>
