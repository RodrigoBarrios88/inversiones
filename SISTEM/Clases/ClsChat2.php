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
	
	
	//////////////////// XXXXXXXXXXXXXXXXXXXXX //////////////////////////
	
	function check_chat_dialog($user1,$user2){
		
	    $sql= "SELECT * ";
		$sql.= " FROM chat_dialog_history";
		$sql.= " WHERE  1 = 1";
		$sql.= " AND (sender_id = '$user1' AND receiver_id = '$user2')";
		$sql.= " OR (sender_id = '$user2' AND receiver_id = '$user1')";
		$sql.= " ORDER BY updated_at DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function check_dialog_id($dialog_id){
		
	    $sql= "SELECT * ";
		$sql.= " FROM chat_dialog_history";
		$sql.= " WHERE dialog_id = '$dialog_id'";
		$sql.= " ORDER BY updated_at DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	
	function get_chat_dialog($user_id){
		
	    $sql= "SELECT * ";
		$sql.= " FROM chat_dialog_history";
		$sql.= " WHERE  1 = 1";
		$sql.= " AND sender_id = '$user_id'";
		$sql.= " OR receiver_id = '$user_id'";
		$sql.= " ORDER BY updated_at DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_chat_list($user_id){
		
	    $sql= "SELECT *, ";
		///sender
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_usu_id,";
		$sql.= " (SELECT usu_tipo FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_tipo,";
		$sql.= " (SELECT usu_tipo_codigo FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_cui,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_name,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_nombre_pantalla,";
		///sender
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_usu_id,";
		$sql.= " (SELECT usu_tipo FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_tipo,";
		$sql.= " (SELECT usu_tipo_codigo FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_cui,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_name,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_nombre_pantalla,";
		///ultimo mensaje
		$sql.= " (SELECT chat_messages.message FROM chat_messages WHERE chat_messages.sender_id = chat_dialog_history.sender_id AND chat_messages.receiver_id = chat_dialog_history.receiver_id ORDER BY chat_messages.updated_at DESC LIMIT 0,1) as last_message";
		//--
		$sql.= " FROM chat_dialog_history";
		$sql.= " WHERE  1 = 1";
		$sql.= " AND sender_id = '$user_id'";
		$sql.= " OR receiver_id = '$user_id'";
		$sql.= " ORDER BY updated_at DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function insert_chat_dialog($chat_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO chat_dialog_history";
		$sql.= " VALUES ($chat_id,'$sender_id','$sender_chat_id','$receiver_id','$receiver_chat_id','$dialog_id','$fsist','$fsist'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_chat_dialog($chat_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$dialog_id){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE chat_dialog_history SET ";
		$sql.= "sender_id = '$sender_id',"; 
		$sql.= "sender_chat_id = '$sender_chat_id',"; 
		$sql.= "receiver_id = '$receiver_id',"; 
		$sql.= "receiver_chat_id = '$receiver_chat_id',"; 
		$sql.= "dialog_id = '$dialog_id',"; 
		$sql.= "updated_at = '$fsist'"; 
		
		$sql.= " WHERE chat_id = $chat_id;";
		//echo $sql;
		return $sql;
	}
	
	function max_chat_dialog() {
		
        $sql = "SELECT max(chat_id) as max ";
		$sql.= " FROM chat_dialog_history";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	////--------------
	
	function get_message_list($user_id,$users_id){
		
	    $sql= "SELECT *, ";
		///sender
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_usu_id,";
		$sql.= " (SELECT usu_tipo FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_tipo,";
		$sql.= " (SELECT usu_tipo_codigo FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_cui,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_name,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo_codigo = sender_id LIMIT 0,1) as sender_nombre_pantalla,";
		$sql.= " (SELECT message FROM chat_messages WHERE chat_messages.sender_id = chat_dialog_history.sender_id AND chat_messages.receiver_id = chat_dialog_history.receiver_id LIMIT 0,1) as sender_last_message,";
		///sender
		$sql.= " (SELECT usu_id FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_usu_id,";
		$sql.= " (SELECT usu_tipo FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_tipo,";
		$sql.= " (SELECT usu_tipo_codigo FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_cui,";
		$sql.= " (SELECT usu_nombre FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_name,";
		$sql.= " (SELECT usu_nombre_pantalla FROM seg_usuarios WHERE usu_tipo_codigo = receiver_id LIMIT 0,1) as receiver_nombre_pantalla,";
		$sql.= " (SELECT message FROM chat_messages WHERE chat_messages.sender_id = chat_dialog_history.sender_id AND chat_messages.receiver_id = chat_dialog_history.receiver_id LIMIT 0,1) as receiver_last_message";
		//--
		$sql.= " FROM chat_dialog_history";
		$sql.= " WHERE  1 = 1";
		$sql.= " AND (sender_id = '$user_id' AND receiver_id IN($users_id))";
		$sql.= " OR (receiver_id = '$user_id' AND sender_id IN($users_id))";
		$sql.= " ORDER BY updated_at DESC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function get_last_message($user_id,$users_id){
		
	    $sql= "SELECT * ";
		$sql.= " FROM chat_messages";
		$sql.= " WHERE  1 = 1";
		$sql.= " AND (sender_id = '$user_id' AND receiver_id IN($users_id))";
		$sql.= " OR (receiver_id = '$user_id' AND sender_id IN($users_id))";
		$sql.= " ORDER BY updated_at DESC LIMIT 0,1";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;
	}
	
	function insert_message($message_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$message){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "INSERT INTO chat_messages";
		$sql.= " VALUES ($message_id,'$sender_id','$sender_chat_id','$receiver_id','$receiver_chat_id','$message','$fsist','$fsist'); ";
		//echo $sql;
		return $sql;
	}
	
	function update_message($message_id,$sender_id,$sender_chat_id,$receiver_id,$receiver_chat_id,$message){
		$fsist = date("Y-m-d H:i:s");
		
		$sql = "UPDATE chat_messages SET ";
		$sql.= "sender_id = '$sender_id',"; 
		$sql.= "sender_chat_id = '$sender_chat_id',"; 
		$sql.= "receiver_id = '$receiver_id',"; 
		$sql.= "receiver_chat_id = '$receiver_chat_id',"; 
		$sql.= "message = '$message',"; 
		$sql.= "updated_at = '$fsist'"; 
		
		$sql.= " WHERE message_id = $message_id;";
		//echo $sql;
		return $sql;
	}
	
	function max_message() {
		
        $sql = "SELECT max(message_id) as max ";
		$sql.= " FROM chat_messages";
		$sql.= " WHERE 1 = 1"; 	
		$result = $this->exec_query($sql);
		foreach($result as $row){
			$max = $row["max"];
		}
		//echo $sql;
		return $max;
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////// CHAT CM ////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function get_cm($cui,$nombre = '',$situacion = '') {
		$nombre = trim($nombre);
		
	    $sql= "SELECT * ";
		$sql.= " FROM chat_cm,seg_usuarios";
		$sql.= " WHERE usu_tipo_codigo = cm_cui";
		$sql.= " AND usu_tipo IN(1,2)";
		if(strlen($cui)>0) { 
			$sql.= " AND cm_cui = $cui"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND cm_nombre like '%$nombre%'"; 
		}
		if(strlen($situacion)>0) { 
			$sql.= " AND cm_situacion = '$situacion'"; 
		}
		$sql.= " ORDER BY cm_cui ASC";
		
		$result = $this->exec_query($sql);
		//echo $sql;
		return $result;

	}
	
	function count_cm($cui,$nombre = '',$situacion = '') {
		$nombre = trim($nombre);
		
	    $sql= "SELECT COUNT(*) as total";
		$sql.= " FROM chat_cm,seg_usuarios";
		$sql.= " WHERE usu_tipo_codigo = cm_cui";
		$sql.= " AND usu_tipo IN(1,2)";
		if(strlen($cui)>0) { 
			$sql.= " AND cm_cui = $cui"; 
		}
		if(strlen($nombre)>0) { 
			$sql.= " AND cm_nombre like '%$nombre%'"; 
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
		
		$sql = "INSERT INTO chat_cm";
		$sql.= " VALUES ($cui,'$nombre','$titulo','$mail','$hini','$hfin','$obs',1,1);";
		//echo $sql;
		return $sql;
	}
	
	function modifica_cm($cui,$nombre,$titulo,$mail,$hini,$hfin,$obs){
		$nombre = trim($nombre);
		$titulo = trim($titulo);
		$mail = strtolower($mail);
		
		$sql = "UPDATE chat_cm SET ";
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
		
		$sql = "UPDATE chat_cm SET ";
		$sql.= "cm_status = $status"; 
				
		$sql.= " WHERE cm_cui = $cui"; 	
		
		return $sql;
	}
	
	
	function cambia_situacion_cm($cui,$situacion){
		
		$sql = "UPDATE chat_cm SET ";
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
	
}	
?>
