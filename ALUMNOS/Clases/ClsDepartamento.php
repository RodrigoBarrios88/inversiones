<?php
require_once ("ClsConex.php");

class ClsDepartamento extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
    function get_departamento($id,$emp = '',$dct = '',$dlg = '',$sit = '') {
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT * ";
		$sql.= " FROM org_departamento, mast_sucursal";
		$sql.= " WHERE dep_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND dep_id = $id"; 
		}
		if(strlen($emp)>0) { 
			  $sql.= " AND dep_sucursal = $emp"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND dep_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND dep_desc_lg like '%$dlg%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND dep_situacion = $sit"; 
		}
		$sql.= " ORDER BY suc_id ASC, dep_id ASC, dep_situacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_departamento($id,$emp = '',$dct = '',$dlg = '',$sit = '') {
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM org_departamento, mast_sucursal";
		$sql.= " WHERE dep_sucursal = suc_id";
		if(strlen($id)>0) { 
			  $sql.= " AND dep_id = $id"; 
		}
		if(strlen($emp)>0) { 
			  $sql.= " AND dep_sucursal = $emp"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND dep_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND dep_desc_lg like '%$dlg%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND dep_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_departamento($id,$dct,$dlg,$emp,$sit){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql = "INSERT INTO org_departamento (dep_id,dep_desc_ct,dep_desc_lg,dep_sucursal,dep_situacion)";
		$sql.= " VALUES ($id,'$dct','$dlg',$emp,$sit); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_departamento($id,$dct,$dlg){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql = "UPDATE org_departamento SET ";
		$sql.= "dep_desc_ct = '$dct',"; 
		$sql.= "dep_desc_lg = '$dlg'"; 
		
		$sql.= " WHERE dep_id = $id; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_departamento($id,$sit){
		
		$sql = "UPDATE org_departamento SET ";
		$sql.= "dep_situacion = $sit"; 
				
		$sql.= " WHERE dep_id = $id"; 	
		
		return $sql;
	}
	
	
	function max_departamento() {
		
        $sql = "SELECT max(dep_id) as max ";
		$sql.= " FROM org_departamento";
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$max = $row["max"];
			}
		}
		//echo $sql;
		return $max;
	}		
	
}	
?>
