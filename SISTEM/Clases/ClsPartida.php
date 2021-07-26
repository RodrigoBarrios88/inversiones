<?php
require_once ("ClsConex.php");

class ClsPartida extends ClsConex{
   
    function get_partida($cod,$tipo = '',$clase = '',$desc = '',$sit = ''){
		$desc = trim($desc);
		
		$sql= "SELECT * ";
		$sql.= " FROM fin_partida, fin_partida_clase";
		$sql.= " WHERE par_clase = cla_codigo";
		if(strlen($cod)>0) { 
			$sql.= " AND par_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($clase)>0) { 
			$sql.= " AND par_clase = '$clase'"; 
		}
		if(strlen($desc)>0) { 
			$sql.= " AND par_descripcion like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND par_situacion = $sit"; 
		}
		$sql.= " ORDER BY par_tipo ASC, par_clase ASC, par_situacion ASC, par_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_partida($cod,$tipo = '',$clase = '',$desc = '',$sit = ''){
		$desc = trim($desc);
		
		$sql= "SELECT COUNT(*) as total ";
		$sql.= " FROM fin_partida, fin_partida_clase";
		$sql.= " WHERE par_clase = cla_codigo";
		if(strlen($cod)>0) { 
			$sql.= " AND par_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($clase)>0) { 
			$sql.= " AND par_clase = '$clase'"; 
		}
		if(strlen($desc)>0) { 
			$sql.= " AND par_descripcion like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND par_situacion = $sit"; 
		}
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
		    foreach($result as $row){
			$total = $row["total"];
		    }
		}    
		//echo $sql;
		return $total;

	}
	
	function insert_partida($id,$tipo,$clase,$desc){
		$tipo = trim($tipo);
		$clase = trim($clase);
		$desc = trim($desc);
		
		$sql = "INSERT INTO fin_partida ";
		$sql.= "VALUES ($id,'$tipo','$clase','$desc',1) ";
		$sql.= "ON DUPLICATE KEY UPDATE ";
		$sql.= "par_tipo = '$tipo', "; 
		$sql.= "par_clase = '$clase', "; 
		$sql.= "par_descripcion = '$desc'; "; 
		//echo $sql;
		return $sql;
	}

	
	function comprueba_sit_partida($cod) {
		
		$sql = "SELECT reg_situacion as sit";
		$sql.= " FROM fin_reglon";
		$sql.= " WHERE reg_partida = $cod;"; 	
		$result = $this->exec_query($sql);
		if(is_array($result)){
			foreach($result as $row){
				$sit = $row["sit"];
				if($sit == 1){
					return true;
				}
			}
		}
		//echo $sql;
		return false;
	}
	
	function cambia_sit_partida($id,$sit){
		
		$sql = "UPDATE fin_partida SET ";
		$sql.= "par_situacion = $sit"; 
				
		$sql.= " WHERE par_codigo = $id"; 	
		
		return $sql;
	}
	
	
	function max_partida() {
		
		$sql = "SELECT max(par_codigo) as max ";
		$sql.= " FROM fin_partida";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
	///////////////// CLASIFICACION /////////////
	
	function get_clase($cod,$tipo = '',$desc = '',$sit = ''){
		$desc = trim($desc);
		
		$sql= "SELECT * ";
		$sql.= " FROM fin_partida_clase";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			$sql.= " AND cla_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cla_tipo = '$tipo'"; 
		}
		if(strlen($desc)>0) { 
			$sql.= " AND cla_desc like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND cla_situacion = $sit"; 
		}
		$sql.= " ORDER BY cla_tipo ASC, cla_situacion ASC, cla_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_clase($cod,$tipo = '',$desc = '',$sit = ''){
		$desc = trim($desc);
		
		$sql= "SELECT COUNT(*) as total ";
		$sql.= " FROM fin_partida_clase";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			$sql.= " AND cla_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND cla_tipo = '$tipo'"; 
		}
		if(strlen($desc)>0) { 
			$sql.= " AND cla_desc like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND cla_situacion = $sit"; 
		}
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
		    foreach($result as $row){
                $total = $row["total"];
		    }
		}    
		//echo $sql;
		return $total;

	}
	
	function insert_clase($id,$tipo,$desc){
		$tipo = trim($tipo);
		$desc = trim($desc);
		
		$sql = "INSERT INTO fin_partida_clase ";
		$sql.= "VALUES ($id,'$tipo','$desc',1) ";
		$sql.= "ON DUPLICATE KEY UPDATE ";
		$sql.= "cla_tipo = '$tipo', "; 
		$sql.= "cla_descripcion = '$desc'; "; 
		//echo $sql;
		return $sql;
	}

	function cambia_sit_clase($id,$sit){
		
		$sql = "UPDATE fin_partida_clase SET ";
		$sql.= "cla_situacion = $sit"; 
				
		$sql.= " WHERE cla_codigo = $id"; 	
		
		return $sql;
	}
	
	
	function max_clase() {
		
		$sql = "SELECT max(cla_codigo) as max ";
		$sql.= " FROM fin_partida_clase";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
    ///////////////// REGLON ///////////////////
    
	function get_reglon($cod,$part = '',$tipo = '',$dct = '',$dlg = '',$sit = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql= "SELECT * ";
		$sql.= " FROM fin_reglon,fin_partida, fin_partida_clase";
		$sql.= " WHERE par_clase = cla_codigo";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND reg_codigo = $cod"; 
		}
		if(strlen($part)>0) { 
			  $sql.= " AND reg_partida = $part"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND reg_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND reg_desc_lg like '%$dlg%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND reg_situacion = $sit"; 
		}
		$sql.= " ORDER BY par_tipo ASC, reg_partida ASC,  par_clase ASC, reg_situacion ASC, reg_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_reglon($cod,$part = '',$tipo = '',$dct = '',$dlg = '',$sit = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql= "SELECT COUNT(*) as total ";
		$sql.= " FROM fin_reglon,fin_partida, fin_partida_clase";
		$sql.= " WHERE par_clase = cla_codigo";
		$sql.= " AND reg_partida = par_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND reg_codigo = $cod"; 
		}
		if(strlen($part)>0) { 
			  $sql.= " AND reg_partida = $part"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($dct)>0) { 
			  $sql.= " AND reg_desc_ct like '%$dct%'"; 
		}
		if(strlen($dlg)>0) { 
			  $sql.= " AND reg_desc_lg like '%$dlg%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND reg_situacion = $sit"; 
		}
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
		    foreach($result as $row){
			$total = $row["total"];
		    }
		}   
		//echo $sql;
		return $total;

	}
		
		
	function insert_reglon($id,$par,$dct,$dlg){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
		$sql = "INSERT INTO fin_reglon ";
		$sql.= "VALUES ($id,$par,'$dct','$dlg',1) ";
		$sql.= "ON DUPLICATE KEY UPDATE ";
		$sql.= "reg_desc_ct = '$dct',"; 
		$sql.= "reg_desc_lg = '$dlg'; "; 
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_reglon($id,$par,$sit){
		
		$sql = "UPDATE fin_reglon SET ";
		$sql.= "reg_situacion = $sit"; 
				
		$sql.= " WHERE reg_partida = $par "; 	
		$sql.= " AND reg_codigo = $id; "; 	
		
		return $sql;
	}
	
	
	function max_reglon($par) {
		
		$sql = "SELECT max(reg_codigo) as max ";
		$sql.= " FROM fin_reglon";
		$sql.= " WHERE reg_partida = $par; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	///////////////// SUBREGLON ///////////////////
    
	function get_subreglon($cod,$partida = '',$reglon = '',$tipo = '',$desc = '',$sit = ''){
		$reglon = trim($reglon);
		$desc = trim($desc);
		
		$sql= "SELECT * ";
		$sql.= " FROM fin_subreglon,fin_reglon,fin_partida,fin_partida_clase";
		$sql.= " WHERE par_clase = cla_codigo";
		$sql.= " AND sub_partida = par_codigo";
		$sql.= " AND sub_partida = reg_partida";
		$sql.= " AND sub_reglon = reg_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND sub_codigo = $cod"; 
		}
		if(strlen($partida)>0) { 
			  $sql.= " AND sub_partida = $partida"; 
		}
		if(strlen($reglon)>0) { 
			  $sql.= " AND sub_reglon = $reglon"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND sub_descripcion like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND sub_situacion = $sit"; 
		}
		$sql.= " ORDER BY par_tipo ASC, sub_partida ASC,  par_clase ASC, sub_situacion ASC, sub_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_subreglon($cod,$partida = '',$reglon = '',$tipo = '',$desc = '',$sit = ''){
		$reglon = trim($reglon);
		$desc = trim($desc);
		
		$sql= "SELECT COUNT(*) as total ";
		$sql.= " FROM fin_subreglon,fin_reglon,fin_partida,fin_partida_clase";
		$sql.= " WHERE par_clase = cla_codigo";
		$sql.= " AND sub_partida = par_codigo";
		$sql.= " AND sub_partida = reg_partida";
		$sql.= " AND sub_reglon = reg_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND sub_codigo = $cod"; 
		}
		if(strlen($partida)>0) { 
			  $sql.= " AND sub_partida = $partida"; 
		}
		if(strlen($reglon)>0) { 
			  $sql.= " AND sub_reglon = $reglon"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND par_tipo = '$tipo'"; 
		}
		if(strlen($desc)>0) { 
			  $sql.= " AND sub_descripcion like '%$desc%'"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND sub_situacion = $sit"; 
		}
		
		$result = $this->exec_query($sql);
		if(is_array($result)){
		    foreach($result as $row){
			$total = $row["total"];
		    }
		}   
		//echo $sql;
		return $total;

	}
		
		
	function insert_subreglon($cod,$partida,$reglon,$desc){
		$reglon = trim($reglon);
		$desc = trim($desc);
		
		$sql = "INSERT INTO fin_subreglon ";
		$sql.= "VALUES ($cod,$partida,$reglon,'$desc',1) ";
		$sql.= "ON DUPLICATE KEY UPDATE ";
		$sql.= "sub_reglon = '$reglon',"; 
		$sql.= "sub_descripcion = '$desc'; "; 
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_subreglon($cod,$partida,$reglon,$sit){
		
		$sql = "UPDATE fin_subreglon SET ";
		$sql.= "sub_situacion = $sit"; 
				
		$sql.= " WHERE sub_partida = $partida ";
        $sql.= " AND sub_reglon = $reglon ";
		$sql.= " AND sub_codigo = $cod; "; 	
		
		return $sql;
	}
	
	
	function max_subreglon($partida,$reglon) {
		
		$sql = "SELECT max(sub_codigo) as max ";
		$sql.= " FROM fin_subreglon";
		$sql.= " WHERE sub_partida = $partida "; 	
		$sql.= " AND sub_reglon = $reglon; "; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
}	
?>
