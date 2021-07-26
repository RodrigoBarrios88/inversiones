<?php
require_once ("ClsConex.php");

class ClsMensaje extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

//////////////////////// Grupo de Mensajes ///////////////////////////////////
      function get_grupo_mensaje($cod,$tipo = '',$nombre = '',$admin = '') {
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_grupo_mensajes";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND gru_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND gru_tipo = '$tipo'"; 
		}
		if(strlen($nombre)>0) { 
			  $sql.= " AND gru_nombre like '%$nombre%'"; 
		}
		if(strlen($admin)>0) { 
			  $sql.= " AND gru_admin = '$admin'"; 
		}
		$sql.= " ORDER BY gru_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_grupo_mensaje($cod,$tipo = '',$nombre = '',$admin = '') {
		
	        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_grupo_mensajes";
		$sql.= " WHERE 1 = 1";
		if(strlen($cod)>0) { 
			  $sql.= " AND gru_codigo = $cod"; 
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND gru_tipo = '$tipo'"; 
		}
		if(strlen($nombre)>0) { 
			  $sql.= " AND gru_nombre like '%$nombre%'"; 
		}
		if(strlen($admin)>0) { 
			  $sql.= " AND gru_admin = '$admin'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	
	function insert_grupo_mensaje($cod,$tipo,$nombre){
		$fechor = date("Y-m-d H:i:s");
		$admin = $_SESSION["codigo"];
		
		$sql = "INSERT INTO app_grupo_mensajes";
		$sql.= " VALUES ($cod,'$tipo','$nombre',$admin,'$fechor');";
		//echo $sql;
		return $sql;
	}
	
	function delete_grupo_mensaje($cod,$admin){
		$admin = $_SESSION["codigo"];
		
		$sql = "DELETE FROM app_grupo_mensajes ";
		$sql.= " WHERE gru_codigo = $cod"; 	
		$sql.= " AND gru_admin = $admin"; 
		
		return $sql;
	}
	
	function max_grupo_mensaje(){
	        $sql = "SELECT max(gru_codigo) as max ";
		$sql.= " FROM app_grupo_mensajes";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	

//////////////////////// Miembros del Grupo de Mensajes ///////////////////////////////////
	
	function get_miembro_mensaje($grupo,$usuario,$tipo = '',$nombre = '',$admin = '') {
		
	        $sql= "SELECT * ";
		$sql.= " FROM app_miembros_mensaje,app_grupo_mensaje";
		$sql.= " WHERE gru_codigo = mie_grupo_mensaje";
		if(strlen($grupo)>0) { 
			$sql.= " AND mie_grupo_mensaje = $grupo";
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND mie_usuario = $usuario";
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND gru_tipo = '$tipo'"; 
		}
		if(strlen($nombre)>0) { 
			  $sql.= " AND gru_nombre like '%$nombre%'"; 
		}
		if(strlen($admin)>0) { 
			  $sql.= " AND gru_admin = '$admin'"; 
		}
		$sql.= " ORDER BY mie_grupo_mensaje ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_miembro_mensaje($grupo,$usuario,$tipo = '',$nombre = '',$admin = '') {
		
	        $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_miembros_mensaje,app_grupo_mensaje";
		$sql.= " WHERE gru_codigo = mie_grupo_mensaje";
		if(strlen($grupo)>0) { 
			$sql.= " AND mie_grupo_mensaje = $grupo";
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND mie_usuario = $usuario";
		}
		if(strlen($tipo)>0) { 
			  $sql.= " AND gru_tipo = '$tipo'"; 
		}
		if(strlen($nombre)>0) { 
			  $sql.= " AND gru_nombre like '%$nombre%'"; 
		}
		if(strlen($admin)>0) { 
			  $sql.= " AND gru_admin = '$admin'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}

	
	function insert_miembro_mensaje($grupo,$usuario){
		
		$fechor = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_miembros_mensaje";
		$sql.= " VALUES ($grupo,$usuario,'$fechor');";
		//echo $sql;
		return $sql;
	}
	
	function delete_miembro_mensaje($cod,$admin){
		
		$sql = "DELETE FROM app_miembros_mensaje ";
		$sql.= " WHERE mie_grupo_mensaje = $cod"; 	
		
		return $sql;
	}
	
//////////////////////// Mensajes ///////////////////////////////////
	
	function get_mensaje($chat,$codigo = '',$emisor = '',$receptor = '',$situacion = '') {
		
	        $sql= "SELECT *, ";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_id = msj_emisor) as msj_emisor_nombre,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_id = msj_receptor) as msj_receptor_nombre";
		$sql.= " FROM app_mensaje";
		$sql.= " WHERE 1 = 1";
		if(strlen($chat)>0) { 
			$sql.= " AND msj_chat = $chat"; 
		}
		if(strlen($cod)>0) { 
			$sql.= " AND msj_codigo = $cod"; 
		}
		if(strlen($emisor)>0) { 
			$sql.= " AND msj_emisor = '$emisor'"; 
		}
		if(strlen($receptor)>0) { 
			$sql.= " AND msj_receptor = '$receptor'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND msj_situacion = '$situacion'"; 
		}
		$sql.= " ORDER BY msj_chat ASC, msj_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function count_mensaje($chat,$codigo = '',$emisor = '',$receptor = '',$situacion = '') {
		$emisor = trim($emisor);
		$receptor = trim($receptor);
		
	        $sql= "SELECT COUNT(*) as total";
		if(strlen($chat)>0) { 
			$sql.= " AND msj_chat = $chat"; 
		}
		if(strlen($cod)>0) { 
			$sql.= " AND msj_codigo = $cod"; 
		}
		if(strlen($emisor)>0) { 
			$sql.= " AND msj_emisor = '$emisor'"; 
		}
		if(strlen($receptor)>0) { 
			$sql.= " AND msj_receptor = '$receptor'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND msj_situacion = '$situacion'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	function get_mensaje_unique($emisor = '',$receptor = '') {
		
		$distinct = ($emisor != "")?"msj_receptor":"msj_emisor";
	        $sql= "SELECT DISTINCT $distinct";
		$sql.= " FROM app_mensaje";
		$sql.= " WHERE 1 = 1";
		if(strlen($emisor)>0) { 
			$sql.= " AND msj_emisor = '$emisor'"; 
		}
		if(strlen($receptor)>0) { 
			$sql.= " AND msj_receptor = '$receptor'"; 
		}
		$sql.= " ORDER BY msj_chat ASC, msj_codigo ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_last_mensaje($emisor = '',$receptor = '') {
		
		$sql= "SELECT msj_chat, msj_codigo, msj_emisor, msj_receptor, msj_mensaje, msj_fec_hora, msj_situacion,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_id = msj_emisor) as msj_emisor_nombre,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_id = msj_receptor) as msj_receptor_nombre";
		$sql.= " FROM app_mensaje";
		$sql.= " WHERE msj_emisor = '$emisor'"; 
		$sql.= " AND msj_receptor = '$receptor'"; 
		$sql.= " ORDER BY msj_codigo DESC LIMIT 1";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function insert_mensaje($chat,$codigo,$emisor,$receptor,$mensaje){
		$fechor = date("Y-m-d H:i:s");
		$sql = "INSERT INTO app_mensaje";
		$sql.= " VALUES ($chat,$codigo,$emisor,$receptor,'$mensaje','$fechor',1);";
		//echo $sql;
		return $sql;
	}
	
	
	function cambia_sit_mensaje($cod,$sit){
		
		$sql = "UPDATE app_mensaje SET ";
		$sql.= "msj_situacion = $sit"; 
				
		$sql.= " WHERE msj_codigo = $cod"; 	
		
		return $sql;
	}
	
	function delete_mensaje($chat,$codigo){
		
		$sql = "DELETE FROM app_mensaje ";
		$sql.= " WHERE msj_chat = $chat"; 	
		$sql.= " AND msj_codigo = $codigo; "; 	
		
		return $sql;
	}
	
	function delete_chat($chat){
		
		$sql = "DELETE FROM app_mensaje ";
		$sql.= " WHERE msj_chat = $chat;"; 	
		
		return $sql;
	}
	
	function max_mensaje($chat){
	        $sql = "SELECT max(msj_codigo) as max ";
		$sql.= " FROM app_mensaje";
		$sql.= " WHERE msj_chat = $chat";
		
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function max_chat(){
	        $sql = "SELECT max(msj_chat) as max ";
		$sql.= " FROM app_mensaje";
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
}	
?>
