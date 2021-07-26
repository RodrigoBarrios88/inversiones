<?php
require_once ("ClsConex.php");

class ClsIncidente extends ClsConex{
   
////// AUXILIARES ////////
    function get_modulos(){
	   $sql ="SELECT * ";
	   $sql.=" FROM hd_modulos";
       $sql.=" WHERE mod_situacion = 1";
	   $sql.=" ORDER BY mod_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
    
    function get_plataformas(){
	   $sql ="SELECT * ";
	   $sql.=" FROM hd_plataformas";
       $sql.=" WHERE pla_situacion = 1";
	   $sql.=" ORDER BY pla_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
    
    function get_tipo_problema(){
	   $sql ="SELECT * ";
	   $sql.=" FROM hd_tipo_problema";
       $sql.=" WHERE tip_situacion = 1";
	   $sql.=" ORDER BY tip_codigo ASC";
		//echo $sql;
		$result = $this->exec_query($sql);
		return $result;
	}
    
////////////////////////////////// INCIDENTES /////////////////////////////////

    function get_incidente($codigo,$situacion = '',$fini = '',$ffin = '',$modulo = '',$plataforma = '',$tipo = '',$prioridad = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT * ";
		$sql.= " FROM hd_incidente, hd_modulos, hd_plataformas, hd_tipo_problema";
		$sql.= " WHERE mod_codigo = inc_modulo";
		$sql.= " AND pla_codigo = inc_plataforma";
		$sql.= " AND tip_codigo = inc_tipo_problema";
		if(strlen($codigo)>0) { 
			$sql.= " AND inc_codigo = $codigo"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND inc_situacion = $sit"; 
		}
        if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND inc_fecha_registro BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($modulo)>0) { 
			$sql.= " AND inc_modulo = $modulo"; 
		}
        if(strlen($plataforma)>0) { 
			$sql.= " AND inc_plataforma = $plataforma"; 
		}
        if(strlen($tipo)>0) { 
			$sql.= " AND inc_tipo_problema = $tipo"; 
		}
        if(strlen($prioridad)>0) { 
			$sql.= " AND inc_prioridad = '$prioridad'"; 
		}
        $sql.= " ORDER BY inc_situacion ASC, inc_prioridad ASC, inc_fecha_registro DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_incidente($codigo,$dct = '',$dlg = '',$pai = '',$sit = ''){
		$dct = trim($dct);
		$dlg = trim($dlg);
		
        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM hd_incidente, hd_modulos, hd_plataformas, hd_tipo_problema";
		$sql.= " WHERE mod_codigo = inc_modulo";
		$sql.= " AND pla_codigo = inc_plataforma";
		$sql.= " AND tip_codigo = inc_tipo_problema";
		if(strlen($codigo)>0) { 
			$sql.= " AND inc_codigo = $codigo"; 
		}
		if(strlen($sit)>0) { 
			$sql.= " AND inc_situacion = $sit"; 
		}
        if($fini != "" && $ffin != "") { 
			$fini = $this->regresa_fecha($fini);
			$ffin = $this->regresa_fecha($ffin);
			$sql.= " AND inc_fecha_registro BETWEEN '$fini 00:00' AND '$ffin 23:59'"; 
		}
		if(strlen($modulo)>0) { 
			$sql.= " AND inc_modulo = $modulo"; 
		}
        if(strlen($plataforma)>0) { 
			$sql.= " AND inc_plataforma = $plataforma"; 
		}
        if(strlen($tipo)>0) { 
			$sql.= " AND inc_tipo_problema = $tipo"; 
		}
        if(strlen($prioridad)>0) { 
			$sql.= " AND inc_prioridad = '$prioridad'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
		
	function insert_incidente($codigo,$modulo,$plataforma,$tipo,$persona,$desc,$prioridad,$obs){
		//--
		$fechor = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		//--
		$sql = "INSERT INTO hd_incidente VALUES($codigo,$modulo,$plataforma,$tipo,'$persona','$desc','$prioridad','$obs','$fechor','$fechor',$usu,1); ";
		//echo $sql;
		return $sql;
	}
	
	function modifica_incidente($codigo,$modulo,$plataforma,$tipo,$persona,$desc,$prioridad,$obs){
		$persona = trim($persona);
		$desc = trim($desc);
        $obs = trim($obs);
		
		$sql = "UPDATE hd_incidente SET ";
		$sql.= "inc_modulo = '$modulo',"; 
		$sql.= "inc_plataforma = '$plataforma',"; 
		$sql.= "inc_tipo_problema = '$tipo',"; 
		$sql.= "inc_persona = '$persona',"; 
		$sql.= "inc_descripcion = '$desc',"; 
		$sql.= "inc_prioridad = '$prioridad',"; 
		$sql.= "inc_observaciones = '$obs'"; 
		
		$sql.= " WHERE inc_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
    
    function modifica_observaciones($codigo,$obs){
		$obs = trim($obs);
		
		$sql = "UPDATE hd_incidente SET ";
		$sql.= "inc_observaciones = '$obs'"; 
		$sql.= " WHERE inc_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
    
	
	function cambia_sit_incidente($codigo,$sit){
		
		$sql = "UPDATE hd_incidente SET ";
		$sql.= "inc_situacion = $sit"; 
				
		$sql.= " WHERE inc_codigo = $codigo; "; 	
		
		return $sql;
	}
	
	function max_incidente() {
		
        $sql = "SELECT max(inc_codigo) as max ";
		$sql.= " FROM hd_incidente";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	

		
	
}	
?>
