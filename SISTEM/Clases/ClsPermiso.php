<?php
require_once ("ClsConex.php");

class ClsPermiso extends ClsConex{
/* GRUPO */
//////////////////////////////////////////////////////////////////
   
    function get_grupo($id,$desc = '',$clv = ''){
		$desc = trim($desc);
		$clv = trim($clv);
		
        $sql= "SELECT * ";
		$sql.= " FROM perm_grupo_permisos";
		$sql.= " WHERE gperm_situacion = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND gperm_id = $id"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND gperm_desc like '%$desc%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND gperm_clave like '%$clv%'"; 
		}
		$sql.= " ORDER BY gperm_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_grupo($id,$desc = '',$clv = ''){
		$desc = trim($desc);
		$clv = trim($clv);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM perm_grupo_permisos";
		$sql.= " WHERE gperm_situacion = 1";
		if(strlen($id)>0) { 
			  $sql.= " AND gperm_id = $id"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND gperm_desc like '%$desc%'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND gperm_clave like '%$clv%'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_grupo($id,$desc,$clv){
		$desc = trim($desc);
		
		$sql = "INSERT INTO perm_grupo_permisos VALUES ($id,'$desc','$clv',1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_grupo($id,$desc,$clv){
		$desc = trim($desc);
		
		$sql = "UPDATE perm_grupo_permisos SET gperm_desc = '$desc',"; 
		$sql.= " gperm_clave = '$clv'"; 
		$sql.= " WHERE gperm_id = $id;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_grupo($id,$sit){
		
		$sql = "UPDATE perm_grupo_permisos SET gperm_situacion = $sit"; 
		$sql.= " WHERE gperm_id = $id;"; 	
		
		return $sql;
	}
	
	function max_grupo() {
		
        $sql = "SELECT max(gperm_id) as max ";
		$sql.= " FROM perm_grupo_permisos";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
/* PERMISOS */
//////////////////////////////////////////////////////////////////
   
    function get_permisos($id,$grupo,$desc = '',$clv = ''){
		$desc = trim($desc);
		
        $sql= "SELECT * ";
		$sql.= " FROM perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE perm_grupo = gperm_id";
		if(strlen($id)>0) { 
			  $sql.= " AND perm_id = $id"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND perm_grupo = $grupo"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND perm_desc like '%$desc%'"; 
		}
		if(strlen($clv)>0) { 
			  $sql.= " AND perm_clave = '$clv'"; 
		}
		$sql.= " ORDER BY perm_grupo ASC, perm_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_permisos($id,$grupo,$desc = '',$clv = ''){
		$desc = trim($desc);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE perm_grupo = gperm_id";
		if(strlen($id)>0) { 
			  $sql.= " AND perm_id = $id"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND perm_grupo = $grupo"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND perm_desc like '%$desc%'"; 
		}
		if(strlen($clv)>0) { 
			  $sql.= " AND perm_clave = '$clv'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function insert_permisos($id,$grupo,$desc,$clv){
		$desc = trim($desc);
		$clv = trim($clv);
		
		$sql = "INSERT INTO perm_permisos VALUES ($id,$grupo,'$desc','$clv');";
		//echo $sql;
		return $sql;
	}
	
	function modifica_permisos($id,$grupo,$desc,$clv){
		$desc = trim($desc);
		
		$sql = "UPDATE perm_permisos SET "; 
		$sql.= " perm_desc = '$desc',";
		$sql.= " perm_clave = '$clv'";
		
		$sql.= " WHERE perm_id = $id"; 	
		$sql.= " AND perm_grupo = $grupo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function max_permiso($grupo) {
		
        $sql = "SELECT max(perm_id) as max ";
		$sql.= " FROM perm_permisos";
		$sql.= " WHERE perm_grupo = $grupo"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}

/* ASIGNACION DE PERMISOS */
//////////////////////////////////////////////////////////////////
	function insert_perm_asignacion($usu,$rol,$perm,$grupo){
		$fec = date("Y-m-d H:i:s");
		$quien = $_SESSION["codigo"];
		$sql = "INSERT INTO perm_asignacion ";
		$sql.= "(aperm_usuario,aperm_roll,aperm_permiso,aperm_grupo,aperm_fecha,aperm_quien) ";
		$sql.= "VALUES ($usu,$rol,$perm,$grupo,'$fec',$quien); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delet_perm_asignacion($usu){
		$sql = "DELETE FROM perm_asignacion"; 
		$sql.= " WHERE aperm_usuario = $usu; ";
		//echo $sql;
		return $sql;
	}
	
	function get_asi_permisos($usu,$roll = '',$perm = '',$grupo = '',$quien = ''){
		
        $sql= "SELECT *, ";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = aperm_quien) as quien";
		$sql.= " FROM perm_asignacion,seg_usuarios,perm_roll,perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE aperm_usuario = usu_id";
		$sql.= " AND aperm_roll = roll_id";
		$sql.= " AND aperm_permiso = perm_id";
		$sql.= " AND aperm_grupo = perm_grupo";
		$sql.= " AND perm_grupo = gperm_id";
		if(strlen($usu)>0) { 
			  $sql.= " AND aperm_usuario = $usu"; 
		}
		if(strlen($roll)>0) { 
			  $sql.= " AND aperm_roll = $roll"; 
		}
		if(strlen($perm)>0) { 
			  $sql.= " AND aperm_permiso = $perm"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND aperm_grupo = $grupo"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND aperm_quien = $quien"; 
		}
		$sql.= " ORDER BY perm_grupo ASC, perm_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_asi_permisos($usu,$roll = '',$perm = '',$grupo = '',$quien = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM perm_asignacion,seg_usuarios,perm_roll,perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE aperm_usuario = usu_id";
		$sql.= " AND aperm_roll = roll_id";
		$sql.= " AND aperm_permiso = perm_id";
		$sql.= " AND aperm_grupo = perm_grupo";
		$sql.= " AND perm_grupo = gperm_id";
		if(strlen($usu)>0) { 
			  $sql.= " AND aperm_usuario = $usu"; 
		}
		if(strlen($roll)>0) { 
			  $sql.= " AND aperm_roll = $roll"; 
		}
		if(strlen($perm)>0) { 
			  $sql.= " AND aperm_permiso = $perm"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND aperm_grupo = $grupo"; 
		}
		if(strlen($quien)>0) { 
			  $sql.= " AND aperm_quien = $quien"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

/* HISTORIAL DE PERMISOS */
//////////////////////////////////////////////////////////////////

	function insert_hist_asignacion($usu,$rol,$perm,$grupo){
		$fini = date("Y-m-d H:i:s");
		$ffin = "0000-00-00 00:00:00";
		$quien = $_SESSION["codigo"];
		$sql = "INSERT INTO perm_historial ";
		$sql.= "(hperm_usuario,hperm_roll,hperm_permiso,hperm_grupo,hperm_fec_ini,hperm_fec_fin,hperm_quien_ini,hperm_quien_fin) ";
		$sql.= "VALUES ($usu,$rol,$perm,$grupo,'$fini','$ffin',$quien,0); ";
		//echo $sql;
		return $sql;
	}
	
	
	function update_hist_asignacion($usu){
		$ffin = date("Y-m-d H:i:s");
		$quien = $_SESSION["codigo"];
		$sql = "UPDATE perm_historial SET "; 
		$sql.= " hperm_fec_fin = '$ffin',";
		$sql.= " hperm_quien_fin = $quien";
		
		$sql.= " WHERE hperm_usuario = $usu; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function get_hist_permisos($usu,$roll = '',$perm = '',$grupo = '',$quienini = '',$quienfin = ''){
		
        $sql= "SELECT *, ";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = hperm_quien_ini) as quien_ini,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_id = hperm_quien_fin) as quien_fin";
		$sql.= " FROM perm_historial,seg_usuarios,perm_roll,perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE hperm_usuario = usu_id";
		$sql.= " AND hperm_roll = roll_id";
		$sql.= " AND hperm_permiso = perm_id";
		$sql.= " AND hperm_grupo = perm_grupo";
		$sql.= " AND perm_grupo = gperm_id";
		if(strlen($usu)>0) { 
			  $sql.= " AND hperm_usuario = $usu"; 
		}
		if(strlen($roll)>0) { 
			  $sql.= " AND hperm_roll = $roll"; 
		}
		if(strlen($perm)>0) { 
			  $sql.= " AND hperm_permiso = $perm"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND hperm_grupo = $grupo"; 
		}
		if(strlen($quienini)>0) { 
			  $sql.= " AND hperm_quien_ini = $quienini"; 
		}
		if(strlen($quienfin)>0) { 
			  $sql.= " AND hperm_quien_fin = $quienfin"; 
		}
		$sql.= " ORDER BY perm_grupo ASC, perm_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_hist_permisos($usu,$roll = '',$perm = '',$grupo = '',$quienini = '',$quienfin = ''){
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM perm_historial,seg_usuarios,perm_roll,perm_permisos,perm_grupo_permisos";
		$sql.= " WHERE hperm_usuario = usu_id";
		$sql.= " AND hperm_roll = roll_id";
		$sql.= " AND hperm_permiso = perm_id";
		$sql.= " AND hperm_grupo = perm_grupo";
		$sql.= " AND perm_grupo = gperm_id";
		if(strlen($usu)>0) { 
			  $sql.= " AND hperm_usuario = $usu"; 
		}
		if(strlen($roll)>0) { 
			  $sql.= " AND hperm_roll = $roll"; 
		}
		if(strlen($perm)>0) { 
			  $sql.= " AND hperm_permiso = $perm"; 
		}
		if(strlen($grupo)>0) { 
			  $sql.= " AND hperm_grupo = $grupo"; 
		}
		if(strlen($quienini)>0) { 
			  $sql.= " AND hperm_quien_ini = $quienini"; 
		}
		if(strlen($quienfin)>0) { 
			  $sql.= " AND hperm_quien_fin = $quienfin"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

	
}	
?>
