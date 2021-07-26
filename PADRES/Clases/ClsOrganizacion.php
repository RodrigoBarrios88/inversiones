<?php
require_once ("ClsConex.php");

class ClsOrganizacion extends ClsConex{
/* Situacion 1 = ACTIVO, 0 = INACTIVO */
   
    function get_plaza($plaza,$suc = '',$dep = '',$dct = '',$dlg = '',$jer = '',$sub = '',$ind = '',$sit = '') {
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT *, plaz_codigo as plaz_plaza_base, ";
		$sql.= " (SELECT COUNT(*) FROM org_plaza WHERE plaz_subord = plaz_plaza_base) as plaz_cantsub,";
		$sql.= " (SELECT recursiva.plaz_desc_ct FROM org_plaza as recursiva WHERE org_plaza.plaz_subord = recursiva.plaz_codigo) as plaz_subord_desc,";
		$sql.= " (SELECT org_personal FROM org_organizacion WHERE org_plaza = plaz_codigo AND org_situacion = 1) as org_personal,";
		$sql.= " (SELECT CONCAT(TRIM(per_nombres), ' ', TRIM(per_apellidos)) FROM org_organizacion, rrhh_personal WHERE org_personal = per_dpi AND org_situacion = 1 AND org_plaza = plaz_codigo) as plaz_personal_nombres";
		$sql.= " FROM org_plaza, org_departamento, mast_sucursal";
		$sql.= " WHERE plaz_departamento = dep_id";
		$sql.= " AND dep_sucursal = suc_id";
		if(strlen($plaza)>0) { 
			  $sql.= " AND plaz_codigo = $plaza"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND suc_id = $suc"; 
		}
		if(strlen($dep)>0) { 
			  $sql.= " AND dep_id = $dep"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND plaz_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND plaz_desc_lg like '%$dlg%'"; 
		}
		if(strlen($jer)>0) { 
			  $sql.= " AND plaz_jerarquia = '$jer'"; 
		}
		if(strlen($sub)>0) { 
			  $sql.= " AND plaz_subord = $sub"; 
		}
		if(strlen($ind)>0) { 
			  $sql.= " AND plaz_independ = $ind"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND plaz_situacion = $sit"; 
		}
		$sql.= " ORDER BY suc_id ASC, dep_id ASC, plaz_jerarquia ASC, plaz_subord ASC, plaz_independ ASC, plaz_codigo ASC  ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_plaza($plaza,$suc = '',$dep = '',$dct = '',$dlg = '',$jer = '',$sub = '',$ind = '',$sit = '') {
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM org_plaza, org_departamento, mast_sucursal";
		$sql.= " WHERE plaz_departamento = dep_id";
		$sql.= " AND dep_sucursal = suc_id";
		if(strlen($plaza)>0) { 
			  $sql.= " AND plaz_codigo = $plaza"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND suc_id = $suc"; 
		}
		if(strlen($dep)>0) { 
			  $sql.= " AND dep_id = $dep"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND plaz_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND plaz_desc_lg like '%$dlg%'"; 
		}
		if(strlen($jer)>0) { 
			  $sql.= " AND plaz_jerarquia = '$jer'"; 
		}
		if(strlen($sub)>0) { 
			  $sql.= " AND plaz_subord = $sub"; 
		}
		if(strlen($ind)>0) { 
			  $sql.= " AND plaz_independ = $ind"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND plaz_situacion = $sit"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_solo_plaza_sucursal($suc = '',$dep = '',$sit = '') {
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT plaz_codigo ";
		$sql.= " FROM org_plaza, org_departamento, mast_sucursal";
		$sql.= " WHERE plaz_departamento = dep_id";
		$sql.= " AND dep_sucursal = suc_id";
		if(strlen($suc)>0) { 
			  $sql.= " AND suc_id = $suc"; 
		}
		if(strlen($dep)>0) { 
			  $sql.= " AND plaz_departamento = $dep"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND plaz_situacion = $sit"; 
		}
		$sql.= " ORDER BY suc_id ASC, dep_id ASC, plaz_jerarquia ASC, plaz_subord ASC, plaz_independ ASC, plaz_codigo ASC  ";
		
		//echo $sql;
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$cadena.= $row['plaz_codigo'].",";
			}
		}
		return $cadena;

	}
		
	function insert_plaza($plaza,$dct,$dlg,$salario,$horas,$dep,$jer,$sub,$ind,$sit){
		$dct = trim($dct);
		$dlg = trim($dlg);
		$sub = ($sub == "")?0:$sub;
		$sql = "INSERT INTO org_plaza";
		$sql.= " VALUES ($plaza,'$dct','$dlg',$salario,$horas,$dep,'$jer',$sub,$ind,$sit);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_plaza($id,$dct,$dlg,$salario,$horas,$dep,$jer,$sub,$ind){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql = "UPDATE org_plaza SET ";
		$sql.= "plaz_desc_ct = '$dct',"; 
		$sql.= "plaz_desc_lg = '$dlg',"; 
		$sql.= "plaz_salario_hora = $salario,"; 
		$sql.= "plaz_horas_promedio = '$horas',"; 
		$sql.= "plaz_departamento = $dep,"; 
		$sql.= "plaz_jerarquia = '$jer',"; 
		$sql.= "plaz_subord = $sub,"; 
		$sql.= "plaz_independ = $ind"; 
		
		$sql.= " WHERE plaz_codigo = $id;"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_plaza($id,$sit){
		
		$sql = "UPDATE org_plaza SET ";
		$sql.= "plaz_situacion = $sit"; 
				
		$sql.= " WHERE plaz_codigo = $id"; 	
		
		return $sql;
	}
	
	
	function max_plaza() {
		
        $sql = "SELECT max(plaz_codigo) as max ";
		$sql.= " FROM org_plaza";
		$sql.= " WHERE 1 = 1"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
	function max_jerarquia($suc,$dep='') {
		
        $sql = "SELECT MIN(plaz_jerarquia) as min ";
		$sql.= " FROM org_plaza, org_departamento";
		$sql.= " WHERE plaz_departamento = dep_id";
		$sql.= " AND dep_sucursal = $suc"; 
		if(strlen($dep)>0) { 
			$sql.= " AND plaz_departamento = $dep"; 
		}
		$sql.= " AND plaz_situacion = 1"; 
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["min"];
		}
		//echo $sql;
		return $max;
	}
	
//////////////////////// ORGANIZACION //////////////////////////////////////////

	function get_organizacion($personal = '', $plaza = '', $suc = '', $dep = '', $dct = '', $dlg = '', $jer = '', $sub = '', $ind = '', $sit = '') {
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT *, plaz_codigo as plaz_plaza_base, ";
		$sql.= " (SELECT COUNT(*) FROM org_plaza WHERE plaz_subord = plaz_plaza_base) as plaz_cantsub,";
		$sql.= " (SELECT recursiva.plaz_desc_ct FROM org_plaza as recursiva WHERE org_plaza.plaz_subord = recursiva.plaz_codigo) as plaz_subord_desc";
		$sql.= " FROM org_organizacion, rrhh_personal, org_plaza, org_departamento, mast_sucursal";
		$sql.= " WHERE org_personal = per_dpi";
		$sql.= " AND org_plaza = plaz_codigo";
		$sql.= " AND plaz_departamento = dep_id";
		$sql.= " AND dep_sucursal = suc_id";
		if(strlen($personal)>0) { 
			  $sql.= " AND org_personal = $personal"; 
		}
		if(strlen($plaza)>0) { 
			  $sql.= " AND org_plaza = $plaza"; 
		}
		if(strlen($suc)>0) { 
			  $sql.= " AND suc_id = $suc"; 
		}
		if(strlen($dep)>0) { 
			  $sql.= " AND dep_id = $dep"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND plaz_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND plaz_desc_lg like '%$dlg%'"; 
		}
		if(strlen($jer)>0) { 
			  $sql.= " AND plaz_jerarquia = '$jer'"; 
		}
		if(strlen($sub)>0) { 
			  $sql.= " AND plaz_subord = $sub"; 
		}
		if(strlen($ind)>0) { 
			  $sql.= " AND plaz_independ = $ind"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND org_situacion = $sit"; 
		}
		$sql.= " ORDER BY suc_id ASC, dep_id ASC, plaz_jerarquia ASC, plaz_subord ASC, plaz_independ ASC, plaz_codigo ASC  ";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	
	function insert_organizacion($codigo,$personal,$plaza){
		
		$freg = date("Y-m-d H:i:s");
        $usu = $_SESSION["codigo"];
		$sql = "INSERT INTO org_organizacion ";
		$sql.= " VALUES ($codigo,$personal,$plaza,'$freg',$usu,1);";
		//echo $sql;
		return $sql;
	}
	
	
	function anula_organizacion($personal){
		
		$sql = "UPDATE org_organizacion SET ";
		$sql.= "org_situacion = 0"; 
				
		$sql.= " WHERE org_personal = $personal;"; 	
		
		return $sql;
	}
    
    function max_organizacion($personal) {
		
        $sql = "SELECT max(org_codigo) as max ";
		$sql.= " FROM org_organizacion";
		$sql.= " WHERE org_personal = $personal";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
