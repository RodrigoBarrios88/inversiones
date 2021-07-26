<?php
require_once ("ClsConex.php");

class ClsMultimedia extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

/////////////////////////////  POST-IT o Notificaciones //////////////////////////////////////
//////////////  TODOS //////////////////
  
      function get_multimedia($codigo,$tipo = '', $categoria = '', $ordenado_por = '',$limit1 = '',$limit2 = '') {
		$titulo = trim($titulo);
		
		$sql= "SELECT * ";
		$sql.= " FROM app_multimedia";
		$sql.= " WHERE multi_situacion = 1"; 
		if(strlen($codigo)>0) { 
		    $sql.= " AND multi_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND multi_tipo IN($tipo)"; 
		}
		if(strlen($categoria)>0) { 
			$sql.= " AND multi_categoria IN($categoria)"; 
		}
		if(strlen($limit1)>0 && strlen($limit2)>0) { 
			$limite = "LIMIT $limit1,$limit2"; 
		}
		if(strlen($ordenado_por)>0) {
			switch($ordenado_por){
				case 1: $sql.= " ORDER BY multi_fecha_registro DESC, multi_tipo ASC, multi_categoria ASC $limite"; break;
				case 2: $sql.= " ORDER BY multi_contador DESC, multi_tipo ASC, multi_categoria ASC $limite"; break;
				default: $sql.= " ORDER BY multi_tipo ASC, multi_categoria ASC $limite"; break;
			}
			
		}else{
		    $sql.= " ORDER BY multi_codigo DESC $limite";
		}
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	function count_multimedia($codigo,$tipo = '', $categoria = '', $ordenado_por = '') {
		$titulo = trim($titulo);
		
		$sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_multimedia";
		$sql.= " WHERE multi_situacion = 1"; 
		if(strlen($codigo)>0) { 
		    $sql.= " AND multi_codigo = $codigo"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND multi_tipo IN($tipo)"; 
		}
		if(strlen($categoria)>0) { 
			$sql.= " AND multi_categoria IN($categoria)"; 
		}
		
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_multimedia($codigo,$titulo,$link,$tipo,$categoria){
		$titulo = trim($titulo);
		$freg = date("Y-m-d H:i:s");
		$usu = $_SESSION["codigo"];
		
		$sql = "INSERT INTO app_multimedia";
		$sql.= " VALUES ($codigo,'$titulo','$link',$tipo,$categoria,0,'$freg',$usu,1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_multimedia($codigo,$titulo,$link,$tipo,$categoria){
		$titulo = trim($titulo);
		$freg = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_multimedia SET ";
		$sql.= "multi_titulo = '$titulo',"; 
		$sql.= "multi_link = '$link',"; 
		$sql.= "multi_tipo = '$tipo',"; 
		$sql.= "multi_categoria = '$categoria',"; 		
		$sql.= "multi_fecha_registro = '$freg'";
		
		$sql.= " WHERE multi_codigo = $codigo; "; 	
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_multimedia($codigo,$sit){
		$sql = "UPDATE app_multimedia SET ";
		$sql.= "multi_situacion = $sit";
		$sql.= " WHERE multi_codigo = $codigo; "; 	
		
		return $sql;
	}
	
	function contador_multimedia($codigo){
		$sql = "UPDATE app_multimedia SET ";
		$sql.= "multi_contador = (multi_contador + 1)";
		$sql.= " WHERE multi_codigo = $codigo; "; 	
		
		return $sql;
	}

	function max_multimedia(){
	  
	    $sql = "SELECT max(multi_codigo) as max ";
		$sql.= " FROM app_multimedia";
		$sql.= " WHERE 1 = 1";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
