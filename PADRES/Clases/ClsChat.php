<?php
require_once ("ClsConex.php");

class ClsChat extends ClsConex{
/* Situacion 1 = ACTIVO, 2 = INACTIVO */

//////////////////// DIALOGOS //////////////////////////
	function get_dialogo($tipo,$usuario){
		
	    $sql= "SELECT DISTINCT diag_codigo, diag_fechor_creacion, diag_fechor_actualizacion, diag_situacion,";
		$sql.= " (SELECT usu_id FROM app_chat_dialogo_usuarios, seg_usuarios WHERE dusu_dialogo = diag_codigo AND dusu_tipo_usuario = usu_tipo AND dusu_usuario = usu_tipo_codigo AND dusu_usuario != $usuario LIMIT 0,1) as otro_usuario_id,";
		$sql.= " (SELECT usu_nombre_pantalla FROM app_chat_dialogo_usuarios, seg_usuarios WHERE dusu_dialogo = diag_codigo AND dusu_tipo_usuario = usu_tipo AND dusu_usuario = usu_tipo_codigo AND dusu_usuario != $usuario LIMIT 0,1) as otro_usuario,";
		$sql.= " (SELECT msj_texto FROM app_chat_mensajes WHERE msj_dialogo = diag_codigo ORDER BY msj_fechor_registro DESC LIMIT 0,1) as ultimo_mensaje";
		$sql.= " FROM app_chat_dialogo,app_chat_dialogo_usuarios";
		$sql.= " WHERE diag_codigo = dusu_dialogo";
		$sql.= " AND diag_situacion = 1";
		
		if(strlen($tipo)>0) { 
			$sql.= " AND dusu_tipo_usuario = '$tipo'";
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND dusu_usuario = '$usuario'";
		}
		$sql.= " ORDER BY diag_fechor_actualizacion DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;

	}
	
	
	function insert_dialogo($codigo){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_chat_dialogo";
		$sql.= " VALUES ($codigo,'$fsist','$fsist',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function update_dialogo($codigo){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_chat_dialogo SET ";
		$sql.= "diag_fechor_actualizacion = '$fsist'"; 
		
		$sql.= " WHERE diag_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	
	function cambia_sit_dialogo($codigo, $situacion){
		$sql = "UPDATE app_chat_dialogo SET diag_situacion = $situacion";
		$sql.= " WHERE diag_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function delete_dialogo($codigo) {
		
        $sql = "DELETE FROM app_chat_dialogo";
		$sql.= " WHERE diag_codigo = $codigo;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	function max_dialogo() {
		
        $sql = "SELECT max(diag_codigo) as max ";
		$sql.= " FROM app_chat_dialogo";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}	
	
//////////////////// USUARIOS DE LOS DIALOGOS //////////////////////////

	function get_usuarios_dialogo($codigo,$tipo = '',$usuario = ''){
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_chat_dialogo_usuarios, seg_usuarios";
		$sql.= " WHERE dusu_tipo_usuario = usu_tipo";
		$sql.= " AND dusu_usuario = usu_tipo_codigo";
		if(strlen($codigo)>0) { 
			$sql.= " AND dusu_dialogo = '$codigo'";
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND dusu_tipo_usuario = '$tipo'";
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND dusu_usuario = '$usuario'";
		}
		
		$sql.= " ORDER BY dusu_tipo_usuario ASC, usu_nombre ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_usuarios_dialogo($codigo,$tipo = '',$usuario = ''){
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_chat_dialogo_usuarios, seg_usuarios";
		$sql.= " WHERE dusu_tipo_usuario = usu_tipo";
		$sql.= " AND dusu_usuario = usu_tipo_codigo";
		if(strlen($codigo)>0) { 
			$sql.= " AND dusu_dialogo = '$codigo'";
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND dusu_tipo_usuario = '$tipo'";
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND dusu_usuario = '$usuario'";
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;

	}
	
	
	function insert_usuarios_dialogo($codigo,$tipo,$usuario){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_chat_dialogo_usuarios";
		$sql.= " VALUES ('$codigo','$tipo','$usuario','$fsist'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_usuarios_dialogo($codigo,$tipo,$usuario){
		$sql = "DELETE FROM app_chat_dialogo_usuarios";
		$sql.= " WHERE dusu_dialogo = '$codigo'";
		$sql.= " AND dusu_tipo_usuario = '$tipo'";
		$sql.= " AND dusu_usuario = '$usuario';";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_usuarios_dialogo_todos($codigo){
		$sql = "DELETE FROM app_chat_dialogo_usuarios";
		$sql.= " WHERE dusu_dialogo = '$codigo';";
		//echo $sql;
		return $sql;
	}

	
//////////////////// MENSAJES //////////////////////////

	function get_mensajes($dialogo){
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_chat_mensajes, seg_usuarios";
		$sql.= " WHERE msj_tipo_usuario = usu_tipo";
		$sql.= " AND msj_usuario_envia = usu_tipo_codigo";
		$sql.= " AND msj_dialogo = '$dialogo'";
		$sql.= " ORDER BY msj_fechor_registro ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}


	function insert_mensaje($codigo,$dialogo,$tipo,$usuario,$texto){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO app_chat_mensajes";
		$sql.= " VALUES ('$codigo','$dialogo','$tipo','$usuario','$texto','$fsist','$fsist',1); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_mensaje($codigo, $dialogo) {
		
        $sql = "DELETE FROM app_chat_mensajes";
		$sql.= " WHERE msj_codigo = $codigo"; 	
		$sql.= " AND msj_dialogo = $dialogo;"; 	
		//echo $sql;
		return $sql;
	}
	

	function max_mensaje($dialogo) {
		
        $sql = "SELECT max(msj_codigo) as max ";
		$sql.= " FROM app_chat_mensajes";
		$sql.= " WHERE msj_dialogo = $dialogo"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	function status_mensaje($codigo,$dialogo,$situacion){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_chat_mensajes SET ";
		$sql.= "msj_situacion = $situacion,"; 
		$sql.= "msj_fechor_update = '$fsist'"; 
		
		$sql.= " WHERE msj_codigo = $codigo"; 	
		$sql.= " AND msj_dialogo = $dialogo;"; 	
		//echo $sql;
		return $sql;
	}
	
	function visualizar_todos_mensajes($dialogo){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE app_chat_mensajes SET ";
		$sql.= "msj_situacion = 3,"; 
		$sql.= "msj_fechor_update = '$fsist'"; 
		
		$sql.= " WHERE msj_dialogo = $dialogo";
		$sql.= " AND msj_situacion != 3;"; 	
		//echo $sql;
		return $sql;
	}
	
	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// CHAT CM ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function get_cm($cui, $usuario = '', $nombre = '',$tipo = '', $situacion = '') {
		$nombre = trim($nombre);
		
	    $sql= "SELECT * ";
		$sql.= " FROM app_chat_cm,seg_usuarios";
		$sql.= " WHERE usu_tipo_codigo = cm_cui";
		$sql.= " AND usu_tipo IN(1,2,5)";
		if(strlen($cui)>0) { 
			$sql.= " AND cm_cui = $cui"; 
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND usu_id IN($usuario)"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND cm_nombre like '%$nombre%'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND usu_tipo = '$tipo'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND cm_situacion = '$situacion'"; 
		}
		$sql.= " ORDER BY cm_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cm($cui, $usuario = '', $nombre = '', $tipo = '', $situacion = '') {
		$nombre = trim($nombre);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM app_chat_cm,seg_usuarios";
		$sql.= " WHERE usu_tipo_codigo = cm_cui";
		$sql.= " AND usu_tipo IN(1,2,5)";
		if(strlen($cui)>0) { 
			$sql.= " AND cm_cui = $cui"; 
		}
		if(strlen($usuario)>0) { 
			$sql.= " AND usu_id IN($usuario)"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND cm_nombre like '%$nombre%'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND usu_tipo = '$tipo'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND cm_situacion = '$situacion'"; 
		}
		//echo $sql;
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$total = $row['total'];
		}
		return $total;
	}
	
	
	function insert_cm($cui,$nombre,$titulo,$mail,$hini,$hfin,$obs){
		$nombre = trim($nombre);
		$titulo = trim($titulo);
		$mail = strtolower($mail);
		
		$sql = "INSERT INTO app_chat_cm";
		$sql.= " VALUES ($cui,'$nombre','$titulo','$mail','$hini','$hfin','$obs',1,1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_cm($cui,$nombre,$titulo,$mail,$hini,$hfin,$obs){
		$nombre = trim($nombre);
		$titulo = trim($titulo);
		$mail = strtolower($mail);
		
		$sql = "UPDATE app_chat_cm SET ";
		$sql.= "cm_nombre = '$nombre',"; 
		$sql.= "cm_titulo = '$titulo',"; 
		$sql.= "cm_mail = '$mail',";
		$sql.= "cm_hora_ini = '$hini',";
		$sql.= "cm_hora_fin = '$hfin',";
		$sql.= "cm_observaciones = '$obs'";
		
		$sql.= " WHERE cm_cui = $cui; "; 	
		//echo $sql;
		return $sql;
	}
	
	function cambia_status_cm($cui,$status){
		
		$sql = "UPDATE app_chat_cm SET ";
		$sql.= "cm_status = $status"; 
				
		$sql.= " WHERE cm_cui = $cui"; 	
		
		return $sql;
	}
	
	
	function cambia_situacion_cm($cui,$situacion){
		
		$sql = "UPDATE app_chat_cm SET ";
		$sql.= "cm_situacion = $situacion"; 
				
		$sql.= " WHERE cm_cui = $cui"; 	
		
		return $sql;
	}
	
	
	function get_push_notification_user($emisor = '',$type = '',$type_id = '',$mensaje_id = '') {
		$anio1 = date("Y");
        $anio2 = date("Y");
        $anio2++;
		
        $sql= "SELECT * ";
		$sql.= " FROM push_notification, push_user, app_chat_mensajes";
		$sql.= " WHERE push_notification.user_id = push_user.user_id";
        $sql.= " AND push_notification.type_id = app_chat_mensajes.msj_dialogo";
        $sql.= " AND YEAR(push_notification.created_at) BETWEEN $anio1 AND $anio2";
		if(strlen($emisor)>0) { 
			$sql.= " AND push_notification.user_id != '$emisor'"; 
		}
		if(strlen($type)>0) { 
			$sql.= " AND push_type = '$type'"; 
		}
		if(strlen($type_id)>0) { 
			$sql.= " AND msj_dialogo = $type_id"; 
		}
		if(strlen($mensaje_id)>0) { 
			$sql.= " AND msj_codigo = '$mensaje_id'"; 
		}
		$sql.= " GROUP BY push_user.user_id, push_user.device_id";
		$sql.= " ORDER BY push_notification.created_at DESC, push_notification.user_id ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql."<br><br>";
		return $result;
	}
	
	
	
	///////////// ASIGNACION A GRADOS //////////
	function get_grado_usuarios($pensum,$nivel,$grado,$usuario,$tipo = ''){
		$tipo = trim($tipo);
		
        $sql= "SELECT *";
		$sql.= " FROM app_chat_cm,seg_usuarios,app_chat_grado_usuarios,academ_grado";
		$sql.= " WHERE usu_tipo_codigo = cm_cui";
		$sql.= " AND grausu_usuario = cm_cui";
		$sql.= " AND gra_pensum = grausu_pensum";
		$sql.= " AND gra_nivel = grausu_nivel";
		$sql.= " AND gra_codigo = grausu_grado";
		if(strlen($pensum)>0) { 
			  $sql.= " AND grausu_pensum = $pensum"; 
		}
		if(strlen($nivel)>0) { 
			  $sql.= " AND grausu_nivel = $nivel"; 
		}
		if(strlen($grado)>0) { 
			  $sql.= " AND grausu_grado = $grado"; 
		}
		if(strlen($usuario)>0) { 
			  $sql.= " AND grausu_usuario = '$usuario'"; 
		}
		if(strlen($tipo)>0) { 
			$sql.= " AND usu_tipo = '$tipo'"; 
		}
		$sql.= " ORDER BY grausu_pensum ASC, grausu_nivel ASC, grausu_grado ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function get_codigos_usuarios_asignaciones($pensum,$alumno){
		
        $sql = "SELECT usu_id as codigo";
		$sql.= " FROM app_chat_cm, seg_usuarios, app_chat_grado_usuarios, academ_grado_alumno";
		$sql.= " WHERE usu_tipo_codigo = cm_cui";
		$sql.= " AND cm_cui = grausu_usuario";
		$sql.= " AND graa_pensum = grausu_pensum";
		$sql.= " AND graa_nivel = grausu_nivel";
		$sql.= " AND graa_grado = grausu_grado";
		$sql.= " AND cm_situacion = 1";
		$sql.= " AND usu_situacion = 1";
		 
		if(strlen($alumno)>0) { 
			  $sql.= " AND graa_alumno = '$alumno'"; 
		}
		if(strlen($pensum)>0) { 
			  $sql.= " AND graa_pensum = $pensum"; 
		}
		$sql.= " ORDER BY usu_id ASC, cm_cui ASC";
		
		//echo $sql.'<br>';
		$result = $this->exec_query($sql);
		if(is_array($result)){
			$codigos = '';
			foreach($result as $row){
				$codigos.= $row['codigo'].',';
			}
			$codigos = substr($codigos, 0, -1);
		}else{
			$codigos = '';
		}
		//echo $codigos.'<br>';
		return $codigos;

	}
	
    
    function insert_grado_usuarios($pensum,$nivel,$grado,$usuario){
		
		$sql = "INSERT INTO app_chat_grado_usuarios ";
		$sql.= " VALUES ($pensum,$nivel,$grado,'$usuario'); ";
		//echo $sql;
		return $sql;
	}
	
	
	function delete_grado_usuarios($pensum,$nivel,$usuario){
		
		$sql = "DELETE FROM app_chat_grado_usuarios ";
		$sql.= " WHERE grausu_pensum = $pensum"; 	
		if(strlen($nivel)>0) { 
			$sql.= " AND grausu_nivel = $nivel"; 
		}
		$sql.= " AND grausu_usuario = '$usuario';";
		
		//echo $sql;
		return $sql;
	}
	
	
	
}	
?>
