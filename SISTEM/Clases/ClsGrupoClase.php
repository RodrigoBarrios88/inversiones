<?php
require_once ("ClsConex.php");

class ClsGrupoClase extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */
  
      function get_grupo_clase($cod,$nom = '',$area = '',$segmento = '',$sit = '') {
		$nom = trim($nom);
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo,app_segmento,app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND gru_codigo = $cod"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND gru_nombre like '%$nom%'"; 
		}
		if(strlen($area)>0) { 
			  $sql.= " AND gru_area = $area"; 
		}
		if(strlen($segmento)>0) { 
			  $sql.= " AND gru_segmento = $segmento"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gru_situacion = '$sit'"; 
		}
		$sql.= " ORDER BY gru_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_grupo_clase($cod,$nom = '',$area = '',$segmento = '',$sit = '') {
		$nom = trim($nom);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_grupo,app_segmento,app_area";
		$sql.= " WHERE gru_segmento = seg_codigo";
		$sql.= " AND gru_area = seg_area";
		$sql.= " AND seg_area = are_codigo";
		if(strlen($cod)>0) { 
			  $sql.= " AND gru_codigo = $cod"; 
		}
		if(strlen($nom)>0) { 
			  $sql.= " AND gru_nombre like '%$nom%'"; 
		}
		if(strlen($area)>0) { 
			  $sql.= " AND gru_area = $area"; 
		}
		if(strlen($segmento)>0) { 
			  $sql.= " AND gru_segmento = $segmento"; 
		}
		if(strlen($sit)>0) { 
			  $sql.= " AND gru_situacion = '$sit'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row["total"];
		}
		return $total;
	}
	
	
	
	function insert_grupo_clase($cod,$nom,$area,$segmento){
		$nom = trim($nom);
		
		$sql = "INSERT INTO app_grupo";
		$sql.= " VALUES ($cod,'$nom','$area','$segmento',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function modifica_grupo_clase($cod,$nom,$area,$segmento){
		$nom = trim($nom);
		
		$sql = "UPDATE app_grupo SET ";
		$sql.= "gru_nombre = '$nom',"; 
		$sql.= "gru_area = '$area',"; 
		$sql.= "gru_segmento = '$segmento'"; 		
		
		$sql.= " WHERE gru_codigo = $cod"; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_sit_grupo_clase($cod,$sit){
		
		$sql = "UPDATE app_grupo SET ";
		$sql.= "gru_situacion = $sit"; 
				
		$sql.= " WHERE gru_codigo = $cod"; 	
		
		return $sql;
	}
	
	function max_grupo_clase(){
	        $sql = "SELECT max(gru_codigo) as max ";
		$sql.= " FROM app_grupo";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}		


	function APP_USU(){
	    $fecha = date("Y-m-d");
	    $fechaactual = date("Y-m-d H:i:s");
	    $sql = "SELECT * FROM `push_user` LEFT JOIN seg_usuarios ON usu_tipo_codigo = `user_id` WHERE 1 = 1 AND updated_at BETWEEN '$fecha 00:00:00' AND '$fechaactual' GROUP BY `usu_tipo_codigo` ORDER BY updated_at DESC ";
	    $result = $this->exec_query($sql);
	
		//echo $sql;
		return $result;
	}		

}	
?>
